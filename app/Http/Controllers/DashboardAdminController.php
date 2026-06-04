<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Event;
use App\Models\User;
use App\Models\PengajuanPanitia;
use Carbon\Carbon;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // ========== CARD STATS (dari Database) ==========
        $total_pengunjung = User::where('role', 'pengunjung')->count();
        $total_panitia = PengajuanPanitia::where('status', 'disetujui')->count();
        $total_event = Event::where('status', 'Published')->count();

        // ========== PIE CHART: Kategori (dari Database) ==========
        $categories = Kategori::withCount(['events' => function ($query) {
            $query->where('status', 'Published');
        }])->get();

        // ========== EVENT AKTIF BULAN INI (dari Database) ==========
        $now = Carbon::now();
        $eventsBulanIni = Event::with(['kategori', 'panitia'])
            ->where('status', 'Published')
            ->whereMonth('tanggal_mulai', $now->month)
            ->whereYear('tanggal_mulai', $now->year)
            ->orderBy('tanggal_mulai', 'asc')
            ->get()
            ->map(function ($e) {
                return [
                    "tanggal"   => Carbon::parse($e->tanggal_mulai)->format('d M'),
                    "nama"      => $e->judul,
                    "kategori"  => $e->kategori->nama_kategori ?? '-',
                    "waktu"     => Carbon::parse($e->waktu_mulai)->format('H:i') .
                                   ($e->waktu_selesai ? ' - ' . Carbon::parse($e->waktu_selesai)->format('H:i') : ''),
                    "lokasi"    => $e->lokasi,
                    "deskripsi" => $e->deskripsi,
                ];
            })
            ->toArray();

        // ========== LINE CHART: Statistik Pengunjung 7 hari terakhir ==========
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $chartData[] = User::where('role', 'pengunjung')
                ->whereDate('created_at', $date->toDateString())
                ->count();
        }

        return view('pages.admin.dashboard', compact(
            'total_pengunjung',
            'total_panitia',
            'total_event',
            'eventsBulanIni',
            'categories',
            'chartLabels',
            'chartData'
        ));
    }
}