<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Interfaces\ApprovableInterface;

class PengajuanPanitia extends Model implements ApprovableInterface
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

    // ---- Implementasi Interface methods (public) ----
    public function approve()
    {
        $this->status = 'disetujui';
        $this->save();

        $user = $this->user;
        if ($user) {
            $user->role = 'panitia';
            $user->save();
        }
    }

    public function reject()
    {
        $this->status = 'ditolak';
        $this->save();
    }
}
