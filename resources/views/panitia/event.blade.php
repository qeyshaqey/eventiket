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

    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg relative max-h-[90vh] flex flex-col overflow-hidden">

        <!-- HEADER STICKY -->
        <div class="sticky top-0 bg-white z-20 px-6 py-4 border-b flex justify-between items-center">
           <h2 id="formTitle" class="text-lg font-bold">FORM TAMBAH EVENT</h2>
            <button onclick="closeModal()" class="text-xl text-red-500 hover:text-red-700 transition">✖</button>
        </div>

        <!-- BODY SCROLL -->
        <div class="p-6 overflow-y-auto">

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

            </form>

        </div>

        <!-- FOOTER STICKY -->
        <div class="sticky bottom-0 bg-white border-t px-6 py-4 flex justify-between">
            <button onclick="closeModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-gray-800">
                BATAL
            </button>

            <button id="submitBtn" onclick="tambahEvent()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-gray-800">
                UNGGAH
            </button>
        </div>

    </div>
</div>

<!--MODAL DETAIL-->
<div id="detailModal" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl relative max-h-[90vh] flex flex-col overflow-hidden">
        <!-- HEADER -->
        <div class="sticky top-0 bg-white z-20 px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-bold">DETAIL EVENT</h2>
            <button onclick="closeDetail()" class="text-red-500 hover:text-red-700 text-xl">✖</button>
        </div>
        <div class="p-6 overflow-y-auto">
            <!-- CONTENT -->
            <div id="detailContent" class="grid grid-cols-2 gap-6 items-start">

                <!-- KIRI (GAMBAR) -->
                <div>
                    <img id="detailImage" 
                         class="w-full h-60 object-cover rounded shadow bg-gray-200">
                </div>

                <!-- KANAN (TEXT) -->
                <div class="space-y-2 text-sm">
                    <p><b>Judul :</b> <span id="d_judul"></span></p>
                    <p><b>Kategori :</b> <span id="d_kategori"></span></p>
                    <p><b>Tanggal :</b> <span id="d_tanggal"></span></p>
                    <p><b>Waktu :</b> <span id="d_waktu"></span></p>
                    <p><b>Lokasi :</b> <span id="d_lokasi"></span></p>
                    <p><b>Status :</b> <span id="d_status"></span></p>
                </div>

                <!-- DESKRIPSI -->
                <div class="col-span-2">
                    <p class="font-semibold mb-1">Deskripsi :</p>
                    <p id="d_deskripsi"></p>
                </div>
            </div>

            <!--FOOTER-->
            <div class="sticky bottom-0 bg-white border-t px-4 py-2 flex w-full">
                <button onclick="kirimEvent()" class="ml-auto bg-blue-500 text-white px-5 py-2 rounded hover:bg-blue-600 shadow">KIRIM</button>
            </div>
            
        </div>
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

    saveToStorage(); 
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
                <button onclick="lihatDetail(${i})" class="text-blue-500 hover:text-blue-700"><i class="bi bi-upload"></i></button>
                <button onclick="editEvent(${i})" class="text-yellow-500 hover:text-yellow-700"><i class="bi bi-pencil-square"></i></button>
                <button onclick="hapusEvent(${i})" class="text-red-500 hover:text-red-700"><i class="bi bi-trash"></i></button>
            </td>
        </tr>`;
    });
}

function hapusEvent(i) {
    if (confirm("Yakin mau hapus event ini?")) {
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
    document.getElementById('d_status').innerText = e.status;
    document.getElementById('d_deskripsi').innerText = e.deskripsi;

    const img = document.getElementById('detailImage');
    if (e.gambar && e.gambar !== "") {
        img.src = e.gambar;
    } else {
        img.src = "https://via.placeholder.com/400x250?text=No+Image";
    }

    document.getElementById('detailModal').classList.remove('hidden');
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
    document.getElementById('preview').classList.add('hidden');
    document.getElementById('submitBtn').innerText = "UNGGAH";
    editIndex = null;
}

function previewImage(event) {
    const img = document.getElementById('preview');
    img.src = URL.createObjectURL(event.target.files[0]);
    img.classList.remove('hidden');
}
renderTable();

</script>

@endsection