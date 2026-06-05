<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// list impor controller yang dipake
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
use App\Http\Controllers\Pengunjung\PaymentController;
use App\Http\Controllers\Pengunjung\ProfilController;
use App\Http\Controllers\BerandaPanitiaController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\PengunjungController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KategoriController;

//============PANITIA SIDE=========================//
use App\Http\Controllers\panitia\EventPanitiaController;
use App\Http\Controllers\panitia\TiketPanitiaController;
use App\Http\Controllers\panitia\TransaksiController;
Route::prefix('panitia')->name('panitia.')->middleware('role:panitia')->group(function () {

    Route::get('/beranda', [BerandaPanitiaController::class, 'index'])->name('beranda');

    // Event
    Route::get('/event', [EventPanitiaController::class, 'index'])->name('event');
    Route::post('/event', [EventPanitiaController::class, 'store'])->name('event.store');
    Route::put('/event/{event}', [EventPanitiaController::class, 'update'])->name('event.update');
    Route::delete('/event/{event}', [EventPanitiaController::class, 'destroy'])->name('event.destroy');
    Route::post('/event/{event}/kirim', [EventPanitiaController::class, 'kirim'])->name('event.kirim');

    // Tiket
    Route::get('/tiket', [TiketPanitiaController::class, 'index'])->name('tiket');
    Route::post('/tiket', [TiketPanitiaController::class, 'store'])->name('tiket.store');
    Route::put('/tiket/{tiket}', [TiketPanitiaController::class, 'update'])->name('tiket.update');
    Route::delete('/tiket/{tiket}', [TiketPanitiaController::class, 'destroy'])->name('tiket.destroy');

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('transaksi');

    // riwayat event panitia
    Route::get('/riwayat', [EventPanitiaController::class, 'riwayat'])
        ->name('riwayat');

    // profil panitia
    Route::get('/profil', [EventPanitiaController::class, 'profil'])->name('profil');
    // update profil panitia
    Route::post('/profil/update', [EventPanitiaController::class, 'updateProfil'])
        ->name('profil.update');
});
//===============================================================//

// halaman awal, langsung di-redirect ke home page
Route::get('/', function () {
    return redirect('/home_page');
});

Route::get('/home_page', [HomePageController::class, 'index'])->name('home');

// Detail event (Public)
Route::get('/detail_event/{id}', [HomePageController::class, 'showDetail'])->name('pengunjung.detail.event');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

// Etalase Event
Route::get('/etalase_event', [EtalaseEventController::class, 'index'])->name('etalase.event');

// Dashboard 
Route::get('/dashboard', [DashboardController::class, 'index']);

// ============ ADMIN SIDE =========================//
Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
    // Dashboard Admin 
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');

    // Data Pengunjung
    Route::get('/data-pengunjung', [PengunjungController::class, 'index'])->name('data.pengunjung');

    // Data Panitia
    Route::get('/data-panitia', [PanitiaController::class, 'index'])->name('data.panitia');
    Route::post('/data-panitia/approve/{id}', [PanitiaController::class, 'approve'])->name('data.panitia.approve');
    Route::post('/data-panitia/reject/{id}', [PanitiaController::class, 'reject'])->name('data.panitia.reject');
    Route::post('/data-panitia/demote/{id}', [PanitiaController::class, 'demote'])->name('data.panitia.demote');

    // Event
    Route::get('/kelola-event', [EventController::class, 'index'])->name('kelola.event');
    Route::post('/event-approve/{id}', [EventController::class, 'approve'])->name('event.approve');
    Route::post('/event-reject/{id}', [EventController::class, 'reject'])->name('event.reject');
    Route::post('/event-delete/{id}', [EventController::class, 'delete'])->name('event.delete');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori/store', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('kategori.delete');
});
// ===============================================================//

// Lainnya
Route::get('/jenistiket', [JenisTiketController::class, 'index']);
Route::get('/barang', [BarangController::class, 'tampilkan']);

// ── PROSES LOGIN ──
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {
    $username = $request->username;
    $password = $request->password;

    if (!$username || !$password) {
        return back()->with('error', 'NIM/Nama Lengkap dan password wajib diisi.');
    }

    // cari user di db pake nama atau nim
    $user = User::where('name', $username)
                ->orWhere('nim', $username)
                ->first();
    
    // mastiin user ketemu dan password-nya bener
    if (!$user || !Hash::check($password, $user->password)) {
        return back()->with('error', 'NIM/Nama Lengkap atau password salah.');
    }

    // simpan data user ke session kustom
    session([
        'user' => $user->name, 
        'role' => $user->role, 
        'user_id' => $user->id
    ]);
    
    // lempar ke dashboard sesuai role masing-masing
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('pengunjung.dashboard');
    }
});

// ── PROSES DAFTAR ──
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

// ── LUPA PASSWORD (OTP) ──
Route::get('/lupa-password', [ForgotPasswordController::class, 'showForm'])
    ->name('password.forgot');

Route::post('/lupa-password', [ForgotPasswordController::class, 'sendOtp'])
    ->name('password.forgot.send');

// ── VERIFIKASI KODE OTP ──
Route::get('/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])
    ->name('password.verify.form');

Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
    ->name('password.verify');

// ── ATUR ULANG PASSWORD BARU ──
Route::get('/reset-password', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset.form');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.reset');

// ── PENGUNJUNG SIDE ──
Route::prefix('pengunjung')->name('pengunjung.')->middleware('role:pengunjung')->group(function () {
    Route::get('/dashboard_pengunjung', [DashboardPengunjungController::class, 'index'])->name('dashboard');
    Route::get('/dashboard_pengunjung/ajax', [DashboardPengunjungController::class, 'ajaxSearch'])->name('dashboard.ajax');
    Route::get('/detail_event/{id}', [HomePageController::class, 'showDetail'])->name('detail.event');
    Route::get('/tiket_aktif', [TiketController::class, 'index'])->name('tiket');
    Route::post('/checkout', [TiketController::class, 'checkout'])->name('checkout');
    Route::post('/tiket/{id}/batal', [TiketController::class, 'batal'])->name('tiket.batal');
    
    Route::get('/profil_pengunjung', [ProfilController::class, 'index'])->name('profil');
    Route::post('/profil_pengunjung/update', [ProfilController::class, 'update'])->name('profil.update');

    Route::get('/pembayaran', [PaymentController::class, 'initiatePayment'])->name('pembayaran');

    // Halaman riwayat pengajuan panitia + form ajukan diri
    Route::get('/daftar_panitia', [ProfilController::class, 'halamanPengajuan'])->name('daftar_panitia');
    Route::post('/daftar_panitia_post', [ProfilController::class, 'daftarPanitia'])->name('daftar_panitia_post');
});

// ── Beranda Panitia ──
Route::get('/beranda-panitia', [BerandaPanitiaController::class, 'index'])
    ->name('beranda.panitia')
    ->middleware('role:panitia');

// ── PROSES LOGOUT ──
Route::post('/logout', function () {
    session()->flush();
    return redirect('/login');
})->name('logout');

// callback midtrans buat update status bayar
Route::post('/payment/callback', [PaymentController::class, 'callback']);