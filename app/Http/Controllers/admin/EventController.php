<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $eventAktif = Event::with(['panitia', 'kategori'])
            ->where('status', 'Published')
            ->where(function ($query) use ($today) {
                $query->where('tanggal_selesai', '>=', $today)
                      ->orWhere(function ($q) use ($today) {
                          $q->whereNull('tanggal_selesai')
                            ->where('tanggal_mulai', '>=', $today);
                      });
            })
            ->get();

        $eventRiwayat = Event::with(['panitia', 'kategori'])
            ->where('status', 'Published')
            ->where(function ($query) use ($today) {
                $query->where('tanggal_selesai', '<', $today)
                      ->orWhere(function ($q) use ($today) {
                          $q->whereNull('tanggal_selesai')
                            ->where('tanggal_mulai', '<', $today);
                      });
            })
            ->get();

        $eventDitolak = Event::with(['panitia', 'kategori'])->where('status', 'Rejected')->get();
        $eventPending = Event::with(['panitia', 'kategori'])->where('status', 'Pending')->get();

        $kategoris = \App\Models\Kategori::pluck('nama_kategori');

        return view('pages.admin.kelola-event', compact('eventAktif', 'eventRiwayat', 'eventDitolak', 'eventPending', 'kategoris'));
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        
        // Panggil method approve() dari model (Penerapan Polymorphism)
        $event->approve();

        return redirect()->back()->with('success', 'Event berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->alasan_penolakan = $request->input('alasan', 'Tidak memenuhi syarat');
        
        // Panggil method reject() dari model (Penerapan Polymorphism)
        $event->reject();

        return redirect()->back()->with('success', 'Event berhasil ditolak');
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        
        return redirect()->back()->with('success', 'Event berhasil dihapus');
    }
}
