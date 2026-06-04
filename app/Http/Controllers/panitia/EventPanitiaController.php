<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\DetailPembelian;
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
        $validated['user_id'] = session('user_id');

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
        //MENAMPILKAN SEMUA EVENT YANG SUDAH SELESAI UNTUK DITAMPILKAN DI FILTER DAN DI TABS EVENT
        $allEvents = Event::where('status', 'Published')
            ->where(function ($q) {
                $q->where('tanggal_selesai', '<', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '<', now()->toDateString());
                  });
            })
            ->latest()
            ->get();

        // MENAMPILKAN SEMUA KATEGORI UNTUK FILTER
        $categories = \App\Models\Kategori::all();

        // Filter events yang sudah selesai untuk ditampilkan di tab Event
        $eventQuery = Event::where('status', 'Published')
            ->where(function ($q) {
                $q->where('tanggal_selesai', '<', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '<', now()->toDateString());
                  });
            });

        // FILTER BERDASARKAN KATEGORI
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $eventQuery->where('kategori_id', $request->kategori_id);
        }

        // FILTER BERDASARKAN EVENT
        if ($request->has('event_filter_id') && $request->event_filter_id != '') {
            $eventQuery->where('id', $request->event_filter_id);
        }

        $events = $eventQuery->with(['tikets', 'kategori'])
            ->latest()
            ->get();
        
        // MENGAMBIL DATA DETAIL PEMBELIAN YANG TERKAIT DENGAN EVENT YANG SUDAH SELESAI
        $query = DetailPembelian::with(['pembelian.user', 'tiket.event'])
            ->whereHas('tiket.event', function ($q) {
                $q->where('status', 'Published')
                  ->where(function ($q2) {
                      $q2->where('tanggal_selesai', '<', now()->toDateString())
                        ->orWhere(function ($q3) {
                            $q3->whereNull('tanggal_selesai')
                               ->where('tanggal_mulai', '<', now()->toDateString());
                        });
                  });
            });

        // FILTER DETAIL PEMBELIAN BERDASARKAN KATEGORI
        if ($request->has('trx_kategori_id') && $request->trx_kategori_id != '') {
            $query->whereHas('tiket.event', function ($q) use ($request) {
                $q->where('kategori_id', $request->trx_kategori_id);
            });
        }

        // FILTER DETAIL PEMBELIAN BERDASARKAN EVENT
        if ($request->has('event_id') && $request->event_id != '') {
            $query->whereHas('tiket', function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        $details = $query->latest()->get();

        // KONVERSI STATUS PEMBAYARAN YANG DIKIRIM KE VIEW
        $transaksis = $details->map(function ($detail) {
            $rawStatus = $detail->pembelian->status_pembayaran ?? 'Batal';
            $status = 'failed';
            if ($rawStatus === 'Pending') {
                $status = 'pending';
            } elseif ($rawStatus === 'Sukses') {
                $status = 'paid';
            }

            $jenisTiket = ($detail->tiket->nama ?? '-') . ' (' . $detail->jumlah . 'x)';

            //OBJEK TRANSAKSI YANG DIKIRIM KE VIEW
            return (object) [
                'nama' => $detail->pembelian->user->name ?? '-',
                'email' => $detail->pembelian->user->email ?? '-',
                'event' => $detail->tiket->event ?? null,
                'tiket' => $detail->tiket ?? null,
                'created_at' => $detail->created_at,
                'total' => $detail->subtotal,
                'status' => $status,
                'jenis_tiket' => $jenisTiket,
            ];
        });

        return view('pages.panitia.riwayat', compact('events', 'transaksis', 'allEvents', 'categories'));
    }

    public function profil()
    {
        // Disimpan di session agar bisa "diupdate" untuk contoh saja, karena tidak ada tabel user yang sebenarnya untuk panitia
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