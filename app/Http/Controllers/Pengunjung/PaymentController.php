<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Etiket;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Mengatur konfigurasi API Key Midtrans dari file .env
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function initiatePayment(Request $request)
    {
        $userId = session('user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $orderIdRequest = $request->query('order_id');
        
        if ($orderIdRequest) {
            $pembelian = Pembelian::where('user_id', $user->id)
                                ->where('order_id', $orderIdRequest)
                                ->first();
        } else {
            // Mengambil data transaksi terakhir pengguna yang berstatus 'Belum Bayar'
            $pembelian = Pembelian::where('user_id', $user->id)
                                ->where('status_pembayaran', 'Belum Bayar')
                                ->latest()
                                ->first();
        }

        if (!$pembelian) {
            return redirect()->route('pengunjung.tiket')->with('error', 'Data tagihan tidak ditemukan atau sudah dibayar.');
        }

        // Menggunakan snap_token yang sudah ada, atau meminta token baru ke Midtrans jika belum tersedia
        if ($pembelian->snap_token && $pembelian->status_pembayaran == 'Belum Bayar') {
            $snapToken = $pembelian->snap_token;
        } else if ($pembelian->status_pembayaran == 'Belum Bayar') {
            $params = [
                'transaction_details' => [
                    'order_id' => $pembelian->order_id,
                    'gross_amount' => $pembelian->total_bayar,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $pembelian->snap_token = $snapToken;
                $pembelian->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal hubung ke Midtrans: ' . $e->getMessage());
            }
        } else {
            return redirect()->route('pengunjung.tiket')->with('error', 'Pembayaran ini sudah diproses.');
        }

        // Pass 'pembayaran' to view as the view might still use $pembayaran variable
        $pembayaran = $pembelian; 

        return view('pages.pengunjung.pembayaran', compact('pembayaran', 'snapToken'));
    }

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $pembelian = Pembelian::where('order_id', $request->order_id)->first();
                if ($pembelian && $pembelian->status_pembayaran !== 'Lunas') {
                    $pembelian->status_pembayaran = 'Lunas';
                    $pembelian->save();
                    
                    // Menghasilkan kode barcode unik untuk setiap tiket yang dibeli
                    $details = $pembelian->detail_pembelians;
                    foreach ($details as $detail) {
                        for ($i = 0; $i < $detail->jumlah; $i++) {
                            Etiket::create([
                                'pembelian_id' => $pembelian->id,
                                'kode_unik' => 'TKT-' . Str::upper(Str::random(12))
                            ]);
                        }
                        
                        // Menambahkan jumlah tiket terjual untuk memperbarui sisa kuota
                        $tiket = $detail->tiket;
                        if ($tiket) {
                            $tiket->tiket_terjual += $detail->jumlah;
                            $tiket->save();
                        }
                    }
                }
            } elseif ($request->transaction_status == 'pending') {
                // Membiarkan status transaksi tetap pending jika belum diselesaikan
            } else {
                $pembelian = Pembelian::where('order_id', $request->order_id)->first();
                if ($pembelian) {
                    $pembelian->status_pembayaran = 'Kedaluwarsa';
                    $pembelian->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}