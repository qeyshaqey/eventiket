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
        // Mengambil semua event berurut dari yang terbaru beserta relasi tiket dan kategorinya
        $events = Event::with(['tikets', 'kategori'])->latest()->get();

        // Mengambil ID event dari query parameter url (?event_id=x) untuk disorot di tampilan
        $highlightEventId = $request->query('event_id');

        // Mengembalikan halaman view pengelolaan tiket
        return view('pages.panitia.tiket', compact('events', $highlightEventId ? 'highlightEventId' : 'events'));
    }

    /**
     * Menambah jenis tiket baru untuk event tertentu.
     * Secara otomatis mengubah status event tersebut menjadi 'Published' ketika tiket pertama kali ditambahkan.
     */
    public function store(Request $request)
    {
        // Validasi input form penambahan tiket
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|integer',
            'kuota' => 'required|integer',
            'event_id' => 'required|exists:events,id',
        ]);

        // Menyimpan data tiket baru ke database
        Tiket::create($validated);

        // Secara otomatis mengubah status event terkait menjadi 'Published' karena sudah memiliki tiket
        Event::find($validated['event_id'])
            ->update(['status' => 'Published']);

        // Mengalihkan kembali ke halaman pengelolaan tiket dengan highlight event terkait dan pesan sukses
        return redirect()->route('panitia.tiket', [
            'event_id' => $validated['event_id']
        ])->with('success', 'Jenis tiket berhasil ditambahkan');
    }

    /**
     * Mengedit jenis tiket yang sudah ada.
     */
    public function update(Request $request, Tiket $tiket)
    {
        // Validasi input form perubahan tiket
        $validated = $request->validate([
            'nama' => 'required',
            'harga' => 'required|integer',
            'kuota' => 'required|integer',
        ]);

        // Melakukan update data tiket di database
        $tiket->update($validated);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Tiket berhasil diupdate');
    }

    /**
     * Menghapus jenis tiket dari database.
     * Jika setelah dihapus event tidak memiliki tiket sama sekali, status event akan diturunkan kembali ke 'Draft'.
     */
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