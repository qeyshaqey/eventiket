<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanPanitia extends Model
{
    protected $fillable = [
        'user_id',
        'ukm',
        'alasan',
        'status',
        'alasan_penolakan',
        'organisasi',
        'nama_event',
        'kategori',
        'tanggal',
        'deskripsi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
