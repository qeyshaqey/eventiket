<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // kolom-kolom yang boleh diisi langsung (mass assignment)
    // Atribut private
    protected $fillable = [
        'name',
        'email',
        'password',
        'nim',
        'photo',
        'role',
    ];

    // kolom yang disembunyiin biar gak tampil pas data diconvert jadi array/json (keamanan)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // casting tipe data kolom di database ke tipe data php
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
