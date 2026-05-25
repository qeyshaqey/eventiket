<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class EventPanitiaController extends Controller
{
    public function index()
    {
        $events = Event::with(['tikets', 'kategori'])->latest()->get();
        $categories = \App\Models\Kategori::all();

        return view('pages.panitia.event.index', compact('events', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required',
            'poster' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // upload poster
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        $validated['status'] = 'Draft';

        Event::create($validated);

        return back()->with('success', 'Event berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = Event::findOrFail($id);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        $event->update($validated);

        return back()->with('success', 'Event berhasil diupdate');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return back()->with('success', 'Event berhasil dihapus');
    }

    public function kirim($id)
    {
        $event = Event::findOrFail($id);
        $event->update(['status' => 'Pending']); // atau status yang sesuai
        
        return back()->with('success', 'Event berhasil dikirim ke Admin');
    }

    public function riwayat(Request $request)
    {
        $events = Event::with(['tikets', 'kategori'])->latest()->get();
        
        $query = Transaksi::with('event')->latest();

        if ($request->has('event_id') && $request->event_id != '') {
            $query->where('event_id', $request->event_id);
        }

        $transaksis = $query->get();

        return view('pages.panitia.riwayat', compact('events', 'transaksis'));
    }

    public function profil()
    {
        // Data Mock disimpan di session agar bisa "diupdate" untuk contoh
        $user = (object)[
            'name' => session('mock_name', session('user') ?? 'Panitia Event'),
            'email' => session('mock_email', 'panitia@eventiket.com'),
            'nim' => session('mock_nim', '2210112345'),
            'photo' => session('mock_photo', null)
        ];

        return view('pages.panitia.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        // Simulasi update dengan menyimpan ke session
        session([
            'mock_name' => $request->name,
            'mock_email' => $request->email,
            'mock_nim' => $request->nim,
            'user' => $request->name,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui (Simulasi)');
    }
}