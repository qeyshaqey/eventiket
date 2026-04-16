@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold mb-3">Event Yang Dikelola</h1>

        <button onclick="bukaTambah()" 
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

    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg relative max-h-[90vh] flex flex-col overflow-hidden">

        <!-- HEADER -->
        <div class="sticky top-0 bg-white z-20 px-6 py-4 border-b flex justify-between items-center">
            <h2 id="formTitle" class="text-lg font-bold">FORM TAMBAH EVENT</h2>
            <button onclick="closeModal()" class="text-xl text-red-500">✖</button>
        </div>

        <!-- BODY -->
        <div class="p-6 overflow-y-auto">
            <form onsubmit="event.preventDefault(); tambahEvent();" class="space-y-4">

                <div class="space-y-4">

    <!-- JUDUL -->
    <div>
        <label class="text-sm font-semibold">Judul Event</label>
        <input type="text" id="judulEvent"
            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
            placeholder="Masukkan judul event">
    </div>

    <!-- KATEGORI (DROPDOWN) -->
    <div>
        <label class="text-sm font-semibold">Kategori</label>
        <select id="kategori"
            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
            <option value="">Pilih Kategori</option>
            <option value="Workshop">Workshop</option>
            <option value="Seminar">Seminar</option>
            <option value="Hiburan">Hiburan</option>
        </select>
    </div>

    <!-- DESKRIPSI -->
    <div>
        <label class="text-sm font-semibold">Deskripsi</label>
        <textarea id="Deskripsi"
            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
            placeholder="Masukkan deskripsi"></textarea>
    </div>

    <!-- TANGGAL -->
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="text-sm font-semibold">Tanggal Mulai</label>
            <input type="date" id="tanggalmulai"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
        </div>

        <div>
            <label class="text-sm font-semibold">Tanggal Selesai</label>
            <input type="date" id="tanggalselesai"
                class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
        </div>
    </div>

    <!-- WAKTU -->
    <div>
        <label class="text-sm font-semibold">Waktu</label>
        <input type="time" id="waktumulai"
            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none">
    </div>

    <!-- LOKASI -->
    <div>
        <label class="text-sm font-semibold">Lokasi</label>
        <input type="text" id="Lokasi"
            class="w-full border border-gray-300 p-2 rounded focus:ring-2 focus:ring-blue-400 outline-none"
            placeholder="Masukkan lokasi">
    </div>

    <!-- POSTER -->
    <div>
        <label class="text-sm font-semibold">Poster Event</label>

        <input type="file" id="gambarInput" accept="image/*"
            onchange="previewImage(event)"
            class="w-full border border-gray-300 p-2 rounded cursor-pointer">

        <!-- PREVIEW -->
        <img id="preview"
            class="mt-3 hidden w-full h-40 object-cover rounded shadow">
    </div>

</div>

        <!-- FOOTER -->
        <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-between">
            <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded">
                BATAL
            </button>

            <button id="submitBtn" onclick="tambahEvent()" class="bg-blue-500 text-white px-4 py-2 rounded">
                UNGGAH
            </button>
        </div>

    </div>
</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">

    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl relative max-h-[90vh] flex flex-col">

        <!-- HEADER -->
        <div class="sticky top-0 bg-white z-20 px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-bold">DETAIL EVENT</h2>
            <button onclick="closeDetail()" class="text-red-500 text-xl">✖</button>
        </div>

        <!-- CONTENT -->
        <div id="detailContent" class="p-6 overflow-y-auto space-y-4">

            <div class="flex gap-4">

                <!-- POSTER -->
                <div class="w-40 h-40 bg-gray-200 rounded flex items-center justify-center overflow-hidden">
                    <img id="d_gambar" class="w-full h-full object-cover hidden">
                    <i id="d_noimg" class="bi bi-image text-2xl text-gray-400"></i>
                </div>

                <!-- DETAIL -->
                <div class="flex-1 text-sm space-y-1">

                    <p><b>Judul :</b> <span id="d_judul"></span></p>
                    <p><b>Kategori :</b> <span id="d_kategori"></span></p>
                    <p><b>Tanggal :</b> <span id="d_tanggal"></span></p>
                    <p><b>Waktu :</b> <span id="d_waktu"></span></p>
                    <p><b>Lokasi :</b> <span id="d_lokasi"></span></p>

                </div>

            </div>

            <!-- DESKRIPSI -->
            <div>
                <p class="font-semibold">Deskripsi :</p>
                <p id="d_deskripsi"></p>
            </div>

            <!-- TIKET -->
            <div>
                <p class="font-semibold mb-2">Tiket :</p>
                <div id="d_tiket"></div>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-between items-center">

            <!-- STATUS -->
            <span id="d_status_badge"
                class="px-3 py-1 text-sm font-semibold rounded bg-green-100 text-green-600">
                Published
            </span>

            <!-- BUTTON -->
            <button onclick="kirimEvent()" 
                class="bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600">
                KIRIM KE ADMIN
            </button>

        </div>

    </div>
