@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

<!-- CARDS -->
<div class="grid grid-cols-3 gap-6 mb-10">

    <div class="bg-white p-3 rounded-lg shadow-lg hover:scale-105 transition duration-300">
        <p class="text-sm opacity-90">EVENT TERDEKAT</p>
        <p class="text-xl font-bold mt-1">CODING CAMP</p>
        <p class="text-sm opacity-80">20 April</p>
    </div>

    <div class="bg-white p-3 rounded-lg shadow-lg hover:scale-105 transition duration-300">
        <p class="text-sm opacity-90">TIKET TERJUAL</p>
        <p class="text-xl font-bold mt-1">40</p>
        <p class="text-sm opacity-80">+12% dari minggu lalu</p>
    </div>

    <div class="bg-white p-3 rounded-lg shadow-lg hover:scale-105 transition duration-300">
        <p class="text-sm opacity-90">EVENT TERLARIS</p>
        <p class="text-xl font-bold mt-1">Music Festival</p>
        <p class="text-sm opacity-80">50 tiket</p>
    </div>

</div>

<!-- LIST -->
<div class="bg-white rounded-xl shadow p-5">

    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-lg">DAFTAR EVENT AKTIF</h2>

        <div class="flex gap-3">
            <input id="search" type="text" placeholder="Cari..."
                class="px-3 py-2 border rounded text-sm">

            <select id="kategori" class="px-3 py-2 border rounded text-sm">
                <option value="">Semua Kategori</option>
                <option value="Seminar">Seminar</option>
                <option value="Workshop">Workshop</option>
                <option value="Hiburan">Hiburan</option>
            </select>

            <select id="event" class="px-3 py-2 border rounded text-sm">
                <option value="">Semua Event</option>
            </select>
        </div>
    </div>

    <!-- CARD LIST -->
    <div id="eventTable" class="space-y-2 max-h-[450px] overflow-y-auto"></div>

</div>

<!-- MODAL (STYLE TEMANMU) -->
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-sm rounded-lg shadow-xl overflow-hidden mx-4">

        <div class="bg-[#192853] p-3 flex justify-between items-start">

            <div>
                <h3 id="m_nama" class="text-yellow-400 font-semibold text-sm"></h3>
                <p id="m_kategori" class="text-white/60 text-[10px]"></p>
            </div>

            <button onclick="closeModal()" class="text-white text-lg">&times;</button>

        </div>

        <div class="p-3 space-y-2 text-xs">

            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>
                <span id="m_tanggal"></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Waktu</span>
                <span id="m_waktu"></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Lokasi</span>
                <span id="m_lokasi"></span>
            </div>

            <div>
                <span class="text-gray-500">Kuota</span>
                <p id="m_kuota"></p>
            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

window.dataEvent = [
    { judul:"Coding Camp", kategori:"Workshop", tanggal:"20-21 April", waktu:"09:00", lokasi:"Polibatam", kuota:"15" },
    { judul:"Seminar AI", kategori:"Seminar", tanggal:"25 April", waktu:"13:00", lokasi:"Batam Center", kuota:"20" },
    { judul:"Music Festival", kategori:"Hiburan", tanggal:"30 April", waktu:"19:00", lokasi:"Mega Mall", kuota:"50" },
    { judul:"Startup Talk", kategori:"Seminar", tanggal:"5 Mei", waktu:"10:00", lokasi:"Nagoya", kuota:"30" }
];

let filteredData = [...window.dataEvent];

// RENDER CARD
function tampilkanData(data){
    const container = document.getElementById("eventTable");
    container.innerHTML = "";

    data.forEach((e, i) => {
        container.innerHTML += `
        <div onclick="openDetail(${i})"
            class="flex items-center gap-3 p-3 rounded-lg border hover:bg-blue-50 cursor-pointer transition">

            <div class="bg-[#192853] text-yellow-400 px-2 py-2 rounded text-[10px] min-w-[60px] text-center">
                ${e.tanggal}
            </div>

            <div class="flex-1">
                <div class="font-semibold text-sm">${e.judul}</div>
                <div class="text-gray-500 text-[10px]">${e.lokasi} • ${e.waktu}</div>
            </div>

            <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-[10px]">
                ${e.kategori}
            </span>

        </div>`;
    });
}

// FILTER
function filterData(){
    const search = document.getElementById("search").value.toLowerCase();
    const kategori = document.getElementById("kategori").value;
    const event = document.getElementById("event").value;

    filteredData = window.dataEvent.filter(e =>
        e.judul.toLowerCase().includes(search) &&
        (kategori ? e.kategori === kategori : true) &&
        (event ? e.judul === event : true)
    );

    tampilkanData(filteredData);
}

// DROPDOWN
const eventSelect = document.getElementById("event");

[...new Set(window.dataEvent.map(e => e.judul))].forEach(j=>{
    let opt = document.createElement("option");
    opt.value = j;
    opt.textContent = j;
    eventSelect.appendChild(opt);
});

// MODAL FIX (WAJIB window)
window.openDetail = function(index){
    const data = filteredData[index];
    if(!data) return;

    document.getElementById("m_nama").innerText = data.judul;
    document.getElementById("m_kategori").innerText = data.kategori;
    document.getElementById("m_tanggal").innerText = data.tanggal;
    document.getElementById("m_waktu").innerText = data.waktu;
    document.getElementById("m_lokasi").innerText = data.lokasi;
    document.getElementById("m_kuota").innerText = data.kuota;

    document.getElementById("modal").classList.remove("hidden");
    document.getElementById("modal").classList.add("flex");
}

window.closeModal = function(){
    document.getElementById("modal").classList.add("hidden");
    document.getElementById("modal").classList.remove("flex");
}

// EVENTS
document.getElementById("search").addEventListener("input", filterData);
document.getElementById("kategori").addEventListener("change", filterData);
document.getElementById("event").addEventListener("change", filterData);

// INIT
tampilkanData(window.dataEvent);

});
</script>

@endsection