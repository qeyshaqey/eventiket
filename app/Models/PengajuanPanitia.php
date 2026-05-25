<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPanitia extends Model
{
    protected $fillable = [
        'user_id',
        'ukm',
        'nama_event',
        'kategori',
        'tanggal_event',
        'deskripsi_event',
        'status',
        'alasan_penolakan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
