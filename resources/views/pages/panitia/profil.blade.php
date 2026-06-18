@extends('layouts.panitialayouts.panitia-main')

@section('title', 'Profil Panitia')

@section('content')
<div class="p-6 bg-[#EFF8FF] min-h-screen">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-[#192853]">Profil Panitia</h1>
    </div>

    @if(session('success'))
    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col lg:flex-row gap-8">

        <div class="flex flex-col items-center lg:w-1/3">
            <div class="w-32 h-32 rounded-full overflow-hidden border border-slate-200 shadow-sm">
                <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=192853&color=fff' }}" alt="Profil" class="w-full h-full object-cover">
            </div>
            <h2 class="mt-4 text-xl font-semibold text-[#192853] text-center">{{ $user->name }}</h2>
            <button onclick="openModal()"
                class="mt-5 inline-flex items-center justify-center rounded-full bg-[#192853] px-5 py-2 text-sm font-semibold text-yellow-400 transition hover:opacity-90">
                Edit Profil
            </button>
        </div>

        <div class="lg:w-2/3">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 bg-[#F8FAFF] rounded-2xl border">
                    <p class="text-xs text-gray-500">Nama</p>
                    <p class="mt-2 font-semibold text-[#192853]">{{ $user?->name ?? '-' }}</p>
                </div>
                <div class="p-4 bg-[#F8FAFF] rounded-2xl border">
                    <p class="text-xs text-gray-500">NIM</p>
                    <p class="mt-2 font-semibold text-[#192853]">{{ $user?->nim ?? '-' }}</p>
                </div>
                <div class="p-4 bg-[#F8FAFF] rounded-2xl border">
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="mt-2 font-semibold text-[#192853]">{{ $user?->email ?? '-' }}</p>
                </div>
                <div class="p-4 bg-[#F8FAFF] rounded-2xl border">
                    <p class="text-xs text-gray-500">Role</p>
                    <p class="mt-2 font-semibold text-yellow-600">Panitia</p>
                </div>
            </div>
        </div>

    </div>
</div>

<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 px-4 py-8">
    <div class="bg-white w-full max-w-2xl p-6 rounded-3xl shadow-2xl relative overflow-y-auto max-h-[90vh] animate-fadeIn">

        <button type="button" onclick="closeModal()"
            class="absolute top-4 right-4 text-2xl text-gray-400 hover:text-black">&times;</button>

        <h2 class="text-2xl font-bold text-[#192853] mb-5">Edit Profil</h2>

        <form action="{{ route('panitia.profil.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex flex-col items-center mb-6">
                <div class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-200 shadow-sm">
                    <img id="previewImage" src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=192853&color=fff' }}" alt="Preview" class="w-full h-full object-cover">
                    <label class="absolute bottom-2 right-2 bg-[#192853] text-yellow-400 p-2 rounded-full cursor-pointer text-xs">
                        ✎
                        <input type="file" name="photo" class="hidden" accept="image/jpeg,image/png,image/jpg" onchange="previewFoto(event)">
                    </label>
                </div>
                <p class="text-xs text-gray-500 mt-3">Klik ikon untuk mengganti foto. Kosongkan jika tidak ingin mengubah.</p>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="text-sm font-semibold text-[#192853]">Nama</label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                        class="mt-2 w-full border @error('name') border-red-500 @else border-gray-200 @enderror rounded-2xl px-4 py-3 focus:ring-2 focus:ring-[#192853] outline-none">
                    @error('name')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#192853]">NIM</label>
                    <input type="text" value="{{ $user->nim }}" readonly
                        class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 bg-slate-50 text-gray-600 cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-2">NIM tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#192853]">Email</label>
                    <input type="email" value="{{ $user->email }}" readonly
                        class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 bg-slate-50 text-gray-600 cursor-not-allowed">
                    <p class="text-xs text-gray-500 mt-2">Email tidak dapat diubah.</p>
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#192853]">Kata Sandi Baru (Opsional)</label>
                    <input type="password" name="password" placeholder="Masukkan kata sandi baru"
                        class="mt-2 w-full border @error('password') border-red-500 @else border-gray-200 @enderror rounded-2xl px-4 py-3 focus:ring-2 focus:ring-[#192853] outline-none">
                    @error('password')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-semibold text-[#192853]">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi baru"
                        class="mt-2 w-full border border-gray-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-[#192853] outline-none">
                </div>
            </div>

            <div class="mt-8 flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" onclick="closeModal()"
                    class="w-full sm:w-auto rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-slate-100 transition">
                    Batal
                </button>
                <button type="submit"
                    class="w-full sm:w-auto rounded-full bg-[#192853] px-6 py-3 text-sm font-semibold text-yellow-400 hover:opacity-90 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        openModal();
    });
</script>
@endif

<script>
function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function previewFoto(event) {
    const reader = new FileReader();
    reader.onload = function () {
        document.getElementById('previewImage').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>

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