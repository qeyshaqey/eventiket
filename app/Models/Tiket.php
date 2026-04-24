<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = ['nama', 'harga', 'kuota', 'event_id'];

    // relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}