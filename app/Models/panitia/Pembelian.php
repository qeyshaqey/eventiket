<?php

namespace App\Models\panitia;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Event;

class Pembelian extends Model
{
    protected $table = 'pembelians';

    protected $fillable = [
        'user_id',
        'event_id',
        'jumlah_tiket',
        'total_harga',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}