<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;

class TiketController extends Controller
{

    //  Method ini bertugas untuk menyiapkan data yang akan ditampilkan di halaman "Tiket Saya".
    //  Ia akan memisahkan mana tiket yang masih aktif (belum lewat tanggal) 
    //  dan mana yang sudah masuk riwayat (dibatalkan/kedaluwarsa/lewat tanggal)
     
    public function index()
    {
        // Ambil ID pengguna yang sedang login dari session
        $userId = session('user_id');
        // Simpan waktu hari ini untuk perbandingan batas event
        $now = Carbon::now('Asia/Jakarta');

        // Ambil semua data riwayat pembelian milik pengguna ini.
        // Gunakan WITH untuk menarik data relasi (detail pembelian, tiket, event, kategori, dan e-tiket
        $pembelians = Pembelian::with(['detail_pembelians.tiket.event.kategori', 'etikets'])
            ->where('user_id', $userId)
            ->get();

        // Siapkan dua keranjang (array) kosong untuk memisahkan tiket
        $activeEvents = []; // Keranjang tiket aktif (bisa dipakai/dibayar)
        $historyEvents = []; // Keranjang riwayat tiket (sudah lewat/batal/kedaluwarsa)

        // Looping (Ulangi) setiap struk pembelian yang dimiliki user
        foreach ($pembelians as $pembelian) {
            // Ambil detail tiket pertama 
            $firstDetail = $pembelian->detail_pembelians->first();
            if (!$firstDetail) continue; // Jika kosong, lewati
            
            // Ambil data event dari tiket tersebut
            $event = $firstDetail->tiket->event ?? null;
            if (!$event) continue; // Jika event sudah dihapus, lewati

            // Ambil daftar kode e-tiket (hanya baris kode_unik-nya saja) yang terikat dengan struk ini (jika sudah lunas)
            $eticketCodes = $pembelian->etikets->pluck('kode_unik')->toArray();
            
            // Menyusun data E-Tiket
            $ticketsData = [];
            $etiketIndex = 0; // Penunjuk indeks array kode unik
            foreach ($pembelian->detail_pembelians as $detail) {
                $qty = $detail->jumlah ?? 1; // Berapa tiket yang dibeli untuk jenis ini
                $codes = []; // Keranjang kecil untuk kode unik jenis tiket ini
                
                // Jika beli 2 tiket VIP, ambil 2 kode E-tiket dari daftar dan masukkan ke keranjang kecil
                for ($i = 0; $i < $qty; $i++) {
                    if (isset($eticketCodes[$etiketIndex])) {
                        $codes[] = $eticketCodes[$etiketIndex];
                        $etiketIndex++;
                    }
                }
                
                // Simpan rincian jenis tiket ini beserta keranjang kode uniknya
                $ticketsData[] = [
                    "name" => $detail->tiket->nama ?? '-', 
                    "qty" => $qty,
                    "codes" => $codes
                ];
            }

            // Penentuan Logika Pemisahan (Tiket Aktif vs Riwayat)
            // Gabungkan tanggal selesai + jam selesai agar perbandingannya presisi (menit-per-menit)
            $endDateStr = $event->tanggal_selesai ?? $event->tanggal_mulai;
            $endTimeStr = $event->waktu_selesai ?? '23:59:59';
            $endDateTime = Carbon::parse($endDateStr . ' ' . $endTimeStr, 'Asia/Jakarta');
            $isHistory = false; // Anggap masih aktif pada awalnya
            
            // 1. Jika status pembayarannya Dibatalkan atau Kedaluwarsa -> Masuk Riwayat
            if ($pembelian->status_pembayaran === 'Dibatalkan' || $pembelian->status_pembayaran === 'Kedaluwarsa') {
                $isHistory = true;
            } 
            // 2. Jika waktu sekarang sudah melewati tanggal DAN jam selesai event -> Masuk Riwayat
            elseif ($now->gt($endDateTime)) {
                $isHistory = true;
            } 
            // 3: Jika belum bayar dan sudah lewat 24 jam sejak struk dibuat -> Masuk Riwayat
            elseif ($pembelian->status_pembayaran === 'Belum Bayar' && Carbon::parse($pembelian->created_at)->addHours(24)->isPast()) {
                $isHistory = true;
            }

            $statusStr = $pembelian->status_pembayaran;
            // Jika sebuah tiket sudah lewat tanggal event dan statusnya di DB masih "Belum Bayar"
            // maka ganti statusnya di database menjadi "Kedaluwarsa"
            if ($isHistory && $statusStr === 'Belum Bayar') {
                $statusStr = 'Kedaluwarsa';
                $pembelian->update(['status_pembayaran' => 'Kedaluwarsa']);
            }

            // Bungkus semua data tadi ke dalam format rapi untuk diserahkan ke Blade view
            $data = [
                "id" => $pembelian->id, 
                "title" => $event->judul,
                "category" => $event->kategori->nama_kategori ?? '-',
                // Format tanggal: tampilkan rentang jika tanggal selesai berbeda dengan tanggal mulai
                "date" => ($event->tanggal_selesai && $event->tanggal_selesai != $event->tanggal_mulai)
                    ? Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y') . ' - ' . Carbon::parse($event->tanggal_selesai)->translatedFormat('d M Y')
                    : Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                "date_end" => $event->tanggal_selesai,
                "time" => substr($event->waktu_mulai ?? '', 0, 5) . " - " . substr($event->waktu_selesai ?? '', 0, 5) . " WIB",
                "location" => $event->lokasi,
                "tickets" => $ticketsData, // Rincian tiket per tipe yang kita susun di atas
                "etikets" => $eticketCodes, // Seluruh e-tiket(kode unik)
                "status" => $statusStr,
                "kode_order" => $pembelian->order_id ?? '-'
            ];
            
            // Masukkan bungkusan data ke keranjang yang sesuai (Aktif atau Riwayat)
            if ($isHistory) {
                $historyEvents[] = $data;
            } else {
                $activeEvents[] = $data;
            }
        }

        //lemparkan kedua keranjang ke tiket blade
        return view('pages.pengunjung.tiket', compact('activeEvents', 'historyEvents'));
    }

    
    //  Method ini menangani saat user mengklik tombol "Beli Tiket" (Proses Checkout di halaman Detail).
     
