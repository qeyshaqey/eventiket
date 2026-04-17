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
                <td class="border p-2">{{ $event->judul }}</td>
                <td class="border p-2">{{ $event->kategori }}</td>
                <td class="border p-2">{{ Str::limit($event->deskripsi, 30) }}</td>
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
                <td class="border p-2 space-x-1">
                    <button onclick="openDetail({{ $event->id }})" class="text-green-500 hover:text-green-700" title="Lihat Detail">
                        <i class="bi bi-eye"></i>
                    </button>
                    <button onclick="openModal('edit', {{ $event->id }})" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    @if($event->status === 'Draft')
                    <form action="{{ route('panitia.event.kirim', $event->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-500 hover:text-blue-700" title="Kirim ke Admin" onclick="return confirm('Kirim event ke admin?')">
                            <i class="bi bi-upload"></i>
                        </button>
                    </form>
                    @endif
                    <form action="{{ route('panitia.event.destroy', $event->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus" onclick="return confirm('Hapus event?')">
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

<!-- ================= MODAL FORM (TAMBAH/EDIT) ================= -->
<div id="eventModal" class="fixed inset-0 bg-black/50 hidden z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg max-h-[90vh] flex flex-col overflow-hidden">
        
        <!-- HEADER -->
        <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b flex justify-between items-center">
            <h2 id="modalTitle" class="text-lg font-bold">Tambah Event</h2>
            <button onclick="closeModal()" class="text-xl text-red-500 hover:text-red-700">&times;</button>
        </div>

        <!-- BODY -->
        <div class="p-6 overflow-y-auto flex-1">
            <form id="eventForm" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <input type="hidden" id="methodOverride" name="_method" value="POST">

                <!-- JUDUL -->
                <div>
                    <label class="text-sm font-semibold">Judul Event</label>
                    <input type="text" id="judul" name="judul"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
                        placeholder="Masukkan judul event" required>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label class="text-sm font-semibold">Kategori</label>
                    <select id="kategori" name="kategori"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Seminar">Seminar</option>
                        <option value="Hiburan">Hiburan</option>
                    </select>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label class="text-sm font-semibold">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
                        placeholder="Masukkan deskripsi"></textarea>
                </div>

                <!-- TANGGAL -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
                </div>

                <!-- WAKTU -->
                <div>
                    <label class="text-sm font-semibold">Waktu</label>
                    <input type="time" id="waktu" name="waktu"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
                </div>

                <!-- LOKASI -->
                <div>
                    <label class="text-sm font-semibold">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi"
                        class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
                        placeholder="Masukkan lokasi">
                </div>

                <!-- POSTER -->
                <div>
                    <label class="text-sm font-semibold">Poster Event</label>
                    <div id="previewContainer" class="mb-2 hidden">
                        <img id="previewGambar" src="" class="w-32 h-32 object-cover rounded">
                    </div>
                    <input type="file" id="gambar" name="gambar" accept="image/*"
                        class="w-full border border-gray-300 p-2 rounded cursor-pointer">
                    <p id="gambarHint" class="text-xs text-gray-500 hidden">Kosongkan jika tidak ingin mengubah</p>
                </div>
            </form>
        </div>

        <!-- FOOTER -->
        <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-end gap-2">
            <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                BATAL
            </button>
            <button onclick="submitForm()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                SIMPAN
            </button>
        </div>

    </div>
</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] flex flex-col overflow-hidden">
        
        <!-- HEADER -->
        <div class="sticky top-0 bg-white z-10 px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-bold">Detail Event</h2>
            <button onclick="closeDetail()" class="text-xl text-red-500 hover:text-red-700">&times;</button>
        </div>

        <!-- BODY -->
        <div class="p-6 overflow-y-auto flex-1">
            <div class="flex gap-6">
                <!-- POSTER -->
                <div class="w-40 h-40 bg-gray-200 rounded flex items-center justify-center overflow-hidden flex-shrink-0">
                    <img id="d_gambar" class="w-full h-full object-cover hidden">
                    <i id="d_noimg" class="bi bi-image text-4xl text-gray-400"></i>
                </div>

                <!-- DETAIL -->
                <div class="flex-1 text-sm space-y-2">
                    <p><b>Judul :</b> <span id="d_judul"></span></p>
                    <p><b>Kategori :</b> <span id="d_kategori"></span></p>
                    <p><b>Tanggal :</b> <span id="d_tanggal"></span></p>
                    <p><b>Waktu :</b> <span id="d_waktu"></span></p>
                    <p><b>Lokasi :</b> <span id="d_lokasi"></span></p>
                    <p><b>Status :</b> <span id="d_status"></span></p>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="mt-4">
                <p class="font-semibold">Deskripsi :</p>
                <p id="d_deskripsi" class="text-sm mt-1"></p>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-between items-center">
            <span id="d_status_badge" class="px-3 py-1 text-sm font-semibold rounded bg-yellow-100 text-yellow-600">
                Draft
            </span>
            <button id="btnEdit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                EDIT
            </button>
        </div>

    </div>
