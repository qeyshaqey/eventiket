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
            'nim'  => '3312401001',
            'name' => 'naya',
            'email' => 'naya@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'pengunjung',
        ]);

        // 2. Buat Event Pertama: Festival Musik Mapala
        $event = \App\Models\Event::create([
            'judul' => 'Festival Musik Mapala',
            'kategori' => 'Hiburan',
            'deskripsi' => 'Konser musik tahunan Mapala Polibatam',
            'tanggal_mulai' => '2026-12-02',
            'tanggal_selesai' => '2026-12-05',
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

        // Event 6: Workshop UI/UX Design
        $event6 = \App\Models\Event::create([
            'judul' => 'Workshop UI/UX Design',
            'kategori' => 'Workshop',
            'deskripsi' => 'Belajar dasar-dasar desain antarmuka dan pengalaman pengguna bersama praktisi industri.',
            'tanggal_mulai' => '2026-06-01',
            'tanggal_selesai' => '2026-06-01',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Lab Multimedia Polibatam',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Workshop',
            'harga' => 35000,
            'kuota' => 50,
            'event_id' => $event6->id
        ]);

        // Event 7: Turnamen Futsal Antar Jurusan
        $event7 = \App\Models\Event::create([
            'judul' => 'Turnamen Futsal Antar Jurusan',
            'kategori' => 'Olahraga',
            'deskripsi' => 'Kompetisi futsal antar jurusan untuk mempererat silaturahmi dan sportivitas mahasiswa.',
            'tanggal_mulai' => '2026-06-05',
            'tanggal_selesai' => '2026-06-07',
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'lokasi' => 'Lapangan Futsal Polibatam',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Penonton',
            'harga' => 15000,
            'kuota' => 200,
            'event_id' => $event7->id
        ]);

        // Event 8: Seminar Cyber Security
        $event8 = \App\Models\Event::create([
            'judul' => 'Seminar Cyber Security',
            'kategori' => 'Seminar',
            'deskripsi' => 'Mengenal ancaman siber terkini dan cara melindungi data pribadi di era digital.',
            'tanggal_mulai' => '2026-06-10',
            'tanggal_selesai' => '2026-06-10',
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '16:00',
            'lokasi' => 'Auditorium Gedung Utama',
            'poster' => 'gambarevent3.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Seminar',
            'harga' => 20000,
            'kuota' => 150,
            'event_id' => $event8->id
        ]);

        // Event 9: Pameran Karya Seni Mahasiswa
        $event9 = \App\Models\Event::create([
            'judul' => 'Pameran Karya Seni Mahasiswa',
            'kategori' => 'Pameran',
            'deskripsi' => 'Pameran lukisan, fotografi, dan instalasi karya mahasiswa Polibatam.',
            'tanggal_mulai' => '2026-06-12',
            'tanggal_selesai' => '2026-06-14',
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '20:00',
            'lokasi' => 'Galeri Seni Kampus',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Masuk',
            'harga' => 10000,
            'kuota' => 300,
            'event_id' => $event9->id
        ]);

        // Event 10: Hackathon Polibatam 2026
        $event10 = \App\Models\Event::create([
            'judul' => 'Hackathon Polibatam 2026',
            'kategori' => 'Kompetisi',
            'deskripsi' => 'Kompetisi membuat aplikasi inovatif dalam waktu 24 jam non-stop.',
            'tanggal_mulai' => '2026-06-15',
            'tanggal_selesai' => '2026-06-16',
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '08:00',
            'lokasi' => 'Lab Komputer Gedung B',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Peserta',
            'harga' => 50000,
            'kuota' => 60,
            'event_id' => $event10->id
        ]);

        // Event 11: Talkshow Karir di Dunia IT
        $event11 = \App\Models\Event::create([
            'judul' => 'Talkshow Karir di Dunia IT',
            'kategori' => 'Talkshow',
            'deskripsi' => 'Sharing pengalaman dari para profesional IT tentang persiapan karir setelah lulus.',
            'tanggal_mulai' => '2026-06-18',
            'tanggal_selesai' => '2026-06-18',
            'waktu_mulai' => '13:00',
            'waktu_selesai' => '16:00',
            'lokasi' => 'Auditorium Polibatam',
            'poster' => 'gambarevent3.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Umum',
            'harga' => 25000,
            'kuota' => 100,
            'event_id' => $event11->id
        ]);

        // Event 12: Lomba Debat Bahasa Inggris
        $event12 = \App\Models\Event::create([
            'judul' => 'Lomba Debat Bahasa Inggris',
            'kategori' => 'Kompetisi',
            'deskripsi' => 'Kompetisi debat bahasa Inggris antar kampus se-Kepulauan Riau.',
            'tanggal_mulai' => '2026-06-20',
            'tanggal_selesai' => '2026-06-21',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '17:00',
            'lokasi' => 'Ruang Serbaguna Lt. 3',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Penonton',
            'harga' => 10000,
            'kuota' => 80,
            'event_id' => $event12->id
        ]);

        // Event 13: Workshop Internet of Things
        $event13 = \App\Models\Event::create([
            'judul' => 'Workshop Internet of Things',
            'kategori' => 'Workshop',
            'deskripsi' => 'Praktik langsung membuat proyek IoT menggunakan Arduino dan sensor.',
            'tanggal_mulai' => '2026-06-23',
            'tanggal_selesai' => '2026-06-23',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '16:00',
            'lokasi' => 'Lab Elektronika Polibatam',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Peserta',
            'harga' => 45000,
            'kuota' => 40,
            'event_id' => $event13->id
        ]);

        // Event 14: Festival Kuliner Nusantara
        $event14 = \App\Models\Event::create([
            'judul' => 'Festival Kuliner Nusantara',
            'kategori' => 'Festival',
            'deskripsi' => 'Bazar makanan khas daerah dari seluruh Indonesia yang dikelola oleh mahasiswa.',
            'tanggal_mulai' => '2026-06-25',
            'tanggal_selesai' => '2026-06-26',
            'waktu_mulai' => '10:00',
            'waktu_selesai' => '21:00',
            'lokasi' => 'Lapangan Parkir Polibatam',
            'poster' => 'gambarevent3.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Masuk',
            'harga' => 5000,
            'kuota' => 500,
            'event_id' => $event14->id
        ]);

        // Event 15: Seminar Kewirausahaan Muda
        $event15 = \App\Models\Event::create([
            'judul' => 'Seminar Kewirausahaan Muda',
            'kategori' => 'Seminar',
            'deskripsi' => 'Inspirasi dan tips memulai bisnis sejak muda dari entrepreneur sukses Batam.',
            'tanggal_mulai' => '2026-06-28',
            'tanggal_selesai' => '2026-06-28',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '12:00',
            'lokasi' => 'Gedung Serbaguna Polibatam',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Seminar',
            'harga' => 30000,
            'kuota' => 120,
            'event_id' => $event15->id
        ]);

        // Event 16: Konser Akustik Senja
        $event16 = \App\Models\Event::create([
            'judul' => 'Konser Akustik Senja',
            'kategori' => 'Hiburan',
            'deskripsi' => 'Pertunjukan musik akustik dari band-band kampus di sore hari yang santai.',
            'tanggal_mulai' => '2026-07-01',
            'tanggal_selesai' => '2026-07-01',
            'waktu_mulai' => '16:00',
            'waktu_selesai' => '20:00',
            'lokasi' => 'Taman Kampus Polibatam',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Reguler',
            'harga' => 20000,
            'kuota' => 150,
            'event_id' => $event16->id
        ]);

        // Event 17: Workshop Data Science dengan Python
        $event17 = \App\Models\Event::create([
            'judul' => 'Workshop Data Science dengan Python',
            'kategori' => 'Workshop',
            'deskripsi' => 'Belajar analisis data dan visualisasi menggunakan Python, Pandas, dan Matplotlib.',
            'tanggal_mulai' => '2026-07-03',
            'tanggal_selesai' => '2026-07-03',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '15:00',
            'lokasi' => 'Lab Komputer Gedung A',
            'poster' => 'gambarevent3.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Peserta',
            'harga' => 40000,
            'kuota' => 45,
            'event_id' => $event17->id
        ]);

        // Event 18: Lomba Fotografi Kampus
        $event18 = \App\Models\Event::create([
            'judul' => 'Lomba Fotografi Kampus',
            'kategori' => 'Kompetisi',
            'deskripsi' => 'Kompetisi fotografi dengan tema keindahan kampus dan kehidupan mahasiswa.',
            'tanggal_mulai' => '2026-07-05',
            'tanggal_selesai' => '2026-07-07',
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '17:00',
            'lokasi' => 'Seluruh Area Kampus',
            'poster' => 'gambarevent1.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Peserta',
            'harga' => 15000,
            'kuota' => 70,
            'event_id' => $event18->id
        ]);

        // Event 19: Donor Darah Polibatam
        $event19 = \App\Models\Event::create([
            'judul' => 'Donor Darah Polibatam',
            'kategori' => 'Sosial',
            'deskripsi' => 'Kegiatan donor darah bekerja sama dengan PMI Kota Batam untuk kemanusiaan.',
            'tanggal_mulai' => '2026-07-10',
            'tanggal_selesai' => '2026-07-10',
            'waktu_mulai' => '08:00',
            'waktu_selesai' => '14:00',
            'lokasi' => 'Aula Gedung Utama',
            'poster' => 'gambarevent2.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Gratis',
            'harga' => 0,
            'kuota' => 200,
            'event_id' => $event19->id
        ]);

        // Event 20: Workshop Mobile App Development
        $event20 = \App\Models\Event::create([
            'judul' => 'Workshop Mobile App Development',
            'kategori' => 'Workshop',
            'deskripsi' => 'Belajar membuat aplikasi mobile menggunakan Flutter dari nol hingga deploy.',
            'tanggal_mulai' => '2026-07-12',
            'tanggal_selesai' => '2026-07-13',
            'waktu_mulai' => '09:00',
            'waktu_selesai' => '16:00',
            'lokasi' => 'Lab Komputer Gedung B',
            'poster' => 'gambarevent3.jpg',
            'status' => 'Published'
        ]);
        \App\Models\Tiket::create([
            'nama' => 'Tiket Peserta',
            'harga' => 55000,
            'kuota' => 35,
            'event_id' => $event20->id
        ]);
    }
}
