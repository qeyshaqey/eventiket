<?php

namespace App\Http\Controllers\Pengunjung;

// Trait ini menyediakan fungsi untuk mengambil data event yang akan ditampilkan
// kepada pengunjung. Semua data diproses di sini sebelum dikirim ke view
trait EventDataTrait
{
   
    public function events()
    {
        // Dapatkan waktu saat ini dalam zona waktu Asia/Jakarta
        // carbon library php digunakan untuk memanipulasi tanggal dan waktu
        $now = \Carbon\Carbon::now('Asia/Jakarta');

        // Ambil semua event yang berstatus 'Published' tetapi bukan event yang dibuat oleh user saat ini
        $dbEvents = \App\Models\Event::where('status', 'Published')
            // get digunakan untuk mengeksekusi query
            ->when(session('user_id'), function ($query, $userId) {
                return $query->where('user_id', '!=', $userId);
            })
            ->get()

            // Filter: hanya event yang belum melewati batas akhir (tanggal & jam)
            ->filter(function($event) use ($now) {
                // Tentukan batas tanggal akhir: jika ada tanggal selesai pakai itu, kalau tidak pakai tanggal mulai
                $endDate = !empty($event->tanggal_selesai) ? $event->tanggal_selesai : $event->tanggal_mulai;
                
                // Tentukan batas jam: Jika waktu selesai tidak diisi, asumsikan acara berakhir di penghujung hari (23:59:59)
                $endTime = !empty($event->waktu_selesai) ? $event->waktu_selesai : '23:59:59';
                
                // Gabungkan tanggal dan jam menjadi satu objek waktu(berzona Jakarta)
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime, 'Asia/Jakarta');
                
                // Hanya tampilkan event jika batas akhir (Hari & Jam) belum terlewat
                // Kurang dari atau sama dengan sekarang
                return $now->lessThanOrEqualTo($endDateTime); 
            })
            // Map: Setelah event yang kadaluwarsa dibuang, susun ulang bentuk datanya
            ->map(function($event) use ($now) {
                
                // Cari harga paling murah dari seluruh jenis tiket yang dimiliki event
                // Gunakan 0 sebagai nilai default jika event belum memiliki tiket
                $minPrice = $event->tikets()->min('harga') ?? 0;
                
                // Hitung total keseluruhan sisa kuota dengan menjumlahkan kolom 'kuota' dari semua jenis tiket
                $totalKuota = $event->tikets()->sum('kuota');
                
                //variabel penanda apakah event tersebut sedang berlangsung 
                // anggap event belum mulai (false)
                $isOngoing = false;
                
                // Tentukan waktu mulai: Jika jam mulai kosong, asumsikan mulai jam 00:00:00
                $startTime = !empty($event->waktu_mulai) ? $event->waktu_mulai : '00:00:00';
                
                // Gabungkan tanggal mulai dan jam mulai menjadi objek waktu
                $startDateTime = \Carbon\Carbon::parse($event->tanggal_mulai . ' ' . $startTime, 'Asia/Jakarta');

                // Jika waktu sekarang ($now) sudah melewati atau sama persis dengan waktu mulai acara ($startDateTime)
                // Jika ya, berarti acara tersebut sedang berlangsung saat ini
                if ($now->greaterThanOrEqualTo($startDateTime)) {
                    $isOngoing = true;
                }

                // Penentuan (Badge) Status di antarmuka pengunjung
                if ($isOngoing) {
                    // Jika acara sedang berjalan sekarang
                    $statusBadge = 'Sedang Berjalan';
                } elseif ($totalKuota <= 0) {
                    // Jika acara belum berjalan, tapi tiket (sisa kuota) sudah habis terjual
                    $statusBadge = 'Tiket Habis';
                } else {
                    // Jika acara belum berjalan, dan tiket masih tersedia
                    $statusBadge = 'Tersedia Tiket';
                }

                // Kembalikan array data yang sudah diformat dan digunakan di Blade view
                return [
                    'id' => $event->id, // ID dari event
                    'title' => $event->judul, // Judul event
                    
                    // Carbon::parse() mengubah string teks biasa dari database (misal: "2026-06-10")

                    // Apakah tanggal selesai TIDAK KOSONG? DAN apakah tanggal selesainya BERBEDA dengan tanggal mulainya?
                    'date' => !empty($event->tanggal_selesai) && $event->tanggal_selesai !== $event->tanggal_mulai
                        // Jika ya, maka format tanggalnya"Tanggal Mulai - Tanggal Selesai" (Contoh: "10 Jun 2026 - 12 Jun 2026")
                        ? \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d M Y')
                        // Jika tidak,maka format tanggalnya "10 Jun 2026" (hanya 1 hari)
                        : \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),

                    // Format jam tayang (Contoh: "08:00 - 15:00 WIB")
                    // substr($string, 0, 5) digunakan untuk memotong teks.
                    // Jika di database jam tersimpan "08:00:00", maka diambil 5 karakter pertama saja menjadi "08:00".
                    'time' => substr($event->waktu_mulai, 0, 5) . ' - ' . substr($event->waktu_selesai, 0, 5) . ' WIB',
                    
                    'venue' => $event->lokasi, // Lokasi  event

                    // Ambil nama kategori lewat relasi ORM. Jika tidak ada, tulis 'Lainnya'
                    'category' => $event->kategori->nama_kategori ?? 'Lainnya', 
                    'status' => $statusBadge, // Badge status hasil perhitungan di atas
                    
                    // number_format engubah angka int mentah menjadi format mata uang
                    // Mengubah angka 20000 menjadi format Rp 20.000 dengan titik sebagai pemisah ribuan.
                    'price' => 'Rp ' . number_format($minPrice, 0, ',', '.'),
                    'image' => $event->poster ? \Illuminate\Support\Facades\Storage::url($event->poster) : asset('image/gambarevent1.jpg'), // Gambar poster event
                    'description' => $event->deskripsi, // Teks paragraf deskripsi event
                    // Susun ulang data tiket (jenis-jenis tiket) yang ada dalam event ini
                    'tickets' => $event->tikets->map(function($t) {
                        return [
                            'id' => $t->id, // ID Jenis Tiket
                            'type' => $t->nama, // Nama kategori tiket
                            'price' => $t->harga, // Harga per satuan tiket
                            'quota' => $t->kuota, // SISA kuota tiket yang bisa dibeli
                            'sold' => $t->tiket_terjual, // Total jumlah tiket yang sudah lunas/terjual
                        ];
                    })->toArray(), // Ubah hasil mapping koleksi tiket menjadi array 
                ];
            });

        // Kembalikan kumpulan data event yang sudah disaring dan diformat
        return $dbEvents;
    }

    public function findEvent($id)
    {
        // Panggil fungsi events() yang sudah terformat di atas, 
        // lalu cari baris pertama yang id-nya cocok dengan $id yang dicari (dijadikan integer)
        return $this->events()->firstWhere('id', (int) $id);
    }
}
