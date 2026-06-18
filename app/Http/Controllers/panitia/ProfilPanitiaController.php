<?php

namespace App\Http\Controllers\panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilPanitiaController extends Controller
{
    /**
     * Menampilkan profil panitia dari database.
     */
    public function profil()
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        return view('pages.panitia.profil', compact('user'));
    }

    /**
     * Memperbarui profil panitia di database.
     */
    public function updateProfil(Request $request)
    {
        $user = User::find(session('user_id'));

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

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

        $isChanged = false;

        if ($user->name !== $request->name) {
            $user->name = $request->name;
            session(['user' => $user->name]);
            $isChanged = true;
        }

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
            $isChanged = true;
        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $isChanged = true;
        }

        if ($isChanged) {
            $user->save();
            return back()->with('success', 'Profil berhasil diperbarui!');
        }

        return back()->with('success', 'Tidak ada perubahan data.');
    }
}
