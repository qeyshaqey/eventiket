<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman Lupa Password.
     */
    public function showForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Memproses pengiriman link reset password.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Sementara: simulasi pengiriman (sesuaikan dengan logic email Anda nanti)
        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}
