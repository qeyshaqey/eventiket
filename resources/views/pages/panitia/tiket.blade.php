@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

    <h1 class="text-xl font-bold mb-6">TIKET YANG DIKELOLA</h1>

    @forelse($events as $event)
    <div id="event-{{ $event->id }}" class="bg-white rounded-xl shadow p-4 mb-6 {{ isset($highlightEventId) && $highlightEventId == $event->id ? 'ring-4 ring-blue-400' : '' }}">

        <div class="flex gap-4">
            <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center">
                @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" class="w-full h-full object-cover rounded">
                @else
                    <i class="bi bi-image text-2xl text-gray-400"></i>
                @endif
            </div>

            <div class="flex-1 text-sm space-y-1">
                <p><b>Judul Event :</b> {{ $event->judul }}</p>
                <p><b>Kategori :</b> {{ $event->kategori }}</p>
                <p><b>Tanggal :</b> {{ $event->tanggal_mulai ?? '-' }}
                    @if($event->tanggal_selesai)
                        - {{ $event->tanggal_selesai }}
                    @endif
                </p>
                <p><b>Waktu :</b> {{ $event->waktu_mulai ?? '-' }}
                    @if($event->waktu_selesai)
                        - {{ $event->waktu_selesai }}
                    @endif
                </p>
                <p><b>Lokasi :</b> {{ $event->lokasi }}</p>
            </div>
        </div>

        <div class="mt-3 text-sm">
            <p class="font-semibold">Deskripsi :</p>
            <p>{{ $event->deskripsi }}</p>
        </div>

        <div class="mt-4">
            <p class="font-semibold mb-2 text-sm">Tiket:</p>

            @forelse($event->tikets as $tiket)
            <div class="flex justify-between items-center border p-2 rounded mb-2">
                <div>
                    <p class="font-semibold text-sm">{{ $tiket->nama }}</p>
                    <p class="text-gray-500 text-xs">
                        Rp {{ number_format($tiket->harga) }} • Kuota: {{ $tiket->kuota }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <button onclick="openEditModal({{ $tiket->id }}, '{{ $tiket->nama }}', {{ $tiket->harga }}, {{ $tiket->kuota }})"
                        class="text-yellow-500 hover:scale-110 transition">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <form action="{{ route('panitia.tiket.destroy', $tiket->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus tiket ini?')"
                            class="text-red-500 hover:scale-110 transition">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-sm">Belum ada tiket</p>
            @endforelse
        </div>

        <div class="flex justify-between items-center mt-4">
            <button onclick="openModal({{ $event->id }})"
                class="bg-[#192853] text-yellow-400 px-3 py-2 rounded-lg text-sm">
                + Tambah Tiket
            </button>

            <span class="text-xs text-gray-500">
                Status: {{ $event->status }}
            </span>
        </div>

    </div>
    @empty
    <p class="text-gray-500">Belum ada event.</p>
    @endforelse

</div>

<!-- MODAL TAMBAH -->
<div id="modalTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeModal()">

    <div class="bg-white p-6 rounded-xl shadow w-96" onclick="event.stopPropagation()">

        <form method="POST" action="{{ route('panitia.tiket.store') }}">
            @csrf
            <input type="hidden" name="event_id" id="eventId">

            <!-- JUDUL -->
            <h2 class="text-lg font-bold mb-2">Tambah Tiket</h2>
            <hr class="mb-4">

            <!-- NAMA -->
            <label class="text-sm text-black-600 mb-1 block">Nama Tiket</label>
            <input name="nama" type="text"
                class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm">

            <!--Harga -->
            <label class="text-sm text-black-600 mb-1 block">Harga</label>
            <input name="harga" type="text"
                class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm">

            <!-- KUOTA -->
            <label class="text-sm text-black-600 mb-1 block">Kuota</label>
            <input name="kuota" type="number"
                class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm">

            <!-- BUTTON -->
            <div class="flex justify-end gap-2 mt-4">
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
<!-- MODAL EDIT -->
<div id="modalEditTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeEditModal()">

    <div class="bg-white p-6 rounded-xl shadow w-96" onclick="event.stopPropagation()">

        <!-- JUDUL -->
        <h2 class="text-lg font-bold mb-2">Edit Tiket</h2>
        <hr class="mb-4">

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <!-- NAMA -->
            <label class="text-sm font-medium">Nama Tiket</label>
            <input id="editNama" name="nama" type="text"
                class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm">

            <!-- HARGA -->
            <label class="text-sm font-medium">Harga</label>
            <input id="editHarga" name="harga" type="text"
                class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm">

            <!-- KUOTA -->
            <label class="text-sm font-medium">Kuota</label>
            <input id="editKuota" name="kuota" type="number"
                class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm">

            <!-- BUTTON -->
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="closeEditModal()" class="bg-gray-400 text-white px-3 py-1 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>
@endsection


@section('script')
<script>
function openModal(eventId) {
    document.getElementById('eventId').value = eventId;
    document.getElementById('modalTiket').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalTiket').classList.add('hidden');
}

function openEditModal(id, nama, harga, kuota) {
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editKuota').value = kuota;
    document.getElementById('formEdit').action = '/panitia/tiket/' + id;
    document.getElementById('modalEditTiket').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('modalEditTiket').classList.add('hidden');
}
</script>
@endsection