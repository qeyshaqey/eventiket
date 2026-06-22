<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\Kategori;
use App\Models\Event;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
     // Menampilkan riwayat transaksi pembelian tiket oleh pengunjung
    public function index(Request $request)
    {
        // Mengambil data pembelian tiket yang hanya dimiliki oleh event panitia yang sedang login
        $panitiaId = session('user_id');

        // Mengambil data pembelian beserta relasi detail pembelian, tiket, event, dan user.
        $query = Pembelian::with(['user', 'detail_pembelians.tiket.event'])
            ->whereHas('detail_pembelians.tiket.event', function ($q) use ($panitiaId) {
                $q->where('user_id', $panitiaId);
            });

        // Filter berdasarkan kategori event
        if ($request->has('kategori_id') && $request->kategori_id !== '') {
            $query->whereHas('detail_pembelians.tiket.event', function ($q) use ($request) {
                $q->where('kategori_id', $request->kategori_id);
            });
        }

        // Filter berdasarkan event tertentu
        if ($request->has('event_id') && $request->event_id !== '') {
            $query->whereHas('detail_pembelians.tiket', function ($q) use ($request) {
                $q->where('event_id', $request->event_id);
            });
        }

        // Pencarian berdasarkan nama pembeli atau judul event
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($sub) use ($searchTerm) {
                    $sub->where('name', 'like', '%' . $searchTerm . '%');
                })->orWhereHas('detail_pembelians.tiket.event', function ($sub) use ($searchTerm) {
                    $sub->where('judul', 'like', '%' . $searchTerm . '%');
                });
            });
        }

        $pembelians = $query->latest()->paginate(10);

        // Memetakan data pembelian ke dalam struktur objek 
        $transaksis = $pembelians->through(function ($pembelian) {
            $firstDetail = $pembelian->detail_pembelians->first();
            $event = $firstDetail->tiket->event ?? null;
            
            // Meneruskan status langsung dari DB (Belum Bayar, Lunas, Dibatalkan)
            $status = $pembelian->status_pembayaran;

            // Merangkum seluruh jenis tiket yang dibeli dalam satu transaksi 
            $jenisTiket = $pembelian->detail_pembelians->map(function ($detail) {
                return ($detail->tiket->nama ?? '-') . ' (' . $detail->jumlah . 'x)';
            })->implode(', ');

            // Membuat objek transaksi standar
            return (object) [
                'id' => $pembelian->id,
                'user' => $pembelian->user,
                'event' => $event,
                'jumlah_tiket' => $pembelian->detail_pembelians->sum('jumlah'),
                'total_harga' => $pembelian->total_bayar,
                'status' => $status,
                'created_at' => $pembelian->tanggal_beli,
                'jenis_tiket' => $jenisTiket,
            ];
        });

        // Mengambil data untuk filter dropdown
        $panitiaId = session('user_id');
        $categories = Kategori::all();
        $events = Event::where('user_id', $panitiaId)->orderBy('judul')->get();

        // Mengirim data hasil pemetaan ke halaman view transaksi panitia
        return view('pages.panitia.transaksi.index', compact('transaksis', 'categories', 'events'));
    }
}