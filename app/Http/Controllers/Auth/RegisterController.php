<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    /**
     * Tampilkan halaman form registrasi.
     */
    public function showForm()
    {
        return view('auth.register');
    }

    /**
     * Proses data registrasi.
     */
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