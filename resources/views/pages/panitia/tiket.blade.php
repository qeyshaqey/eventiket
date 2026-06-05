@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

    <!-- JUDUL HALAMAN -->
    <h1 class="text-xl font-bold mb-6">TIKET YANG DIKELOLA</h1>

    <!-- TOAST NOTIFIKASI BERHASIL -->
    @if(session('success'))
    <div id="toastSuccess" class="fixed top-5 right-5 z-[9999] bg-green-500 text-white px-6 py-4 rounded-xl shadow-2xl flex items-center gap-4 animate-fadeIn transition-all duration-500">
        <div class="bg-white/20 p-2 rounded-full flex items-center justify-center">
            <i class="bi bi-check-lg text-xl"></i>
        </div>
        <div>
            <h4 class="font-bold text-sm">Berhasil!</h4>
            <span class="block text-sm">{{ session('success') }}</span>
        </div>
        <button onclick="document.getElementById('toastSuccess').remove()" class="ml-4 text-white/80 hover:text-white text-2xl leading-none">&times;</button>
    </div>
    <script>
        // Menghilangkan toast secara otomatis dalam 3 detik
        setTimeout(() => {
            const toast = document.getElementById('toastSuccess');
            if(toast) {
                toast.classList.add('opacity-0', '-translate-y-5');
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>
    @endif

    <!-- PERULANGAN EVENT YANG DIKELOLA -->
    @forelse($events as $event)
    <!-- Box Event: Diberi ring biru jika di-highlight dari parameter URL -->
    <div id="event-{{ $event->id }}" class="bg-white rounded-xl shadow p-4 mb-6 {{ isset($highlightEventId) && $highlightEventId == $event->id ? 'ring-4 ring-blue-400' : '' }}">

        <div class="flex gap-4">
            <!-- Poster Event -->
            <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center">
                @if($event->poster)
                    <img src="{{ Storage::url($event->poster) }}" class="w-full h-full object-cover rounded">
                @else
                    <i class="bi bi-image text-2xl text-gray-400"></i>
                @endif
            </div>

            <!-- Detail Event -->
            <div class="flex-1 text-sm space-y-1">
                <p><b>Judul Event :</b> {{ $event->judul }}</p>
                <p><b>Kategori :</b> {{ $event->kategori->nama_kategori ?? '-' }}</p>
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

        <!-- Deskripsi Event -->
        <div class="mt-3 text-sm">
            <p class="font-semibold">Deskripsi :</p>
            <p>{{ $event->deskripsi }}</p>
        </div>

        <!-- Daftar Tiket Yang Terikat dengan Event ini -->
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

                <!-- Tombol Edit dan Hapus Tiket -->
                <div class="flex gap-2">
                    <button onclick="openEditModal({{ $tiket->id }}, '{{ $tiket->nama }}', {{ $tiket->harga }}, {{ $tiket->kuota }})"
                        class="text-yellow-500 hover:scale-110 transition">
                        <i class="bi bi-pencil-square"></i>
                    </button>

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

        <!-- Tombol Tambah Tiket Baru dan Tampilan Status Event -->
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

<!-- ================= MODAL TAMBAH TIKET ================= -->
<div id="modalTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeModal()">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-[400px] relative animate-fadeIn" onclick="event.stopPropagation()">

        <!-- Tombol Close Modal -->
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-400 hover:text-black text-lg">&times;</button>

        <h2 class="text-lg font-bold text-[#192853] mb-3">Tambah Tiket</h2>

        <!-- Form Tambah Tiket -->
        <form method="POST" action="{{ route('panitia.tiket.store') }}">
            @csrf
            <!-- Input Hidden Event ID -->
            <input type="hidden" name="event_id" id="eventId">

            <div class="space-y-3">
                <input name="nama" type="text" placeholder="Nama Tiket" required
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">

                <input name="harga" type="text" placeholder="Harga (misal: 10.000)" required
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">

                <input name="kuota" type="number" placeholder="Kuota" min="1" required
                    class="w-full border rounded-lg p-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
            </div>

            <div class="flex justify-end gap-3 mt-5">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#192853] text-yellow-400 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT TIKET ================= -->
<div id="modalEditTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeEditModal()">
    <div class="bg-white p-6 rounded-2xl shadow-2xl w-[400px] relative animate-fadeIn" onclick="event.stopPropagation()">

        <!-- Tombol Close Modal -->
        <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-400 hover:text-black text-lg">&times;</button>

        <h2 class="text-lg font-bold text-[#192853] mb-3">Edit Tiket</h2>

        <!-- Form Edit Tiket -->
        <form id="formEdit" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-3">
                <input id="editNama" name="nama" type="text" required class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                <input id="editHarga" name="harga" type="text" placeholder="Harga (misal: 10.000)" required class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                <input id="editKuota" name="kuota" type="number" min="1" required class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
            </div>

            <div class="flex justify-end gap-3 mt-5">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 bg-gray-200 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-[#192853] text-yellow-400 rounded-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL KONFIRMASI HAPUS ================= -->
<div id="modalDelete" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="bg-white w-[360px] rounded-2xl shadow-2xl p-6 text-center animate-fadeIn">

        <!-- Icon Tempat Sampah -->
        <div class="flex justify-center mb-4">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">
                <i class="bi bi-trash text-red-500 text-lg"></i>
            </div>
        </div>

        <h2 class="font-bold text-[#192853] text-lg">Hapus Tiket?</h2>
        <p class="text-sm text-gray-500 mt-1">Data tidak bisa dikembalikan</p>

        <!-- Pilihan Aksi Batal / Hapus -->
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="w-full py-2 bg-gray-100 rounded-lg">Batal</button>
            <button onclick="submitDelete()" class="w-full py-2 bg-red-500 text-white rounded-lg">Hapus</button>
        </div>

    </div>
</div>

<!-- Form tersembunyi untuk proses delete tiket -->
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

@endsection


@section('script')
<script>
// Fungsi membuka modal tambah tiket dan menset event_id
function openModal(id){
    document.getElementById('eventId').value = id;
    document.getElementById('modalTiket').classList.remove('hidden');
}
// Fungsi menutup modal tambah tiket
function closeModal(){
    document.getElementById('modalTiket').classList.add('hidden');
}

// Fungsi membuka modal edit tiket dan mempopulasikan datanya
function openEditModal(id,nama,harga,kuota){
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editKuota').value = kuota;
    document.getElementById('formEdit').action = '/panitia/tiket/' + id;
    document.getElementById('modalEditTiket').classList.remove('hidden');
}
// Fungsi menutup modal edit tiket
function closeEditModal(){
    document.getElementById('modalEditTiket').classList.add('hidden');
}

let deleteId = null;
// Fungsi membuka modal hapus tiket
function openDeleteModal(id){
    deleteId = id;
    document.getElementById('modalDelete').classList.remove('hidden');
    document.getElementById('modalDelete').classList.add('flex');
}
// Fungsi menutup modal hapus tiket
function closeDeleteModal(){
    document.getElementById('modalDelete').classList.add('hidden');
    document.getElementById('modalDelete').classList.remove('flex');
}
// Fungsi mensubmit request penghapusan tiket
function submitDelete(){
    const form = document.getElementById('deleteForm');
    form.action = '/panitia/tiket/' + deleteId;
    form.submit();
}

@if ($errors->any())
document.addEventListener("DOMContentLoaded", function () {
    if (typeof showToast === 'function') {
        showToast("{{ $errors->first() }}", "error");
    }
});
@endif
</script>
@endsection