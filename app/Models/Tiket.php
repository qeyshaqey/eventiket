<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    // Atribut private
    protected $fillable = ['nama', 'harga', 'kuota', 'keterangan', 'tiket_terjual', 'event_id'];

    // Method public: Relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}