    public function checkout(Request $request)
    {
        // Cek keamanan (apakah session user sudah ada / sudah login?)
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        // Validasi input form: pastikan event_id benar-benar terdaftar di tabel events dan form tiket berupa array
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|array',
        ]);

        $event = Event::findOrFail($validated['event_id']);
        
        // Buat nomor pesanan/Order ID unik (Contoh: TRX-ABCDE12345) menggunakan fungsi Str::random
        $orderId = 'TRX-' . Str::upper(Str::random(10));

        // DB::beginTransaction() digunakan agar jika terjadi error di tengah jalan, 
        // semua proses simpan DB yang sudah sempat jalan akan otomatis dibatalkan (Rollback)
        DB::beginTransaction();
        try {
            $createdCount = 0;
            $totalHarga = 0;
            $jumlahTiket = 0;

            // Buat struk pembelian awal (status masih 'Belum Bayar', total '0' dulu)
            $pembelian = Pembelian::create([
                'user_id' => $userId,
                'tanggal_beli' => now(),
                'total_bayar' => 0, 
                'status_pembayaran' => 'Belum Bayar',
                'order_id' => $orderId,
            ]);

            // Cek satu per satu jenis tiket yang dikirim dari form
            foreach ($validated['tickets'] as $ticketId => $qty) {
                $qty = (int) $qty;
                if ($qty <= 0) continue; // Abaikan jika jumlah belinya 0 

                // Cari tiket tersebut di database
                $tiket = Tiket::where('id', $ticketId)->where('event_id', $event->id)->first();
                if (!$tiket) {
                    DB::rollBack(); // Batalkan semua operasi DB
                    return response()->json(['success' => false, 'message' => 'Tiket tidak valid.'], 400);
                }

                // Cek ketersediaan SISA kuota tiket, bandingkan dengan jumlah yang mau dibeli (qty)
                if ($tiket->kuota < $qty) {
                    DB::rollBack(); // Batalkan semua operasi DB
                    return response()->json(['success' => false, 'message' => "Kuota tiket '{$tiket->nama}' tidak mencukupi. Tersisa: {$tiket->kuota}"], 400);
                }

                // Hitung subtotal harga (Harga Satuan * Jumlah)
                $subtotal = $tiket->harga * $qty;
                
                // Simpan rincian pembelian jenis ini ke database (tabel detail_pembelians)
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'tiket_id' => $tiket->id,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal
                ]);

                // Hitung kumulatif total uang keseluruhan dan jumlah total tiket
                $totalHarga += $subtotal;
                $jumlahTiket += $qty;
                $createdCount++;
            }

            // Jika tidak ada satu tiket pun yang berhasil dihitung (mungkin user input 0 di semua jenis tiket)
            if ($createdCount === 0) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Pilih minimal 1 tiket.'], 400);
            }

            // Update struk pembelian awal dengan total harga sesungguhnya hasil perhitungan 
            $pembelian->update(['total_bayar' => $totalHarga]);

            // Set konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = config('midtrans.is_sanitized');
            Config::$is3ds = config('midtrans.is_3ds');

            $user = User::find($userId);

            // Siapkan parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalHarga,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email,
                ],
            ];

            try {
                // Pre-fetch Snap Token dari Midtrans
                $snapToken = Snap::getSnapToken($params);
                $pembelian->update(['snap_token' => $snapToken]);
            } catch (\Exception $e) {
            }

            // Simpan semua perubahan database secara permanen (Commit)
            DB::commit();
            
            // Kembalikan pesan sukses ke Javascript beserta nomor ordernya untuk diarahkan ke halaman pembayaran
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            // Jika ada error/bug pada kodingan dalam try, tangkap errornya, batalkan operasi DB, dan tampilkan pesannya
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    
    // status dibatalkan
    // Method ini dipanggil saat pengunjung mengklik tombol "Batal" di halaman Tiket Saya secara sadar/manual.
    
    public function batal($id)
    {
        $userId = session('user_id');
        // Cari struk pembelian berdasarkan ID dan pastikan struk itu milik user yang sedang login
        $pembelian = Pembelian::where('id', $id)->where('user_id', $userId)->first();
        
        // Jika statusnya memang masih "Belum Bayar"
        if ($pembelian && $pembelian->status_pembayaran == 'Belum Bayar') {
            // izinkan mengubah status di database menjadi 'Dibatalkan'
            $pembelian->update(['status_pembayaran' => 'Dibatalkan']);
            return response()->json(['success' => true, 'message' => 'Tiket berhasil dibatalkan.']);
        }
        
        // Jika gagal/kondisi tidak terpenuhi
        return response()->json(['success' => false, 'message' => 'Gagal membatalkan tiket.'], 400);
    }
}