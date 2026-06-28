<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Etiket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    
    // Method ini hanya bertugas mengambil Snap Token yang sudah digenerate saat proses Checkout di TiketController
    public function initiatePayment(Request $request)
    {
        // Ambil ID user dari session
        $userId = session('user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.']);
        }
        
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
                                ->latest()
                                ->first();
        }

        if (!$pembelian) {
            return response()->json(['success' => false, 'message' => 'Data tagihan tidak ditemukan atau sudah dibayar.']);
        }

        // Cek Kedaluwarsa 
        // Jika sudah lebih dari 24 jam sejak tagihan dibuat, ubah statusnya jadi Kedaluwarsa.
        // Fungsi Carbon::parse mengubah format tanggal dari DB, lalu addHours(24) menambah waktu 24 jam, 
        // lalu isPast() mengecek apakah waktu tersebut sudah lewat
        if ($pembelian->status_pembayaran === 'Belum Bayar' && \Carbon\Carbon::parse($pembelian->created_at)->addHours(24)->isPast()) {
            $pembelian->update(['status_pembayaran' => 'Kedaluwarsa']);
            return response()->json(['success' => false, 'message' => 'Tagihan telah kedaluwarsa karena melewati batas waktu pembayaran 24 jam.']);
        }

        // Cek apakah token sudah digenerate (oleh TiketController saat checkout)
        if ($pembelian->snap_token && $pembelian->status_pembayaran == 'Belum Bayar') {
            return response()->json([
                'success' => true,
                'snap_token' => $pembelian->snap_token
            ]);
        } 
        
        // Jika token tidak ada atau status sudah bukan 'Belum Bayar'
        return response()->json(['success' => false, 'message' => 'Token pembayaran tidak ditemukan atau pembayaran sudah diproses.']);
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
                    $details = $pembelian->detail_pembelians;
                    // mengambil kumpulan data $details, lalu setiap kali berulang, simpan satu datanya ke dalam variabel $detail
                    foreach ($details as $detail) {
                        // $i < $detail->jumlah : Ulangi terus selama angka $i lebih kecil dari jumlah tiket yang dibeli. 
                        // (jika beli 3, maka akan berulang untuk angka 0, 1, 2)
                        // $i++ : Setiap kali selesai satu putaran, tambahkan nilai $i dengan angka 1
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