<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventPanitiaController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get();
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

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        $validated['status'] = 'Draft';

        Event::create($validated);

        return back()->with('success', 'Event berhasil ditambahkan');
    }
}