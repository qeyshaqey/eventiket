<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanPanitia;

class PanitiaController extends Controller
{
    public function index()
    {
        // ================= KELOLA =================
        $kelola = PengajuanPanitia::with('user')
            ->whereIn('status', ['disetujui', 'dicabut'])
            ->get()
            ->map(function ($item) {
                return [
                    "id" => $item->id,
                    "nama" => $item->user->name ?? '',
                    "email" => $item->user->email ?? '',
                    "nim" => $item->user->nim ?? '',
                    "nama_organisasi" => $item->nama_organisasi,
                    "status" => $item->status == 'disetujui' ? 'Aktif' : 'Nonaktif'
                ];
            })
            ->toArray();

        // ================= PENGAJUAN =================
        $pengajuan = PengajuanPanitia::with('user')
            ->where('status', 'pending')
            ->get()
            ->map(function ($item) {
                return [
                    "id" => $item->id,
                    "nama" => $item->user->name ?? '',
                    "email" => $item->user->email ?? '',
                    "nim" => $item->user->nim ?? '',
                    "tanggal" => $item->created_at ? $item->created_at->format('d M Y') : '',
                    "nama_organisasi" => $item->nama_organisasi,
                    "event_nama" => $item->nama_event ?? '',
                    "kategori_event" => $item->kategori ?? '',
                    "tgl_event" => $item->tanggal_event ? \Carbon\Carbon::parse($item->tanggal_event)->format('d M Y') : '',
                    "deskripsi" => $item->deskripsi ?? ''
                ];
            })
            ->toArray();

        // ================= DITOLAK =================
        $ditolak = PengajuanPanitia::with('user')
            ->where('status', 'ditolak')
            ->get()
            ->map(function ($item) {
                return [
                    "nama" => $item->user->name ?? '',
                    "email" => $item->user->email ?? '',
                    "nim" => $item->user->nim ?? '',
                    "nama_organisasi" => $item->nama_organisasi,
                    "alasan" => $item->alasan_penolakan ?? 'Tidak ada alasan'
                ];
            })
            ->toArray();

        return view('pages.admin.panitia', compact('kelola', 'pengajuan', 'ditolak'));
    }

    public function approve($id)
    {
        $pengajuan = PengajuanPanitia::findOrFail($id);
        $pengajuan->status = 'disetujui';
        $pengajuan->save();

        $user = $pengajuan->user;
        if ($user) {
            $user->role = 'panitia';
            $user->save();
        }
 
        return redirect()->back()->with('success', 'Pengajuan panitia berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $pengajuan = PengajuanPanitia::findOrFail($id);
        $pengajuan->status = 'ditolak';
        $pengajuan->alasan_penolakan = $request->alasan_penolakan;
        $pengajuan->save();

        return redirect()->back()->with('success', 'Pengajuan panitia berhasil ditolak.');
    }

    public function demote($id)
    {
        $pengajuan = PengajuanPanitia::findOrFail($id);
        
        $user = $pengajuan->user;
        if ($user) {
            // Cek apakah panitia ini memiliki event aktif (status = 'Published')
            $hasActiveEvents = \App\Models\Event::where('user_id', $user->id)
                ->where('status', 'Published')
                ->exists();

            if ($hasActiveEvents) {
                return redirect()->back()->with('error', 'Tidak dapat menurunkan jabatan panitia ini karena masih memiliki event aktif.');
            }

            $user->role = 'pengunjung';
            $user->save();
        }

        $pengajuan->status = 'dicabut';
        $pengajuan->save();
 
        return redirect()->back()->with('success', 'Jabatan panitia berhasil diturunkan.');
    }
}
