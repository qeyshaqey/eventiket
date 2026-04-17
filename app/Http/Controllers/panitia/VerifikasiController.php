<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        // Get all payments with pending status
        $pembayarans = Pembayaran::with(['user', 'tiket.event'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('panitia.verif.verifikasi', compact('pembayarans'));
    }

    public function konfirmasi(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'confirmed';
        $pembayaran->save();

        return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    public function tolak(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'rejected';
        $pembayaran->save();

        return back()->with('error', 'Pembayaran ditolak!');
    }
}