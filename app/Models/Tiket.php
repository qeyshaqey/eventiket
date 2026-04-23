<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $fillable = [
        'event_id',
        'nama',
        'harga',
        'kuota'
    ];

    // relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}