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
    /**
     * Menampilkan daftar semua event yang dikelola oleh panitia.
     * Mengambil data event beserta tiket dan kategorinya, serta semua kategori untuk modal tambah/edit.
     */
    public function index()
    {
        // Mengambil semua data event diurutkan dari yang terbaru beserta relasinya
        $events = Event::with(['tikets', 'kategori'])->latest()->get();
        // Mengambil semua kategori untuk opsi pilihan dropdown pada form
        $categories = \App\Models\Kategori::all();

        // Mengirimkan data event dan kategori ke halaman view
        return view('pages.panitia.event.index', compact('events', 'categories'));
    }

    /**
     * Menyimpan data event baru ke dalam database.
     * Dilengkapi validasi ketat untuk mendeteksi tanggal dan waktu yang sudah lewat di masa lalu.
     */
    public function store(Request $request)
    {
        // Mendapatkan tanggal hari ini dalam format Y-m-d dan waktu sekarang H:i
        $today = date('Y-m-d');
        $currentTime = date('H:i');

        // Aturan validasi dasar
        $rules = [
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required',
            'poster' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Validasi Waktu Mulai: Jika tanggal mulai adalah HARI INI, waktu mulai harus setelah jam sekarang
        if ($request->tanggal_mulai === $today) {
            $rules['waktu_mulai'] .= '|after:' . $currentTime;
        }

        // Validasi Waktu Selesai: Jika tanggal mulai dan tanggal selesai sama, waktu selesai harus setelah waktu mulai
        if ($request->tanggal_mulai === $request->tanggal_selesai) {
            $rules['waktu_selesai'] .= '|after:waktu_mulai';
        }

        // Mengeksekusi validasi dengan pesan error khusus dalam Bahasa Indonesia
        $validated = $request->validate($rules, [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh tanggal yang sudah lewat.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'waktu_mulai.after' => 'Waktu mulai harus setelah waktu sekarang untuk event hari ini.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai pada hari yang sama.',
        ]);

        // Mengunggah file poster jika ada ke storage public
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        // Set status bawaan menjadi Draft dan mengambil user_id dari sesi saat ini
        $validated['status'] = 'Draft';
        $validated['user_id'] = session('user_id');

        // Membuat record event baru di database
        Event::create($validated);

        // Kembali ke halaman sebelumnya dengan membawa pesan sukses
        return back()->with('success', 'Event berhasil ditambahkan');
    }

    /**
     * Memperbarui data event yang sudah ada.
     * Validasi tanggal/waktu lampau bersifat dinamis agar tidak mengunci event lama yang sedang diedit.
     */
    public function update(Request $request, $id)
    {
        // Mencari event berdasarkan ID, tampilkan error 404 jika tidak ditemukan
        $event = Event::findOrFail($id);

        $today = date('Y-m-d');
        $currentTime = date('H:i');

        // Aturan validasi dasar
        $rules = [
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Hanya validasi tanggal hari ini/mendatang jika tanggal mulai diubah oleh pengguna
        if ($request->tanggal_mulai !== $event->tanggal_mulai) {
            $rules['tanggal_mulai'] .= '|after_or_equal:today';
        }

        // Validasi waktu mulai: Jika tanggal mulai diatur ke hari ini dan diubah, pastikan tidak menggunakan jam yang sudah lewat
        if ($request->tanggal_mulai === $today && ($request->tanggal_mulai !== $event->tanggal_mulai || $request->waktu_mulai !== $event->waktu_mulai)) {
            $rules['waktu_mulai'] .= '|after:' . $currentTime;
        }

        // Jika tanggal mulai dan selesai sama, pastikan waktu selesai tidak mendahului waktu mulai
        if ($request->tanggal_mulai === $request->tanggal_selesai) {
            $rules['waktu_selesai'] .= '|after:waktu_mulai';
        }

        // Mengeksekusi validasi dengan pesan error khusus dalam Bahasa Indonesia
        $validated = $request->validate($rules, [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh tanggal yang sudah lewat.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'waktu_mulai.after' => 'Waktu mulai harus setelah waktu sekarang untuk event hari ini.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai pada hari yang sama.',
        ]);

        // Mengunggah file poster baru jika diunggah oleh user
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('poster', 'public');
        }

        // Memperbarui data event di database
        $event->update($validated);

        // Kembali dengan pesan sukses
        return back()->with('success', 'Event berhasil diupdate');
    }

    /**
     * Menghapus event dari database.
     */
    public function destroy($id)
    {
        // Mencari event lalu menghapusnya
        $event = Event::findOrFail($id);
        $event->delete();

        // Kembali dengan pesan sukses
        return back()->with('success', 'Event berhasil dihapus');
    }

    /**
     * Mengirimkan event ke Admin untuk peninjauan (mengubah status menjadi 'Pending').
     */
    public function kirim($id)
    {
        // Mencari event berdasarkan ID
        $event = Event::findOrFail($id);
        // Mengubah status event menjadi Pending
        $event->update(['status' => 'Pending']); 
        
        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Event berhasil dikirim ke Admin');
    }

    /**
     * Menampilkan riwayat transaksi dan data event yang sudah selesai (masa lalu).
     * Berisi filter kategori dan detail pembelian tiket.
     */
    public function riwayat(Request $request)
    {
        // MENGAMBIL SEMUA EVENT YANG SUDAH SELESAI
        // Berstatus 'Published' dan tanggal selesai kurang dari hari ini
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

        // Mengambil semua kategori untuk filter
        $categories = \App\Models\Kategori::all();

        // Menyiapkan query event selesai untuk tab Event
        $eventQuery = Event::where('status', 'Published')
            ->where(function ($q) {
                $q->where('tanggal_selesai', '<', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '<', now()->toDateString());
                  });
            });

        // Menerapkan filter kategori jika dipilih
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $eventQuery->where('kategori_id', $request->kategori_id);
        }

        // Menerapkan filter ID event jika dipilih
        if ($request->has('event_filter_id') && $request->event_filter_id != '') {
            $eventQuery->where('id', $request->event_filter_id);
        }

        // Mengeksekusi query event selesai
        $events = $eventQuery->with(['tikets', 'kategori'])
            ->latest()
            ->get();
        
        // Menyiapkan query transaksi (detail pembelian) untuk event yang sudah selesai
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

        // Menerapkan filter kategori transaksi
        if ($request->has('trx_kategori_id') && $request->trx_kategori_id != '') {
            $query->whereHas('tiket.event', function ($q) use ($request) {
                $q->where('kategori_id', $request->trx_kategori_id);
            });
        }

        // Menerapkan filter event transaksi
        if ($request->has('event_id') && $request->event_id != '') {
            $query->whereHas('tiket', function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        // Mengeksekusi query detail pembelian
        $details = $query->latest()->get();

        // Memetakan status pembayaran dari DB ke status yang dimengerti oleh view
        $transaksis = $details->map(function ($detail) {
            $status = $detail->pembelian->status_pembayaran ?? 'Dibatalkan';

            $jenisTiket = ($detail->tiket->nama ?? '-') . ' (' . $detail->jumlah . 'x)';

            // Membuat objek transaksi standar untuk dikirim ke view
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

        // Merender view riwayat beserta data-datanya
        return view('pages.panitia.riwayat', compact('events', 'transaksis', 'allEvents', 'categories'));
    }

    /**
     * Menampilkan profil simulasi panitia.
     */
    public function profil()
    {
        // Menggunakan data mock yang disimpan di session untuk keperluan simulasi profil
        $user = (object)[
            'name' => session('mock_name', session('user') ?? 'Panitia Event'),
            'email' => session('mock_email', 'panitia@eventiket.com'),
            'nim' => session('mock_nim', '2210112345'),
            'photo' => session('mock_photo', null)
        ];

        return view('pages.panitia.profil', compact('user'));
    }

    /**
     * Memperbarui profil simulasi panitia di dalam session.
     */
    public function updateProfil(Request $request)
    {
        // Menyimpan data simulasi profil baru ke dalam session
        session([
            'mock_name' => $request->name,
            'mock_email' => $request->email,
            'mock_nim' => $request->nim,
            'user' => $request->name,
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Profil berhasil diperbarui (Simulasi)');
    }
}