@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

<!-- CARDS UPGRADE -->
<div class="grid grid-cols-3 gap-6 mb-10">

    <!-- EVENT AKTIF -->
    <div class="bg-white p-3 rounded-lg shadow-lg hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">EVENT TERDEKAT</p>
                <p class="text-xl font-bold mt-1">CODING CAMP</p>
                <p class="text-sm opacity-80">20 April </p>
            </div>
        </div>
    </div>

    <!-- TIKET TERJUAL -->
    <div class="bg-white p-3 rounded-lg shadow-lg hover:scale-105 transition duration-300">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm opacity-90">TIKET TERJUAL</p>
                <p class="text-xl font-bold mt-1">40</p>
                <p class="text-sm opacity-80">+12% dari minggu lalu</p>
            </div>
        </div>
    </div>

    <!-- PENDING -->
    <div class="bg-white p-3 rounded-lg shadow-sm hover:scale-105 transition duration-300">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm opacity-90">EVENT TERLARIS</p>
            <p class="text-xl font-bold mt-1">Music Festival</p>
            <p class="text-sm opacity-80">50 tiket</p>
        </div>
    </div>
</div>

</div>
<!-- GRAFIK -->
<div class="grid grid-cols-2 gap-6 mb-10">
    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-bold text-lg mb-4">Tiket Terjual per Event</h3>
        <canvas id="ticketChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h3 class="font-bold text-lg mb-4">Progress Kuota</h3>

        <div class="mb-3">
            <div class="flex justify-between text-sm">
                <span>Music Festival</span><span>50%</span>
            </div>
            <div class="bg-gray-200 h-3 rounded">
                <div class="bg-yellow-500 h-3 rounded" style="width:50%"></div>
            </div>
        </div>

        <div class="mb-3">
            <div class="flex justify-between text-sm">
                <span>Seminar AI</span><span>48%</span>
            </div>
            <div class="bg-gray-200 h-3 rounded">
                <div class="bg-green-600 h-3 rounded" style="width:48%"></div>
            </div>
        </div>

        <div class="mb-3">
            <div class="flex justify-between text-sm">
                <span>Startup Talk</span><span>45%</span>
            </div>
            <div class="bg-gray-200 h-3 rounded">
                <div class="bg-purple-600 h-3 rounded" style="width:45%"></div>
            </div>
        </div>

        <div class="mb-3">
            <div class="flex justify-between text-sm">
                <span>Coding Camp</span><span>43%</span>
            </div>
            <div class="bg-gray-200 h-3 rounded">
                <div class="bg-blue-600 h-3 rounded" style="width:43%"></div>
            </div>
        </div>

    </div>
</div>

<!-- TABLE -->
<div class="bg-white rounded shadow p-4">

<div class="flex justify-between items-center mb-4">
    <h2 class="font-bold text-lg">DAFTAR EVENT AKTIF</h2>

    <!-- FILTER -->
    <div class="flex gap-3">

        <input id="search" type="text" placeholder="Cari..."
            class="px-3 py-2 border rounded text-sm">

        <!-- KATEGORI -->
        <select id="kategori" class="px-3 py-2 border rounded text-sm">
            <option value="">Semua Kategori</option>
            <option value="Seminar">Seminar</option>
            <option value="Workshop">Workshop</option>
            <option value="Hiburan">Hiburan</option>
        </select>

        <!-- AUTO EVENT -->
        <select id="event" class="px-3 py-2 border rounded text-sm">
            <option value="">Semua Event</option>
        </select>

    </div>
</div>

<table class="w-full text-sm border">
    <thead class="bg-gray-100">
        <tr>
            <th class="border p-2">NO</th>
            <th class="border p-2">JUDUL</th>
            <th class="border p-2">KATEGORI</th>
            <th class="border p-2">TANGGAL</th>
            <th class="border p-2">WAKTU</th>
            <th class="border p-2">LOKASI</th>
            <th class="border p-2">KUOTA</th>
        </tr>
    </thead>
    <tbody id="eventTable"></tbody>
</table>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

const dataEvent = [
    { judul:"Coding Camp", kategori:"Workshop", tanggal:"20-21 April", waktu:"09:00", lokasi:"Polibatam", kuota:"15" },
    { judul:"Seminar AI", kategori:"Seminar", tanggal:"25 April", waktu:"13:00", lokasi:"Batam Center", kuota:"20" },
    { judul:"Music Festival", kategori:"Hiburan", tanggal:"30 April", waktu:"19:00", lokasi:"Mega Mall", kuota:"50" },
    { judul:"Startup Talk", kategori:"Seminar", tanggal:"5 Mei", waktu:"10:00", lokasi:"Nagoya", kuota:"30" }
];

// render table
function tampilkanData(data){
    const table = document.getElementById("eventTable");
    table.innerHTML="";
    data.forEach((e,i)=>{
        table.innerHTML += `
        <tr>
            <td class="border p-2">${i+1}</td>
            <td class="border p-2">${e.judul}</td>
            <td class="border p-2">${e.kategori}</td>
            <td class="border p-2">${e.tanggal}</td>
            <td class="border p-2">${e.waktu}</td>
            <td class="border p-2">${e.lokasi}</td>
            <td class="border p-2">${e.kuota}</td>
        </tr>`;
    });
}

// FILTER (FIX TOTAL)
function filterData(){
    const search = document.getElementById("search").value.toLowerCase();
    const kategori = document.getElementById("kategori").value;
    const event = document.getElementById("event").value;

    const hasil = dataEvent.filter(e =>
        e.judul.toLowerCase().includes(search) &&
        (kategori ? e.kategori === kategori : true) &&
        (event ? e.judul === event : true)
    );

    tampilkanData(hasil);
}

// AUTO DROPDOWN EVENT (FIX)
const eventSelect = document.getElementById("event");
[...new Set(dataEvent.map(e=>e.judul))].forEach(j=>{
    let opt=document.createElement("option");
    opt.value=j;
    opt.textContent=j;
    eventSelect.appendChild(opt);
});

// EVENT LISTENER
document.getElementById("search").addEventListener("input",filterData);
document.getElementById("kategori").addEventListener("change",filterData);
document.getElementById("event").addEventListener("change",filterData);

// init
tampilkanData(dataEvent);

// CHART
new Chart(document.getElementById('ticketChart'), {
    type:'bar',
    data:{
        labels:dataEvent.map(e=>e.judul),
        datasets:[{
            data:dataEvent.map(e=>parseInt(e.kuota)),
            backgroundColor:['#2563eb','#059669','#f59e0b','#7c3aed']
        }]
    },
    options:{plugins:{legend:{display:false}}}
});

});
</script>

@endsection