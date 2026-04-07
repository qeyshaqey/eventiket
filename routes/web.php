<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EtalaseEventController;
use App\Http\Controllers\JenisTiketController;
use App\Http\Controllers\ListEventController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');
Route::get('/etalase-event', [EtalaseEventController::class, 'index'])->name('etalase.event');
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/jenistiket', [JenisTiketController::class, 'index']);
Route::get('/event', [ListEventController::class, 'index']);
Route::get('/barang', [BarangController::class, 'tampilkan']);

use Illuminate\Http\Request;

Route::get('/login', function () {
    return view('login');
});

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

use App\Http\Controllers\AuthController;

