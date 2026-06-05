<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;

class TransaksiController extends Controller
{
    /**
     * Menampilkan riwayat transaksi pembelian tiket oleh pengunjung.
     * Mengambil data pembelian beserta relasi detail pembelian, tiket, event, dan user.
     */
    public function index()
    {
        // Mengambil semua data pembelian tiket 
        $pembelians = Pembelian::with(['user', 'detail_pembelians.tiket.event'])
            ->latest()
            ->get();

        // Memetakan data pembelian ke dalam struktur objek 
        $transaksis = $pembelians->map(function ($pembelian) {
            // Mengambil detail pembelian pertama untuk mendapatkan data event terkait
            $firstDetail = $pembelian->detail_pembelians->first();
            $event = $firstDetail->tiket->event ?? null;
            
            // Mengonversi status pembayaran dari DB ('Pending', 'Sukses', 'Batal')
            $status = 'failed';
            if ($pembelian->status_pembayaran === 'Pending') {
                $status = 'pending';
            } elseif ($pembelian->status_pembayaran === 'Sukses') {
                $status = 'paid';
            }

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

        // Mengirim data hasil pemetaan ke halaman view transaksi panitia
        return view('pages.panitia.transaksi.index', compact('transaksis'));
    }
}