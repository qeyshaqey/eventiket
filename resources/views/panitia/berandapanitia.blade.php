@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

<!-- CARDS -->
<div class="grid grid-cols-3 gap-4 mb-10">
    <div class="bg-white p-10 rounded shadow text-center transition transform hover:-translate-y-2 hover:shadow-xl">
        <p class="text-2xl font-bold">3</p>
        <p class="text-sm">EVENT AKTIF</p>
    </div>
    <div class="bg-white p-10 rounded shadow text-center transition transform hover:-translate-y-2 hover:shadow-xl">
        <p class="text-2xl font-bold">40</p>
        <p class="text-sm">TIKET TERJUAL</p>
    </div>
    <div class="bg-white p-10 rounded shadow text-center transition transform hover:-translate-y-2 hover:shadow-xl">
        <p class="text-2xl font-bold">10</p>
        <p class="text-sm">PENDING VERIFIKASI</p>
    </div>
</div>

<!-- TABLE -->
<div class="bg-white rounded shadow p-4">

    <!-- HEADER + FILTER -->
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-bold text-lg">DAFTAR EVENT</h2>

        <!-- FILTER KATEGORI SAJA -->
        <select id="filterKategori" onchange="filterData()" 
            class="border rounded px-3 py-1 text-sm">
            <option value="">Semua Kategori</option>
            <option value="Workshop">Workshop</option>
            <option value="Seminar">Seminar</option>
            <option value="Hiburan">Hiburan</option>
        </select>
    </div>

    <!-- TABLE -->
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">NO</th>
                <th class="border p-2">JUDUL EVENT</th>
                <th class="border p-2">KATEGORI</th>
                <th class="border p-2">TANGGAL</th>
                <th class="border p-2">WAKTU</th>
                <th class="border p-2">LOKASI</th>
                <th class="border p-2">SISA KUOTA</th>
            </tr>
        </thead>

        <tbody id="eventTable" class="text-center"></tbody>
    </table>

</div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {

    const dataEvent = [
        {
            judul: "Coding Camp",
            kategori: "Workshop",
            tanggal: "20-21 April 2026",
            waktu: "09:00",
            lokasi: "Politeknik Batam",
            kuota: "15 Tiket"
        },
        {
            judul: "Seminar AI",
            kategori: "Seminar",
            tanggal: "25 April 2026",
            waktu: "13:00",
            lokasi: "Batam Center",
            kuota: "20 Tiket"
        },
        {
            judul: "Music Festival",
            kategori: "Hiburan",
            tanggal: "30 April 2026",
            waktu: "19:00",
            lokasi: "Mega Mall",
            kuota: "50 Tiket"
        },
        {
            judul: "Startup Talk",
            kategori: "Seminar",
            tanggal: "5 Mei 2026",
            waktu: "10:00",
            lokasi: "Nagoya Hill",
            kuota: "30 Tiket"
        }
    ];

    function tampilkanData(data) {
        const table = document.getElementById("eventTable");
        table.innerHTML = "";

        data.forEach((event, index) => {
            table.innerHTML += `
                <tr class="hover:bg-gray-50">
                    <td class="border p-2">${index + 1}</td>
                    <td class="border p-2 font-semibold">${event.judul}</td>
                    <td class="border p-2">${event.kategori}</td>
                    <td class="border p-2">${event.tanggal}</td>
                    <td class="border p-2">${event.waktu}</td>
                    <td class="border p-2">${event.lokasi}</td>
                    <td class="border p-2 text-green-600 font-semibold">${event.kuota}</td>
                </tr>
            `;
        });
    }

    window.filterData = function () {
        const kategori = document.getElementById("filterKategori").value;

        let hasil = dataEvent;

        if (kategori) {
            hasil = hasil.filter(e => e.kategori === kategori);
        }

        tampilkanData(hasil);
    }

    tampilkanData(dataEvent);

});
</script>

@endsection