<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $eventDisetujui = \App\Models\Event::with(['panitia', 'kategori'])->where('status', 'Published')->get();
        $eventDitolak = \App\Models\Event::with(['panitia', 'kategori'])->where('status', 'Rejected')->get();
        $eventPending = \App\Models\Event::with(['panitia', 'kategori'])->where('status', 'Draft')->get();

        return view('pages.admin.kelola-event', compact('eventDisetujui', 'eventDitolak', 'eventPending'));
    }

    public function approve($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $event->status = 'Published';
        $event->save();

        return redirect()->back()->with('success', 'Event berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $event->status = 'Rejected';
        $event->alasan_penolakan = $request->input('alasan', 'Tidak memenuhi syarat');
        $event->save();

        return redirect()->back()->with('success', 'Event berhasil ditolak');
    }

    public function delete($id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $event->delete();
        
        return redirect()->back()->with('success', 'Event berhasil dihapus');
    }
}