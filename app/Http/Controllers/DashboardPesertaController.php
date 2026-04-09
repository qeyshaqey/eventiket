<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DashboardPesertaController extends Controller
{
    private function events()
    {
        return collect([
            [
                'id' => 1,
                'title' => 'Festival Musik Kampus',
                'date' => '28 April 2026',
                'time' => '19.00 WIB',
                'venue' => 'Lapangan Terbuka',
                'category' => 'Musik',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 125.000',
                'image' => 'gambarevent.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 150000],
                    ['type' => 'Tiket Umum', 'price' => 125000],
                    ['type' => 'Tiket Premium', 'price' => 200000],
                ],
            ],
            [
                'id' => 2,
                'title' => 'Pameran Startup Lokal',
                'date' => '02 Mei 2026',
                'time' => '10.00 - 16.00 WIB',
                'venue' => 'Aula Serbaguna',
                'category' => 'Pameran',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 85.000',
                'image' => 'gambarevent2.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 110000],
                    ['type' => 'Tiket Umum', 'price' => 85000],
                    ['type' => 'Tiket Premium', 'price' => 140000],
                ],
            ],
            [
                'id' => 3,
                'title' => 'Workshop Konten Digital',
                'date' => '06 Mei 2026',
                'time' => '13.00 - 17.00 WIB',
                'venue' => 'Lab Multimedia',
                'category' => 'Workshop',
                'status' => 'Tiket Habis',
                'price' => 'Rp 55.000',
                'image' => 'gambarevent.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 70000],
                    ['type' => 'Tiket Umum', 'price' => 55000],
                    ['type' => 'Tiket Premium', 'price' => 90000],
                ],
            ],
            [
                'id' => 4,
                'title' => 'Seminar Kewirausahaan',
                'date' => '10 Mei 2026',
                'time' => '09.00 - 12.00 WIB',
                'venue' => 'Gedung Serbaguna',
                'category' => 'Seminar',
                'status' => 'Tiket Habis',
                'price' => 'Rp 45.000',
                'image' => 'gambarevent.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 60000],
                    ['type' => 'Tiket Umum', 'price' => 45000],
                    ['type' => 'Tiket Premium', 'price' => 80000],
                ],
            ],
            [
                'id' => 5,
                'title' => 'Kompetisi Coding Nasional',
                'date' => '15 Mei 2026',
                'time' => '08.00 - 18.00 WIB',
                'venue' => 'Lab Komputer',
                'category' => 'Kompetisi',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 95.000',
                'image' => 'gambarevent2.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 120000],
                    ['type' => 'Tiket Umum', 'price' => 95000],
                    ['type' => 'Tiket Premium', 'price' => 175000],
                ],
            ],
            [
                'id' => 6,
                'title' => 'Talkshow Alumni Sukses',
                'date' => '20 Mei 2026',
                'time' => '14.00 - 16.00 WIB',
                'venue' => 'Auditorium',
                'category' => 'Talkshow',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 65.000',
                'image' => 'gambarevent.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 90000],
                    ['type' => 'Tiket Umum', 'price' => 65000],
                    ['type' => 'Tiket Premium', 'price' => 120000],
                ],
            ],
            [
                'id' => 7,
                'title' => 'Festival Film Pendek',
                'date' => '25 Mei 2026',
                'time' => '18.00 - 22.00 WIB',
                'venue' => 'Teater Kampus',
                'category' => 'Festival',
                'status' => 'Tersedia Tiket',
                'price' => 'Rp 75.000',
                'image' => 'gambarevent.jpg',
                'tickets' => [
                    ['type' => 'Tiket Perdana', 'price' => 100000],
                    ['type' => 'Tiket Umum', 'price' => 75000],
                    ['type' => 'Tiket Premium', 'price' => 140000],
                ],
            ],
        ]);
    }

    public function index(Request $request)
    {
        $events = $this->events();
        $perPage = 4;
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

        return view('dashboard_peserta', compact('paginatedEvents'));
    }

    public function showDetail($id)
    {
        $event = $this->events()->firstWhere('id', (int) $id);

        if (! $event) {
            abort(404);
        }

        return view('detail_event', compact('event'));
    }
}