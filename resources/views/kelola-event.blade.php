@extends('layouts.app')

@section('content')

@php
$events = [
    [
        "nama" => "Workshop UI/UX Design",
        "tanggal" => "12 Apr",
        "waktu" => "09:00 - 12:00",
        "lokasi" => "Aula Kampus",
        "kategori" => "Workshop",
        "deskripsi" => "Pelatihan desain UI/UX untuk mahasiswa tingkat akhir"
    ],
    [
        "nama" => "Seminar Kewirausahaan",
        "tanggal" => "06 Jun",
        "waktu" => "13:00 - 15:00",
        "lokasi" => "Ruang Seminar",
        "kategori" => "Seminar",
        "deskripsi" => "Belajar bisnis dari nol"
    ],
    [
        "nama" => "Festival Budaya Kampus",
        "tanggal" => "30 Jul",
        "waktu" => "08:00",
        "lokasi" => "Lapangan",
        "kategori" => "Festival",
        "deskripsi" => "Acara budaya tahunan"
    ]
];
@endphp

<div class="flex">

    <div class="flex-1 px-6 py-0">

        <div class="max-w-5xl mx-auto">

            <h1 class="text-2xl font-semibold text-[#192853] mb-6">Kelola Event</h1>

            <!-- CONTAINER -->
            <!-- <div class="bg-gray-100 rounded-2xl p-4 space-y-3 shadow"> -->
                <div class="bg-white rounded-2xl p-4 space-y-3 shadow">

                @foreach ($events as $i => $event)
                <div
                    class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-100 active:bg-gray-200 transition cursor-pointer"
                    onclick='showModal(
                        @json($event["nama"]),
                        @json($event["tanggal"]),
                        @json($event["waktu"]),
                        @json($event["lokasi"]),
                        @json($event["deskripsi"])
                    )'
                >

                    <!-- LEFT -->
                    <div class="flex items-center gap-4">

                        <!-- DATE -->
                        <div class="bg-[#192853] text-yellow-400 text-xs font-semibold px-3 py-2 rounded text-center min-w-[60px]">
                            {{ $event['tanggal'] }}
                        </div>

                        <!-- TEXT -->
                        <div>
                            <div class="text-sm font-medium text-[#192853]">
                                {{ $event['nama'] }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $event['lokasi'] }} • {{ $event['waktu'] }}
                            </div>
                        </div>

                    </div>

                    <!-- RIGHT (FIXED ORDER) -->
                    <div class="flex items-center gap-3">

                        <!-- BADGE -->
                        <span class="text-xs bg-yellow-200 px-3 py-1 rounded-full">
                            {{ $event['kategori'] }}
                        </span>

                        <!-- ✔ APPROVE -->
                        <button onclick="event.stopPropagation()"
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-200 hover:bg-green-100 text-sm">
                            ✔
                        </button>

                        <!-- ✖ REJECT -->
                        <button onclick="event.stopPropagation()"
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-200 hover:bg-red-100 text-sm">
                            ✖
                        </button>

                        <!-- ARROW -->
                        <span class="text-gray-400 text-lg">›</span>

                    </div>

                </div>
                @endforeach

            </div>

        </div>

    </div>

</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

        <!-- HEADER -->
        <div class="bg-[#192853] p-5 flex justify-between items-start">
            <h3 id="m_nama" class="text-yellow-400 font-semibold"></h3>
            <button onclick="closeModal()" class="text-white text-xl">&times;</button>
        </div>

        <!-- BODY -->
        <div class="p-5 space-y-4 text-sm">

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
                <span class="text-gray-500 block mb-1">Deskripsi</span>
                <p id="m_deskripsi"></p>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="p-4 border-t">
            <button onclick="closeModal()"
                class="w-full py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-sm">
                Tutup
            </button>
        </div>

    </div>

</div>

<!-- SCRIPT -->
<script>
function showModal(nama, tanggal, waktu, lokasi, deskripsi) {
    document.getElementById('m_nama').textContent = nama;
    document.getElementById('m_tanggal').textContent = tanggal;
    document.getElementById('m_waktu').textContent = waktu;
    document.getElementById('m_lokasi').textContent = lokasi;
    document.getElementById('m_deskripsi').textContent = deskripsi;

    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('modal').classList.add('flex');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

document.getElementById('modal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
</script>

@endsection