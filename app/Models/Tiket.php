<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'harga',
        'kuota',
        'event_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}