@extends('layouts.panitialayouts.panitia-main')

@section('content')

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
    setTimeout(() => {
        const toast = document.getElementById('toastSuccess');
        if(toast) {
            toast.classList.add('opacity-0', '-translate-y-5');
            setTimeout(() => toast.remove(), 500);
        }
    }, 3000);
</script>
@endif

<div class="bg-white rounded shadow p-4">
    <!-- HEADER -->
<div class="mb-4">

    <!-- BARIS ATAS -->
    <div class="flex justify-between items-center mb-3">
        <h1 class="text-xl font-bold mb-6">EVENT YANG DIKELOLA</h1>
    </div>

    <!-- BARIS BAWAH -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">

    <!-- KIRI: SEARCH + FILTER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">

    <!-- KIRI: BUTTON -->
    <button 
        data-modal-target="eventModal"
        data-modal-toggle="eventModal"
        onclick="openModal('tambah')"
        class="bg-[#192853] text-yellow-400 px-4 py-2 rounded-lg text-sm font-semibold shadow w-fit">
        + Tambah Event
    </button>

    <!-- KANAN: SEARCH + FILTER -->
    <div class="flex gap-2 w-full md:w-auto">

        <!-- SEARCH -->
        <input 
            type="text" 
            id="searchEvent"
            placeholder="Cari event..."
            class="border rounded-lg px-3 py-2 text-sm w-full md:w-64 focus:ring-2 focus:ring-[#192853]">

        <!-- FILTER -->
        <select id="filterKategori"
            class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853]">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->nama_kategori }}">{{ $cat->nama_kategori }}</option>
            @endforeach
        </select>

    </div>

</div>
</div>

    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">