</div>

<script>
let events = JSON.parse(localStorage.getItem('events')) || [];
let editIndex = null;

function saveToStorage() {
    localStorage.setItem('events', JSON.stringify(events));
}

function tambahEvent() {

    const data = {
        judul: document.getElementById('judulEvent').value,
        kategori: document.getElementById('kategori').value,
        deskripsi: document.getElementById('Deskripsi').value,
        tanggalMulai: document.getElementById('tanggalmulai').value,
        tanggalSelesai: document.getElementById('tanggalselesai').value,
        waktu: document.getElementById('waktumulai').value,
        lokasi: document.getElementById('Lokasi').value,
        status: "Draft",
        tiket: []
    };

    if (editIndex !== null) {
        events[editIndex] = data;
        editIndex = null;
    } else {
        events.push(data);
    }

    saveToStorage(); 
    renderTable();
    closeModal();
}
function previewImage(event) {
    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.classList.remove('hidden');
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
            <td class="border p-2">${e.tanggalMulai}</td>
            <td class="border p-2">${e.waktu}</td>
            <td class="border p-2">${e.lokasi}</td>

            <td class="border p-2">
                ${
                    e.status === "Published" 
                    ? '<span class="text-green-600 font-semibold">Published</span>'
                    : e.status === "Menunggu Approval"
                    ? '<span class="text-blue-600 font-semibold">Menunggu</span>'
                    : '<span class="text-yellow-600 font-semibold">Draft</span>'
                }
            </td>

            <td class="border p-2 space-x-2">

                <button onclick="window.location.href='/panitia/tiket?event=${i}'"
                    class="text-green-500">
                    <i class="bi bi-ticket-perforated"></i>
                </button>

                <button onclick="lihatDetail(${i})" class="text-blue-500">
                    <i class="bi bi-upload"></i>
                </button>

                <button onclick="editEvent(${i})" class="text-yellow-500">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <button onclick="hapusEvent(${i})" class="text-red-500">
                    <i class="bi bi-trash"></i>
                </button>

            </td>
        </tr>`;
    });
}

function hapusEvent(i) {
    if (confirm("Hapus?")) {
        events.splice(i,1);
        saveToStorage();
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

    document.getElementById('formTitle').innerText = "FORM EDIT EVENT";
    document.getElementById('submitBtn').innerText = "SIMPAN";

    openModal();
}

function lihatDetail(i) {
    const e = events[i];

    document.getElementById('d_judul').innerText = e.judul;
    document.getElementById('d_kategori').innerText = e.kategori;
    document.getElementById('d_tanggal').innerText = e.tanggalMulai + " - " + e.tanggalSelesai;
    document.getElementById('d_waktu').innerText = e.waktu;
    document.getElementById('d_lokasi').innerText = e.lokasi;
    document.getElementById('d_deskripsi').innerText = e.deskripsi;

    // STATUS
    const status = document.getElementById('d_status_badge');
    status.innerText = e.status;

    if (e.status === "Published") {
        status.className = "px-3 py-1 text-sm font-semibold rounded bg-green-100 text-green-600";
    } else if (e.status === "Menunggu Approval") {
        status.className = "px-3 py-1 text-sm font-semibold rounded bg-blue-100 text-blue-600";
    } else {
        status.className = "px-3 py-1 text-sm font-semibold rounded bg-yellow-100 text-yellow-600";
    }

    // GAMBAR
    const img = document.getElementById('d_gambar');
    const noimg = document.getElementById('d_noimg');

    if (e.gambar) {
        img.src = e.gambar;
        img.classList.remove('hidden');
        noimg.classList.add('hidden');
    } else {
        img.classList.add('hidden');
        noimg.classList.remove('hidden');
    }

    // TIKET
    const tiket = document.getElementById('d_tiket');

    if (e.tiket && e.tiket.length > 0) {
        tiket.innerHTML = e.tiket.map(t => `
            <div class="border p-2 rounded mb-2">
                <p class="font-semibold">${t.nama}</p>
                <p class="text-xs text-gray-500">
                    Rp ${t.harga} • Kuota: ${t.kuota}
                </p>
            </div>
        `).join('');
    } else {
        tiket.innerHTML = `<p class="text-gray-400">Belum ada tiket</p>`;
    }

    document.getElementById('detailModal').classList.remove('hidden');
    window.selectedEvent = i;
}

function kirimEvent() {
    const i = window.selectedEvent;

    events[i].status = "Menunggu Approval";

    localStorage.setItem('events', JSON.stringify(events));

    renderTable();
    closeDetail();

    alert("Event berhasil dikirim ke admin!");
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}

function bukaTambah() {
    document.getElementById('formTitle').innerText = "FORM TAMBAH EVENT";
    document.getElementById('submitBtn').innerText = "UNGGAH";
    openModal();
}

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    document.querySelector('form').reset();
    editIndex = null;
}

renderTable();
</script>

@endsection