<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';

    protected $fillable = [
        'nama_kategori'
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'kategori_id');
    }
}
