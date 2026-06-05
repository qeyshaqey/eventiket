<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Tiket;
use App\Models\Pembelian;
use App\Models\DetailPembelian;

class TiketController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        $today = Carbon::today();

        // Mengambil data riwayat pembelian dari database berdasarkan ID pengguna
        $pembelians = Pembelian::with(['detail_pembelians.tiket.event.kategori'])
            ->where('user_id', $userId)
            ->get();

        $activeEvents = [];
        $historyEvents = [];

        foreach ($pembelians as $pembelian) {
            $firstDetail = $pembelian->detail_pembelians->first();
            if (!$firstDetail) continue;
            
            $event = $firstDetail->tiket->event ?? null;
            if (!$event) continue;

            $ticketsData = [];
            foreach ($pembelian->detail_pembelians as $detail) {
                $ticketsData[] = ["name" => $detail->tiket->nama ?? '-', "qty" => $detail->jumlah ?? 1];
            }

            $endDate = Carbon::parse($event->tanggal_selesai ?? $event->tanggal_mulai);
            $isHistory = false;
            
            if ($pembelian->status_pembayaran === 'Dibatalkan' || $pembelian->status_pembayaran === 'Kedaluwarsa') {
                $isHistory = true;
            } elseif (!$endDate->gte($today)) {
                $isHistory = true;
            }

            $statusStr = $pembelian->status_pembayaran;
            // Mengubah status pembayaran menjadi Kedaluwarsa secara otomatis jika event telah berlalu namun tagihan belum dibayar
            if ($isHistory && $statusStr === 'Belum Bayar') {
                $statusStr = 'Kedaluwarsa';
                $pembelian->update(['status_pembayaran' => 'Kedaluwarsa']);
            }

            $data = [
                "id" => $pembelian->id, 
                "title" => $event->judul,
                "category" => $event->kategori->nama_kategori ?? '-',
                "date" => Carbon::parse($event->tanggal_mulai)->translatedFormat('d M Y'),
                "date_end" => $event->tanggal_selesai,
                "time" => substr($event->waktu_mulai ?? '', 0, 5) . " - " . substr($event->waktu_selesai ?? '', 0, 5) . " WIB",
                "location" => $event->lokasi,
                "tickets" => $ticketsData,
                "status" => $statusStr,
                "kode_order" => $pembelian->order_id ?? '-'
            ];
            
            if ($isHistory) {
                $historyEvents[] = $data;
            } else {
                $activeEvents[] = $data;
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
        
        $orderId = 'TRX-' . Str::upper(Str::random(10));

        DB::beginTransaction();
        try {
            $createdCount = 0;
            $totalHarga = 0;
            $jumlahTiket = 0;

            $pembelian = Pembelian::create([
                'user_id' => $userId,
                'tanggal_beli' => now(),
                'total_bayar' => 0, 
                'status_pembayaran' => 'Belum Bayar',
                'order_id' => $orderId,
            ]);

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
                
                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'tiket_id' => $tiket->id,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal
                ]);

                $totalHarga += $subtotal;
                $jumlahTiket += $qty;
                $createdCount++;
            }

            if ($createdCount === 0) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Pilih minimal 1 tiket.'], 400);
            }

            $pembelian->update(['total_bayar' => $totalHarga]);

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
        $pembelian = Pembelian::where('id', $id)->where('user_id', $userId)->first();
        
        if ($pembelian && $pembelian->status_pembayaran == 'Belum Bayar') {
            $pembelian->update(['status_pembayaran' => 'Dibatalkan']);
            return response()->json(['success' => true, 'message' => 'Tiket berhasil dibatalkan.']);
        }
        
        return response()->json(['success' => false, 'message' => 'Gagal membatalkan tiket.'], 400);
    }
}