</div>

<script>
let events = @json($events);
let currentEventId = null;

function openModal(mode, eventId = null) {
    const modal = document.getElementById('eventModal');
    const form = document.getElementById('eventForm');
    const title = document.getElementById('modalTitle');
    const methodInput = document.getElementById('methodOverride');
    const previewContainer = document.getElementById('previewContainer');
    const gambarHint = document.getElementById('gambarHint');

    closeDetail();
    modal.classList.remove('hidden');
    form.reset();
    previewContainer.classList.add('hidden');

    if (mode === 'tambah') {
        title.innerText = 'Tambah Event';
        form.action = '{{ route("panitia.event.store") }}';
        methodInput.value = 'POST';
        gambarHint.classList.add('hidden');
    } else if (mode === 'edit') {
        currentEventId = eventId;
        const event = events.find(e => e.id === eventId);
        
        title.innerText = 'Edit Event';
        form.action = `/panitia/event/${eventId}`;
        methodInput.value = 'PUT';
        gambarHint.classList.remove('hidden');

        // Fill form
        document.getElementById('judul').value = event.judul;
        document.getElementById('kategori').value = event.kategori;
        document.getElementById('deskripsi').value = event.deskripsi || '';
        document.getElementById('tanggal_mulai').value = event.tanggal_mulai;
        document.getElementById('tanggal_selesai').value = event.tanggal_selesai || '';
        document.getElementById('waktu').value = event.waktu || '';
        document.getElementById('lokasi').value = event.lokasi || '';

        // Show preview
        if (event.gambar) {
            document.getElementById('previewGambar').src = '/storage/' + event.gambar;
            previewContainer.classList.remove('hidden');
        }
    }
}

function closeModal() {
    document.getElementById('eventModal').classList.add('hidden');
    currentEventId = null;
}

function submitForm() {
    document.getElementById('eventForm').submit();
}

function openDetail(eventId) {
    const event = events.find(e => e.id === eventId);
    const modal = document.getElementById('detailModal');
    
    closeModal();
    
    document.getElementById('d_judul').innerText = event.judul;
    document.getElementById('d_kategori').innerText = event.kategori;
    document.getElementById('d_tanggal').innerText = event.tanggal_mulai + (event.tanggal_selesai ? ' - ' + event.tanggal_selesai : '');
    document.getElementById('d_waktu').innerText = event.waktu || '-';
    document.getElementById('d_lokasi').innerText = event.lokasi || '-';
    document.getElementById('d_deskripsi').innerText = event.deskripsi || 'Tidak ada deskripsi';

    // Status
    const statusBadge = document.getElementById('d_status_badge');
    const statusText = document.getElementById('d_status');
    
    if (event.status === 'Published') {
        statusBadge.className = 'px-3 py-1 text-sm font-semibold rounded bg-green-100 text-green-600';
        statusBadge.innerText = 'Published';
        statusText.innerText = 'Published';
    } else if (event.status === 'Rejected') {
        statusBadge.className = 'px-3 py-1 text-sm font-semibold rounded bg-red-100 text-red-600';
        statusBadge.innerText = 'Rejected';
        statusText.innerText = 'Rejected';
    } else {
        statusBadge.className = 'px-3 py-1 text-sm font-semibold rounded bg-yellow-100 text-yellow-600';
        statusBadge.innerText = 'Draft';
        statusText.innerText = 'Draft';
    }

    // Gambar
    const img = document.getElementById('d_gambar');
    const noimg = document.getElementById('d_noimg');
    if (event.gambar) {
        img.src = '/storage/' + event.gambar;
        img.classList.remove('hidden');
        noimg.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        noimg.classList.remove('hidden');
    }

    currentEventId = eventId;
    
    // Set edit button
    document.getElementById('btnEdit').onclick = function() {
        closeDetail();
        openModal('edit', eventId);
    };
    
    modal.classList.remove('hidden');
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
    currentEventId = null;
}
</script>

@endsection