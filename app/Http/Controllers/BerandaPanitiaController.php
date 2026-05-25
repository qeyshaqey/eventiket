<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Kategori;

class BerandaPanitiaController extends Controller
{
    public function index()
    {
        // 1. Total Tiket Terjual
        $totalTiketTerjual = Tiket::sum('tiket_terjual');

        // 2. Event Terdekat (Published, tanggal_mulai >= hari ini, terdekat)
        $nearestEvent = Event::where('status', 'Published')
            ->where('tanggal_mulai', '>=', now()->toDateString())
            ->orderBy('tanggal_mulai', 'asc')
            ->first();

        // Jika tidak ada event di masa depan, ambil event published terdekat/terbaru apa saja
        if (!$nearestEvent) {
            $nearestEvent = Event::where('status', 'Published')
                ->orderBy('tanggal_mulai', 'desc')
                ->first();
        }

        // 3. Event Terlaris (Published, berdasarkan jumlah tiket_terjual terbanyak)
        $bestSellingEvent = Event::where('status', 'Published')
            ->withSum('tikets', 'tiket_terjual')
            ->orderByDesc('tikets_sum_tiket_terjual')
            ->first();

        if ($bestSellingEvent && (!$bestSellingEvent->tikets_sum_tiket_terjual || $bestSellingEvent->tikets_sum_tiket_terjual <= 0)) {
            $bestSellingEvent = null;
        }

        // 4. Daftar Event Aktif (Published dan belum berakhir/akan datang)
        $activeEvents = Event::where('status', 'Published')
            ->where(function ($q) {
                $q->where('tanggal_selesai', '>=', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '>=', now()->toDateString());
                  });
            })
            ->with(['kategori', 'tikets'])
            ->latest()
            ->get();

        $totalActiveEvents = $activeEvents->count();

        // 5. Seluruh Kategori untuk filter dropdown
        $categories = Kategori::all();

        // Map data event untuk dikonsumsi oleh JavaScript interaktif di halaman
        $eventsData = $activeEvents->map(function ($event) {
            // Format tanggal mulai & selesai
            $start = \Carbon\Carbon::parse($event->tanggal_mulai);
            $tanggal = $start->translatedFormat('d F');
            if ($event->tanggal_selesai && $event->tanggal_selesai !== $event->tanggal_mulai) {
                $end = \Carbon\Carbon::parse($event->tanggal_selesai);
                if ($start->format('m Y') === $end->format('m Y')) {
                    $tanggal = $start->format('d') . '-' . $end->format('d') . ' ' . $start->translatedFormat('F');
                } else {
                    $tanggal = $start->translatedFormat('d M') . ' - ' . $end->translatedFormat('d M');
                }
            }

            // Total kuota = jumlah kuota seluruh jenis tiket untuk event ini
            $totalKuota = $event->tikets->sum('kuota');

            return [
                'judul' => $event->judul,
                'kategori' => $event->kategori->nama_kategori ?? '-',
                'tanggal' => $tanggal,
                'waktu' => $event->waktu_mulai ? substr($event->waktu_mulai, 0, 5) : '00:00',
                'lokasi' => $event->lokasi ?? '-',
                'kuota' => $totalKuota
            ];
        });

        return view('pages.panitia.berandapanitia', compact(
            'totalTiketTerjual',
            'nearestEvent',
            'bestSellingEvent',
            'totalActiveEvents',
            'categories',
            'eventsData'
        ));
    }
}