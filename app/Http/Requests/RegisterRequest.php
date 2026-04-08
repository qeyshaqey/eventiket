<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Izinkan semua user mengakses
    }

    public function rules(): array
    {
        return [
            'username'         => ['required', 'string', 'min:3', 'max:50', 'unique:users,name'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required'         => 'Username wajib diisi.',
            'username.min'              => 'Username minimal 3 karakter.',
            'username.unique'           => 'Username sudah digunakan.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email sudah terdaftar.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'confirm_password.required' => 'Konfirmasi password wajib diisi.',
            'confirm_password.same'     => 'Password tidak cocok.',
        ];
    }

    /**
     * Nama atribut yang ditampilkan di pesan error (opsional).
     */
    public function attributes(): array
    {
        return [
            'username'         => 'Username',
            'email'            => 'Email',
            'password'         => 'Password',
            'confirm_password' => 'Konfirmasi Password',
        ];
    }
}