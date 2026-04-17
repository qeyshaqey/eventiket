<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventPanitiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil events untuk user yang login (atau semua jika admin)
        $events = Event::when(auth()->check(), function ($query) {
            return $query->where('panitia_id', auth()->id());
        })->latest()->get();

        return view('panitia.event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panitia.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('event-images', 'public');
        }

        // Set default status Draft
        $validated['status'] = 'Draft';
        
        // Set panitia_id (gunakan user login atau default 1 untuk demo)
        $validated['panitia_id'] = auth()->id() ?? 1;

        Event::create($validated);

        return redirect()->route('panitia.event')->with('success', 'Event berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('panitia.event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('panitia.event.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date',
            'waktu' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($event->gambar) {
                Storage::disk('public')->delete($event->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('event-images', 'public');
        }

        $event->update($validated);

        return redirect()->route('panitia.event')->with('success', 'Event berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Hapus gambar jika ada
        if ($event->gambar) {
            Storage::disk('public')->delete($event->gambar);
        }

        $event->delete();

        return redirect()->route('panitia.event')->with('success', 'Event berhasil dihapus!');
    }

    /**
     * Kirim event ke admin untuk approval
     */
    public function kirim(Event $event)
    {
        $event->update(['status' => 'Published']);
        return redirect()->route('panitia.event')->with('success', 'Event berhasil dikirim ke admin!');
    }
}
