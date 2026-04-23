@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold mb-3">Event Yang Dikelola</h1>

        <a href="{{ route('panitia.event.create') }}" 
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition inline-block">
            + Tambah Event
        </a>
    </div>

    <!-- TABLE -->
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">NO</th>
                <th class="border p-2">JUDUL EVENT</th>
                <th class="border p-2">KATEGORI</th>
                <th class="border p-2">DESKRIPSI</th>
                <th class="border p-2">TANGGAL</th>
                <th class="border p-2">WAKTU</th>
                <th class="border p-2">LOKASI</th>
                <th class="border p-2">STATUS</th>
                <th class="border p-2">AKSI</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @forelse($events as $index => $event)
            <tr>
                <td class="border p-2">{{ $index + 1 }}</td>
                <td class="border p-2">{{ $event->judul }}</td>
                <td class="border p-2">{{ $event->kategori }}</td>
                <td class="border p-2">{{ Str::limit($event->deskripsi, 50) }}</td>
                <td class="border p-2">{{ $event->tanggal_mulai }}</td>
                <td class="border p-2">{{ $event->waktu }}</td>
                <td class="border p-2">{{ $event->lokasi }}</td>
                <td class="border p-2">
                    @if($event->status === 'Published')
                        <span class="text-green-600 font-semibold">Published</span>
                    @elseif($event->status === 'Rejected')
                        <span class="text-red-600 font-semibold">Rejected</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Draft</span>
                    @endif
                </td>
                <td class="border p-2 space-x-2">
                    <a href="{{ route('panitia.event.show', $event->id) }}" class="text-green-500" title="Lihat Detail">
                        <i class="bi bi-eye"></i>
                    </a>
                    <a href="{{ route('panitia.event.edit', $event->id) }}" class="text-yellow-500" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    @if($event->status === 'Draft')
                    <form action="{{ route('panitia.event.kirim', $event->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-500" title="Kirim ke Admin" onclick="return confirm('Kirim event ke admin?')">
                            <i class="bi bi-upload"></i>
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('panitia.event.destroy', $event->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500" title="Hapus" onclick="return confirm('Hapus event?')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="border p-4 text-center text-gray-500">Belum ada event</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection