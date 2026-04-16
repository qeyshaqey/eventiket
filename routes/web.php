<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Controller
use App\Http\Controllers\BarangController;
use App\Http\Controllers\Pengunjung\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\EtalaseEventController;
use App\Http\Controllers\JenisTiketController;
use App\Http\Controllers\ListEventController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Pengunjung\HomePageController;
use App\Http\Controllers\Pengunjung\DashboardPengunjungController;
use App\Http\Controllers\Pengunjung\TiketController;
use App\Http\Controllers\BerandaPanitiaController;



// Halaman awal
Route::get('/', function () {
    return view('welcome');
});

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Etalase Event
Route::get('/etalase_event', [EtalaseEventController::class, 'index'])->name('etalase.event');

// Dashboard 
Route::get('/dashboard', [DashboardController::class, 'index']);

// Dashboard Admin 
Route::get('/dashboard-admin', [DashboardAdminController::class, 'index']);

use App\Http\Controllers\PengunjungController;

Route::get('/data-pengunjung', [PengunjungController::class, 'index'])
    ->name('data.pengunjung');

use App\Http\Controllers\PanitiaController;

Route::get('/data-panitia', [PanitiaController::class, 'index'])
    ->name('data.panitia');

use App\Http\Controllers\EventController;

Route::get('/kelola-event', [EventController::class, 'index'])->name('kelola.event');
Route::get('/event-approve/{id}', [EventController::class, 'approve'])->name('event.approve');
Route::get('/event-delete/{id}', [EventController::class, 'delete'])->name('event.delete');


use App\Http\Controllers\KategoriController;

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');

// Lainnya
Route::get('/jenistiket', [JenisTiketController::class, 'index']);
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
        session(['user' => $username, 'role' => 'admin']);

        return redirect('/dashboard-admin');
    }

    session(['user' => $username, 'role' => 'pengunjung']);

    return redirect()->route('pengunjung.dashboard');
});

// ── Register ──
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ── Lupa Password ──
Route::get('/lupa-password', [ForgotPasswordController::class, 'showForm'])
    ->name('password.forgot');

Route::post('/lupa-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.forgot.send');

// ── Dashboard Pengunjung ──
Route::get('/home_page', [HomePageController::class, 'index']);
Route::get('/dashboard_pengunjung', [DashboardPengunjungController::class, 'index'])->name('pengunjung.dashboard');
Route::get('/detail_event/{id}', [HomePageController::class, 'showDetail'])->name('detail.event');
Route::get('/tiket_aktif', [TiketController::class, 'index']);

// ── Beranda Panitia ──
Route::get('/beranda-panitia', [BerandaPanitiaController::class, 'index'])->name('beranda.panitia');

Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');
