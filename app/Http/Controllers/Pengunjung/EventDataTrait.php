<?php

namespace App\Http\Controllers\Pengunjung;

trait EventDataTrait
{
    public function events()
    {
        // Ambil semua data event dari database yang statusnya sudah 'Published'
        $dbEvents = \App\Models\Event::where('status', 'Published')->get()->map(function($event) {
            // Cari harga paling murah dari daftar tiket yang ada
            $minPrice = $event->tikets()->min('harga') ?? 0;
            
            return [
                'id' => $event->id,
                'title' => $event->judul,
                'date' => \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                'time' => substr($event->waktu_mulai, 0, 5) . ' - ' . substr($event->waktu_selesai, 0, 5) . ' WIB',
                'venue' => $event->lokasi,
                'category' => $event->kategori,
                'status' => 'Tersedia Tiket',
                'price' => 'Rp ' . number_format($minPrice, 0, ',', '.'),
                'image' => $event->poster ?? 'gambarevent1.jpg',
                'description' => $event->deskripsi,
                'tickets' => $event->tikets->map(function($t) {
                    return [
                        'id' => $t->id,
                        'type' => $t->nama,
                        'price' => $t->harga,
                        'quota' => $t->kuota
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
