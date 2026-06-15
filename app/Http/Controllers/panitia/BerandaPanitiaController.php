<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Kategori;
use Carbon\Carbon;

class BerandaPanitiaController extends Controller
{
    public function index()
    {
        $userId = session('user_id');

        //Total Tiket Terjual untuk event panitia ini saja
        $totalTiketTerjual = Tiket::whereHas('event', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('tiket_terjual');

        //Event Terdekat (Published, tanggal_mulai >= hari ini, terdekat) milik panitia saat ini
        $today = Carbon::today()->toDateString();
        $nearestEvent = Event::where('status', 'Published')
            ->where('user_id', $userId)
            ->whereDate('tanggal_mulai', '>=', $today)
            ->orderBy('tanggal_mulai', 'asc')
            ->first();

        // Jika tidak ada event di masa depan, ambil event published terdekat/terbaru milik panitia saat ini
        if (!$nearestEvent) {
            $nearestEvent = Event::where('status', 'Published')
                ->where('user_id', $userId)
                ->orderBy('tanggal_mulai', 'desc')
                ->first();
        }

        // Event Terlaris (Published, berdasarkan jumlah tiket_terjual terbanyak) milik panitia saat ini
        $bestSellingEvent = Event::where('status', 'Published')
            ->where('user_id', $userId)
            ->withSum('tikets', 'tiket_terjual')
            ->orderByDesc('tikets_sum_tiket_terjual')
            ->first();

        if ($bestSellingEvent && (!$bestSellingEvent->tikets_sum_tiket_terjual || $bestSellingEvent->tikets_sum_tiket_terjual <= 0)) {
            $bestSellingEvent = null;
        }

        // Daftar Event Aktif (Published dan belum berakhir/akan datang)
        $activeEvents = Event::where('status', 'Published')
            ->where('user_id', $userId)
            ->where(function ($q) use ($today) {
                $q->whereDate('tanggal_selesai', '>=', $today)
                  ->orWhere(function ($q2) use ($today) {
                      $q2->whereNull('tanggal_selesai')
                         ->whereDate('tanggal_mulai', '>=', $today);
                  });
            })
            ->with(['kategori', 'tikets'])
            ->orderBy('tanggal_mulai', 'asc')
            ->get();

        $totalActiveEvents = $activeEvents->count();

        // Seluruh Kategori untuk filter dropdown
        $categories = Kategori::all();

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