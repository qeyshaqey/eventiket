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
        // ID panitia yang sedang login
        $panitiaId = session('user_id');

        // MENGAMBIL SEMUA EVENT MILIK PANITIA YANG SUDAH SELESAI
        // Berstatus 'Published' dan tanggal selesai kurang dari hari ini
        $allEvents = Event::where('status', 'Published')
            ->where('user_id', $panitiaId)
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

        // Menyiapkan query event selesai milik panitia untuk tab Event
        $eventQuery = Event::where('status', 'Published')
            ->where('user_id', $panitiaId)
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
        
        // Menyiapkan query transaksi untuk event milik panitia yang sudah selesai
        $query = DetailPembelian::with(['pembelian.user', 'tiket.event'])
            ->whereHas('tiket.event', function ($q) use ($panitiaId) {
                $q->where('status', 'Published')
                  ->where('user_id', $panitiaId)
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
            // Meneruskan status langsung dari DB (Belum Bayar, Lunas, Dibatalkan)
            $status = $detail->pembelian->status_pembayaran ?? 'Dibatalkan';

            $jenisTiket = ($detail->tiket->nama ?? '-') . ' (' . $detail->jumlah . 'x)';

            // Membuat objek transaksi standar untuk dikirim ke view
            return (object) [
                'nama'       => $detail->pembelian->user->name ?? '-',
                'email'      => $detail->pembelian->user->email ?? '-',
                'event'      => $detail->tiket->event ?? null,
                'tiket'      => $detail->tiket ?? null,
                'created_at' => \Carbon\Carbon::parse($detail->created_at),
                'total'      => $detail->subtotal,
                'status'     => $status,
                'jenis_tiket'=> $jenisTiket,
            ];
        });

        // Merender view riwayat beserta data-datanya
        return view('pages.panitia.riwayat', compact('events', 'transaksis', 'allEvents', 'categories'));
    }

    /**
     * Menampilkan profil panitia dari database.
     */
    public function profil()
    {
        // Mengambil data pengguna berdasarkan ID sesi login
        $user = \App\Models\User::find(session('user_id'));

        // Mengarahkan ke halaman login jika sesi telah berakhir atau belum masuk
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        return view('pages.panitia.profil', compact('user'));
    }

    /**
     * Memperbarui profil panitia di database (nama, email, nim, foto, dan kata sandi).
     */
    public function updateProfil(Request $request)
    {
        $user = \App\Models\User::find(session('user_id'));

        // Memastikan pengguna telah masuk sebelum melakukan pembaruan
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Memvalidasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.string' => 'NIM harus berupa teks.',
            'nim.max' => 'NIM maksimal 50 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh akun lain.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $isChanged = false;

        // Memperbarui nama
        if ($user->name !== $request->name) {
            $user->name = $request->name;
            session(['user' => $user->name]);
            $isChanged = true;
        }

        // Memperbarui NIM
        if ($user->nim !== $request->nim) {
            $user->nim = $request->nim;
            $isChanged = true;
        }

        // Memperbarui Email
        if ($user->email !== $request->email) {
            $user->email = $request->email;
            $isChanged = true;
        }

        // Memeriksa unggahan foto profil baru
        if ($request->hasFile('photo')) {
            // Menghapus foto lama jika ada
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            // Menyimpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
            $isChanged = true;
        }

        // Memeriksa pengisian kata sandi baru
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $isChanged = true;
        }

        // Menyimpan perubahan jika ada data yang diubah
        if ($isChanged) {
            $user->save();
            return back()->with('success', 'Profil berhasil diperbarui!');
        }

        return back()->with('success', 'Tidak ada perubahan data.');
    }
}