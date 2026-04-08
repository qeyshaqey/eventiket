<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaPanitiaController extends Controller
{
    public function index()
    {
        // data sementara (nanti bisa dari database)
        $totalEvent = 5;
        $totalPeserta = 120;
        $totalTiket = 300;
        $eventAktif = 2;

        $events = [
            [
                'nama' => 'Seminar IT',
                'tanggal' => '10 Mei 2026',
                'status' => 'Aktif'
            ],
            [
                'nama' => 'Workshop UI/UX',
                'tanggal' => '15 Mei 2026',
                'status' => 'Draft'
            ]
        ];

        return view('beranda', compact(
            'totalEvent',
            'totalPeserta',
            'totalTiket',
            'eventAktif',
            'events'
        ));
    }
}