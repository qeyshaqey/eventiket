<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Set konfigurasi API Key Midtrans dari file .env
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function initiatePayment(Request $request)
    {
        // Cari tau siapa yang lagi login pakai session user_id
        $userId = session('user_id');
        $user = \App\Models\User::find($userId);

        // Kalau nggak ada yang login, balikkan ke halaman login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Ambil data pembayaran terakhir yang statusnya masih 'pending'
        $pembayaran = Pembayaran::where('user_id', $user->id)
                                ->where('status', 'pending')
                                ->latest()
                                ->first();

        // JIKA TIDAK ADA TRANSAKSI, KITA BUATKAN OTOMATIS (Sama seperti di TiketController)
        if (!$pembayaran) {
            $eventContoh = \App\Models\Event::first();
            $tiketContoh = \App\Models\Tiket::where('event_id', $eventContoh?->id)->first();
            
            if ($eventContoh && $tiketContoh) {
                $pembayaran = Pembayaran::create([
                    'user_id' => $user->id,
                    'tiket_id' => $tiketContoh->id,
                    'jumlah' => $tiketContoh->harga,
                    'status' => 'pending',
                    'order_id' => 'TRX-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(10))
                ]);
            } else {
                return redirect()->back()->with('error', 'Data event/tiket tidak ditemukan. Silakan jalankan seeder.');
            }
        }

        // Selalu buat Order ID baru buat ngetes ganti-ganti metode pembayaran di Midtrans
        if ($pembayaran->status == 'pending') {
            $pembayaran->order_id = 'TRX-' . Str::upper(Str::random(10));
            $pembayaran->snap_token = null; // Reset token supaya dapet yang baru
            $pembayaran->save();
        }

        // Kalau snap_token sudah ada, pakai yang itu. Kalau belum, kita minta ke Midtrans
        if ($pembayaran->snap_token) {
            $snapToken = $pembayaran->snap_token;
        } else {
            // Setting detail transaksi buat dikirim ke Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $pembayaran->order_id,
                    'gross_amount' => $pembayaran->jumlah,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            try {
                // Minta Snap Token dari Midtrans
                $snapToken = Snap::getSnapToken($params);
                $pembayaran->snap_token = $snapToken;
                $pembayaran->save();
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal hubung ke Midtrans: ' . $e->getMessage());
            }
        }

        return view('pages.pengunjung.pembayaran', compact('pembayaran', 'snapToken'));
    }

    public function callback(Request $request)
    {
        // Fungsi ini buat nerima laporan otomatis dari Midtrans (Notification)
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Cek dulu apakah laporannya beneran dari Midtrans atau bukan (keamanan)
        if ($hashed == $request->signature_key) {
            // Kalau statusnya lunas atau berhasil diproses
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                $pembayaran = Pembayaran::where('order_id', $request->order_id)->first();
                if ($pembayaran) {
                    $pembayaran->status = 'success';
                    $pembayaran->save();
                }
            } elseif ($request->transaction_status == 'pending') {
                // Biarkan status tetap pending
            } else {
                // Kalau gagal, ganti status jadi failed
                $pembayaran = Pembayaran::where('order_id', $request->order_id)->first();
                if ($pembayaran) {
                    $pembayaran->status = 'failed';
                    $pembayaran->save();
                }
            }
        }

        return response()->json(['status' => 'success']);
    }
}