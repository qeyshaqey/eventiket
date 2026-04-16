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

                <input type="text" id="judulEvent" placeholder="Judul Event" class="w-full border p-2 rounded">
                <input type="text" id="kategori" placeholder="Kategori" class="w-full border p-2 rounded">
                <textarea id="Deskripsi" placeholder="Deskripsi" class="w-full border p-2 rounded"></textarea>

                <input type="date" id="tanggalmulai" class="w-full border p-2 rounded">
                <input type="date" id="tanggalselesai" class="w-full border p-2 rounded">
                <input type="time" id="waktumulai" class="w-full border p-2 rounded">
                <input type="text" id="Lokasi" placeholder="Lokasi" class="w-full border p-2 rounded">

            </form>
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

            <td class="border p-2 text-yellow-600">${e.status}</td>

            <td class="border p-2 space-x-2">

                <!-- KE TIKET -->
                <button onclick="window.location.href='/panitia/tiket?event=${i}'"
                    class="text-green-500">
                    <i class="bi bi-ticket-perforated"></i>
                </button>

                <!-- DETAIL -->
                <button onclick="lihatDetail(${i})" class="text-blue-500">
                    <i class="bi bi-upload"></i>
                </button>

                <!-- EDIT -->
                <button onclick="editEvent(${i})" class="text-yellow-500">
                    <i class="bi bi-pencil-square"></i>
                </button>

                <!-- HAPUS -->
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
    alert("Detail event index: " + i);
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