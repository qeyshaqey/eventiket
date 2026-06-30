<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\DetailPembelian;

class EventPanitiaController extends Controller
{
    //Menampilkan daftar semua event yang dikelola oleh panitia.
     
    public function index(Request $request)
    {
        $query = Event::with(['tikets', 'kategori'])
            ->where('user_id', session('user_id'))
            ->where(function ($q) {
                $q->where('tanggal_selesai', '>=', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '>=', now()->toDateString());
                  });
            });

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use($request){
                $q->where('nama_kategori', $request->kategori);
            });
        }

        $events = $query->latest()->paginate(10);
        $categories = \App\Models\Kategori::all();

        // Mengirimkan data event dan kategori ke halaman view
        return view('pages.panitia.event.index', compact('events', 'categories'));
    }

    //Menyimpan data event baru ke dalam database.Dilengkapi validasi ketat untuk mendeteksi tanggal dan waktu yang sudah lewat di masa lalu.
    public function store(Request $request)
    {
        // Tanggal minimal = 7 hari dari sekarang (logika pengajuan panitia)
        $minDate = now()->addDays(7)->toDateString();
        $currentTime = date('H:i');

        // Aturan validasi dasar
        $rules = [
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategoris,id',
            'deskripsi' => 'required',
            'tanggal_mulai' => 'required|date|after_or_equal:' . $minDate,
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required',
            'poster' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Validasi Waktu Selesai: Waktu selesai harus selalu setelah waktu mulai
        $rules['waktu_selesai'] .= '|after:waktu_mulai';

        // Mengeksekusi validasi dengan pesan error khusus dalam Bahasa Indonesia
        $minDateFormatted = now()->addDays(7)->translatedFormat('d F Y');
        $validated = $request->validate($rules, [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai harus minimal 7 hari dari sekarang (minimal ' . $minDateFormatted . ').',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'poster.required' => 'Poster wajib diunggah.',
            'poster.image' => 'File poster harus berupa gambar.',
            'poster.mimes' => 'Format poster harus jpg, jpeg, atau png.',
            'poster.max' => 'Ukuran poster maksimal 2MB.',
            'judul.required' => 'Judul event wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'deskripsi.required' => 'Deskripsi event wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
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

        return back()->with('success', 'Event berhasil ditambahkan');
    }

    //Memperbarui data event yang sudah ada.
    public function update(Request $request, $id)
    {
        // Mencari event berdasarkan ID, tampilkan error 404 jika tidak ditemukan
        $event = Event::findOrFail($id);

        // Tanggal minimal = 7 hari dari sekarang (jika tanggal diubah)
        $minDate = now()->addDays(7)->toDateString();

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

        // Hanya validasi minimal 7 hari jika tanggal mulai diubah oleh pengguna
        if ($request->tanggal_mulai !== $event->tanggal_mulai) {
            $rules['tanggal_mulai'] .= '|after_or_equal:' . $minDate;
        }

        // Validasi Waktu Selesai: Waktu selesai harus selalu setelah waktu mulai
        $rules['waktu_selesai'] .= '|after:waktu_mulai';

        // Mengeksekusi validasi dengan pesan error khusus dalam Bahasa Indonesia
        $minDateFormatted = now()->addDays(7)->translatedFormat('d F Y');
        $validated = $request->validate($rules, [
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai harus minimal 7 hari dari sekarang (minimal ' . $minDateFormatted . ').',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai harus setelah atau sama dengan tanggal mulai.',
            'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
            'poster.image' => 'File poster harus berupa gambar.',
            'poster.mimes' => 'Format poster harus jpg, jpeg, atau png.',
            'poster.max' => 'Ukuran poster maksimal 2MB.',
            'judul.required' => 'Judul event wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'deskripsi.required' => 'Deskripsi event wajib diisi.',
            'tanggal_mulai.required' => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Tanggal selesai wajib diisi.',
            'waktu_mulai.required' => 'Waktu mulai wajib diisi.',
            'waktu_selesai.required' => 'Waktu selesai wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
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

    //Menghapus event dari database.
    public function destroy($id)
    {
        // Mencari event
        $event = Event::findOrFail($id);

        // Cek apakah ada pembelian untuk tiket di event ini
        $hasPurchases = \App\Models\DetailPembelian::whereHas('tiket', function($q) use ($id) {
            $q->where('event_id', $id);
        })->exists();

        if ($hasPurchases) {
            return back()->with('error', 'Event tidak dapat dihapus karena sudah memiliki transaksi pembelian.');
        }

        try {
            $event->delete();
            return back()->with('success', 'Event berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus event.');
        }
    }

    //Mengirimkan event ke Admin untuk peninjauan (mengubah status menjadi 'Pending').
    public function kirim($id)
    {
        // Mencari event berdasarkan ID
        $event = Event::findOrFail($id);
        // Mengubah status event menjadi Pending
        $event->update(['status' => 'Pending']); 
        
        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Event berhasil dikirim ke Admin');
    }
}