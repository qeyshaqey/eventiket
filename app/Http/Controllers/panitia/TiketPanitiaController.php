<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketPanitiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Debug: tampilkan semua event dulu (hapus filter auth)
        $events = Event::with('tikets')
            ->latest()
            ->get();

        return view('panitia.tiket', compact('events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'kuota' => 'required|integer|min:1',
            'event_id' => 'required|exists:events,id',
        ]);

        Tiket::create($validated);

        // Update status event menjadi Published
        $event = Event::find($validated['event_id']);
        $event->update(['status' => 'Published']);

        return redirect()->route('panitia.tiket')->with('success', 'Tiket berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tiket $tiket)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'kuota' => 'required|integer|min:1',
        ]);

        $tiket->update($validated);

        return redirect()->route('panitia.tiket')->with('success', 'Tiket berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tiket $tiket)
    {
        $eventId = $tiket->event_id;
        $tiket->delete();

        // Jika tidak ada tiket lagi, update status event menjadi Draft
        $tiketCount = Tiket::where('event_id', $eventId)->count();
        if ($tiketCount === 0) {
            Event::find($eventId)->update(['status' => 'Draft']);
        }

        return redirect()->route('panitia.tiket')->with('success', 'Tiket berhasil dihapus!');
    }
}