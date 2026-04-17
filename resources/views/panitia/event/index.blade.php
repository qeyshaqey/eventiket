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
                <td class="border p-2 text-left">
                    <div class="max-w-xs">
                        {{ Str::limit($event->deskripsi, 30) }}
                        @if(strlen($event->deskripsi) > 30)
                        <button onclick="openDetail({{ $event->id }})" class="text-blue-500 hover:text-blue-700 text-xs underline">
                            Read more
                        </button>
                        @endif
                    </div>
                </td>
                <td class="border p-2">
                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                    {{ $event->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($event->tanggal_selesai)->format('d M Y') : '' }}
                </td>
                <td class="border p-2">
                    {{ $event->waktu_mulai ? \Carbon\Carbon::parse($event->waktu_mulai)->format('H:i') : '-' }}
                    {{ $event->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($event->waktu_selesai)->format('H:i') : '' }}
                </td>
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
                    @if($event->tikets->count() === 0)
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
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold">Waktu Mulai</label>
                        <input type="time" id="waktu_mulai" name="waktu_mulai"
                            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
                    <div>
                        <label class="text-sm font-semibold">Waktu Selesai</label>
                        <input type="time" id="waktu_selesai" name="waktu_selesai"
                            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
                    </div>
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
                    <p><b>Tiket :</b></p>
                    <div id="d_tiket" class="ml-2 text-gray-600"></div>
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="mt-4">
                <p class="font-semibold">Deskripsi :</p>
                <p id="d_deskripsi" class="text-sm mt-1"></p>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-end items-center">
            <button onclick="kirimKeAdmin()" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                <i class="bi bi-send mr-1"></i> KIRIM
            </button>
        </div>

    </div>
</div>

<!-- ================= MODAL KONFIRMASI HAPUS ================= -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 hidden z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-exclamation-triangle text-red-500 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold mb-2">Hapus Event?</h3>
            <p id="deleteMessage" class="text-gray-600 mb-6">Event yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    BATAL
                </button>
                <button onclick="confirmDelete()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    HAPUS
                </button>
            </div>
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
        document.getElementById('waktu_mulai').value = event.waktu_mulai || '';
        document.getElementById('waktu_selesai').value = event.waktu_selesai || '';
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
    
    // Tanggal: gabungkan mulai dan selesai
    let tanggalText = event.tanggal_mulai;
    if (event.tanggal_selesai && event.tanggal_selesai !== event.tanggal_mulai) {
        tanggalText += ' - ' + event.tanggal_selesai;
    }
    document.getElementById('d_tanggal').innerText = tanggalText;
    
    // Waktu: gabungkan mulai dan selesai
    let waktuText = event.waktu_mulai || '-';
    if (event.waktu_selesai && event.waktu_selesai !== event.waktu_mulai) {
        waktuText += ' - ' + event.waktu_selesai;
    }
    document.getElementById('d_waktu').innerText = waktuText;
    
    document.getElementById('d_lokasi').innerText = event.lokasi || '-';
    document.getElementById('d_deskripsi').innerText = event.deskripsi || 'Tidak ada deskripsi';

    // Status berdasarkan ada tidaknya tiket
    const hasTickets = event.tikets && event.tikets.length > 0;
    
    // Info Tiket
    const ticketContainer = document.getElementById('d_tiket');
    if (hasTickets) {
        let ticketHtml = '<ul class="list-disc list-inside space-y-1">';
        event.tikets.forEach(t => {
            ticketHtml += `<li>${t.nama} - Rp ${parseInt(t.harga).toLocaleString('id-ID')} (Kuota: ${t.kuota})</li>`;
        });
        ticketHtml += '</ul>';
        ticketContainer.innerHTML = ticketHtml;
    } else {
        ticketContainer.innerText = 'Belum ada tiket';
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
    
    // Set edit button - tidak ada di modal detail
    // Gunakan tombol edit di tabel untuk mengedit
    
    modal.classList.remove('hidden');
}

function kirimKeAdmin() {
    if (confirm('Kirim event ke admin untuk approval?')) {
        fetch(`/panitia/event/${currentEventId}/kirim`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => {
            showToast('Event berhasil dikirim ke admin!');
            setTimeout(() => location.reload(), 1000);
        });
    }
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
    currentEventId = null;
}

function hapusEvent(eventId) {
    currentEventId = eventId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    currentEventId = null;
}

function confirmDelete() {
    if (!currentEventId) return;
    
    fetch(`/panitia/event/${currentEventId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ _method: 'DELETE' })
    }).then(response => {
        closeDeleteModal();
        if (response.ok) {
            showToast('Event berhasil dihapus!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Gagal menghapus event!', 'error');
        }
    }).catch(() => {
        closeDeleteModal();
        showToast('Terjadi kesalahan!', 'error');
    });
}

function bukaHalamanTiket(eventId) {
    // Redirect ke halaman tiket dengan parameter event
    window.location.href = '{{ route("panitia.tiket") }}?event_id=' + eventId;
}
</script>

@endsection