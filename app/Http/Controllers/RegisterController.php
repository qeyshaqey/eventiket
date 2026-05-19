<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest; 
use App\Models\User;                   
use Illuminate\Support\Facades\Hash;  
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // buat nampilin form pendaftaran akun
    public function showForm()
    {
        return view('register');
    }

    // buat ngeproses pendaftaran akun baru
    public function store(RegisterRequest $request)
    {
        User::create([
            'nim'      => $request->nim,
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pengunjung',
        ]);

        return redirect()->route('register')->with('success', true);
    }
}