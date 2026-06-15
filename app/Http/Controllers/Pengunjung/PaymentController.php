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
        // Mengatur konfigurasi API Key Midtrans dengan mengambil data dari file .env
        Config::$serverKey = config('midtrans.server_key'); // Kunci rahasia server
        Config::$isProduction = config('midtrans.is_production'); // true = Live, false = Sandbox (Testing)
        Config::$isSanitized = config('midtrans.is_sanitized'); // Membersihkan input data (keamanan)
        Config::$is3ds = config('midtrans.is_3ds'); // Fitur keamanan tambahan untuk kartu kredit
    }

    // Method ini bertugas untuk memulai proses pembayaran
    // Ia akan mengecek pesanan pengguna dan meminta 'Snap Token' ke Midtrans untuk memunculkan pop-up bayar
    public function initiatePayment(Request $request)
    {
        // Ambil ID user dari session
        $userId = session('user_id');
        // Cari data user tersebut di database
        $user = \App\Models\User::find($userId);

        // Jika tidak ditemukan (belum login), kirim kembali ke halaman login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Cek apakah ada parameter 'order_id' di URL (misal dipanggil dari riwayat transaksi)
        $orderIdRequest = $request->query('order_id');
        
        if ($orderIdRequest) {
            // Jika ada order_id spesifik, cari data pembelian berdasarkan order_id tersebut
            $pembelian = Pembelian::where('user_id', $user->id)
                                ->where('order_id', $orderIdRequest)
                                ->first();
        } else {
            // Jika tidak ada order_id, otomatis ambil transaksi TERAKHIR yang statusnya masih 'Belum Bayar'
            $pembelian = Pembelian::where('user_id', $user->id)
                                ->where('status_pembayaran', 'Belum Bayar')
                                ->latest() // Urutkan dari yang paling baru dibuat
                                ->first();
        }

        // Jika sama sekali tidak ada data tagihan yang perlu dibayar, kembalikan ke halaman tiket
        if (!$pembelian) {
            return redirect()->route('pengunjung.tiket')->with('error', 'Data tagihan tidak ditemukan atau sudah dibayar.');
        }

        // Cek Kedaluwarsa 
        // Jika sudah lebih dari 24 jam sejak tagihan dibuat, ubah statusnya jadi Kedaluwarsa.
        // Fungsi Carbon::parse mengubah format tanggal dari DB, lalu addHours(24) menambah waktu 24 jam, 
        // lalu isPast() mengecek apakah waktu tersebut sudah lewat
        if ($pembelian->status_pembayaran === 'Belum Bayar' && \Carbon\Carbon::parse($pembelian->created_at)->addHours(24)->isPast()) {
            $pembelian->update(['status_pembayaran' => 'Kedaluwarsa']);
            return redirect()->route('pengunjung.tiket')->with('error', 'Tagihan telah kedaluwarsa karena melewati batas waktu pembayaran 24 jam.');
        }

        // Proses mendapatkan Snap Token (Kunci untuk memunculkan jendela Midtrans)
        // Jika token sudah pernah dibuat sebelumnya dan tagihan belum dibayar, pakai token yang lama saja
        if ($pembelian->snap_token && $pembelian->status_pembayaran == 'Belum Bayar') {
            $snapToken = $pembelian->snap_token;
        } 
        // Jika belum punya token, kita harus memintanya ke server Midtrans
        else if ($pembelian->status_pembayaran == 'Belum Bayar') {
            // Siapkan paket data (parameter) yang disyaratkan oleh Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $pembelian->order_id, // Nomor unik pesanan kita
                    'gross_amount' => $pembelian->total_bayar, // Total uang yang harus dibayar
                ],
                'customer_details' => [
                    'first_name' => $user->name, // Nama pelanggan
                    'email' => $user->email, // Email pelanggan
                ],
            ];

            try {
                // Minta token ke Midtrans dengan mengirimkan paket data di atas
                $snapToken = Snap::getSnapToken($params);
                // Simpan token tersebut ke database kita agar tidak perlu minta berulang kali
                $pembelian->snap_token = $snapToken;
                $pembelian->save();
            } catch (\Exception $e) {
                // Jika server Midtrans sedang down/error, tangkap errornya
                return redirect()->back()->with('error', 'Gagal hubung ke Midtrans: ' . $e->getMessage());
            }
        } else {
            // Jika statusnya bukan 'Belum Bayar', cegah proses ini
            return redirect()->route('pengunjung.tiket')->with('error', 'Pembayaran ini sudah diproses.');
        }

        // Lempar data tagihan dan token ke halaman view pembayaran
        $pembayaran = $pembelian; 
        return view('pages.pengunjung.pembayaran', compact('pembayaran', 'snapToken'));
    }

    //  Method Callback / Webhook
    //  Ini untuk memberitahu web kalau pelanggan sudah sukses transfer uang atau pesanannya kedaluwarsa.
    public function callback(Request $request)
    {
        // Ambil kunci server dari file konfigurasi
        $serverKey = config('midtrans.server_key');
        // Buat rumus keamanan dengan menyatukan OrderID + StatusCode + TotalUang + ServerKey lalu dienkripsi (hash sha512)
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        // Cocokkan hasil enkripsi dengan kunci rahasia yang dikirim Midtrans.
        // Jika cocok, berarti benar ini dari Midtrans
        if ($hashed == $request->signature_key) {
            
            // Cek status transaksinya
            // capture = sukses untuk kartu kredit, settlement = sukses untuk e-wallet/transfer bank
            if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                
                // Cari data pesanan di database kita yang order_id-nya sama dengan laporan Midtrans
                $pembelian = Pembelian::where('order_id', $request->order_id)->first();
                
                // Jika pesanan ketemu dan statusnya di sistem kita belum Lunas
                if ($pembelian && $pembelian->status_pembayaran !== 'Lunas') {
                    // Ubah status tagihan di database kita menjadi 'Lunas'
                    $pembelian->status_pembayaran = 'Lunas';
                    $pembelian->save();
                    
                    // Generate E-Tiket (Kode Unik) tabel pembelian berelasi dengan detail pembelian
                    // Ambil detail rincian tiket apa saja yang dibeli di pesanan ini
                    $details = $pembelian->detail_pembelians;
                    foreach ($details as $detail) {
                        // Jika dia beli 3 tiket, lakukan perulangan 3 kali untuk membuat 3 kode E-Tiket terpisah
                        for ($i = 0; $i < $detail->jumlah; $i++) {
                            Etiket::create([
                                'pembelian_id' => $pembelian->id,
                                // Buat kode unik format "TKT-XXXX" dengan fungsi Str::random untuk abjad acak
                                'kode_unik' => 'TKT-' . Str::upper(Str::random(12)) 
                            ]);
                        }
                        
                        // Update Kuota & Tiket Terjual
                        $tiket = $detail->tiket;
                        if ($tiket) {
                            // Tambah angka "Terjual" di database
                            $tiket->tiket_terjual += $detail->jumlah;
                            // Kurangi angka "Sisa Kuota" di database
                            $tiket->kuota -= $detail->jumlah;
                            $tiket->save(); // Simpan perubahan
                        }
                    }
                }
            } elseif ($request->transaction_status == 'pending') {
                // Membiarkan status transaksi tetap pending jika belum diselesaikan
                
            } else {
                // Jika status dari Midtrans adalah deny/expire/cancel, ubah pesanan kita jadi Kedaluwarsa
                $pembelian = Pembelian::where('order_id', $request->order_id)->first();
                if ($pembelian) {
                    $pembelian->status_pembayaran = 'Kedaluwarsa';
                    $pembelian->save();
                }
            }
        }

        // Wajib mengembalikan pesan sukses agar server Midtrans tahu aplikasinya sudah menerima laporan
        return response()->json(['status' => 'success']);
    }
}