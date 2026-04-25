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

                    <!-- DELETE BUTTON (UPDATED) -->
                    <button onclick="openDeleteModal({{ $tiket->id }})"
                        class="text-red-500 hover:scale-110 transition">
                        <i class="bi bi-trash"></i>
                    </button>
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

<!-- ================= MODAL TAMBAH ================= -->
<div id="modalTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeModal()">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-[400px] relative animate-fadeIn" onclick="event.stopPropagation()">

        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-black text-lg">&times;</button>

        <h2 class="text-lg font-bold text-[#192853] mb-3">Tambah Tiket</h2>

        <form method="POST" action="{{ route('panitia.tiket.store') }}">
            @csrf
            <input type="hidden" name="event_id" id="eventId">

            <div class="space-y-3">
                <input name="nama" type="text" placeholder="Nama Tiket"
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">

                <input name="harga" type="text" placeholder="Harga"
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">

                <input name="kuota" type="number" placeholder="Kuota"
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
            </div>

            <div class="flex justify-end gap-3 mt-5">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#192853] text-yellow-400 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT ================= -->
<div id="modalEditTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeEditModal()">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-[400px] relative animate-fadeIn" onclick="event.stopPropagation()">

        <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-400 hover:text-black text-lg">&times;</button>

        <h2 class="text-lg font-bold text-[#192853] mb-3">Edit Tiket</h2>

        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-3">
                <input id="editNama" name="nama" type="text" class="w-full border p-2 rounded-lg">
                <input id="editHarga" name="harga" type="text" class="w-full border p-2 rounded-lg">
                <input id="editKuota" name="kuota" type="number" class="w-full border p-2 rounded-lg">
            </div>

            <div class="flex justify-end gap-3 mt-5">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#192853] text-yellow-400 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL DELETE ================= -->
<div id="modalDelete" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="bg-white w-[360px] rounded-2xl shadow-2xl p-6 text-center animate-fadeIn">

        <div class="flex justify-center mb-4">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">
                <i class="bi bi-trash text-red-500 text-lg"></i>
            </div>
        </div>

        <h2 class="font-bold text-[#192853] text-lg">Hapus Tiket?</h2>
        <p class="text-sm text-gray-500 mt-1">Data tidak bisa dikembalikan</p>

        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="w-full py-2 bg-gray-100 rounded-lg">Batal</button>
            <button onclick="submitDelete()" class="w-full py-2 bg-red-500 text-white rounded-lg">Hapus</button>
        </div>

    </div>
</div>

<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection


@section('script')
<script>
function openModal(id){
    document.getElementById('eventId').value = id;
    document.getElementById('modalTiket').classList.remove('hidden');
}
function closeModal(){
    document.getElementById('modalTiket').classList.add('hidden');
}

function openEditModal(id,nama,harga,kuota){
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editKuota').value = kuota;
    document.getElementById('formEdit').action = '/panitia/tiket/' + id;
    document.getElementById('modalEditTiket').classList.remove('hidden');
}
function closeEditModal(){
    document.getElementById('modalEditTiket').classList.add('hidden');
}

let deleteId = null;
function openDeleteModal(id){
    deleteId = id;
    document.getElementById('modalDelete').classList.remove('hidden');
    document.getElementById('modalDelete').classList.add('flex');
}
function closeDeleteModal(){
    document.getElementById('modalDelete').classList.add('hidden');
    document.getElementById('modalDelete').classList.remove('flex');
}
function submitDelete(){
    const form = document.getElementById('deleteForm');
    form.action = '/panitia/tiket/' + deleteId;
    form.submit();
}
</script>
@endsection