@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold mb-3">Event Yang Dikelola</h1>
        <button onclick="openModal('tambah')" 
            class="flex items-center gap-2 bg-[#192853] text-yellow-400 px-3 py-2 rounded-lg text-sm hover:bg-[#0f1a35] transition">
            + Tambah Event
        </button>
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
                <td class="border p-2">{{ $event->judul ?? '' }}</td>
                <td class="border p-2">{{ $event->kategori ?? '' }}</td>
                <td class="border p-2 text-left">
                    <div class="max-w-xs">
                        {{ \Illuminate\Support\Str::limit($event->deskripsi ?? '', 30) }}
                        @if(strlen($event->deskripsi ?? '') > 30)
                        <button onclick="openDetail({{ $event->id }})" class="text-blue-500 hover:text-blue-700 text-xs underline">
                            Read more
                        </button>
                        @endif
                    </div>
                </td>

                <!-- TANGGAL FIX -->
                <td class="border p-2">
                    {{ \Carbon\Carbon::parse($event->tanggal_mulai ?? now())->format('d M Y') }}
                    {{ ($event->tanggal_selesai ?? null) 
                        ? ' - ' . \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') 
                        : '' }}
                </td>

                <!-- WAKTU FIX -->
                <td class="border p-2">
                    {{ ($event->waktu_mulai ?? null) 
                        ? \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') 
                        : '-' }}
                    {{ ($event->waktu_selesai ?? null) 
                        ? ' - ' . \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') 
                        : '' }}
                </td>

                <td class="border p-2">{{ $event->lokasi ?? '' }}</td>

                <td class="border p-2">
                    @if(($event->status ?? '') === 'Published')
                        <span class="text-green-600 font-semibold">Published</span>
                    @elseif(($event->status ?? '') === 'Rejected')
                        <span class="text-red-600 font-semibold">Rejected</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Draft</span>
                    @endif
                </td>
                
                <!-- AKSI FIX -->
                <td class="border p-2 space-x-1">
                    @php
                        $tikets = collect($event->tikets ?? []);
                    @endphp

                    @if($tikets->count() === 0)
                    <button onclick="bukaHalamanTiket({{ $event->id }})" class="text-green-500 hover:text-green-700" title="Tambah Tiket">
                        <i class="bi bi-ticket-perforated"></i>
                    </button>
                    @endif

                    <button onclick="openModal('edit', {{ $event->id }})" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <button onclick="openDetail({{ $event->id }})" class="text-blue-500 hover:text-blue-700" title="Kirim ke Admin">
                        <i class="bi bi-upload"></i>
                    </button>

                    <button onclick="hapusEvent({{ $event->id }})" class="text-red-500 hover:text-red-700" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="border p-4 text-center text-gray-500">Belum ada event</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>
<!-- MODAL TAMBAH EVENT -->
<div id="eventModal" class="fixed inset-0 bg-black/50 hidden z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-xl shadow w-96" onclick="event.stopPropagation()">
        
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="font-bold">Tambah Event</h2>
            <button onclick="closeModal()" class="text-red-500 text-xl">&times;</button>
        </div>

        <form id="eventForm" method="POST" action="{{ route('panitia.event.store') }}">
            @csrf
            <input type="hidden" id="methodOverride" name="_method" value="POST">

            <input name="judul" type="text" placeholder="Judul"
                class="w-full border p-2 mb-2 rounded" required>

            <input name="kategori" type="text" placeholder="Kategori"
                class="w-full border p-2 mb-2 rounded" required>

            <textarea name="deskripsi" placeholder="Deskripsi"
                class="w-full border p-2 mb-2 rounded"></textarea>

            <input name="tanggal_mulai" type="date"
                class="w-full border p-2 mb-2 rounded" required>

            <input name="waktu_mulai" type="time"
                class="w-full border p-2 mb-2 rounded" required>

            <input name="lokasi" type="text" placeholder="Lokasi"
                class="w-full border p-2 mb-3 rounded">

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="bg-gray-400 text-white px-3 py-1 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    window.events = @json($events ?? []);
    let events = window.events || [];

    let currentEventId = null;

    function openModal(mode, eventId = null) {
        console.log('klik tombol', mode);

        const modal = document.getElementById('eventModal');

        if (!modal) {
            console.error('MODAL TIDAK DITEMUKAN');
            return;
        }

        modal.classList.remove('hidden');

        const form = document.getElementById('eventForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('methodOverride');

        if (form) form.reset();

        if (mode === 'tambah') {
            if (title) title.innerText = 'Tambah Event';
            if (form) form.action = '{{ route("panitia.event.store") }}';
            if (methodInput) methodInput.value = 'POST';
        }
    }

    function closeModal() {
        const modal = document.getElementById('eventModal');
        if (modal) modal.classList.add('hidden');
    }

    // 🔥 WAJIB: expose ke global (biar onclick bisa akses)
    window.openModal = openModal;
    window.closeModal = closeModal;

});
</script>
@endsection