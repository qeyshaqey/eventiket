<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;

class TiketPanitiaController extends Controller
{
    /**
     * Menampilkan halaman pengelolaan tiket.
     * Mengambil seluruh data event beserta tiketnya dan kategori untuk ditampilkan di view,
     * serta menangkap event_id dari query parameter untuk fokus/menyorot event tertentu.
     */
    public function index(Request $request)
    {
        $userId = session('user_id');

        // Mengambil semua event milik panitia saat ini berurut dari yang terbaru beserta relasi tiket dan kategorinya
        $events = Event::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('tanggal_selesai', '>=', now()->toDateString())
                  ->orWhere(function ($q2) {
                      $q2->whereNull('tanggal_selesai')
                         ->where('tanggal_mulai', '>=', now()->toDateString());
                  });
            })
            ->with(['tikets', 'kategori'])
            ->latest()
            ->get();

        $categories = $events->pluck('kategori.nama_kategori')->filter()->unique()->values();
        $highlightEventId = $request->query('event_id');

        return view('pages.panitia.tiket', compact('events', 'categories', 'highlightEventId'));
    } 

    /**
     * Menambah jenis tiket baru untuk event tertentu.
     * Secara otomatis mengubah status event tersebut menjadi 'Published' ketika tiket pertama kali ditambahkan.
     */
    public function store(Request $request)
    {
        // Bersihkan format harga (hilangkan titik/karakter non-angka) sebelum divalidasi
        if ($request->has('harga')) {
            $request->merge([
                'harga' => preg_replace('/[^0-9]/', '', $request->harga)
            ]);
        }

        // Validasi input form penambahan tiket
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|integer|min:1',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'required|string',
            'event_id' => 'required|exists:events,id',
        ], [
            'nama.required' => 'Nama tiket wajib diisi.',
            'harga.required' => 'Harga tiket wajib diisi.',
            'harga.integer' => 'Harga tiket harus berupa angka/bilangan bulat.',
            'harga.min' => 'Harga tiket tidak boleh kurang dari 1.',
            'kuota.required' => 'Kuota tiket wajib diisi.',
            'kuota.integer' => 'Kuota tiket harus berupa angka/bilangan bulat.',
            'kuota.min' => 'Kuota tiket minimal 1.',
            'keterangan.required' => 'Keterangan tiket wajib diisi.',
            'event_id.required' => 'Event ID wajib diisi.',
            'event_id.exists' => 'Event tidak valid.',
        ]);

        // Menyimpan data tiket baru ke database
        Tiket::create($validated);

        // Mengalihkan kembali ke halaman pengelolaan tiket dengan highlight event terkait dan pesan sukses
        return redirect()->route('panitia.tiket', [
            'event_id' => $validated['event_id']
        ])->with('success', 'Jenis tiket berhasil ditambahkan');
    }

    //Mengedit jenis tiket yang sudah ada.
    public function update(Request $request, Tiket $tiket)
    {
        // Bersihkan format harga (hilangkan titik/karakter non-angka) sebelum divalidasi
        if ($request->has('harga')) {
            $request->merge([
                'harga' => preg_replace('/[^0-9]/', '', $request->harga)
            ]);
        }

        // Validasi input form perubahan tiket
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|integer|min:1',
            'kuota' => 'required|integer|min:1',
            'keterangan' => 'required|string',
        ], [
            'nama.required' => 'Nama tiket wajib diisi.',
            'harga.required' => 'Harga tiket wajib diisi.',
            'harga.integer' => 'Harga tiket harus berupa angka/bilangan bulat.',
            'harga.min' => 'Harga tiket tidak boleh kurang dari 1.',
            'kuota.required' => 'Kuota tiket wajib diisi.',
            'kuota.integer' => 'Kuota tiket harus berupa angka/bilangan bulat.',
            'kuota.min' => 'Kuota tiket minimal 1.',
            'keterangan.required' => 'Keterangan tiket wajib diisi.',
        ]);

        // Melakukan update data tiket di database
        $tiket->update($validated);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Tiket berhasil diupdate');
    }

    //Menghapus jenis tiket dari database. Jika setelah dihapus event tidak memiliki tiket sama sekali, status event akan diturunkan kembali ke 'Draft'.
    public function destroy(Tiket $tiket)
    {
        // Menyimpan ID event terkait sebelum menghapus tiket
        $eventId = $tiket->event_id;
        // Menghapus tiket dari database
        $tiket->delete();

        // Jika event tersebut sudah tidak memiliki tiket sama sekali, statusnya diturunkan menjadi 'Draft'
        if (Tiket::where('event_id', $eventId)->count() === 0) {
            Event::where('id', $eventId)->update(['status' => 'Draft']);
        }

        // Kembali dengan pesan sukses
        return back()->with('success', 'Tiket berhasil dihapus');
    }
}