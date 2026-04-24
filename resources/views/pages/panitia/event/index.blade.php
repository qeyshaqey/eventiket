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
            <th class="px-4 py-3 text-center">AKSI</th>
        </tr>
    </thead>

    <!-- BODY -->
    <tbody class="divide-y divide-gray-100">

        @forelse($events as $index => $event)
        @php
            $tikets = collect($event->tikets ?? []);
            $isPublished = $tikets->count() > 0;
        @endphp

        <tr class="hover:bg-gray-50 transition">

            <td class="px-4 py-3 font-medium text-gray-700">
                {{ $index + 1 }}
            </td>

            <td class="px-4 py-3 font-semibold text-gray-900">
                {{ $event->judul }}
            </td>

            <td class="px-4 py-3">
                <span class="px-2 py-1 rounded-full bg-blue-50 text-blue-600 text-xs">
                    {{ $event->kategori }}
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

                    <button onclick="openModal('edit', {{ $event->id }})" 
                        class="text-yellow-500 hover:text-yellow-600 transition">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <button 
                        onclick="{{ $isPublished ? "openDetailModal($event->id)" : '' }}"
                        class="text-blue-500 {{ !$isPublished ? 'opacity-30 cursor-not-allowed' : 'hover:text-blue-700' }}"
                        title="{{ $isPublished ? 'Kirim ke Admin' : 'Tambah tiket dulu' }}">
                        <i class="bi bi-upload"></i>
                    </button>

                    <button onclick="openDeleteModal({{ $event->id }})" 
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
<div id="eventModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-xl shadow w-[420px]" onclick="event.stopPropagation()">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-4">
            <h2 id="modalTitle" class="font-bold text-lg">Tambah Event</h2>
            <button onclick="closeModal()" class="text-red-500 text-xl">&times;</button>
        </div>

        <!-- FORM -->
        <form id="eventForm" method="POST" action="{{ route('panitia.event.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="methodOverride" name="_method" value="POST">

            <!-- Judul -->

<div>
    <label class="text-sm text-black-600 mb-1 block">Judul Event</label>
    <input type="text" name="judul"
        placeholder="Judul Event"
        value="{{ old('judul') }}"
        class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm @error('judul') border-red-500 @enderror">

    @error('judul')
        <small class="text-red-500 text-xs">{{ $message }}</small>
    @enderror
</div>

