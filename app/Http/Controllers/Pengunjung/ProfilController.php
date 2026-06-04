<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // Menampilkan halaman profil pengunjung
    public function index()
    {
        // Mengambil data pengguna berdasarkan ID sesi login
        $user = \App\Models\User::find(session('user_id'));

        // Mengarahkan ke halaman login jika sesi telah berakhir atau belum masuk
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Memeriksa riwayat pengajuan panitia terakhir milik pengguna
        $pengajuan = \App\Models\PengajuanPanitia::where('user_id', $user->id)->latest()->first();

        return view('pages.pengunjung.profil_pengunjung', compact('user', 'pengajuan'));
    }

    // Memperbarui data profil pengguna (nama, foto, dan kata sandi)
    public function update(Request $request)
    {
        $user = \App\Models\User::find(session('user_id'));

        // Memastikan pengguna telah masuk sebelum melakukan pembaruan
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Memvalidasi input dari pengguna
        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Penanda untuk mengetahui apakah terdapat perubahan data
        $isChanged = false;

        // Memperbarui nama pengguna jika terdapat perubahan
        if ($user->name !== $request->name) {
            $user->name = $request->name;
            // Memperbarui sesi nama agar tampilan navbar langsung menyesuaikan
            session(['user' => $user->name]);
            $isChanged = true;
        }

        // Memeriksa apakah pengguna mengunggah foto profil baru
        if ($request->hasFile('photo')) {
            // Menghapus foto profil lama dari penyimpanan
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Menyimpan foto profil baru ke penyimpanan
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
            $isChanged = true;
        }

        // Memeriksa apakah pengguna memasukkan kata sandi baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $isChanged = true;
        }

        // Menyimpan perubahan ke basis data jika ada data yang diubah
        if ($isChanged) {
            $user->save();
            return redirect()->route('pengunjung.profil')
                ->with('profile_success', 'Profil berhasil diperbarui!');
        }

        // Mengembalikan ke halaman profil jika tidak ada perubahan
        return redirect()->route('pengunjung.profil')
            ->with('profile_success', 'Tidak ada perubahan data.');
    }

    public function halamanPengajuan()
    {
        $userId = session('user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Mengambil seluruh riwayat pengajuan panitia pengguna untuk ditampilkan
        $riwayatPengajuan = \App\Models\PengajuanPanitia::where('user_id', $userId)->latest()->get();

        // Memeriksa kelayakan pengguna untuk mengajukan form baru
        $bolehAjukan = !$riwayatPengajuan->whereIn('status', ['pending', 'dicabut'])->count();

        return view('pages.pengunjung.daftar_panitia', compact('user', 'riwayatPengajuan', 'bolehAjukan'));
    }

    public function daftarPanitia(Request $request)
    {
        $userId = session('user_id');

        $request->validate([
            'organisasi'  => 'required|string|max:255',
            'nama_event'  => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',
            'tanggal'     => 'required|date',
            'deskripsi'   => 'required|string',
        ]);

        $cekBlacklist = \App\Models\PengajuanPanitia::where('user_id', $userId)
                                        ->where('status', 'dicabut')
                                        ->exists();
                                        
        if ($cekBlacklist) {
            return redirect()->back()->with('toast_error', 'Anda telah dicabut dari keanggotaan panitia karena melanggar aturan dan tidak dapat mendaftar kembali.');
        }

        $cekPending = \App\Models\PengajuanPanitia::where('user_id', $userId)
                                      ->where('status', 'pending')
                                      ->exists();
                                      
        if ($cekPending) {
            return redirect()->back()->with('toast_error', 'Anda masih memiliki pengajuan yang sedang diproses oleh Admin.');
        }

        \App\Models\PengajuanPanitia::create([
            'user_id'         => $userId,
            'nama_organisasi' => $request->organisasi,
            'nama_event'      => $request->nama_event,
            'kategori'        => $request->kategori,
            'tanggal_event'   => $request->tanggal,
            'deskripsi'       => $request->deskripsi,
            'status'          => 'pending',
        ]);

        return redirect()->route('pengunjung.daftar_panitia')->with('toast_success', 'Pengajuan berhasil dikirim! Silakan tunggu konfirmasi Admin.');
    }
}
