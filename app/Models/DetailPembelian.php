<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'tiket_id',
        'jumlah',
        'subtotal'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
}
