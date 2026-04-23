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
            @php
                $tikets = collect($event->tikets ?? []);
                $isPublished = $tikets->count() > 0;
            @endphp

            <tr>
                <td class="border p-2">{{ $index + 1 }}</td>
                <td class="border p-2">{{ $event->judul }}</td>
                <td class="border p-2">{{ $event->kategori }}</td>

                <td class="border p-2 text-left">
                    {{ \Illuminate\Support\Str::limit($event->deskripsi, 30) }}
                </td>

                <td class="border p-2">
                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                    {{ $event->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') : '' }}
                </td>

                <td class="border p-2">
                    {{ \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') }}
                    {{ $event->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : '' }}
                </td>

                <td class="border p-2">{{ $event->lokasi }}</td>

                <!-- STATUS -->
                <td class="border p-2">
                    @if($isPublished)
                        <span class="text-green-600 font-semibold">Published</span>
                    @else
                        <span class="text-yellow-600 font-semibold">Draft</span>
                    @endif
                </td>

                <!-- AKSI -->
                <td class="border p-2 space-x-1">

                    <!-- Tambah Tiket -->
                    @if(($event->status ?? '') === 'Draft')
<button 
    onclick="window.location.href='{{ route('panitia.tiket') }}?event_id={{ $event->id }}'"
    class="text-green-500 hover:text-green-700" 
    title="Tambah Tiket">
    <i class="bi bi-ticket-perforated"></i>
</button>
@endif

                    <!-- Edit -->
                    <button onclick="openModal('edit', {{ $event->id }})" 
                        class="text-yellow-500 hover:text-yellow-700">
                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <!-- Upload -->
                    <button 
    onclick="{{ $isPublished ? "openDetailModal($event->id)" : '' }}"
    class="text-blue-500 {{ !$isPublished ? 'opacity-30 cursor-not-allowed' : 'hover:text-blue-700' }}"
    title="{{ $isPublished ? 'Kirim ke Admin' : 'Tambah tiket dulu' }}">
    <i class="bi bi-upload"></i>
</button>

                    <!-- Hapus -->
                    <button onclick="openDeleteModal({{ $event->id }})" 
                        class="text-red-500 hover:text-red-700">
                        <i class="bi bi-trash"></i>
                    </button>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="border p-4 text-center">Belum ada event</td>
            </tr>
            @endforelse
        </tbody>
    </table>

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
            <input name="judul" type="text" placeholder="Judul Event"
                class="w-full border p-2 mb-2 rounded" required>

            <!-- Kategori -->
            <select name="kategori" class="w-full border p-2 mb-2 rounded" required>
                <option value="">Pilih Kategori</option>
                <option value="Musik">Musik</option>
                <option value="Seminar">Seminar</option>
                <option value="Workshop">Workshop</option>
                <option value="Olahraga">Olahraga</option>
            </select>

            <!-- Deskripsi -->
            <textarea name="deskripsi" placeholder="Deskripsi"
                class="w-full border p-2 mb-2 rounded"></textarea>

            <!-- Tanggal -->
            <input name="tanggal_mulai" type="date" class="w-full border p-2 mb-2 rounded" required>
            <input name="tanggal_selesai" type="date" class="w-full border p-2 mb-2 rounded">

            <!-- Waktu -->
            <input name="waktu_mulai" type="time" class="w-full border p-2 mb-2 rounded" required>
            <input name="waktu_selesai" type="time" class="w-full border p-2 mb-2 rounded">

            <!-- Lokasi -->
            <input name="lokasi" type="text" placeholder="Lokasi"
                class="w-full border p-2 mb-2 rounded">

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
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">
    <div class="bg-white p-6 rounded w-96">
        <h2 class="font-bold mb-3">Detail Event</h2>
        <div id="detailContent"></div>

        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeDetailModal()" class="bg-gray-300 px-3 py-1 rounded">Batal</button>
            <button onclick="kirimKeAdmin()" class="bg-blue-500 text-white px-3 py-1 rounded">Kirim</button>
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

        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailContent');

        const event = window.events.find(e => e.id == id);
        if (!event) return;

        if (content) {
            content.innerHTML = `
                <p><b>Judul:</b> ${event.judul}</p>
                <p><b>Kategori:</b> ${event.kategori}</p>
                <p><b>Tanggal:</b> ${event.tanggal_mulai ?? '-'} ${event.tanggal_selesai ? ' - ' + event.tanggal_selesai : ''}</p>
                <p><b>Waktu:</b> ${event.waktu_mulai ?? '-'} ${event.waktu_selesai ? ' - ' + event.waktu_selesai : ''}</p>
                <p><b>Lokasi:</b> ${event.lokasi}</p>
                <p><b>Deskripsi:</b> ${event.deskripsi}</p>
            `;
        }

        modal?.classList.remove('hidden');
    }

    function closeDetailModal() {
        document.getElementById('detailModal')?.classList.add('hidden');
    }

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

@endsection