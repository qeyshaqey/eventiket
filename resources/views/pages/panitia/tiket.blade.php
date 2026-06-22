@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

    <!-- JUDUL HALAMAN -->
    

    <!-- SEARCH & FILTER -->
    <div class="bg-white rounded-xl shadow p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <h1 class="text-xl font-bold text-[#192853]">TIKET YANG DIKELOLA</h1>
            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                <!-- SEARCH -->
                <input 
                    type="text" 
                    id="searchTiket"
                    placeholder="Cari event atau tiket..."
                    class="border rounded-lg px-3 py-2 text-sm w-full md:w-64 focus:ring-2 focus:ring-[#192853] outline-none">

                <!-- FILTER KATEGORI -->
                <select id="filterKategori"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>

                <!-- FILTER EVENT -->
                <select id="filterEvent"
                    class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                    <option value="">Semua Event</option>
                    @foreach($events as $e)
                        <option value="{{ $e->id }}" {{ isset($highlightEventId) && $highlightEventId == $e->id ? 'selected' : '' }}>{{ $e->judul }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

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
    <div id="event-{{ $event->id }}" data-title="{{ strtolower($event->judul . ' ' . $event->tikets->pluck('nama')->implode(' ')) }}" data-category="{{ strtolower($event->kategori->nama_kategori ?? '') }}" class="bg-white rounded-xl shadow p-4 mb-6 {{ isset($highlightEventId) && $highlightEventId == $event->id ? 'ring-4 ring-blue-400' : '' }}">

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
                <p><b>Tanggal :</b>
                    {{ $event->tanggal_mulai ? \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') : '-' }}
                    @if($event->tanggal_selesai)
                        - {{ \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') }}
                    @endif
                </p>
                <p><b>Waktu :</b>
                    {{ $event->waktu_mulai ? \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') : '-' }}
                    @if($event->waktu_selesai)
                        - {{ \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') }}
                    @endif
                </p>
                <p><b>Lokasi :</b> {{ $event->lokasi }}</p>
            </div>
        </div>

        <!-- Deskripsi Event -->
        <div class="mt-3 text-sm">
            <p class="font-semibold">Deskripsi :</p>
            <p class="leading-relaxed break-words bg-gray-50 p-3 rounded-lg max-h-48 overflow-y-auto mt-1">{{ $event->deskripsi }}</p>
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
                    @if(!empty($tiket->keterangan))
                        <p class="text-gray-400 text-xs mt-1">{{ $tiket->keterangan }}</p>
                    @endif
                </div>

                <!-- Tombol Edit dan Hapus Tiket -->
                <div class="flex gap-2">
                            <button onclick="openEditModal({{ $tiket->id }}, '{{ $tiket->nama }}', {{ $tiket->harga }}, {{ $tiket->kuota }}, this.dataset.keterangan)"
                        data-keterangan="{{ e($tiket->keterangan) }}"
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
    <div class="w-full max-w-lg bg-white/95 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-[fadeIn_0.2s_ease]" onclick="event.stopPropagation()">

        <!-- HEADER -->
        <div class="flex justify-between items-center px-6 py-4 border-b bg-[#192853] text-white">
            <h2 class="font-semibold text-lg">Tambah Tiket</h2>
            <button onclick="closeModal()" class="text-white/80 hover:text-white text-2xl">&times;</button>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('panitia.tiket.store') }}" class="p-6 space-y-4">
            @csrf
            <!-- Input Hidden Event ID -->
            <input type="hidden" name="event_id" id="eventId">

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold">Nama Tiket</label>
                    <input name="nama" type="text" placeholder="Nama Tiket" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Harga</label>
                    <input name="harga" type="text" placeholder="Harga (misal: 10.000)" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Kuota</label>
                    <input name="kuota" type="number" placeholder="Kuota" min="1" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Keterangan Tiket</label>
                    <textarea name="keterangan" rows="3" placeholder="Keterangan tiket" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#192853] text-yellow-400 hover:opacity-90 text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT TIKET ================= -->
<div id="modalEditTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50" onclick="closeEditModal()">
    <div class="w-full max-w-lg bg-white/95 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-[fadeIn_0.2s_ease]" onclick="event.stopPropagation()">

        <!-- HEADER -->
        <div class="flex justify-between items-center px-6 py-4 border-b bg-[#192853] text-white">
            <h2 class="font-semibold text-lg">Edit Tiket</h2>
            <button onclick="closeEditModal()" class="text-white/80 hover:text-white text-2xl">&times;</button>
        </div>

        <!-- FORM -->
        <form id="formEdit" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label class="text-sm font-semibold">Nama Tiket</label>
                    <input id="editNama" name="nama" type="text" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Harga</label>
                    <input id="editHarga" name="harga" type="text" placeholder="Harga (misal: 10.000)" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Kuota</label>
                    <input id="editKuota" name="kuota" type="number" min="1" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Keterangan Tiket</label>
                    <textarea id="editKeterangan" name="keterangan" rows="3" placeholder="Keterangan tiket" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none"></textarea>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-[#192853] text-yellow-400 hover:opacity-90 text-sm">
                    Simpan
                </button>
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
function openEditModal(id,nama,harga,kuota,keterangan){
    document.getElementById('editNama').value = nama;
    document.getElementById('editHarga').value = harga;
    document.getElementById('editKuota').value = kuota;
    document.getElementById('editKeterangan').value = keterangan;
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

function filterTicketCards() {
    const searchValue = document.getElementById('searchTiket')?.value.toLowerCase().trim() || '';
    const categoryValue = document.getElementById('filterKategori')?.value.toLowerCase() || '';
    const eventValue = document.getElementById('filterEvent')?.value || '';
    const cards = document.querySelectorAll('[id^="event-"]');

    cards.forEach(card => {
        const title = card.dataset.title || '';
        const category = card.dataset.category || '';
        const cardId = card.id.replace('event-', '');

        const matchesSearch = searchValue === '' || title.includes(searchValue);
        const matchesCategory = categoryValue === '' || category === categoryValue;
        const matchesEvent = eventValue === '' || cardId === eventValue;

        card.style.display = matchesSearch && matchesCategory && matchesEvent ? '' : 'none';
    });
}

const searchInput = document.getElementById('searchTiket');
const filterSelect = document.getElementById('filterKategori');
const filterEventSelect = document.getElementById('filterEvent');
if (searchInput) searchInput.addEventListener('input', filterTicketCards);
if (filterSelect) filterSelect.addEventListener('change', filterTicketCards);
if (filterEventSelect) filterEventSelect.addEventListener('change', filterTicketCards);

// Jalankan filter saat pertama kali halaman dimuat
filterTicketCards();

@if ($errors->any())
document.addEventListener("DOMContentLoaded", function () {
    if (typeof showToast === 'function') {
        showToast("{{ $errors->first() }}", "error");
    }
});
@endif
</script>
@endsection