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

        // Ambil data pembayaran asli dari database milik user yang sedang login
        $pembayarans = \App\Models\Pembayaran::with(['tiket.event'])
            ->where('user_id', $userId)
            ->get();

        // Group by order_id. If order_id is null, group by id (each is a single card)
        $grouped = $pembayarans->groupBy(function ($item) {
            return $item->order_id ?? 'no-order-' . $item->id;
        });

        $activeEvents = [];
        $historyEvents = [];

        foreach ($grouped as $orderId => $items) {
            // Get the first item to extract event info
            $firstItem = $items->first();
            $event = $firstItem->tiket->event ?? null;
            if (!$event) continue;

            // Gather all tickets in this order/group
            $tickets = [];
            foreach ($items as $item) {
                if ($item->tiket) {
                    $tickets[] = [
                        "name" => $item->tiket->nama,
                        "qty" => $item->qty ?? 1
                    ];
                }
            }

            $data = [
                "id" => $firstItem->id,
                "title" => $event->judul,
                "category" => $event->kategori,
                "date" => Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                "date_end" => $event->tanggal_selesai,
                "time" => substr($event->waktu_mulai, 0, 5) . " - " . substr($event->waktu_selesai, 0, 5) . " WIB",
                "location" => $event->lokasi,
                "tickets" => $tickets,
                "status" => $firstItem->status == 'pending' ? 'Belum Bayar' : ($firstItem->status == 'success' ? 'Berhasil Diverifikasi' : ($firstItem->status == 'cancel' ? 'Dibatalkan' : 'Gagal')),
                "kode_order" => str_starts_with($orderId, 'no-order-') ? '-' : $orderId
            ];

            // Determine if active or history based on event's end date
            // Fallback to tanggal_mulai if tanggal_selesai is null
            $endDateStr = $event->tanggal_selesai ?? $event->tanggal_mulai;
            $endDate = Carbon::parse($endDateStr);

            // Tiket dianggap riwayat jika statusnya batal/gagal, ATAU event-nya sudah lewat
            if ($firstItem->status === 'cancel' || $firstItem->status === 'expire' || $firstItem->status === 'failed') {
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

        $event = \App\Models\Event::findOrFail($validated['event_id']);
        
        // Generate a single unique order ID for the entire checkout
        $orderId = 'TRX-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(10));

        // Start transaction or do validation
        \DB::beginTransaction();
        try {
            $createdCount = 0;
            foreach ($validated['tickets'] as $ticketId => $qty) {
                $qty = (int) $qty;
                if ($qty <= 0) continue;

                $tiket = \App\Models\Tiket::where('id', $ticketId)->where('event_id', $event->id)->first();
                if (!$tiket) {
                    \DB::rollBack();
                    return response()->json(['success' => false, 'message' => 'Tiket tidak valid.'], 400);
                }

                if ($tiket->kuota < $qty) {
                    \DB::rollBack();
                    return response()->json(['success' => false, 'message' => "Kuota tiket '{$tiket->nama}' tidak mencukupi. Tersisa: {$tiket->kuota}"], 400);
                }

                \App\Models\Pembayaran::create([
                    'user_id' => $userId,
                    'tiket_id' => $tiket->id,
                    'jumlah' => $tiket->harga * $qty,
                    'qty' => $qty,
                    'status' => 'pending',
                    'order_id' => $orderId,
                ]);
                $createdCount++;
            }

            if ($createdCount === 0) {
                \DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Pilih minimal 1 tiket.'], 400);
            }

            \DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat.',
                'order_id' => $orderId
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function batal($id)
    {
        $userId = session('user_id');
        $pembayaran = \App\Models\Pembayaran::where('id', $id)->where('user_id', $userId)->first();
        
        if ($pembayaran && $pembayaran->status == 'pending') {
            if ($pembayaran->order_id) {
                \App\Models\Pembayaran::where('order_id', $pembayaran->order_id)
                    ->where('user_id', $userId)
                    ->update(['status' => 'cancel']);
            } else {
                $pembayaran->status = 'cancel';
                $pembayaran->save();
            }
            return response()->json(['success' => true, 'message' => 'Tiket berhasil dibatalkan.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Gagal membatalkan tiket.'], 400);
    }
}