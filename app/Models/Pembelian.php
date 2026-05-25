<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_beli',
        'total_bayar',
        'status_pembayaran',
        'order_id',
        'snap_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail_pembelians()
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function etikets()
    {
        return $this->hasMany(Etiket::class);
    }
}
