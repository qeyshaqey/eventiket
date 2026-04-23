<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketPanitiaController extends Controller
{
    public function index(Request $request)
{
    $events = Event::with('tikets')->latest()->get();

    $highlightEventId = $request->query('event_id');

    return view('pages.panitia.tiket', compact('events', 'highlightEventId'));
}

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required',
        'harga' => 'required|integer',
        'kuota' => 'required|integer',
        'event_id' => 'required|exists:events,id',
    ]);

    Tiket::create($validated);

    // update status event jadi Published
    Event::find($validated['event_id'])
        ->update(['status' => 'Published']);

    return redirect()->route('panitia.tiket', [
        'event_id' => $validated['event_id']
    ]);
}

    public function update(Request $request, Tiket $tiket)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|integer',
            'kuota' => 'required|integer',
        ]);

        $tiket->update($validated);

        return back()->with('success', 'Tiket diupdate');
    }

    public function destroy(Tiket $tiket)
    {
        $eventId = $tiket->event_id;
        $tiket->delete();

        // kalau tiket habis, balik ke Draft
        if (Tiket::where('event_id', $eventId)->count() === 0) {
            Event::where('id', $eventId)->update(['status' => 'Draft']);
        }

        return back()->with('success', 'Tiket dihapus');
    }
}