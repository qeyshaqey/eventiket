<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $eventDisetujui = Event::with(['panitia', 'kategori'])->where('status', 'Published')->get();
        $eventDitolak = Event::with(['panitia', 'kategori'])->where('status', 'Rejected')->get();
        $eventPending = Event::with(['panitia', 'kategori'])->where('status', 'Pending')->get();

        return view('pages.admin.kelola-event', compact('eventDisetujui', 'eventDitolak', 'eventPending'));
    }

    public function approve($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'Published';
        $event->save();

        return redirect()->back()->with('success', 'Event berhasil disetujui');
    }

    public function reject(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'Rejected';
        $event->alasan_penolakan = $request->input('alasan', 'Tidak memenuhi syarat');
        $event->save();

        return redirect()->back()->with('success', 'Event berhasil ditolak');
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        
        return redirect()->back()->with('success', 'Event berhasil dihapus');
    }
}
