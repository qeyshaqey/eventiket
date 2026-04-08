<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    // form registrasi.
    public function showForm()
    {
        return view('register');
    }

    // registrasi
    public function store(RegisterRequest $request)
    {
        // Data sudah tervalidasi oleh RegisterRequest
        User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('register')->with('success', true);
    }
}