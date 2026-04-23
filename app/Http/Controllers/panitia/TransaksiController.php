<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\panitia\Pembelian; // ganti dari Pembayaran

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Pembelian::with(['user', 'event'])
            ->latest()
            ->get();

        return view('pages.panitia.transaksi.index', compact('transaksis'));
    }
}