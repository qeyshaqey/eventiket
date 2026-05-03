<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TiketController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $today = Carbon::today();

        // CEK: Jika user belum punya tiket sama sekali di database
        $cekPembayaran = \App\Models\Pembayaran::where('user_id', $userId)->exists();
        
        if (!$cekPembayaran) {
            // Kita ambil event pertama dan tiket pertama dari database buat contoh
            $eventContoh = \App\Models\Event::first();
            $tiketContoh = \App\Models\Tiket::where('event_id', $eventContoh->id)->first();
            
            if ($eventContoh && $tiketContoh) {
                \App\Models\Pembayaran::create([
                    'user_id' => $userId,
                    'tiket_id' => $tiketContoh->id,
                    'jumlah' => $tiketContoh->harga,
                    'status' => 'pending'
                ]);
            }
        }

        // Ambil data pembayaran asli dari database milik user yang sedang login
        $pembayarans = \App\Models\Pembayaran::with(['tiket.event'])
            ->where('user_id', $userId)
            ->get();

        $activeEvents = [];
        $historyEvents = [];

        foreach ($pembayarans as $p) {
            $event = $p->tiket->event;
            if (!$event) continue;

            // Format data agar sesuai dengan tampilan blade Anda
            $data = [
                "id" => $p->id,
                "title" => $event->judul,
                "category" => $event->kategori,
                "date" => Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                "date_end" => $event->tanggal_selesai,
                "time" => substr($event->waktu_mulai, 0, 5) . " - " . substr($event->waktu_selesai, 0, 5) . " WIB",
                "location" => $event->lokasi,
                "tickets" => [
                    ["name" => $p->tiket->nama, "qty" => 1]
                ],
                "status" => $p->status == 'pending' ? 'Belum Bayar' : ($p->status == 'success' ? 'Berhasil Diverifikasi' : 'Gagal'),
                "kode_order" => $p->order_id
            ];

            $endDate = Carbon::parse($event->tanggal_selesai);
            if ($endDate->gte($today)) {
                $activeEvents[] = $data;
            } else {
                $historyEvents[] = $data;
            }
        }

        return view('pages.pengunjung.tiket', compact('activeEvents', 'historyEvents'));
    }
}