<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiket extends Model
{
    use HasFactory;

    protected $fillable = [
        'pembelian_id',
        'kode_unik'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }
}
