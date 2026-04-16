<?php

namespace App\Http\Controllers\Pengunjung;

trait EventDataTrait
{
    public function events()
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Seminar Kewirausahaan',
                'date' => '10 Mei 2026',
                'time' => '09.00 - 12.00 WIB',
                'venue' => 'Gedung Serbaguna',
                'category' => 'Seminar',
                'status' => 'Tiket Habis',
                'price' => 'Rp 45.000',
                'image' => 'gambarevent1.jpg',
                'description' => 'Seminar Kewirausahaan adalah acara spesial',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 150000, 'quota' => 3],
                    ['type' => 'Tiket Umum', 'price' => 125000, 'quota' => 5],
                    ['type' => 'Tiket Premium', 'price' => 200000, 'quota' => 1],
                ],
            ],
            [
                'id' => 2,
                'title' => 'Sosialisasi Program Kerja',
                'date' => '28 April 2026',
                'time' => '19.00 WIB',
                'venue' => 'Lapangan Terbuka',
                'category' => 'Sosial',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 125.000',
                'image' => 'gambarevent2.jpg',
                'description' => 'Sosialisasi Program Kerja adalah acara spesial',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 110000, 'quota' => 25],
                    ['type' => 'Tiket Umum', 'price' => 85000, 'quota' => 60],
                    ['type' => 'Tiket Premium', 'price' => 140000, 'quota' => 18],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Olahraga Bersama',
                'date' => '02 Mei 2026',
                'time' => '10.00 - 16.00 WIB',
                'venue' => 'Aula Serbaguna',
                'category' => 'Olahraga',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 85.000',
                'image' => 'gambarevent3.jpg',
                'description' => 'Olahraga Bersama adalah acara spesial',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 70000, 'quota' => 20],
                    ['type' => 'Tiket Umum', 'price' => 55000, 'quota' => 50],
                    ['type' => 'Tiket Premium', 'price' => 90000, 'quota' => 12],
                ],
            ],
            [
                'id' => 4,
                'title' => 'Hiburan Kampus',
                'date' => '06 Mei 2026',
                'time' => '13.00 - 17.00 WIB',
                'venue' => 'Lab Multimedia',
                'category' => 'Hiburan',
                'status' => 'Tiket Habis',
                'price' => 'Rp 55.000',
                'image' => 'gambarevent1.jpg',
                'description' => 'Hiburan campus marupakan acara spesial',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 60000, 'quota' => 20],
                    ['type' => 'Tiket Umum', 'price' => 45000, 'quota' => 50],
                    ['type' => 'Tiket Premium', 'price' => 80000, 'quota' => 10],
                ],
            ],
            [
                'id' => 5,
                'title' => 'Ibadah Bersama',
                'date' => '15 Mei 2026',
                'time' => '08.00 - 18.00 WIB',
                'venue' => 'Lab Komputer',
                'category' => 'Religi',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 95.000',
                'image' => 'gambarevent2.jpg',
                'description' => 'Ibadah jumat yang diadakan setiap minggu untuk mempererat tali silaturahmi antar mahasiswa',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 120000, 'quota' => 40],
                    ['type' => 'Tiket Umum', 'price' => 95000, 'quota' => 70],
                    ['type' => 'Tiket Premium', 'price' => 175000, 'quota' => 20],
                ],
            ],
            [
                'id' => 6,
                'title' => 'Kompetisi Coding Nasional',
                'date' => '20 Mei 2026',
                'time' => '14.00 - 16.00 WIB',
                'venue' => 'Auditorium',
                'category' => 'Kompetisi',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 65.000',
                'image' => 'gambarevent3.jpg',
                'description' => 'Kompetisi Coding Nasional untuk mengasah kemampuan coding mahasiswa dengan berbagai tantangan menarik',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 90000, 'quota' => 30],
                    ['type' => 'Tiket Umum', 'price' => 65000, 'quota' => 90],
                    ['type' => 'Tiket Premium', 'price' => 120000, 'quota' => 28],
                ],
            ],
            [
                'id' => 7,
                'title' => 'Jalan Sehat HMTI',
                'date' => '25 Mei 2026',
                'time' => '18.00 - 22.00 WIB',
                'venue' => 'Teater Kampus',
                'category' => 'Olahraga',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 75.000',
                'image' => 'gambarevent1.jpg',
                'description' => 'Kegiatan jalan sehat yang diadakan setiap tahun untuk meningkatkan kesehatan dan kebersamaan antar mahasiswa',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 100000, 'quota' => 45],
                    ['type' => 'Tiket Umum', 'price' => 75000, 'quota' => 120],
                    ['type' => 'Tiket Premium', 'price' => 140000, 'quota' => 22],
                ],
            ],
            [
                'id' => 8,
                'title' => 'Sosialisasi Program Kerja',
                'date' => '25 Mei 2026',
                'time' => '18.00 - 22.00 WIB',
                'venue' => 'Teater Kampus',
                'category' => 'Sosial',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 75.000',
                'image' => 'gambarevent2.jpg',
                'description' => 'Seminar sosialisasi program kerja untuk memperkenalkan program kerja yang akan dilaksanakan selama satu periode kedepan',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 65000, 'quota' => 40],
                    ['type' => 'Tiket Umum', 'price' => 50000, 'quota' => 90],
                    ['type' => 'Tiket Premium', 'price' => 95000, 'quota' => 20],
                ],
            ],
        ]);
    }

    public function findEvent($id)
    {
        return $this->events()->firstWhere('id', (int) $id);
    }
}
