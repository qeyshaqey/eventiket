<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPanitia extends Model
{
    protected $fillable = [
        'user_id',
        'nama_organisasi',
        'nama_event',
        'kategori',
        'tanggal_event',
        'deskripsi',
        'status',
        'alasan_penolakan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
