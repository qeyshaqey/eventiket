@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

    <h1 class="text-xl font-bold mb-6">TIKET YANG DIKELOLA</h1>

    @forelse($events as $event)
    <div class="bg-white rounded-xl shadow p-4 mb-6">

        <div class="flex gap-4">
            <!-- GAMBAR -->
            <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center">
                @if($event->gambar)
                    <img src="{{ Storage::url($event->gambar) }}" class="w-full h-full object-cover rounded">
                @else
                    <i class="bi bi-image text-2xl text-gray-400"></i>
                @endif
            </div>

            <!-- DETAIL -->
            <div class="flex-1 text-sm space-y-1">
                <p><b>Judul Event :</b> {{ $event->judul }}</p>
                <p><b>Kategori :</b> {{ $event->kategori }}</p>
                <p><b>Tanggal :</b> {{ $event->tanggal_mulai }}</p>
                <p><b>Waktu :</b> {{ $event->waktu }}</p>
                <p><b>Lokasi :</b> {{ $event->lokasi }}</p>
            </div>
        </div>

        <!-- DESKRIPSI -->
        <div class="mt-3 text-sm">
            <p class="font-semibold">Deskripsi :</p>
            <p>{{ $event->deskripsi }}</p>
        </div>

        <!-- LIST TIKET -->
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
                        <!-- EDIT -->
                        <button onclick="openEditModal({{ $tiket->id }}, '{{ $tiket->nama }}', {{ $tiket->harga }}, {{ $tiket->kuota }})" 
                            class="text-yellow-500 hover:scale-110 transition">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <!-- HAPUS -->
                        <form action="{{ route('panitia.tiket.destroy', $tiket->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:scale-110 transition" onclick="return confirm('Hapus tiket ini?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-sm">Belum ada tiket</p>
            @endforelse
        </div>

        <!-- ACTION -->
        <div class="flex justify-between items-center mt-4">
            <button onclick="openModal({{ $event->id }})"
                class="flex items-center gap-2 bg-[#192853] text-yellow-400 px-3 py-2 rounded-lg text-sm hover:bg-[#0f1a35] transition">
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

<!-- MODAL TAMBAH TIKET -->
<div id="modalTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeModal()">
    <div class="bg-white p-6 rounded-xl shadow w-96" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold">Tambah Tiket</h2>
            <button onclick="closeModal()" class="text-red-500 text-xl">&times;</button>
        </div>

        <form id="formTambah" method="POST" action="{{ route('panitia.tiket.store') }}" onsubmit="return checkForm()">
            @csrf
            <input type="hidden" name="event_id" id="eventId">

            <input id="namaTiket" name="nama" type="text" placeholder="Nama Tiket"
                class="w-full border p-2 mb-3 rounded" required>

            <input id="hargaTiket" name="harga" type="number" placeholder="Harga"
                class="w-full border p-2 mb-3 rounded" required>

            <input id="kuotaTiket" name="kuota" type="number" placeholder="Kuota"
                class="w-full border p-2 mb-4 rounded" required>

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

<!-- MODAL EDIT TIKET -->
<div id="modalEditTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeEditModal()">
    <div class="bg-white p-6 rounded-xl shadow w-96" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold">Edit Tiket</h2>
            <button onclick="closeEditModal()" class="text-red-500 text-xl">&times;</button>
        </div>

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <input id="editNama" name="nama" type="text" placeholder="Nama Tiket"
                class="w-full border p-2 mb-3 rounded" required>

            <input id="editHarga" name="harga" type="number" placeholder="Harga"
                class="w-full border p-2 mb-3 rounded" required>

            <input id="editKuota" name="kuota" type="number" placeholder="Kuota"
                class="w-full border p-2 mb-4 rounded" required>

            <div class="flex justify-end gap-2">
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

<script>
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeEditModal();
    }
});

function openModal(eventId) {
    console.log('Opening modal for event:', eventId);
    document.getElementById('eventId').value = eventId;
    document.getElementById('modalTiket').classList.remove('hidden');
}

function checkForm() {
    const eventId = document.getElementById('eventId').value;
    const nama = document.getElementById('namaTiket').value;
    const harga = document.getElementById('hargaTiket').value;
    const cuota = document.getElementById('kuotaTiket').value;
    
    console.log('Form values:', { event_id: eventId, nama, harga, cuota });
    
    if (!eventId) {
        alert('Event ID tidak ada! Klik tombol "+ Tambah Tiket" dari event yang benar.');
        return false;
    }
    return true;
}

function closeModal() {
    document.getElementById('modalTiket').classList.add('hidden');
    document.getElementById('namaTiket').value = "";
    document.getElementById('hargaTiket').value = "";
    document.getElementById('kuotaTiket').value = "";
}

function openEditModal(id, nama, harga, cuota) {
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editKuota').value = cuota;
    document.getElementById('formEdit').action = '/panitia/tiket/' + id;
    document.getElementById('modalEditTiket').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('modalEditTiket').classList.add('hidden');
}
</script>

@endsection
