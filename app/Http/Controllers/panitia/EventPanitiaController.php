<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventPanitiaController extends Controller
{
    public function index()
    {
        $events = session('events', []);

        return view('pages.panitia.event.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required',
            'waktu_mulai' => 'required',
            'lokasi' => 'required',
        ]);

        $events = session('events', []);

        // ✅ FIX: struktur lengkap sesuai blade
        $validated['id'] = count($events) + 1;
        $validated['status'] = 'Draft';
        $validated['tikets'] = [];

        // 🔥 INI YANG BIKIN ERROR TADI
        $validated['tanggal_selesai'] = null;
        $validated['waktu_selesai'] = null;

        $events[] = (object) $validated;

        session(['events' => $events]);

        return back()->with('success', 'Event berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $events = session('events', []);

        foreach ($events as &$event) {
            if ($event->id == $id) {
                $event->judul = $request->judul;
                $event->kategori = $request->kategori;
                $event->deskripsi = $request->deskripsi;
                $event->tanggal_mulai = $request->tanggal_mulai;
                $event->waktu_mulai = $request->waktu_mulai;
                $event->lokasi = $request->lokasi;
            }
        }

        session(['events' => $events]);

        return back()->with('success', 'Event berhasil diupdate');
    }

    public function destroy($id)
    {
        $events = session('events', []);

        $events = array_filter($events, function ($event) use ($id) {
            return $event->id != $id;
        });

        session(['events' => array_values($events)]);

        return back()->with('success', 'Event berhasil dihapus');
    }

    public function show($id) { return back(); }
    public function edit($id) { return back(); }
    public function kirim($id) { return back(); }
}