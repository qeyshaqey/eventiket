<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use Carbon\Carbon;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kategori
        $kategoriSeminar = Kategori::updateOrCreate(['nama_kategori' => 'Seminar']);
        $kategoriWorkshop = Kategori::updateOrCreate(['nama_kategori' => 'Workshop']);
        $kategoriPameran = Kategori::updateOrCreate(['nama_kategori' => 'Pameran']);
        $kategoriTalkshow = Kategori::updateOrCreate(['nama_kategori' => 'Talkshow']);

        // 2. Panitia Users
        $panitia1 = User::updateOrCreate(
            ['email' => 'panitia1@example.com'],
            [
                'name' => 'Panitia Satu',
                'password' => Hash::make('password'),
                'role' => 'panitia',
                'nim' => '1110001'
            ]
        );

        $panitia2 = User::updateOrCreate(
            ['email' => 'panitia2@example.com'],
            [
                'name' => 'Panitia Dua',
                'password' => Hash::make('password'),
                'role' => 'panitia',
                'nim' => '1110002'
            ]
        );

        // 3. Events
        $event1 = Event::updateOrCreate(
            ['judul' => 'Seminar Kewirausahaan'],
            [
                'user_id' => $panitia1->id,
                'kategori_id' => $kategoriSeminar->id,
                'deskripsi' => 'Belajar cara memulai bisnis dari nol bersama para praktisi sukses.',
                'tanggal_mulai' => Carbon::now()->addDays(5)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(5)->toDateString(),
                'waktu_mulai' => '09:00:00',
                'waktu_selesai' => '13:00:00',
                'lokasi' => 'Aula Utama Gedung A',
                'status' => 'Published'
            ]
        );

        $event2 = Event::updateOrCreate(
            ['judul' => 'Workshop UI/UX Design'],
            [
                'user_id' => $panitia1->id,
                'kategori_id' => $kategoriWorkshop->id,
                'deskripsi' => 'Praktik langsung mendesain antarmuka aplikasi mobile yang user-friendly.',
                'tanggal_mulai' => Carbon::now()->addDays(10)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(10)->toDateString(),
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '16:00:00',
                'lokasi' => 'Laboratorium Komputer 3',
                'status' => 'Published'
            ]
        );

        $event3 = Event::updateOrCreate(
            ['judul' => 'Pameran Teknologi'],
            [
                'user_id' => $panitia2->id,
                'kategori_id' => $kategoriPameran->id,
                'deskripsi' => 'Pameran hasil karya inovasi mahasiswa di bidang IoT dan Web App.',
                'tanggal_mulai' => Carbon::now()->addDays(15)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(16)->toDateString(),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '17:00:00',
                'lokasi' => 'Gedung Serbaguna Kampus',
                'status' => 'Published'
            ]
        );

        $event4 = Event::updateOrCreate(
            ['judul' => 'Talkshow Startup'],
            [
                'user_id' => $panitia2->id,
                'kategori_id' => $kategoriTalkshow->id,
                'deskripsi' => 'Talkshow seru membahas pendanaan startup di era digital.',
                'tanggal_mulai' => Carbon::now()->addDays(20)->toDateString(),
                'tanggal_selesai' => Carbon::now()->addDays(20)->toDateString(),
                'waktu_mulai' => '13:00:00',
                'waktu_selesai' => '16:00:00',
                'lokasi' => 'Auditorium Lantai 4',
                'status' => 'Published'
            ]
        );

        // 4. Tikets
        $tiket1 = Tiket::updateOrCreate(
            ['event_id' => $event1->id, 'nama' => 'Regular'],
            ['harga' => 50000, 'kuota' => 100, 'tiket_terjual' => 0]
        );

        $tiket2 = Tiket::updateOrCreate(
            ['event_id' => $event2->id, 'nama' => 'VIP'],
            ['harga' => 150000, 'kuota' => 50, 'tiket_terjual' => 0]
        );

        $tiket3 = Tiket::updateOrCreate(
            ['event_id' => $event3->id, 'nama' => 'Tiket Masuk'],
            ['harga' => 25000, 'kuota' => 200, 'tiket_terjual' => 0]
        );

        $tiket4 = Tiket::updateOrCreate(
            ['event_id' => $event4->id, 'nama' => 'Umum'],
            ['harga' => 35000, 'kuota' => 150, 'tiket_terjual' => 0]
        );

        // 5. Visitors (Pengunjung) & Pembelian Data
        $pengunjungs = [
            ['nama' => 'Qeysha Nadin', 'email' => 'nadin@gmail.com', 'nim' => '2210001', 'tiket' => $tiket1, 'tanggal' => '2026-05-01'],
            ['nama' => 'Yohana Abigail', 'email' => 'hana@gmail.com', 'nim' => '2210002', 'tiket' => $tiket2, 'tanggal' => '2026-05-02'],
            ['nama' => 'Naya Khairunnisa', 'email' => 'nisa@gmail.com', 'nim' => '2210003', 'tiket' => $tiket1, 'tanggal' => '2026-05-03'],
            ['nama' => 'Raka Pratama', 'email' => 'raka@gmail.com', 'nim' => '2210004', 'tiket' => $tiket3, 'tanggal' => '2026-05-04'],
            ['nama' => 'Dimas Saputra', 'email' => 'dimas@gmail.com', 'nim' => '2210005', 'tiket' => $tiket4, 'tanggal' => '2026-05-05'],
            ['nama' => 'Siti Aisyah', 'email' => 'aisyah@gmail.com', 'nim' => '2210006', 'tiket' => $tiket1, 'tanggal' => '2026-05-06'],
            ['nama' => 'Andi Wijaya', 'email' => 'andi@gmail.com', 'nim' => '2210007', 'tiket' => $tiket2, 'tanggal' => '2026-05-07'],
            ['nama' => 'Putri Maharani', 'email' => 'putri@gmail.com', 'nim' => '2210008', 'tiket' => $tiket1, 'tanggal' => '2026-05-08'],
            ['nama' => 'Fajar Nugroho', 'email' => 'fajar@gmail.com', 'nim' => '2210009', 'tiket' => $tiket3, 'tanggal' => '2026-05-09'],
            ['nama' => 'Larasati Dewi', 'email' => 'laras@gmail.com', 'nim' => '2210010', 'tiket' => $tiket4, 'tanggal' => '2026-05-10'],
        ];

        foreach ($pengunjungs as $index => $p) {
            // Create or update user
            $user = User::updateOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['nama'],
                    'password' => Hash::make('password'),
                    'role' => 'pengunjung',
                    'nim' => $p['nim']
                ]
            );

            // Create pembelian
            $pembelian = Pembelian::create([
                'user_id' => $user->id,
                'created_at' => $p['tanggal'],
                'updated_at' => $p['tanggal'],
                'total_bayar' => $p['tiket']->harga,
                'status_pembayaran' => 'Lunas',
                'order_id' => 'ORDER-' . uniqid() . '-' . $index,
                'snap_token' => 'SNAP-' . uniqid()
            ]);

            // Create detail_pembelian
            DetailPembelian::create([
                'pembelian_id' => $pembelian->id,
                'tiket_id' => $p['tiket']->id,
                'jumlah' => 1,
                'subtotal' => $p['tiket']->harga
            ]);

            // Update tiket_terjual
            $p['tiket']->increment('tiket_terjual');
        }
    }
}
