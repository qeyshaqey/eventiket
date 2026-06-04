<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;

class TransaksiController extends Controller
{

    //MENGAMBIL DATA PEMBELIAN
    public function index()
    {
        $pembelians = Pembelian::with(['user', 'detail_pembelians.tiket.event'])
            ->latest()
            ->get();

        $transaksis = $pembelians->map(function ($pembelian) {
            $firstDetail = $pembelian->detail_pembelians->first();
            $event = $firstDetail->tiket->event ?? null;
            
            $jenisTiket = $pembelian->detail_pembelians->map(function ($detail) {
                return ($detail->tiket->nama ?? '-') . ' (' . $detail->jumlah . 'x)';
            })->implode(', ');

            return (object) [
                'id' => $pembelian->id,
                'user' => $pembelian->user,
                'event' => $event,
                'jumlah_tiket' => $pembelian->detail_pembelians->sum('jumlah'),
                'total_harga' => $pembelian->total_bayar,
                'status' => $pembelian->status_pembayaran,
                'created_at' => $pembelian->tanggal_beli,
                'jenis_tiket' => $jenisTiket,
            ];
        });

        return view('pages.panitia.transaksi.index', compact('transaksis'));
    }
}