<!-- Kategori -->
<div>
    <label class="text-sm text-black-600 mb-1 block">Kategori</label>
    <select name="kategori"
        class="w-full border rounded-lg p-2 text-sm @error('kategori') border-red-500 @enderror">
        
        <option value="">Pilih Kategori</option>
        <option value="Seminar" {{ old('kategori') == 'Seminar' ? 'selected' : '' }}>Seminar</option>
        <option value="Workshop" {{ old('kategori') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
    </select>

    @error('kategori')
        <small class="text-red-500 text-xs">{{ $message }}</small>
    @enderror
</div>

<!-- Deskripsi -->
<div>
    <label class="text-sm text-black-600 mb-1 block">Deskripsi</label>
    <textarea name="deskripsi"
        placeholder="Deskripsi"
        class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>

    @error('deskripsi')
        <small class="text-red-500 text-xs">{{ $message }}</small>
    @enderror
</div>

<!-- Tanggal -->
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="text-sm text-black-600 mb-1 block">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai"
            value="{{ old('tanggal_mulai') }}"
            class="w-full border rounded-lg p-2 text-sm @error('tanggal_mulai') border-red-500 @enderror">

        @error('tanggal_mulai')
            <small class="text-red-500 text-xs">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label class="text-sm text-black-600 mb-1 block">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai"
            value="{{ old('tanggal_selesai') }}"
            class="w-full border rounded-lg p-2 text-sm @error('tanggal_selesai') border-red-500 @enderror">

        @error('tanggal_selesai')
            <small class="text-red-500 text-xs">{{ $message }}</small>
        @enderror
    </div>
</div>

<!-- Waktu -->
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="text-sm text-black-600 mb-1 block">Waktu Mulai</label>
        <input type="time" name="waktu_mulai"
            value="{{ old('waktu_mulai') }}"
            class="w-full border rounded-lg p-2 text-sm @error('waktu_mulai') border-red-500 @enderror">

        @error('waktu_mulai')
            <small class="text-red-500 text-xs">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label class="text-sm text-black-600 mb-1 block">Waktu Selesai</label>
        <input type="time" name="waktu_selesai"
            value="{{ old('waktu_selesai') }}"
            class="w-full border rounded-lg p-2 text-sm @error('waktu_selesai') border-red-500 @enderror">

        @error('waktu_selesai')
            <small class="text-red-500 text-xs">{{ $message }}</small>
        @enderror
    </div>
</div>

<!-- Lokasi -->
<div>
    <label class="text-sm text-black-600 mb-1 block">Lokasi</label>
    <input type="text" name="lokasi"
        placeholder="Lokasi"
        value="{{ old('lokasi') }}"
        class="w-full border rounded-lg p-2 placeholder-gray-400 text-sm @error('lokasi') border-red-500 @enderror">

    @error('lokasi')
        <small class="text-red-500 text-xs">{{ $message }}</small>
    @enderror
</div>
            <!-- Poster -->
            <input type="file" name="poster"
                class="w-full border p-2 mb-3 rounded">

            <!-- BUTTON -->
            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeModal()" 
                    class="bg-gray-300 px-3 py-1 rounded">
                    Batal
                </button>

                <button type="submit" 
                    class="bg-[#192853] text-yellow-400 px-3 py-1 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DETAIL -->
<div id="modalDetail" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-6 rounded-xl w-[600px] max-h-[90vh] overflow-y-auto">

        <h2 class="text-lg font-bold mb-3">Detail Event</h2>
        <hr class="mb-4">

        <!-- ATAS: POSTER + INFO -->
        <div class="flex gap-4 mb-4">

            <!-- POSTER -->
            <img id="detailPoster" class="w-40 h-40 object-cover rounded">

            <!-- INFO -->
            <div class="flex-1 text-sm space-y-1">
                <p><b>Judul:</b> <span id="detailJudul"></span></p>
                <p><b>Kategori:</b> <span id="detailKategori"></span></p>
                <p><b>Lokasi:</b> <span id="detailLokasi"></span></p>
                <p><b>Tanggal:</b> <span id="detailTanggal"></span></p>
                <p><b>Waktu:</b> <span id="detailWaktu"></span></p>
            </div>

        </div>

        <!-- DESKRIPSI -->
        <div class="mb-4">
            <b>Deskripsi:</b>
            <p id="detailDeskripsi" class="text-sm mt-1"></p>
        </div>

        <!-- TIKET -->
        <div class="mb-4">
            <b>Daftar Tiket:</b>
            <div id="detailTiket" class="mt-2"></div>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeDetailModal()" class="bg-gray-300 px-3 py-1 rounded">
                Batal
            </button>
            <button onclick="kirimKeAdmin()" class="bg-blue-500 text-white px-3 py-1 rounded">
                Kirim
            </button>
        </div>

    </div>
</div>

<!-- MODAL DELETE -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">
    <div class="bg-white p-6 rounded text-center w-80">
        <h2 class="font-bold mb-2">Hapus Event?</h2>
        <p class="text-sm text-gray-500 mb-4">Tidak bisa dikembalikan</p>

        <button onclick="closeDeleteModal()" class="bg-gray-300 px-3 py-1 rounded">Batal</button>
        <button onclick="confirmDelete()" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ambil data event dari blade
    window.events = @json($events ?? []);

    // =========================
    // MODAL TAMBAH / EDIT EVENT
    // =========================
    function openModal(mode, eventId = null) {
        const modal = document.getElementById('eventModal');
        const form = document.getElementById('eventForm');
        const title = document.getElementById('modalTitle');
        const methodInput = document.getElementById('methodOverride');

        // cegah error null
        if (!modal || !form) return;

        modal.classList.remove('hidden');
        form.reset();

        if (mode === 'tambah') {
    if (title) title.innerText = 'Tambah Event';
    form.action = '{{ route("panitia.event.store") }}';
    if (methodInput) methodInput.value = 'POST';

    form.reset();

    form.judul.value = '';
    form.kategori.value = '';
    form.deskripsi.value = '';
    form.tanggal_mulai.value = '';
    form.tanggal_selesai.value = '';
    form.waktu_mulai.value = '';
    form.waktu_selesai.value = '';
    form.lokasi.value = '';

    // hapus error visual
    form.querySelectorAll('.border-red-500').forEach(el => {
        el.classList.remove('border-red-500');
    });

    form.querySelectorAll('small.text-red-500').forEach(el => {
        el.remove();
    });
}

        if (mode === 'edit') {
            if (title) title.innerText = 'Edit Event';
            if (methodInput) methodInput.value = 'PUT';
            form.action = `/panitia/event/${eventId}`;

            const event = window.events.find(e => e.id == eventId);
            if (!event) return;

            form.judul.value = event.judul ?? '';
            form.kategori.value = event.kategori ?? '';
            form.deskripsi.value = event.deskripsi ?? '';
            form.tanggal_mulai.value = event.tanggal_mulai ?? '';
            form.tanggal_selesai.value = event.tanggal_selesai ?? '';
            form.waktu_mulai.value = event.waktu_mulai ?? '';
            form.waktu_selesai.value = event.waktu_selesai ?? '';
            form.lokasi.value = event.lokasi ?? '';
        }
    }

    function closeModal() {
        document.getElementById('eventModal')?.classList.add('hidden');
    }

    // =========================
    // MODAL DELETE
    // =========================
    let deleteId = null;

    function openDeleteModal(id) {
        deleteId = id;
        document.getElementById('deleteModal')?.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal')?.classList.add('hidden');
    }

    function confirmDelete() {
        if (!deleteId) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/panitia/event/${deleteId}`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'DELETE';

        form.appendChild(csrf);
        form.appendChild(method);

        document.body.appendChild(form);
        form.submit();
    }

    // =========================
    // MODAL DETAIL (UPLOAD ADMIN)
    // =========================
    let selectedEventId = null;

    function openDetailModal(id) {
    selectedEventId = id;

    const event = window.events.find(e => e.id == id);
    if (!event) return;

    // POSTER
    document.getElementById('detailPoster').src = event.poster 
        ? '/storage/' + event.poster 
        : 'https://via.placeholder.com/400x200?text=No+Image';

    // TEXT
    document.getElementById('detailJudul').innerText = event.judul;
    document.getElementById('detailKategori').innerText = event.kategori;
    document.getElementById('detailLokasi').innerText = event.lokasi;

    document.getElementById('detailTanggal').innerText =
        (event.tanggal_mulai ?? '-') + 
        (event.tanggal_selesai ? ' - ' + event.tanggal_selesai : '');

    document.getElementById('detailWaktu').innerText =
        (event.waktu_mulai ?? '-') + 
        (event.waktu_selesai ? ' - ' + event.waktu_selesai : '');

    document.getElementById('detailDeskripsi').innerText = event.deskripsi;

    // =========================
    // TIKET
    // =========================
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

    // TAMPILKAN MODAL
    document.getElementById('modalDetail').classList.remove('hidden');
}

    function closeDetailModal() {
    document.getElementById('modalDetail').classList.add('hidden');
}

// BIKIN GLOBAL
window.closeDetailModal = closeDetailModal;

    function kirimKeAdmin() {
        if (!selectedEventId) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/panitia/event/${selectedEventId}/kirim`;

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    }

    // =========================
    // GLOBAL EXPORT
    // =========================
    window.openModal = openModal;
    window.closeModal = closeModal;

    window.openDeleteModal = openDeleteModal;
    window.closeDeleteModal = closeDeleteModal;
    window.confirmDelete = confirmDelete;

    window.openDetailModal = openDetailModal;
    window.closeDetailModal = closeDetailModal;
    window.kirimKeAdmin = kirimKeAdmin;

});
</script>
@if ($errors->any())
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('eventModal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    });
</script>
@endif
@endsection