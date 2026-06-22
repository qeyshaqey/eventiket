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

            // Ambil kategori_id berdasarkan nama kategori yang diajukan
            $kategori = \App\Models\Kategori::where('nama_kategori', $this->kategori)->first();
            $kategoriId = $kategori ? $kategori->id : (\App\Models\Kategori::first()?->id);

            // Otomatis membuat event pertama sebagai Draft
            \App\Models\Event::create([
                'user_id'         => $user->id,
                'judul'           => $this->nama_event,
                'kategori_id'     => $kategoriId,
                'deskripsi'       => $this->deskripsi,
                'tanggal_mulai'   => $this->tanggal_event,
                'tanggal_selesai' => $this->tanggal_event,
                'waktu_mulai'     => '08:00:00', // Default waktu mulai
                'waktu_selesai'   => '17:00:00', // Default waktu selesai
                'lokasi'          => 'Belum ditentukan', // Default lokasi
                'status'          => 'Draft',
            ]);
        }
    }

    public function reject()
    {
        $this->status = 'ditolak';
        $this->save();
    }
}
