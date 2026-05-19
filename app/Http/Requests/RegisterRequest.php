<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // semua user boleh ngelakuin request ini
    }

    public function rules(): array
    {
        return [
            'nim'              => ['required', 'numeric', 'digits:10', 'unique:users,nim'],
            'username'         => ['required', 'string', 'min:3', 'max:50', 'unique:users,name'],
            'email'            => ['required', 'email', 'unique:users,email'],
            'password'         => ['required', 'string', 'min:8'],
            'confirm_password' => ['required', 'same:password'],
        ];
    }

    public function messages(): array
    {
        return [
            'nim.required'              => 'NIM wajib diisi.',
            'nim.numeric'               => 'NIM harus berupa angka.',
            'nim.digits'                => 'NIM harus tepat 10 angka.',
            'nim.unique'                => 'NIM sudah terdaftar.',
            'username.required'         => 'Username wajib diisi.',
            'username.min'              => 'Username minimal 3 karakter.',
            'username.unique'           => 'Nama lengkap sudah digunakan.',
            'email.required'            => 'Email wajib diisi.',
            'email.email'               => 'Format email tidak valid.',
            'email.unique'              => 'Email sudah terdaftar.',
            'password.required'         => 'Password wajib diisi.',
            'password.min'              => 'Password minimal 8 karakter.',
            'confirm_password.required' => 'Konfirmasi password wajib diisi.',
            'confirm_password.same'     => 'Password tidak cocok.',
        ];
    }

    // ganti nama field/atribut pas nampilin pesan error
    public function attributes(): array
    {
        return [
            'nim'              => 'NIM',
            'username'         => 'Username',
            'email'            => 'Email',
            'password'         => 'Password',
            'confirm_password' => 'Konfirmasi Password',
        ];
    }
}