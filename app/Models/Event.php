<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ApprovableInterface;

class Event extends Model implements ApprovableInterface
{
    // Atribut private
    protected $fillable = [
        'judul',
        'kategori_id',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'poster',
        'status'
    ];

    // Relasi ke kategori (Foreign Key)
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // relasi ke tiket
    public function tikets()
    {
        return $this->hasMany(Tiket::class);
    }

    // ---- Implementasi Interface methods (public) ----
    public function approve()
    {
        $this->status = 'approved';
        $this->save();
    }

    public function reject()
    {
        $this->status = 'rejected';
        $this->save();
    }
}