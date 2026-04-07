<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class EtalaseEventController extends Controller
{
    public function index(Request $request)
    {
        $events = collect([
            [
                'title' => 'Festival Musik Kampus',
                'date' => '28 April 2026',
                'time' => '19.00 WIB',
                'venue' => 'Lapangan Terbuka',
                'category' => 'Musik',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 125.000',
                'image' => 'gambarevent.jpg',
            ],
            [
                'title' => 'Pameran Startup Lokal',
                'date' => '02 Mei 2026',
                'time' => '10.00 - 16.00 WIB',
                'venue' => 'Aula Serbaguna',
                'category' => 'Pameran',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 85.000',
                'image' => 'gambarevent2.jpg',
            ],
            [
                'title' => 'Workshop Konten Digital',
                'date' => '06 Mei 2026',
                'time' => '13.00 - 17.00 WIB',
                'venue' => 'Lab Multimedia',
                'category' => 'Workshop',
                'status' => 'Tiket Habis',
                'price' => 'Rp 55.000',
                'image' => 'gambarevent.jpg',
            ],
            [
                'title' => 'Seminar Kewirausahaan',
                'date' => '10 Mei 2026',
                'time' => '09.00 - 12.00 WIB',
                'venue' => 'Gedung Serbaguna',
                'category' => 'Seminar',
                'status' => 'Tiket Habis',
                'price' => 'Rp 45.000',
                'image' => 'gambarevent.jpg',
            ],
            [
                'title' => 'Kompetisi Coding Nasional',
                'date' => '15 Mei 2026',
                'time' => '08.00 - 18.00 WIB',
                'venue' => 'Lab Komputer',
                'category' => 'Kompetisi',
                'status' => 'Pendaftaran Terbuka',
                'price' => 'Rp 95.000',
                'image' => 'gambarevent2.jpg',
            ],
            [
                'title' => 'Talkshow Alumni Sukses',
                'date' => '20 Mei 2026',
                'time' => '14.00 - 16.00 WIB',
                'venue' => 'Auditorium',
                'category' => 'Talkshow',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 65.000',
                'image' => 'gambarevent.jpg',
            ],
            [
                'title' => 'Festival Film Pendek',
                'date' => '25 Mei 2026',
                'time' => '18.00 - 22.00 WIB',
                'venue' => 'Teater Kampus',
                'category' => 'Festival',
                'status' => 'Pendaftaran Terbuka',
                'price' => 'Rp 75.000',
                'image' => 'gambarevent.jpg',
            ],
            [
                'title' => 'Workshop Desain Grafis',
                'date' => '30 Mei 2026',
                'time' => '09.00 - 15.00 WIB',
                'venue' => 'Studio Desain',
                'category' => 'Workshop',
                'status' => 'Tiket Habis',
                'price' => 'Rp 50.000',
                'image' => 'gambarevent.jpg',
            ],
        ]);

        $perPage = 6;
        $page = $request->input('page', 1);
        $currentPageItems = $events->slice(($page - 1) * $perPage, $perPage)->values();

        $paginatedEvents = new LengthAwarePaginator(
            $currentPageItems,
            $events->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('etalase_event', compact('paginatedEvents'));
    }
}
