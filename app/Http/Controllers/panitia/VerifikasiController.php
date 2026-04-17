<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        $pembayarans = collect([
    (object)[
        'id' => 1,
        'jumlah_tiket' => 2,
        'harga_tiket' => 75000,
        'tanggal_beli' => '2026-04-15',
        'bukti_pembayaran' => 'bukti1.jpg',
        'user' => (object)[
            'name' => 'Andi Saputra',
            'email' => 'andi@gmail.com'
        ],
        'tiket' => (object)[
            'nama' => 'VIP',
            'event' => (object)[
                'judul' => 'Konser Musik 2026'
            ]
        ]
    ],
]);

        return view('panitia..verif.verifikasi', compact('pembayarans'));
    }

    public function tolak(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'rejected';
        $pembayaran->save();

        return back()->with('error', 'Pembayaran ditolak!');
    }
}