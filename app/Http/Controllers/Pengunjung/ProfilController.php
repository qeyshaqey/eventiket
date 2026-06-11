<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    
    //  Method ini menangani tampilan halaman Profil Pengunjung.
    //  Mengambil data diri user serta status terakhir pengajuan panitia (jika ada).
  
    public function index()
    {
        // Mengambil data pengguna secara spesifik dari tabel 'users' berdasarkan ID yang ada di session
        $user = \App\Models\User::find(session('user_id'));

        // Jika ID tidak ditemukan (mungkin session kedaluwarsa atau belum login), 
        // tendang/redirect user kembali ke halaman login.
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Mengambil riwayat pengajuan panitia terakhir milik pengguna ini.
        // Fungsi latest()->first() memastikan kita hanya mengambil SATU data pengajuan yang paling baru dibuat.
        $pengajuan = \App\Models\PengajuanPanitia::where('user_id', $user->id)->latest()->first();

        // Buka halaman (view) profil dan bawa serta variabel $user dan $pengajuan agar bisa dicetak di HTML
        return view('pages.pengunjung.profil_pengunjung', compact('user', 'pengajuan'));
    }

    /**
     * Method ini menangani proses saat pengguna mengklik tombol "Simpan Perubahan" di profil.
     * Mengubah nama, mengunggah foto profil, atau mengganti password.
     */
    public function update(Request $request)
    {
        // Ambil data user saat ini
        $user = \App\Models\User::find(session('user_id'));

        // Memastikan pengguna telah masuk sebelum melakukan pembaruan
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Memvalidasi input dari formulir web (keamanan)
        $request->validate([
            'name' => 'required|string|max:255', // Nama tidak boleh kosong
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Foto boleh kosong, wajib gambar, maks 2MB
            'password' => 'nullable|string|min:8|confirmed', // Password boleh kosong, min 8 huruf, wajib cocok dengan kolom konfirmasi
        ], [
            // Pesan error kustom agar lebih mudah dipahami orang Indonesia
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama lengkap harus berupa teks.',
            'name.max' => 'Nama lengkap maksimal 255 karakter.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran gambar maksimal 2MB.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Siapkan variabel penanda untuk melacak apakah benar-benar ada data yang diganti oleh user
        $isChanged = false;

        // Periksa apakah user mengganti namanya
        if ($user->name !== $request->name) {
            $user->name = $request->name; // Update nama di object user
            // Wajib memperbarui 'session' nama juga, agar tulisan nama di pojok kanan atas Navbar langsung berubah!
            session(['user' => $user->name]);
            $isChanged = true; // Tandai bahwa ada perubahan
        }

        // Periksa apakah pengguna mengunggah foto profil baru
        if ($request->hasFile('photo')) {
            // Cek apakah sebelumnya user sudah pernah punya foto? 
            if ($user->photo) {
                // Jika ya, HAPUS foto fisik yang lama dari folder server agar penyimpanan (disk) tidak penuh
                Storage::disk('public')->delete($user->photo);
            }

            // Simpan foto fisik yang baru ke dalam folder 'storage/app/public/photos'
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path; // Catat path/lokasi fotonya ke database
            $isChanged = true; // Tandai bahwa ada perubahan
        }

        // Periksa apakah pengguna mengisi kolom kata sandi baru (tidak dibiarkan kosong)
        if ($request->filled('password')) {
            // Enkripsi (Hash) kata sandi tersebut demi keamanan sebelum disimpan ke DB
            $user->password = Hash::make($request->password);
            $isChanged = true; // Tandai bahwa ada perubahan
        }

        // Menyimpan perubahan ke database
        // Jika ada salah satu data di atas yang berubah, baru jalankan perintah save()
        if ($isChanged) {
            $user->save();
            return redirect()->route('pengunjung.profil')
                ->with('profile_success', 'Profil berhasil diperbarui!');
        }

        // Jika user cuma pencet "Simpan" tapi tidak mengganti ketikan apa-apa
        return redirect()->route('pengunjung.profil')
            ->with('profile_success', 'Tidak ada perubahan data.');
    }

    
    // Method ini bertugas merender halaman form untuk pendaftaran Panitia 
     
    public function halamanPengajuan()
    {
        $userId = session('user_id');
        $user = \App\Models\User::find($userId);

        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        // Mengambil SELURUH riwayat pengajuan milik user ini dari yang paling baru ke paling lama
        $riwayatPengajuan = \App\Models\PengajuanPanitia::where('user_id', $userId)->latest()->get();

        // Pengguna HANYA BOLEH MENGAJUKAN formulir baru JIKA:
        // Tidak ada pengajuan yang statusnya masih pending (menunggu) 
        // ATAU tidak ada pengajuan yang 'dicabut' 
        $bolehAjukan = !$riwayatPengajuan->whereIn('status', ['pending', 'dicabut'])->count();

        // Mengambil kumpulan tulisan daftar kategori event dari database untuk dijadikan pilihan di Dropdown
        $kategoris = \App\Models\Kategori::pluck('nama_kategori');

        // Buka halamannya dan lempar datanya
        return view('pages.pengunjung.daftar_panitia', compact('user', 'riwayatPengajuan', 'bolehAjukan', 'kategoris'));
    }

    
    // Method ini menangani proses saat user mengklik "Kirim Pengajuan" di halaman pendaftaran panitia.
    public function daftarPanitia(Request $request)
    {
        $userId = session('user_id');

        // Validasi formulir pengajuan, pastikan tidak ada data penting yang terlewat
        $request->validate([
            'organisasi'  => 'required|string|max:255', // Nama UKM / Organisasi
            'nama_event'  => 'required|string|max:255', // Rencana acara
            'kategori'    => 'required|string|max:255', // Pilihan Dropdown
            'tanggal'     => 'required|date',           // Tanggal rencana pelaksanaan
            'deskripsi'   => 'required|string',         // Paragraf deskripsi konsep acara
        ]);

        // Cek kembali ke database, apakah user ini berstatus 'dicabut' (di-banned admin)?
        $cekBlacklist = \App\Models\PengajuanPanitia::where('user_id', $userId)
                                        ->where('status', 'dicabut')
                                        ->exists();
                                        
        if ($cekBlacklist) {
            // Tolak mentah-mentah jika statusnya dicabut
            return redirect()->back()->with('toast_error', 'Anda telah dicabut dari keanggotaan panitia karena melanggar aturan dan tidak dapat mendaftar kembali.');
        }

        // Cek apakah user mencoba mengirim ulang padahal status pengajuan sebelumnya masih diproses admin?
        $cekPending = \App\Models\PengajuanPanitia::where('user_id', $userId)
                                      ->where('status', 'pending')
                                      ->exists();
                                      
        if ($cekPending) {
            // Tolak karena masih menunggu hasil admin
            return redirect()->back()->with('toast_error', 'Anda masih memiliki pengajuan yang sedang diproses oleh Admin.');
        }
        // Jika aman, masukkan semua isian formulir tadi ke dalam tabel 'pengajuan_panitias'
        \App\Models\PengajuanPanitia::create([
            'user_id'         => $userId,
            'nama_organisasi' => $request->organisasi,
            'nama_event'      => $request->nama_event,
            'kategori'        => $request->kategori,
            'tanggal_event'   => $request->tanggal,
            'deskripsi'       => $request->deskripsi,
            'status'          => 'pending', // Otomatis diset menjadi 'pending'
        ]);

        // Berhasil, kembalikan user dengan notifikasi sukses Toast
        return redirect()->route('pengunjung.daftar_panitia')->with('toast_success', 'Pengajuan berhasil dikirim! Silakan tunggu konfirmasi Admin.');
    }
}

