<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\DetailPembelian;

class RiwayatPanitiaController extends Controller
{
    /**
     * Menampilkan halaman riwayat event dan transaksi panitia.
     */
    public function index(Request $request)
    {
        $panitiaId = session('user_id');

        $allEvents = Event::where('status', 'Published')
            ->where('user_id', $panitiaId)
            ->latest()
            ->get();

        $categories = \App\Models\Kategori::all();

        $eventQuery = Event::where('status', 'Published')
            ->where('user_id', $panitiaId)
            ->where(function ($q) {
                $q->where('tanggal_selesai', '<', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '<', now()->toDateString());
                  });
            });

        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $eventQuery->where('kategori_id', $request->kategori_id);
        }

        if ($request->has('event_filter_id') && $request->event_filter_id != '') {
            $eventQuery->where('id', $request->event_filter_id);
        }

        $events = $eventQuery->with(['tikets', 'kategori'])
            ->latest()
            ->get();

        $query = DetailPembelian::with(['pembelian.user', 'tiket.event'])
            ->whereHas('pembelian', function ($q) {
                $q->where('status_pembayaran', 'Lunas');
            })
            ->whereHas('tiket.event', function ($q) use ($panitiaId) {
                $q->where('status', 'Published')
                  ->where('user_id', $panitiaId)
                  ->where(function ($queryTanggal) {
                      $queryTanggal->where('tanggal_selesai', '<', now()->toDateString())
                                   ->orWhere(function ($q2) {
                                       $q2->whereNull('tanggal_selesai')
                                          ->where('tanggal_mulai', '<', now()->toDateString());
                                   });
                  });
            });

        if ($request->has('trx_kategori_id') && $request->trx_kategori_id != '') {
            $query->whereHas('tiket.event', function ($q) use ($request) {
                $q->where('kategori_id', $request->trx_kategori_id);
            });
        }

        if ($request->has('event_id') && $request->event_id != '') {
            $query->whereHas('tiket', function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        $details = $query->latest()->get();

        $transaksis = $details->map(function ($detail) {
            $status = $detail->pembelian->status_pembayaran ?? 'Dibatalkan';
            $jenisTiket = ($detail->tiket->nama ?? '-') . ' (' . $detail->jumlah . 'x)';

            return (object) [
                'nama'       => $detail->pembelian->user->name ?? '-',
                'email'      => $detail->pembelian->user->email ?? '-',
                'event'      => $detail->tiket->event ?? null,
                'tiket'      => $detail->tiket ?? null,
                'created_at' => \Carbon\Carbon::parse($detail->created_at),
                'total'      => $detail->subtotal,
                'status'     => $status,
                'jenis_tiket'=> $jenisTiket,
            ];
        });

        return view('pages.panitia.riwayat', compact('events', 'transaksis', 'allEvents', 'categories'));
    }
}
