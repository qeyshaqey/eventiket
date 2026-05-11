@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-6">
    <div class="mb-4">
        <a href="{{ route('panitia.event') }}" class="text-blue-500 hover:underline">
            &larr; Kembali
        </a>
        <h1 class="text-xl font-bold mt-2">Tambah Event</h1>
    </div>

    <form action="{{ route('panitia.event.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- JUDUL -->
        <div>
            <label class="text-sm font-semibold">Judul Event</label>
            <input type="text" name="judul" value="{{ old('judul') }}"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
                placeholder="Masukkan judul event" required>
            @error('judul')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- KATEGORI -->
        <div>
            <label class="text-sm font-semibold">Kategori</label>
            <select name="kategori"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none" required>
                <option value="">Pilih Kategori</option>
                <option value="Workshop" {{ old('kategori') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                <option value="Seminar" {{ old('kategori') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
                <option value="Hiburan" {{ old('kategori') == 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
            </select>
            @error('kategori')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- DESKRIPSI -->
        <div>
            <label class="text-sm font-semibold">Deskripsi</label>
            <textarea name="deskripsi"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
                placeholder="Masukkan deskripsi">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- TANGGAL -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none" required>
                @error('tanggal_mulai')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-semibold">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                    class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
            </div>
        </div>

        <!-- WAKTU -->
        <div>
            <label class="text-sm font-semibold">Waktu</label>
            <input type="time" name="waktu" value="{{ old('waktu') }}"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <!-- LOKASI -->
        <div>
            <label class="text-sm font-semibold">Lokasi</label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
                placeholder="Masukkan lokasi">
        </div>

        <!-- POSTER -->
        <div>
            <label class="text-sm font-semibold">Poster Event</label>
            <input type="file" name="gambar" accept="image/*"
                class="w-full border border-gray-300 p-2 rounded cursor-pointer">
            @error('gambar')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('panitia.event') }}" 
                class="px-6 py-2 bg-gray-200 text-gray-700 rounded-xl text-sm font-semibold hover:bg-gray-300 transition">
                BATAL
            </a>
            <button type="submit" 
                class="px-6 py-2 bg-[#192853] text-yellow-400 rounded-xl text-sm font-bold shadow hover:opacity-90 transition">
                SIMPAN
            </button>
        </div>
    </form>
</div>

@endsection