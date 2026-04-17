<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu',
        'lokasi',
        'gambar',
        'status',
        'panitia_id',
    ];

    public function panitia()
    {
        return $this->belongsTo(User::class, 'panitia_id');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }
}