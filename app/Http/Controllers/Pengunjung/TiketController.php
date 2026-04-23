<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TiketController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $events = [
            [
                "title" => "Festival Musik Mapala",
                "category" => "Seminar",
                "date" => "02 - 05 Mei 2026",
                "date_start" => "2026-05-02",
                "date_end" => "2026-05-05",
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
                "date_start" => "2026-05-02",
                "date_end" => "2026-05-05",
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
                "date_start" => "2026-05-02",
                "date_end" => "2026-05-05",
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
                "date" => "10 April 2026",
                "date_start" => "2026-04-10",
                "date_end" => "2026-04-10",
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
                "date" => "04 April 2026",
                "date_start" => "2026-04-04",
                "date_end" => "2026-04-04",
                "time" => "10.00 - 16.00 WIB",
                "location" => "Auditorium Gedung Utama Lantai 2",
                "tickets" => [
                    ["name" => "Tiket Perdana", "qty" => 1],
                    ["name" => "Tiket Umum", "qty" => 1],
                    ["name" => "Tiket Premium", "qty" => 1]
                ],
                "status" => "Ditolak",
                "kode_order" => "000963963"
            ],
            [
                "title" => "Festival Musik Mapala",
                "category" => "Keagamaan",
                "date" => "02 - 05 Mei 2026",
                "date_start" => "2026-05-02",
                "date_end" => "2026-05-05",
                "time" => "10.00 - 16.00 WIB",
                "location" => "Auditorium Gedung Utama Lantai 2",
                "tickets" => [
                    ["name" => "Tiket Perdana", "qty" => 1],
                    ["name" => "Tiket Umum", "qty" => 1],
                    ["name" => "Tiket Premium", "qty" => 1]
                ],
                "status" => "Berhasil Diverifikasi",
                "kode_order" => "000963964"
            ]
        ];

        $activeEvents = [];
        $historyEvents = [];

        foreach ($events as $event) {
            $endDate = Carbon::parse($event['date_end']);
            if ($endDate->gte($today)) {
                $activeEvents[] = $event;
            } else {
                $historyEvents[] = $event;
            }
        }

        return view('pages.pengunjung.tiket', compact('activeEvents', 'historyEvents'));
    }
}