<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventPanitiaController extends Controller
{
    public function index()
    {
        $events = Event::with('tikets')->latest()->get(); // biar tiket ikut kebaca
        return view('pages.panitia.event.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'required',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload poster
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        // default status
        $validated['status'] = 'Draft';

        Event::create($validated);

        return back()->with('success', 'Event berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'required',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = Event::findOrFail($id);

        // update poster kalau ada
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        $event->update($validated);

        return back()->with('success', 'Event berhasil diupdate');
    }
    public function riwayat()
{
    // ambil event + tiket
    $events = Event::with('tikets')->latest()->get();

    // ambil transaksi (kalau sudah ada tabel transaksi)
    $transaksis = \App\Models\Transaksi::latest()->get();

    return view('pages.panitia.riwayat', compact('events', 'transaksis'));
}
}