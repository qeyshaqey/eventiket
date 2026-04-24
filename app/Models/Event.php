<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'poster',
        'status'
    ];

    // relasi ke tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
    public function transaksis()
{
    return $this->hasMany(Transaksi::class);
}
}