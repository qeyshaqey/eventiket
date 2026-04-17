@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-6">
    <div class="mb-4">
        <a href="{{ route('panitia.event') }}" class="text-blue-500 hover:underline">
            &larr; Kembali
        </a>
        <h1 class="text-xl font-bold mt-2">Detail Event</h1>
    </div>

    <div class="flex gap-6">
        <!-- POSTER -->
        <div class="w-48 h-48 bg-gray-200 rounded flex items-center justify-center overflow-hidden flex-shrink-0">
            @if($event->gambar)
                <img src="{{ Storage::url($event->gambar) }}" alt="Poster" class="w-full h-full object-cover">
            @else
                <i class="bi bi-image text-4xl text-gray-400"></i>
            @endif
        </div>

        <!-- DETAIL -->
        <div class="flex-1 text-sm space-y-2">
            <p><b>Judul :</b> {{ $event->judul }}</p>
            <p><b>Kategori :</b> {{ $event->kategori }}</p>
            <p><b>Tanggal :</b> {{ $event->tanggal_mulai }} @if($event->tanggal_selesai) - {{ $event->tanggal_selesai }} @endif</p>
            <p><b>Waktu :</b> {{ $event->waktu ?? '-' }}</p>
            <p><b>Lokasi :</b> {{ $event->lokasi ?? '-' }}</p>
            <p><b>Status :</b> 
                @if($event->status === 'Published')
                    <span class="text-green-600 font-semibold">Published</span>
                @elseif($event->status === 'Rejected')
                    <span class="text-red-600 font-semibold">Rejected</span>
                @else
                    <span class="text-yellow-600 font-semibold">Draft</span>
                @endif
            </p>
        </div>
    </div>

    <!-- DESKRIPSI -->
    <div class="mt-6">
        <p class="font-semibold">Deskripsi :</p>
        <p class="text-sm mt-1">{{ $event->deskripsi ?? 'Tidak ada deskripsi' }}</p>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="mt-6 flex justify-between items-center border-t pt-4">
        <div>
            @if($event->status === 'Draft')
            <form action="{{ route('panitia.event.kirim', $event->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" onclick="return confirm('Kirim event ke admin?')">
                    KIRIM KE ADMIN
                </button>
            </form>
            @endif
        </div>
        <div class="flex gap-2">
            <a href="{{ route('panitia.event.edit', $event->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                EDIT
            </a>
            <form action="{{ route('panitia.event.destroy', $event->id) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('Hapus event?')">
                    HAPUS
                </button>
            </form>
        </div>
    </div>
</div>

@endsection