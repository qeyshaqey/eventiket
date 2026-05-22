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

        // CEK: Jika user memiliki tiket kurang dari 2, buatkan dummy data agar selalu ada minimal 2
        $jumlahPembayaran = \App\Models\Pembayaran::where('user_id', $userId)->count();
        
        if ($jumlahPembayaran < 2) {
            // Kita ambil 2 event secara acak atau 2 event terbaru
            $eventsContoh = \App\Models\Event::whereDate('tanggal_selesai', '>=', $today)->take(2)->get();
            
            // Jika tidak ada event yang belum selesai, ambil event apa saja
            if ($eventsContoh->isEmpty()) {
                $eventsContoh = \App\Models\Event::take(2)->get();
            }

            foreach ($eventsContoh as $eventContoh) {
                $tiketContoh = \App\Models\Tiket::where('event_id', $eventContoh->id)->first();
                
                // Pastikan belum pernah order event ini di contoh dummy
                $sudahPesan = \App\Models\Pembayaran::where('user_id', $userId)
                                ->where('tiket_id', $tiketContoh->id ?? 0)
                                ->exists();

                if ($tiketContoh && !$sudahPesan) {
                    \App\Models\Pembayaran::create([
                        'user_id' => $userId,
                        'tiket_id' => $tiketContoh->id,
                        'jumlah' => $tiketContoh->harga,
                        'status' => 'pending'
                    ]);
                }
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
                "status" => $p->status == 'pending' ? 'Belum Bayar' : ($p->status == 'success' ? 'Berhasil Diverifikasi' : ($p->status == 'cancel' ? 'Dibatalkan' : 'Gagal')),
                "kode_order" => $p->order_id
            ];

            $endDate = Carbon::parse($event->tanggal_selesai);
            // Tiket dianggap riwayat jika statusnya batal/gagal, ATAU event-nya sudah lewat
            if ($p->status === 'cancel' || $p->status === 'expire') {
                $historyEvents[] = $data;
            } elseif ($endDate->gte($today)) {
                $activeEvents[] = $data;
            } else {
                $historyEvents[] = $data;
            }
        }

        return view('pages.pengunjung.tiket', compact('activeEvents', 'historyEvents'));
    }

    public function batal($id)
    {
        $userId = session('user_id');
        $pembayaran = \App\Models\Pembayaran::where('id', $id)->where('user_id', $userId)->first();
        
        if ($pembayaran && $pembayaran->status == 'pending') {
            $pembayaran->status = 'cancel';
            $pembayaran->save();
            return response()->json(['success' => true, 'message' => 'Tiket berhasil dibatalkan.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Gagal membatalkan tiket.'], 400);
    }
}