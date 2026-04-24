<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = ['nama', 'event_id', 'total', 'status'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}