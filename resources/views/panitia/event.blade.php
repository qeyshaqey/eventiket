@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold mb-3">Event Yang Dikelola</h1>

        <button onclick="openModal()" 
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
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

        <tbody id="eventTable" class="text-center"></tbody>
    </table>

</div>

<!-- ================= MODAL FORM ================= -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">

    <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-lg relative max-h-[90vh] overflow-y-auto">

        <button onclick="closeModal()" class="absolute top-2 right-3 text-xl">✖</button>

        <div class="sticky top-0 bg-white z-10 pb-2 border-b mb-4">
        <h2 class="text-lg font-bold">FORM TAMBAH EVENT</h2>
        </div>

        <form onsubmit="event.preventDefault(); tambahEvent();" class="space-y-4">

            <div>
                <label class="text-sm font-semibold">Judul Event</label>
                <input type="text" id="judulEvent" class="w-full border px-3 py-2 rounded mt-1">
            </div>

            <div>
                <label class="text-sm font-semibold">Kategori</label>
                <select id="kategori" class="w-full border px-3 py-2 rounded mt-1">
                    <option value="">Pilih Kategori</option>
                    <option>Workshop</option>
                    <option>Seminar</option>
                    <option>Hiburan</option>
                    <option>Olahraga</option>
                </select>
            </div>

            <div>
                <label class="text-sm font-semibold">Deskripsi</label>
                <textarea id="Deskripsi" class="w-full border px-3 py-2 rounded mt-1"></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-sm font-semibold">Tanggal Mulai</label>
                    <input type="date" id="tanggalmulai" class="w-full border px-3 py-2 rounded mt-1">
                </div>

                <div>
                    <label class="text-sm font-semibold">Tanggal Selesai</label>
                    <input type="date" id="tanggalselesai" class="w-full border px-3 py-2 rounded mt-1">
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold">Waktu</label>
                <input type="time" id="waktumulai" class="w-full border px-3 py-2 rounded mt-1">
            </div>

            <div>
                <label class="text-sm font-semibold">Lokasi</label>
                <input type="text" id="Lokasi" class="w-full border px-3 py-2 rounded mt-1">
            </div>

            <div>
                <label class="text-sm font-semibold">Poster</label>
                <div class="border rounded p-3 text-center mt-1">
                    <input type="file" id="gambarInput" accept="image/*" onchange="previewImage(event)" class="hidden">

                    <button type="button"
                        onclick="document.getElementById('gambarInput').click()"
                        class="border px-3 py-1 text-sm">
                        PILIH FILE
                    </button>

                    <img id="preview" class="hidden w-32 mt-2 mx-auto rounded">
                </div>
            </div>

            <div class="flex justify-between pt-3">
                <button type="button" onclick="closeModal()" class="border px-4 py-2 rounded">
                    BATAL
                </button>

                <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded">
                    SIMPAN
                </button>
            </div>

        </form>
    </div>
</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">

    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-lg relative">

        <button onclick="closeDetail()" class="absolute top-2 right-3 text-xl">✖</button>

        <h2 class="text-xl font-bold mb-4">Detail Event</h2>

        <div id="detailContent"></div>

    </div>
</div>

<script>

let events = JSON.parse(localStorage.getItem('events')) || [];
let editIndex = null;

// simpan ke localStorage
function saveToStorage() {
    localStorage.setItem('events', JSON.stringify(events));
}

function tambahEvent() {

    const fileInput = document.getElementById('gambarInput');
    let gambar = "";

    if (fileInput.files.length > 0) {
        gambar = URL.createObjectURL(fileInput.files[0]);
    }

    const data = {
        judul: document.getElementById('judulEvent').value,
        kategori: document.getElementById('kategori').value,
        deskripsi: document.getElementById('Deskripsi').value,
        tanggalMulai: document.getElementById('tanggalmulai').value,
        tanggalSelesai: document.getElementById('tanggalselesai').value,
        waktu: document.getElementById('waktumulai').value,
        lokasi: document.getElementById('Lokasi').value,
        status: "Draft",
        gambar: gambar
    };

    if (editIndex !== null) {
        events[editIndex] = data;
        editIndex = null;
    } else {
        events.push(data);
    }

    saveToStorage(); // 🔥 simpan permanen
    renderTable();
    closeModal();
}

function renderTable() {
    const table = document.getElementById('eventTable');
    table.innerHTML = "";

    events.forEach((e, i) => {
        table.innerHTML += `
        <tr>
            <td class="border p-2">${i+1}</td>
            <td class="border p-2">${e.judul}</td>
            <td class="border p-2">${e.kategori}</td>
            <td class="border p-2">${e.deskripsi}</td>
            <td class="border p-2">${e.tanggalMulai || '-'} - ${e.tanggalSelesai || '-'}</td>
            <td class="border p-2">${e.waktu}</td>
            <td class="border p-2">${e.lokasi}</td>

            <td class="border p-2">
                <span class="text-yellow-600 font-semibold">
                    ${e.status}
                </span>
            </td>

            <td class="border p-2 space-x-1">
                <button onclick="lihatDetail(${i})">👁️</button>
                <button onclick="editEvent(${i})">✏️</button>
                <button onclick="hapusEvent(${i})">🗑️</button>
            </td>
        </tr>`;
    });
}

function hapusEvent(i) {
    if (confirm("Yakin mau hapus event ini?")) {
        events.splice(i,1);
        saveToStorage(); // 🔥 update storage
        renderTable();
    }
}

function editEvent(i) {
    const e = events[i];

    document.getElementById('judulEvent').value = e.judul;
    document.getElementById('kategori').value = e.kategori;
    document.getElementById('Deskripsi').value = e.deskripsi;
    document.getElementById('tanggalmulai').value = e.tanggalMulai;
    document.getElementById('tanggalselesai').value = e.tanggalSelesai;
    document.getElementById('waktumulai').value = e.waktu;
    document.getElementById('Lokasi').value = e.lokasi;

    editIndex = i;
    openModal();
}

function lihatDetail(i) {
    const e = events[i];

    document.getElementById('detailContent').innerHTML = `
        <p><b>Judul:</b> ${e.judul}</p>
        <p><b>Kategori:</b> ${e.kategori}</p>
        <p><b>Deskripsi:</b> ${e.deskripsi}</p>
        <p><b>Tanggal:</b> ${e.tanggalMulai} - ${e.tanggalSelesai}</p>
        <p><b>Waktu:</b> ${e.waktu}</p>
        <p><b>Lokasi:</b> ${e.lokasi}</p>
        <p><b>Status:</b> ${e.status}</p>
        ${e.gambar ? `<img src="${e.gambar}" class="mt-3 w-full rounded">` : ''}
    `;

    document.getElementById('detailModal').classList.remove('hidden');
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.querySelector('form').reset();
    document.getElementById('preview').classList.add('hidden');
}

function previewImage(event) {
    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.classList.remove('hidden');
}

// 🔥 AUTO LOAD SAAT REFRESH
renderTable();

</script>

@endsection