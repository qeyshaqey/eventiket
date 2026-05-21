<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ApprovableInterface;

class Transaksi extends Model implements ApprovableInterface
{
    // Atribut private 
    protected $fillable = [
        'order_id', 
        'user_id', 
        'tiket_id', 
        'jumlah', 
        'total_harga', 
        'status', 
        'snap_token',
        // field lama (legacy) untuk menjaga backend tidak rusak
        'nama', 
        'event_id', 
        'total'
    ];

    // Method public: Relasi ke Pengunjung (User)
    public function pengunjung()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Method public: Relasi ke Tiket
    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }

    // Method public: Relasi ke Event (dipertahankan agar query existing tidak rusak)
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // ---- Implementasi Interface methods (Public) ----
    // Ini digunakan saat pembayaran berhasil (Midtrans Callback)
    public function approve()
    {
        $this->status = 'settlement';
        $this->save();
    }

    // Ini digunakan saat pembayaran gagal/batal
    public function reject()
    {
        $this->status = 'cancel';
        $this->save();
    }
}