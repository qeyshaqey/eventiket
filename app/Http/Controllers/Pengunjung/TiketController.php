<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
    {
        $events = [
            [
                "title" => "Festival Musik Mapala",
                "category" => "Seminar",
                "date" => "02 - 05 Mei 2026",
                "time" => "10.00 - 16.00 WIB",
                "location" => "Auditorium Gedung Utama Lantai 2",
                "tickets" => [
                    ["name" => "Tiket Perdana", "qty" => 1],
                    ["name" => "Tiket Umum", "qty" => 1],
                    ["name" => "Tiket Premium", "qty" => 1]
                ],
                "status" => "Belum Bayar"
            ],
            [
                "title" => "Jalan Sehat Komite Olahraga Polibatam",
                "category" => "Sosial",
                "date" => "02 - 05 Mei 2026",
                "time" => "10.00 - 16.00 WIB",
                "location" => "Auditorium Gedung Utama Lantai 2",
                "tickets" => [
                    ["name" => "Tiket Perdana", "qty" => 1],
                    ["name" => "Tiket Umum", "qty" => 1],
                    ["name" => "Tiket Premium", "qty" => 1]
                ],
                "status" => "Ditolak"
            ],
             [
                "title" => "Event Naya Senam",
                "category" => "Olahraga",
                "date" => "02 - 05 Mei 2026",
                "time" => "10.00 - 16.00 WIB",
                "location" => "Auditorium Gedung Utama Lantai 2",
                "tickets" => [
                    ["name" => "Tiket Perdana", "qty" => 1],
                    ["name" => "Tiket Umum", "qty" => 1],
                    ["name" => "Tiket Premium", "qty" => 1]
                ],
                "status" => "Menunggu Verifikasi"
            ],
        [
            "title" => "Festival Musik Mapala",
            "category" => "Hiburan",
            "date" => "02 - 05 Mei 2026",
            "time" => "10.00 - 16.00 WIB",
            "location" => "Auditorium Gedung Utama Lantai 2",
            "tickets" => [
                ["name" => "Tiket Perdana", "qty" => 1],
                ["name" => "Tiket Umum", "qty" => 1],
                ["name" => "Tiket Premium", "qty" => 1]
            ],
            "status" => "Berhasil Diverifikasi",
            "kode_order" => "000963962"
        ],
        [
            "title" => "Festival Musik Mapala",
            "category" => "Kompetisi",
            "date" => "02 - 05 Mei 2026",
            "time" => "10.00 - 16.00 WIB",
            "location" => "Auditorium Gedung Utama Lantai 2",
            "tickets" => [
                ["name" => "Tiket Perdana", "qty" => 1],
                ["name" => "Tiket Umum", "qty" => 1],
                ["name" => "Tiket Premium", "qty" => 1]
            ],
            "status" => "Berhasil Diverifikasi",
            "kode_order" => "000963962"
        ],
         [
            "title" => "Festival Musik Mapala",
            "category" => "Keagamaan",
            "date" => "02 - 05 Mei 2026",
            "time" => "10.00 - 16.00 WIB",
            "location" => "Auditorium Gedung Utama Lantai 2",
            "tickets" => [
                ["name" => "Tiket Perdana", "qty" => 1],
                ["name" => "Tiket Umum", "qty" => 1],
                ["name" => "Tiket Premium", "qty" => 1]
            ],
            "status" => "Berhasil Diverifikasi",
            "kode_order" => "000963962"
        ]
        ];

        return view('Pengunjung.tiket', compact('events'));
    }
}