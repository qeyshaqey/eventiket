<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest; 
use App\Models\User;                   
use Illuminate\Support\Facades\Hash;  
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    // form registrasi
    public function showForm()
    {
        return view('register');
    }

    // registrasi
    public function store(RegisterRequest $request)
    {
        User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('success', true);
    }
}