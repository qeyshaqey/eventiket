<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pembayaran;
use App\Models\panitia\Pembelian;

class TiketController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $today = Carbon::today();

        // Ambil data pembayaran asli dari database milik user yang sedang login
        // Group by order_id to merge multiple tickets in one purchase card
        $pembayaransRaw = Pembayaran::with(['tiket.event'])
            ->where('user_id', $userId)
            ->get();
            
        $groupedPembayarans = $pembayaransRaw->groupBy('order_id');

        $activeEvents = [];
        $historyEvents = [];

        foreach ($groupedPembayarans as $orderId => $pembayarans) {
            $firstP = $pembayarans->first();
            $event = $firstP->tiket->event ?? null;
            if (!$event) continue;

            $ticketsData = [];
            foreach ($pembayarans as $p) {
                $ticketsData[] = ["name" => $p->tiket->nama ?? '-', "qty" => $p->qty ?? 1];
            }

            $data = [
                "id" => $firstP->id, 
                "title" => $event->judul,
                "category" => $event->kategori,
                "date" => Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                "date_end" => $event->tanggal_selesai,
                "time" => substr($event->waktu_mulai ?? '', 0, 5) . " - " . substr($event->waktu_selesai ?? '', 0, 5) . " WIB",
                "location" => $event->lokasi,
                "tickets" => $ticketsData,
                "status" => $firstP->status == 'pending' ? 'Belum Bayar' : ($firstP->status == 'success' ? 'Berhasil Diverifikasi' : ($firstP->status == 'cancel' ? 'Dibatalkan' : 'Gagal')),
                "kode_order" => $orderId
            ];

            $endDate = Carbon::parse($event->tanggal_selesai ?? $event->tanggal_mulai);
            
            if ($firstP->status === 'cancel' || $firstP->status === 'failed' || $firstP->status === 'expire') {
                $historyEvents[] = $data;
            } elseif ($endDate->gte($today)) {
                $activeEvents[] = $data;
            } else {
                $historyEvents[] = $data;
            }
        }

        return view('pages.pengunjung.tiket', compact('activeEvents', 'historyEvents'));
    }

    public function checkout(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'tickets' => 'required|array',
        ]);

        $event = Event::findOrFail($validated['event_id']);
        
        // Generate a single unique order ID for the entire checkout
        $orderId = 'TRX-' . Str::upper(Str::random(10));

        // Start transaction or do validation
        DB::beginTransaction();
        try {
            $createdCount = 0;
            $totalHarga = 0;
            $jumlahTiket = 0;

            foreach ($validated['tickets'] as $ticketId => $qty) {
                $qty = (int) $qty;
                if ($qty <= 0) continue;

                $tiket = Tiket::where('id', $ticketId)->where('event_id', $event->id)->first();
                if (!$tiket) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Tiket tidak valid.'], 400);
                }

                if ($tiket->kuota < $qty) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => "Kuota tiket '{$tiket->nama}' tidak mencukupi. Tersisa: {$tiket->kuota}"], 400);
                }

                $subtotal = $tiket->harga * $qty;
                Pembayaran::create([
                    'user_id' => $userId,
                    'tiket_id' => $tiket->id,
                    'jumlah' => $subtotal,
                    'qty' => $qty,
                    'status' => 'pending',
                    'order_id' => $orderId,
                ]);

                $totalHarga += $subtotal;
                $jumlahTiket += $qty;
                $createdCount++;
            }

            if ($createdCount === 0) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Pilih minimal 1 tiket.'], 400);
            }

            // Create Pembelian record for panitia tracking
            Pembelian::create([
                'user_id' => $userId,
                'event_id' => $event->id,
                'jumlah_tiket' => $jumlahTiket,
                'total_harga' => $totalHarga,
                'status' => 'pending',
                'order_id' => $orderId,
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function batal($id)
    {
        $userId = session('user_id');
        $pembayaran = Pembayaran::where('id', $id)->where('user_id', $userId)->first();
        
        if ($pembayaran && $pembayaran->status == 'pending') {
            if ($pembayaran->order_id) {
                Pembayaran::where('order_id', $pembayaran->order_id)
                    ->where('user_id', $userId)
                    ->update(['status' => 'cancel']);

                Pembelian::where('order_id', $pembayaran->order_id)
                    ->where('user_id', $userId)
                    ->update(['status' => 'failed']);
            } else {
                $pembayaran->status = 'cancel';
                $pembayaran->save();
            }
            return response()->json(['success' => true, 'message' => 'Tiket berhasil dibatalkan.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Gagal membatalkan tiket.'], 400);
    }
}