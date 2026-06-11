@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="p-6 bg-[#EFF8FF] min-h-screen">

    <!-- HEADER HALAMAN PROFIL -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-[#192853]">Profil Panitia</h1>
    </div>

    <!-- NOTIFIKASI SUKSES UPDATE PROFIL -->
    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- KARTU UTAMA PROFIL -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-8">

        <!-- FOTO PROFIL (AVATAR) -->
        <div class="flex flex-col items-center md:w-1/4">
            <img src="{{ ($user->photo ?? null) ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . ($user->name ?? 'Guest') }}" class="w-28 h-28 rounded-full object-cover shadow-md border">

            <!-- Tombol untuk memicu pembukaan modal edit profil -->
            <button onclick="openModal()"
                class="mt-4 bg-[#192853] text-yellow-400 px-4 py-2 rounded-lg text-sm hover:opacity-90 transition">
                Edit Profil
            </button>
        </div>

        <!-- BLOK INFORMASI DATA DIRI -->
        <div class="md:w-3/4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Tampilan Nama -->
                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">Nama</p>
                    <p class="font-semibold text-[#192853]">{{ $user?->name ?? '-' }}</p>
                </div>
                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">NIM</p>
                    <p class="font-semibold text-[#192853]">{{ $user?->nim ?? '-' }}</p>
                </div>
                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="font-semibold text-[#192853]">{{ $user?->email ?? '-' }}</p>
                </div>
                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">Role</p>
                    <p class="font-semibold text-yellow-600">Panitia</p>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- ================= MODAL EDIT PROFIL ================= -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 transition">
    <div class="bg-white w-[420px] p-6 rounded-2xl shadow-2xl relative animate-fadeIn">

        <!-- Tombol Tutup Modal -->
        <button onclick="closeModal()" 
            class="absolute top-3 right-3 text-gray-400 hover:text-black text-xl">
            &times;
        </button>

        <h2 class="text-xl font-bold text-[#192853] mb-4">Edit Profil</h2>

        <!-- Form Edit Data Diri & Foto -->
        <form action="{{ route('panitia.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Upload Foto Profil dengan Preview -->
            <div class="flex flex-col items-center mb-5">
                <div class="relative">
                    <!-- Preview Foto -->
                    <img id="previewImage"
                        src="{{ ($user->photo ?? null) ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . ($user->name ?? 'Guest') }}"
                        class="w-24 h-24 rounded-full object-cover border shadow">
                    <label class="absolute bottom-0 right-0 bg-[#192853] text-yellow-400 p-1 rounded-full cursor-pointer text-xs">
                        ✎
                        <input type="file" name="photo" class="hidden" onchange="previewFoto(event)">
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-2">Klik ikon untuk ganti foto</p>
            </div>

            <!-- Form Input Profil -->
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <input type="text" name="name" required
                        value="{{ old('name', $user?->name) }}"
                        class="w-full border @error('name') border-red-500 @else border-gray-200 @enderror p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">NIM</label>
                    <input type="text" name="nim" required
                        value="{{ old('nim', $user?->nim) }}"
                        class="w-full border @error('nim') border-red-500 @else border-gray-200 @enderror p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                    @error('nim')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" required
                        value="{{ old('email', $user?->email) }}"
                        class="w-full border @error('email') border-red-500 @else border-gray-200 @enderror p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Kata Sandi Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Masukkan kata sandi baru"
                        class="w-full border @error('password') border-red-500 @else border-gray-200 @enderror p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                    @error('password')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi baru"
                        class="w-full border border-gray-200 p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                </div>
            </div>

            <!-- Tombol Batal & Simpan -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-4 py-2 bg-[#192853] text-yellow-400 rounded-lg hover:opacity-90 transition">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<!-- JAVASCRIPT LOGIC -->
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        openModal();
        if (typeof showToast === 'function') {
            showToast("{{ $errors->first() }}", "error");
        }
    });
</script>
@endif

<script>
// Membuka modal edit profil
function openModal(){
    document.getElementById('modal').classList.remove('hidden');
}

// Menutup modal edit profil
function closeModal(){
    document.getElementById('modal').classList.add('hidden');
}

// Membuat preview foto secara instan setelah file dipilih
function previewFoto(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImage').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

<!-- STYLE ANIMASI POP-UP -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>

@endsection