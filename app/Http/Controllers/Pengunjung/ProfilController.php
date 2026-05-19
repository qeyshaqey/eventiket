<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    // buat nampilin halaman profil pengunjung
    public function index()
    {
        // cari data user berdasarkan session id login kustom kita
        $user = \App\Models\User::find(session('user_id'));

        // kalo belum login atau session habis, lempar ke login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        return view('pages.pengunjung.profil_pengunjung', compact('user'));
    }

    // buat nge-update data profil (nama, foto, password)
    public function update(Request $request)
    {
        $user = \App\Models\User::find(session('user_id'));

        // pastiin user udah login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // validasi dulu biar inputannya bener dan aman
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

        // flag/penanda apakah ada data yang beneran berubah
        $isChanged = false;

        // cek kalau namanya beda sama yang lama
        if ($user->name !== $request->name) {
            $user->name = $request->name;
            // session nama di-update juga biar di navbar langsung berubah
            session(['user' => $user->name]);
            $isChanged = true;
        }

        // cek kalau user upload foto baru
        if ($request->hasFile('photo')) {
            // hapus foto lama dari storage biar gak menuh-menuhin
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // simpan foto baru ke folder photos di public storage
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
            $isChanged = true;
        }

        // cek kalau user ngisi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $isChanged = true;
        }

        // kalau ada yang berubah baru kita save ke database
        if ($isChanged) {
            $user->save();
            return redirect()->route('pengunjung.profil')
                ->with('profile_success', 'Profil berhasil diperbarui!');
        }

        // kalau klik simpan tapi gak ada yang diubah, langsung balik aja
        return redirect()->route('pengunjung.profil')
            ->with('profile_success', 'Tidak ada perubahan data.');
    }
}
