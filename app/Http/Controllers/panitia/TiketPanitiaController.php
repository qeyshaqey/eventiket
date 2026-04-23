<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TiketPanitiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = session('events', []);
        $highlightEventId = $request->query('event_id');

        return view('pages.panitia.tiket', compact('events', 'highlightEventId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'kuota' => 'required',
            'event_id' => 'required',
        ]);

        $events = session('events', []);

        foreach ($events as &$event) {
            if ($event->id == $validated['event_id']) {

                // kalau belum ada tikets, bikin array dulu
                if (!isset($event->tikets)) {
                    $event->tikets = [];
                }

                // tambah tiket
                $event->tikets[] = (object) [
                    'id' => count($event->tikets) + 1,
                    'nama' => $validated['nama'],
                    'harga' => $validated['harga'],
                    'kuota' => $validated['kuota'],
                ];

                // update status
                $event->status = 'Published';
            }
        }

        session(['events' => $events]);

        return redirect()->route('panitia.tiket', [
            'event_id' => $validated['event_id']
        ]);
    }

    /**
     * Update tiket (SESSION VERSION)
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required',
            'kuota' => 'required',
        ]);

        $events = session('events', []);

        foreach ($events as &$event) {
            if (!isset($event->tikets)) continue;

            foreach ($event->tikets as &$tiket) {
                if ($tiket->id == $id) {
                    $tiket->nama = $validated['nama'];
                    $tiket->harga = $validated['harga'];
                    $tiket->kuota = $validated['kuota'];
                }
            }
        }

        session(['events' => $events]);

        return back()->with('success', 'Tiket berhasil diupdate!');
    }

    /**
     * Remove tiket (SESSION VERSION)
     */
    public function destroy($id)
    {
        $events = session('events', []);

        foreach ($events as &$event) {

            if (!isset($event->tikets)) continue;

            // hapus tiket
            $event->tikets = array_filter($event->tikets, function ($tiket) use ($id) {
                return $tiket->id != $id;
            });

            // reset index
            $event->tikets = array_values($event->tikets);

            // kalau tiket habis → balik ke Draft
            if (count($event->tikets) === 0) {
                $event->status = 'Draft';
            }
        }

        session(['events' => $events]);

        return back()->with('success', 'Tiket berhasil dihapus!');
    }
}