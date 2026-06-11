<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index()
    {
        $pembelians = \App\Models\Pembelian::with(['user', 'detail_pembelians.tiket.event.kategori'])
            ->where('status_pembayaran', 'Lunas')
            ->latest()
            ->get();

        $data = [];
        foreach ($pembelians as $pembelian) {
            $user = $pembelian->user;
            if (!$user) continue;

            foreach ($pembelian->detail_pembelians as $detail) {
                $tiket = $detail->tiket;
                $event = $tiket ? $tiket->event : null;
                $kategori = $event ? $event->kategori : null;

                $data[] = [
                    'nama' => $user->name,
                    'email' => $user->email,
                    'nim' => $user->nim ?? '-',
                    'tanggal_beli' => $pembelian->tanggal_beli ?? ($pembelian->created_at ? $pembelian->created_at->toDateString() : date('Y-m-d')),
                    'kategori' => $kategori ? $kategori->nama_kategori : '-',
                    'event' => $event ? $event->judul : '-',
                    'foto' => $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=192853&color=fbbf24&size=80&rounded=true&bold=true'
                ];
            }
        }

        $kategoris = \App\Models\Kategori::pluck('nama_kategori');
        $events = \App\Models\Event::pluck('judul');

        return view('pages.admin.pengunjung', compact('data', 'kategoris', 'events'));
    }

    public function create()
    {
        return view('pengunjung_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'event' => 'required',
            'kategori' => 'required',
        ]);

        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        return "Detail pengunjung ID: " . $id;
    }

    public function edit($id)
    {
        return "Edit pengunjung ID: " . $id;
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        return redirect()->route('pengunjung.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
