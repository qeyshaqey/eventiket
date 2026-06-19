<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
                    "tanggal"   => Carbon::parse($e->tanggal_mulai)->format('d M') . ($e->tanggal_selesai && $e->tanggal_selesai !== $e->tanggal_mulai ? ' - ' . Carbon::parse($e->tanggal_selesai)->format('d M') : ''),
                    "nama"      => $e->judul,
                    "kategori"  => $e->kategori->nama_kategori ?? '-',
                    "waktu"     => Carbon::parse($e->waktu_mulai)->format('H:i') .
                                   ($e->waktu_selesai ? ' - ' . Carbon::parse($e->waktu_selesai)->format('H:i') : ''),
                    "lokasi"    => $e->lokasi,
                    "deskripsi" => $e->deskripsi,
                ];
            })
            ->toArray();

        return view('pages.admin.dashboard', compact(
            'total_pengunjung',
            'total_panitia',
            'total_event',
            'eventsBulanIni',
            'categories'
        ));
    }
}