<table class="min-w-full text-sm text-left bg-white">

    <!-- HEADER -->
    <thead class="bg-[#192853] text-white text-xs uppercase tracking-wider">
        <tr>
            <th class="px-4 py-3">NO</th>
            <th class="px-4 py-3">JUDUL EVENT</th>
            <th class="px-4 py-3">KATEGORI</th>
            <th class="px-4 py-3">DESKRIPSI</th>
            <th class="px-4 py-3">TANGGAL</th>
            <th class="px-4 py-3">WAKTU</th>
            <th class="px-4 py-3">LOKASI</th>
            <th class="px-4 py-3">STATUS</th>
            <th class="px-4 py-3">AKSI</th>
        </tr>
    </thead>

    <!-- BODY -->
    <tbody class="divide-y divide-gray-200">

        @forelse($events as $index => $event)
        @php
            $tikets = collect($event->tikets ?? []);
            $isPublished = $tikets->count() > 0;
        @endphp

        <tr class="hover:bg-gray-50 transition">

            <td class="px-4 py-3 font-semibold text-gray-700">
                {{ $index + 1 }}
            </td>

            <td class="px-4 py-3 font-semibold text-gray-900">
                {{ $event->judul }}
            </td>

            <td class="px-4 py-3">
                <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-600 text-xs">
                    {{ $event->kategori->nama_kategori ?? '-' }}
                </span>
            </td>

            <td class="px-4 py-3 text-gray-600">
                {{ \Illuminate\Support\Str::limit($event->deskripsi, 40) }}
            </td>

            <td class="px-4 py-3 text-gray-600">
                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                {{ $event->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') : '' }}
            </td>

            <td class="px-4 py-3 text-gray-600">
                {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                {{ $event->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : '' }}
            </td>

            <td class="px-4 py-3 text-gray-600">
                {{ $event->lokasi }}
            </td>

            <!-- STATUS -->
            <td class="px-4 py-3">
                @if($isPublished)
                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-600 font-semibold">
                        Published
                    </span>
                @else
                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                        Draft
                    </span>
                @endif
            </td>

            <!-- AKSI -->
            <td class="px-4 py-3">
                <div class="flex items-center justify-center gap-3">

                    @if(($event->status ?? '') === 'Draft')
                    <button 
                        onclick="window.location.href='{{ route('panitia.tiket') }}?event_id={{ $event->id }}'"
                        class="text-green-500 hover:text-green-700 transition"
                        title="Tambah Tiket">
                        <i class="bi bi-ticket-perforated"></i>
                    </button>
                    @endif

                    <button 
    data-modal-target="eventModal"
    data-modal-toggle="eventModal"
    onclick="openModal('edit', {{ $event->id }})"
                        class="text-yellow-500 hover:text-yellow-600 transition">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <button 
                        data-modal-target="modalDetail"
data-modal-toggle="modalDetail"
onclick="{{ $isPublished ? 'openDetailModal(' . $event->id . ')' : '' }}"
                        class="text-blue-500 {{ !$isPublished ? 'opacity-30 cursor-not-allowed' : 'hover:text-blue-700' }}"
                        title="{{ $isPublished ? 'Kirim ke Admin' : 'Tambah tiket dulu' }}">
                        <i class="bi bi-upload"></i>
                    </button>

                    <button 
    data-modal-target="deleteModal"
    data-modal-toggle="deleteModal"
    onclick="openDeleteModal({{ $event->id }})" 
                        class="text-red-500 hover:text-red-600 transition">
                        <i class="bi bi-trash"></i>
                    </button>

                </div>
            </td>

        </tr>

        @empty
        <tr>
            <td colspan="9" class="px-4 py-6 text-center text-gray-400">
                Belum ada event
            </td>
        </tr>
        @endforelse

    </tbody>
</table>

</div>

</div>
<!-- MODAL TAMBAH / EDIT EVENT -->
<div id="eventModal" tabindex="-1" class="fixed inset-0 hidden z-50">
    
    <!-- BACKDROP -->
    <div class="absolute inset-0 bg-black/50" data-modal-hide="eventModal"></div>

    <!-- MODAL BOX -->
    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-lg bg-white/95 rounded-2xl shadow-2xl border border-gray-200 overflow-hidden animate-[fadeIn_0.2s_ease]">

            <!-- HEADER -->
            <div class="flex justify-between items-center px-6 py-4 border-b bg-[#192853] text-white">
                <h2 id="modalTitle" class="font-semibold text-lg">Tambah Event</h2>
                <button data-modal-hide="eventModal"class="text-white/80 hover:text-white text-2xl">&times;</button>
            </div>

            <!-- FORM -->
            <form id="eventForm" method="POST" action="{{ route('panitia.event.store') }}" enctype="multipart/form-data"
                class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">

                @csrf
                <input type="hidden" id="methodOverride" name="_method" value="POST">

                <!-- INPUT STYLE UNIFORM -->
                <div>
                    <label class="text-sm font-semibold">Judul Event</label>
                    <input type="text" name="judul" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold">Kategori</label>
                    <select name="kategori_id" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-semibold">Deskripsi</label>
                    <textarea name="deskripsi" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-semibold">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" required
                            class="w-full mt-1 border @error('tanggal_mulai') border-red-500 @else border-gray-200 @enderror rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                        @error('tanggal_mulai')
                            <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" required
                            class="w-full mt-1 border @error('tanggal_selesai') border-red-500 @else border-gray-200 @enderror rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                        @error('tanggal_selesai')
                            <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-semibold">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai" required
                            class="w-full mt-1 border @error('waktu_mulai') border-red-500 @else border-gray-200 @enderror rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                        @error('waktu_mulai')
                            <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Waktu Selesai</label>
                        <input type="time" id="waktu_selesai" name="waktu_selesai" required
                            class="w-full mt-1 border @error('waktu_selesai') border-red-500 @else border-gray-200 @enderror rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                        @error('waktu_selesai')
                            <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="text-sm font-semibold">Lokasi</label>
                    <input type="text" name="lokasi" required
                        class="w-full mt-1 border rounded-xl p-2.5 text-sm">
                </div>

                <div>
    <label class="text-sm font-semibold">Poster Event</label>
    <input type="file" name="poster" id="posterInput"
        class="w-full mt-1 border rounded-xl p-2.5 text-sm focus:ring-2 focus:ring-[#192853]">
        <p class="text-xs text-gray-400 mt-1">
    Format: JPG/PNG, max 2MB
</p>
</div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" data-modal-hide="eventModal"
                        class="px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-sm">
                        Batal
                    </button>

                    <button type="submit"
                        class="px-4 py-2 rounded-xl bg-[#192853] text-yellow-400 hover:opacity-90 text-sm">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- MODAL DETAIL -->
<div id="modalDetail" tabindex="-1" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-hide="modalDetail"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div class="px-6 py-4 bg-[#192853] text-white flex justify-between items-center">
                <h2 class="font-semibold">Detail Event</h2>
                <button data-modal-hide="modalDetail" class="text-white text-2xl">&times;</button>
            </div>

            <div class="p-6 space-y-4 max-h-[75vh] overflow-y-auto">

                <div class="flex gap-4">
                    <img id="detailPoster" class="w-44 h-44 object-cover rounded-xl shadow">

                    <div class="text-sm space-y-1">
                        <p><b>Judul:</b> <span id="detailJudul"></span></p>
                        <p><b>Kategori:</b> <span id="detailKategori"></span></p>
                        <p><b>Lokasi:</b> <span id="detailLokasi"></span></p>
                        <p><b>Tanggal:</b> <span id="detailTanggal"></span></p>
                        <p><b>Waktu:</b> <span id="detailWaktu"></span></p>
                    </div>
                </div>

                <div>
                    <b>Deskripsi</b>
                    <p id="detailDeskripsi" class="text-sm text-gray-600 mt-1"></p>
                </div>

                <div>
                    <b>Tiket</b>
                    <div id="detailTiket" class="mt-2"></div>
                </div>
                    <button onclick="kirimKeAdmin()" class="px-6 py-2 bg-[#192853] text-yellow-400 rounded-xl text-sm font-bold shadow hover:opacity-90 transition">
                        Kirim
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL DELETE -->
<div id="deleteModal" tabindex="-1" class="fixed inset-0 hidden z-50">
    <div class="absolute inset-0 bg-black/50" data-modal-hide="deleteModal"></div>

    <div class="relative flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-6 w-80 text-center">

            <h2 class="font-bold text-lg mb-2">Hapus Event?</h2>
            <p class="text-sm text-gray-500 mb-5">Data tidak bisa dikembalikan</p>

            <div class="flex justify-center gap-2">
                <button data-modal-hide="deleteModal" class="px-4 py-2 bg-gray-200 rounded-xl text-sm">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-500 text-white rounded-xl text-sm">
                    Hapus
                </button>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    window.events = @json($events ?? []);

    // ==========================================
    // DEKLARASI ELEMEN & LISTENERS VALIDASI FORM
    // ==========================================
    const tglMulaiInput = document.getElementById('tanggal_mulai');
    const tglSelesaiInput = document.getElementById('tanggal_selesai');
    const waktuMulaiInput = document.getElementById('waktu_mulai');
    const waktuSelesaiInput = document.getElementById('waktu_selesai');

    // Fungsi untuk memperbarui batas waktu minimum (Waktu Mulai & Waktu Selesai) secara dinamis
    function updateTimeLimits() {
        const todayStr = new Date().toISOString().split('T')[0];
        
        // Dapatkan waktu saat ini dalam format HH:MM
        const now = new Date();
        const hrs = String(now.getHours()).padStart(2, '0');
        const mins = String(now.getMinutes()).padStart(2, '0');
        const currentTimeStr = `${hrs}:${mins}`;

        // VALIDASI 1: Jika tanggal mulai adalah HARI INI, waktu mulai tidak boleh di masa lalu
        if (tglMulaiInput && tglMulaiInput.value === todayStr) {
            if (waktuMulaiInput) {
                waktuMulaiInput.min = currentTimeStr;
                // Jika waktu yang dipilih sebelumnya lebih kecil dari waktu sekarang, reset ke waktu sekarang
                if (waktuMulaiInput.value && waktuMulaiInput.value < currentTimeStr) {
                    waktuMulaiInput.value = currentTimeStr;
                }
            }
        } else if (waktuMulaiInput) {
            // Hapus batas minimum jika tanggal mulai bukan hari ini
            waktuMulaiInput.removeAttribute('min');
        }

        // VALIDASI 2: Jika tanggal mulai dan tanggal selesai sama, waktu selesai harus setelah waktu mulai
        if (tglMulaiInput && tglSelesaiInput && waktuMulaiInput && waktuSelesaiInput) {
            if (tglMulaiInput.value === tglSelesaiInput.value) {
                waktuSelesaiInput.min = waktuMulaiInput.value;
                // Jika waktu selesai yang dipilih mendahului waktu mulai, sesuaikan otomatis
                if (waktuSelesaiInput.value && waktuSelesaiInput.value < waktuMulaiInput.value) {
                    waktuSelesaiInput.value = waktuMulaiInput.value;
                }
            } else {
                // Hapus batas minimum waktu selesai jika tanggalnya berbeda
                waktuSelesaiInput.removeAttribute('min');
            }
        }
    }

    // Pasang Event Listeners untuk mendeteksi perubahan tanggal dan waktu
    if (tglMulaiInput && tglSelesaiInput) {
        // Ketika tanggal mulai diubah
        tglMulaiInput.addEventListener('change', function () {
            // Tanggal selesai minimal harus sama dengan tanggal mulai
            tglSelesaiInput.min = this.value;
            if (tglSelesaiInput.value && tglSelesaiInput.value < this.value) {
                tglSelesaiInput.value = this.value;
            }
            updateTimeLimits();
        });

        // Ketika tanggal selesai diubah
        tglSelesaiInput.addEventListener('change', updateTimeLimits);
    }

    // Ketika waktu mulai diubah
    if (waktuMulaiInput) {
        waktuMulaiInput.addEventListener('change', updateTimeLimits);
    }

    // ==========================================
    // FUNGSI MEMBUKA MODAL (TAMBAH / EDIT EVENT)
    // ==========================================
    function openModal(mode, eventId = null) {
        const form = document.getElementById('eventForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('methodOverride');

        if (!form) return;

        // Reset semua field form ke kosong
        form.reset();

        const todayStr = new Date().toISOString().split('T')[0];

        // MODE TAMBAH
        if (mode === 'tambah') {
            title.innerText = 'Tambah Event';
            form.action = '{{ route("panitia.event.store") }}';
            methodInput.value = 'POST';
            document.getElementById('posterInput').required = true;

            // Batasi tanggal mulai dan selesai minimal hari ini
            if (tglMulaiInput) tglMulaiInput.min = todayStr;
            if (tglSelesaiInput) tglSelesaiInput.min = todayStr;
            
            // Perbarui batas waktu input
            updateTimeLimits();
        }

        // MODE EDIT
        if (mode === 'edit') {
            title.innerText = 'Edit Event';
            methodInput.value = 'PUT';
            form.action = `/panitia/event/${eventId}`;
            document.getElementById('posterInput').required = false;

            // Cari event berdasarkan ID dari array data events yang dikirim controller
            const event = window.events.find(e => e.id == eventId);
            if (!event) return;

            // Isi nilai form dengan data event yang dipilih
            form.judul.value = event.judul ?? '';
            form.kategori_id.value = event.kategori_id ?? '';
            form.deskripsi.value = event.deskripsi ?? '';
            form.tanggal_mulai.value = event.tanggal_mulai ?? '';
            form.tanggal_selesai.value = event.tanggal_selesai ?? '';
            form.waktu_mulai.value = event.waktu_mulai ?? '';
            form.waktu_selesai.value = event.waktu_selesai ?? '';
            form.lokasi.value = event.lokasi ?? '';

            // Agar tidak error ketika mengedit event lama di masa lalu,
            // set min date ke tanggal event tersebut (mana yang lebih lama)
            const eventDate = event.tanggal_mulai ?? todayStr;
            const minDate = eventDate < todayStr ? eventDate : todayStr;
            if (tglMulaiInput) tglMulaiInput.min = minDate;
            if (tglSelesaiInput) tglSelesaiInput.min = minDate;

            // Perbarui batas waktu input
            updateTimeLimits();
        }
    }

    // =========================
    // DELETE
    // =========================
    let deleteId = null;

    function openDeleteModal(id) {
        deleteId = id;
    }

    function confirmDelete() {
        if (!deleteId) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/panitia/event/${deleteId}`;

        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="_method" value="DELETE">
        `;

        document.body.appendChild(form);
        form.submit();
    }

    // =========================
    // DETAIL
    // =========================
    let selectedEventId = null;

    function openDetailModal(id) {
        selectedEventId = id;

        const event = window.events.find(e => e.id == id);
        if (!event) return;

        document.getElementById('detailPoster').src =
            event.poster ? '/storage/' + event.poster :
            'https://via.placeholder.com/400x200?text=No+Image';

        document.getElementById('detailJudul').innerText = event.judul;
        document.getElementById('detailKategori').innerText = event.kategori ? event.kategori.nama_kategori : '-';
        document.getElementById('detailLokasi').innerText = event.lokasi;

        document.getElementById('detailTanggal').innerText =
            (event.tanggal_mulai ?? '-') +
            (event.tanggal_selesai ? ' - ' + event.tanggal_selesai : '');

        document.getElementById('detailWaktu').innerText =
            (event.waktu_mulai ?? '-') +
            (event.waktu_selesai ? ' - ' + event.waktu_selesai : '');

        document.getElementById('detailDeskripsi').innerText = event.deskripsi;

        let tiketHTML = '';

        if (event.tikets && event.tikets.length > 0) {
            event.tikets.forEach(t => {
                tiketHTML += `
                    <div class="border rounded p-2 mb-2 text-sm">
                        <b>${t.nama}</b><br>
                        Rp ${Number(t.harga).toLocaleString()} • Kuota: ${t.kuota}
                    </div>
                `;
            });
        } else {
            tiketHTML = `<p class="text-gray-400 text-sm">Belum ada tiket</p>`;
        }

        document.getElementById('detailTiket').innerHTML = tiketHTML;
    }

    function kirimKeAdmin() {
        if (!selectedEventId) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/panitia/event/${selectedEventId}/kirim`;

        form.innerHTML = `
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        `;

        document.body.appendChild(form);
        form.submit();
    }

    // =========================
    // SEARCH & FILTER TABLE
    // =========================
    const searchInput = document.getElementById('searchEvent');
    const filterSelect = document.getElementById('filterKategori');
    const tableRows = document.querySelectorAll('tbody tr');

    function filterTable() {
        const searchText = searchInput ? searchInput.value.toLowerCase() : '';
        const filterVal = filterSelect ? filterSelect.value : '';

        tableRows.forEach(row => {
            // Skip "Belum ada event" row
            if (row.cells.length < 3) return;

            const judul = row.cells[1].textContent.toLowerCase();
            const kategori = row.cells[2].textContent.trim();

            const matchSearch = judul.includes(searchText);
            const matchKategori = filterVal === '' || kategori === filterVal;

            if (matchSearch && matchKategori) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) searchInput.addEventListener('input', filterTable);
    if (filterSelect) filterSelect.addEventListener('change', filterTable);

    // GLOBAL EXPORT (WAJIB)
    window.openModal = openModal;
    window.openDeleteModal = openDeleteModal;
    window.confirmDelete = confirmDelete;
    window.openDetailModal = openDetailModal;
    window.kirimKeAdmin = kirimKeAdmin;
});
</script>
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof showToast === 'function') {
            showToast("{{ $errors->first() }}", "error");
        }
        const modalEl = document.getElementById('eventModal');
        if (modalEl) {
            modalEl.classList.remove('hidden');
            if (typeof Modal !== 'undefined') {
                const flowbiteModal = new Modal(modalEl);
                flowbiteModal.show();
            }
        }
    });
</script>
@endif
@endsection