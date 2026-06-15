<?php

namespace App\Http\Controllers\Pengunjung;

// Trait ini menyediakan fungsi untuk mengambil data event yang akan ditampilkan
// kepada pengunjung. Semua data diproses di sini sebelum dikirim ke view.
trait EventDataTrait
{
   
    public function events()
    {
        // Waktu saat ini dalam zona Jakarta
        $now = \Carbon\Carbon::now('Asia/Jakarta');

        // Ambil semua event yang berstatus 'Published' tetapi bukan event yang dibuat oleh user saat ini
        $dbEvents = \App\Models\Event::where('status', 'Published')
            ->when(session('user_id'), function ($query, $userId) {
                return $query->where('user_id', '!=', $userId);
            })
            ->get()
            // Filter: hanya event yang belum melewati batas akhir (tanggal & jam)
            ->filter(function($event) use ($now) {
                // Tentukan batas akhir: jika ada tanggal selesai pakai itu, kalau tidak pakai tanggal mulai
                $endDate = !empty($event->tanggal_selesai) ? $event->tanggal_selesai : $event->tanggal_mulai;
                // Jika jam selesai tidak diisi, asumsikan akhir hari (23:59:59)
                $endTime = !empty($event->waktu_selesai) ? $event->waktu_selesai : '23:59:59';
                
                // Gabungkan tanggal dan jam menjadi objek Carbon dengan zona Jakarta
                $endDateTime = \Carbon\Carbon::parse($endDate . ' ' . $endTime, 'Asia/Jakarta');
                
                // Hanya tampilkan event jika batas akhir (Hari & Jam) belum terlewat
                // Kurang dari atau sama dengan
                return $now->lessThanOrEqualTo($endDateTime); 
            })
            // Map: susun kembali data yang dibutuhkan view
            ->map(function($event) use ($now) {
                
            // Cari harga paling murah dari daftar tiket yang ada
            $minPrice = $event->tikets()->min('harga') ?? 0;
            
            // Hitung total sisa kuota dari semua jenis tiket
            $totalKuota = $event->tikets()->sum('kuota');
            
            // Logika Status Dinamis (Disiplin Waktu)
            $isOngoing = false;
            
            // Tentukan waktu mulai (gabungkan tanggal dan jam mulai acara menjadi $startDateTime)
            $startTime = !empty($event->waktu_mulai) ? $event->waktu_mulai : '00:00:00';
            $startDateTime = \Carbon\Carbon::parse($event->tanggal_mulai . ' ' . $startTime, 'Asia/Jakarta');

            // Karena event sudah dipastikan belum kadaluwarsa oleh filter di atas,
            // kita cukup cek apakah waktu sekarang sudah lewat dari JAM mulai acara.
            if ($now->greaterThanOrEqualTo($startDateTime)) {
                $isOngoing = true;
            }

            if ($isOngoing) {
                $statusBadge = 'Sedang Berjalan';
            } elseif ($totalKuota <= 0) {
                $statusBadge = 'Tiket Habis';
            } else {
                $statusBadge = 'Tersedia Tiket';
            }

            return [
                'id' => $event->id,
                'title' => $event->judul,
                'date' => !empty($event->tanggal_selesai) && $event->tanggal_selesai !== $event->tanggal_mulai
                    ? \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y') . ' - ' . \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d M Y')
                    : \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                'time' => substr($event->waktu_mulai, 0, 5) . ' - ' . substr($event->waktu_selesai, 0, 5) . ' WIB',
                'venue' => $event->lokasi,
                'category' => $event->kategori->nama_kategori ?? 'Lainnya',
                'status' => $statusBadge,
                'price' => 'Rp ' . number_format($minPrice, 0, ',', '.'),
                'image' => $event->poster ?? 'gambarevent1.jpg',
                'description' => $event->deskripsi,
                'tickets' => $event->tikets->map(function($t) {
                    return [
                        'id' => $t->id,
                        'type' => $t->nama,
                        'price' => $t->harga,
                        'quota' => $t->kuota,
                        'sold' => $t->tiket_terjual,
                    ];
                })->toArray(),
            ];
        });

        return $dbEvents;
    }

    public function findEvent($id)
    {
        return $this->events()->firstWhere('id', (int) $id);
    }
}
