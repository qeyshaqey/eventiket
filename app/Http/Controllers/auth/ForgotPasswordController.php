<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Mail\OtpMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Menampilkan halaman Lupa Password.
     */
    public function showForm()
    {
        // Tampilkan halaman buat masukin email yang lupa passwordnya
        return view('Auth.forgot-password');
    }

    /**
     * Generate OTP, simpan ke database, dan kirim ke email user.
     */
    public function sendOtp(Request $request)
    {
        // Validasi input email
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        // Cari user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user) {
            return back()
                ->withInput()
                ->with('error', 'Email tidak terdaftar dalam sistem kami.');
        }

        // Buat kode OTP 6 digit secara acak
        $otp = strval(random_int(100000, 999999));

        // Simpan atau update kode OTP ke tabel password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token'      => $otp,
                'created_at' => Carbon::now(),
            ]
        );

        // Kirim kodenya ke email si user
        Mail::to($user->email)->send(new OtpMail($otp));

        // Simpan email di session biar bisa dipakai di halaman verifikasi
        session(['password_reset_email' => $user->email]);

        return redirect()->route('password.verify.form')
            ->with('success', 'Kode OTP sudah dikirim ke email Anda. Cek ya!');
    }

    /**
     * Tampilkan form verifikasi OTP.
     */
    public function showVerifyOtpForm()
    {
        if (! session()->has('password_reset_email')) {
            return redirect()->route('password.forgot')
                ->with('error', 'Sesi tidak valid. Silakan mulai dari awal.');
        }

        return view('Auth.verify-otp');
    }

    /**
     * Proses verifikasi OTP yang diinput user.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.digits'   => 'Kode OTP harus berupa 6 digit angka.',
        ]);

        $email = session('password_reset_email');

        if (! $email) {
            return redirect()->route('password.forgot')
                ->with('error', 'Sesi tidak valid. Silakan mulai dari awal.');
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $request->otp)
            ->first();

        if (! $record) {
            return back()->with('error', 'Kode OTP tidak valid. Periksa kembali kode yang dikirim ke email Anda.');
        }

        // Cek apakah OTP sudah kedaluwarsa (lebih dari 10 menit)
        if (Carbon::parse($record->created_at)->addMinutes(10)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->with('error', 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang kode.');
        }

        // Tandai bahwa user sudah terverifikasi OTP-nya
        session(['password_reset_verified' => true]);

        return redirect()->route('password.reset.form')
            ->with('success', 'Verifikasi berhasil! Silakan buat password baru Anda.');
    }

    /**
     * Tampilkan form reset / buat password baru.
     */
    public function showResetForm()
    {
        if (! session('password_reset_email') || ! session('password_reset_verified')) {
            return redirect()->route('password.forgot')
                ->with('error', 'Sesi tidak valid. Silakan mulai dari awal.');
        }

        return view('Auth.reset-password');
    }

    /**
     * Proses penyimpanan password baru ke database.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password'              => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.required'   => 'Password baru wajib diisi.',
            'password.min'        => 'Password minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
        ]);

        $email = session('password_reset_email');

        if (! $email || ! session('password_reset_verified')) {
            return redirect()->route('password.forgot')
                ->with('error', 'Sesi tidak valid. Silakan mulai dari awal.');
        }

        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('password.forgot')
                ->with('error', 'Pengguna tidak ditemukan.');
        }

        // Update password user
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus OTP dari database
        DB::table('password_reset_tokens')->where('email', $email)->delete();

        // Hapus session reset password
        $request->session()->forget(['password_reset_email', 'password_reset_verified']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
