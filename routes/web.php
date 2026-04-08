<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EtalaseEventController;
use App\Http\Controllers\JenisTiketController;
use App\Http\Controllers\ListEventController;
use App\Http\Controllers\RegisterController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/etalase_event', [EtalaseEventController::class, 'index'])->name('etalase.event');
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/jenistiket', [JenisTiketController::class, 'index']);
Route::get('/event', [ListEventController::class, 'index']);
Route::get('/barang', [BarangController::class, 'tampilkan']);

// ── Login ──
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $username = $request->username;
    $password = $request->password;

    if (!$username || !$password) {
        return back()->with('error', 'Username dan password wajib diisi.');
    }

    if ($username === 'admin' && $password === 'password123') {
        session(['user' => $username]);
        return back()->with('success', 'Login berhasil! Selamat datang, ' . $username);
    }

    return back()->with('error', 'Username atau password salah.');
});

// ── Register ──
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

use App\Http\Controllers\DashboardPesertaController;
Route::get('/dashboard_peserta', [DashboardPesertaController::class, 'index']);

use App\Http\Controllers\BerandaPanitiaController;
Route::get('/beranda-panitia', [BerandaPanitiaController::class, 'index'])->name('beranda.panitia');