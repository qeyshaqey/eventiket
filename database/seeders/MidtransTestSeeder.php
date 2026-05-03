<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MidtransTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat user dummy buat ngetes login (Pengunjung)
        $user = \App\Models\User::create([
            'name' => 'naya',
            'email' => 'naya@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'pengunjung',
            'status' => 'verified'
        ]);

        // 2. Buat Event Pertama: Festival Musik Mapala
        $event = \App\Models\Event::create([
            'judul' => 'Festival Musik Mapala',
            'kategori' => 'Hiburan',
            'deskripsi' => 'Konser musik tahunan Mapala Polibatam',
            'tanggal_mulai' => '2026-05-02',
            'tanggal_selesai' => '2026-05-05',
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '16:00',
            'lokasi' => 'Auditorium Gedung Utama Lantai 2',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);

        $tiket = \App\Models\Tiket::create([
            'nama' => 'Tiket Premium',
            'harga' => 10000,
            'kuota' => 100,
            'event_id' => $event->id
        ]);

        // 3. Buat satu transaksi pending buat user naya agar bisa langsung ngetes bayar
        \App\Models\Pembayaran::create([
            'user_id' => $user->id, 
            'tiket_id' => $tiket->id,
            'jumlah' => 10000,
            'status' => 'pending'
        ]);

        // Event Kedua
        $event2 = \App\Models\Event::create([
            'judul' => 'Seminar Nasional Digital 2026',
            'kategori' => 'Seminar',
            'deskripsi' => 'Membangun masa depan digital Indonesia bersama para ahli teknologi.',
            'tanggal_mulai' => '2026-05-15',
            'tanggal_selesai' => '2026-05-15',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '12:00',
            'lokasi' => 'Gedung Serbaguna Polibatam',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);

        \App\Models\Tiket::create([
            'nama' => 'Tiket Umum',
            'harga' => 25000,
            'kuota' => 200,
            'event_id' => $event2->id
        ]);

        // Event 3: Kompetisi Coding Nasional
        $event3 = \App\Models\Event::create([
            'judul' => 'Kompetisi Coding Nasional',
            'kategori' => 'Kompetisi',
            'deskripsi' => 'Kompetisi Coding Nasional untuk mengasah kemampuan coding mahasiswa dengan berbagai tantangan menarik',
            'tanggal_mulai' => '2026-05-20',
            'tanggal_selesai' => '2026-05-20',
            'waktu_mulai' => '14:00',
            'waktu_selesai' => '16:00',
            'lokasi' => 'Auditorium Polibatam',
            'poster' => 'gambarevent3.jpg',
            'status' => 'Published'
        ]);

        \App\Models\Tiket::create([
            'nama' => 'Tiket Perdana',
            'harga' => 90000,
            'kuota' => 30,
            'event_id' => $event3->id
        ]);

        // Event 4: Jalan Sehat HMTI
        $event4 = \App\Models\Event::create([
            'judul' => 'Jalan Sehat HMTI',
            'kategori' => 'Olahraga',
            'deskripsi' => 'Kegiatan jalan sehat yang diadakan setiap tahun untuk meningkatkan kesehatan dan kebersamaan.',
            'tanggal_mulai' => '2026-05-25',
            'tanggal_selesai' => '2026-05-25',
            'waktu_mulai' => '06:00',
            'waktu_selesai' => '10:00',
            'lokasi' => 'Teater Kampus',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);

        \App\Models\Tiket::create([
            'nama' => 'Tiket Umum',
            'harga' => 75000,
            'kuota' => 120,
            'event_id' => $event4->id
        ]);

        // Event 5: Sosialisasi Program Kerja
        $event5 = \App\Models\Event::create([
            'judul' => 'Sosialisasi Program Kerja',
            'kategori' => 'Sosial',
            'deskripsi' => 'Seminar sosialisasi program kerja untuk memperkenalkan program kerja satu periode kedepan.',
            'tanggal_mulai' => '2026-05-28',
            'tanggal_selesai' => '2026-05-28',
            'waktu_mulai' => '18:00',
            'waktu_selesai' => '22:00',
            'lokasi' => 'Teater Kampus',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);

        \App\Models\Tiket::create([
            'nama' => 'Tiket Umum',
            'harga' => 50000,
            'kuota' => 90,
            'event_id' => $event5->id
        ]);
    }
}
