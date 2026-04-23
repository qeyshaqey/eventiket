@extends('layouts.app')

@section('content')

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .tab-active {
        background-color: #192853 !important;
        color: #FACC15 !important;
    }
</style>

@php

$eventDisetujui = [
["nama"=>"Workshop UI/UX Design","tanggal"=>"12 Apr","waktu"=>"09:00 - 12:00","lokasi"=>"Aula Kampus","panitia"=>"Inessa Putri","kategori"=>"Workshop","deskripsi"=>"Pelatihan desain UI/UX"],
["nama"=>"Workshop Web Development","tanggal"=>"15 Mei","waktu"=>"09:00 - 13:00","lokasi"=>"Lab Komputer","panitia"=>"Siti Aisyah","kategori"=>"Workshop","deskripsi"=>"Belajar membuat website"],
["nama"=>"Seminar Digital Marketing","tanggal"=>"20 Jun","waktu"=>"13:00 - 16:00","lokasi"=>"Ruang Seminar","panitia"=>"Andi Wijaya","kategori"=>"Seminar","deskripsi"=>"Strategi pemasaran digital"],
["nama"=>"Talkshow Startup","tanggal"=>"10 Agu","waktu"=>"14:00 - 16:00","lokasi"=>"Auditorium","panitia"=>"Fajar Nugroho","kategori"=>"Talkshow","deskripsi"=>"Pengalaman startup"],
["nama"=>"Pelatihan Public Speaking","tanggal"=>"02 Mei","waktu"=>"10:00 - 12:00","lokasi"=>"Ruang Aula","panitia"=>"Dimas Saputra","kategori"=>"Pelatihan","deskripsi"=>"Public speaking"],
];

$eventPending = [
["nama"=>"Seminar Kewirausahaan","tanggal"=>"06 Jun","waktu"=>"13:00 - 15:00","lokasi"=>"Ruang Seminar","panitia"=>"Fariz Ramadhan","kategori"=>"Seminar","deskripsi"=>"Belajar bisnis"],
["nama"=>"Workshop Mobile App","tanggal"=>"18 Agu","waktu"=>"09:00 - 12:00","lokasi"=>"Lab Mobile","panitia"=>"Larasati Dewi","kategori"=>"Workshop","deskripsi"=>"Membuat aplikasi"],
["nama"=>"Seminar Kepemimpinan","tanggal"=>"05 Sep","waktu"=>"13:00 - 15:00","lokasi"=>"Ruang Seminar","panitia"=>"Rizky Prakoso","kategori"=>"Seminar","deskripsi"=>"Leadership"],
];

$eventDitolak = [
["nama"=>"Festival Budaya Kampus","tanggal"=>"30 Jul","waktu"=>"08:00","lokasi"=>"Lapangan","panitia"=>"Puji Davi","kategori"=>"Festival","deskripsi"=>"Acara budaya","alasan"=>"Bentrok jadwal"],
["nama"=>"Seminar AI","tanggal"=>"15 Jul","waktu"=>"13:00","lokasi"=>"Ruang Seminar","panitia"=>"Raka Putra","kategori"=>"Seminar","deskripsi"=>"AI terbaru","alasan"=>"Kuota penuh"],
];

@endphp

<div>
    <div class="max-w-6xl mx-auto">

        <h1 class="text-[22px] font-semibold text-[#192853] mb-6">
            Data Event
        </h1>

        <!-- TAB -->
        <div class="flex gap-2 mb-6">

            <button onclick="setTab('disetujui', this)"
                class="tab-btn px-4 py-2 text-sm rounded-full border transition-all bg-[#192853] text-white">
                Event Aktif
            </button>

            <button onclick="setTab('ditolak', this)"
                class="tab-btn px-4 py-2 text-sm rounded-full border transition-all bg-white text-yellow-400">
                Ditolak
            </button>

            <button onclick="setTab('pending', this)"
                class="tab-btn px-4 py-2 text-sm rounded-full border transition-all bg-white text-yellow-400">
                Pengajuan Event
            </button>

        </div>

        <!-- CARD -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">

            <input type="text" placeholder="Cari event..."
                class="w-full mb-6 px-4 py-2 rounded-lg border border-gray-200 text-sm">

            <div class="overflow-y-auto max-h-[460px]">

                <table class="w-full text-sm">

                    <thead class="text-gray-400 text-xs uppercase border-b border-gray-100">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3 text-left">Nama Event</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Panitia</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-left">Info</th>
                            <th id="aksiHeader" class="px-4 py-3 text-left" style="display:none;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody">

                        {{-- DISETUJUI --}}
                        @foreach ($eventDisetujui as $i => $event)
                        <tr data-status="disetujui" class="border-b border-gray-100 hover:bg-[#EFF6FF] cursor-pointer"
                            onclick='showModal(@json($event["nama"]),@json($event["tanggal"]),@json($event["waktu"]),@json($event["lokasi"]),@json($event["panitia"]),@json($event["deskripsi"]))'>

                            <td class="px-4 py-3">{{ $i+1 }}</td>
                            <td class="px-4 py-3 font-medium text-[#192853]">{{ $event['nama'] }}</td>
                            <td class="px-4 py-3">{{ $event['tanggal'] }}</td>
                            <td class="px-4 py-3">{{ $event['panitia'] }}</td>
                            <td class="px-4 py-3">
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">{{ $event['kategori'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-green-600 text-xs">Aktif</td>
                            <td class="aksiCell" style="display:none;"></td>
                        </tr>
                        @endforeach

                        {{-- DITOLAK --}}
                        @foreach ($eventDitolak as $i => $event)
                        <tr data-status="ditolak" class="border-b border-gray-100 hover:bg-[#EFF6FF] cursor-pointer"
                            onclick='showModal(@json($event["nama"]),@json($event["tanggal"]),@json($event["waktu"]),@json($event["lokasi"]),@json($event["panitia"]),@json($event["deskripsi"]))'>

                            <td class="px-4 py-3">{{ $i+1 }}</td>
                            <td class="px-4 py-3 font-medium text-[#192853]">{{ $event['nama'] }}</td>
                            <td class="px-4 py-3">{{ $event['tanggal'] }}</td>
                            <td class="px-4 py-3">{{ $event['panitia'] }}</td>
                            <td class="px-4 py-3">
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">{{ $event['kategori'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-red-500 text-xs">{{ $event['alasan'] }}</td>
                            <td class="aksiCell" style="display:none;"></td>
                        </tr>
                        @endforeach

                        {{-- PENDING --}}
                        @foreach ($eventPending as $i => $event)
                        <tr data-status="pending" class="border-b border-gray-100 hover:bg-[#EFF6FF] cursor-pointer"
                            onclick='showModal(@json($event["nama"]),@json($event["tanggal"]),@json($event["waktu"]),@json($event["lokasi"]),@json($event["panitia"]),@json($event["deskripsi"]))'>

                            <td class="px-4 py-3">{{ $i+1 }}</td>
                            <td class="px-4 py-3 font-medium text-[#192853]">{{ $event['nama'] }}</td>
                            <td class="px-4 py-3">{{ $event['tanggal'] }}</td>
                            <td class="px-4 py-3">{{ $event['panitia'] }}</td>
                            <td class="px-4 py-3">
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">{{ $event['kategori'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-yellow-600 text-xs">Menunggu</td>

                            <td class="px-4 py-3 aksiCell" style="display:none;">
                                <div class="flex gap-2">
                                    <button onclick="event.stopPropagation()" class="bg-green-100 text-green-600 px-3 py-1 rounded">✔</button>
                                    <button onclick="event.stopPropagation(); openRejectModal()" class="bg-red-100 text-red-500 px-3 py-1 rounded">✖</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-2xl">

        <div class="bg-[#192853] p-5 flex justify-between">
            <h3 id="m_nama" class="text-yellow-400"></h3>
            <button onclick="closeModal()" class="text-white">&times;</button>
        </div>

        <div class="p-5 text-sm space-y-2">
            <p>Tanggal: <span id="m_tanggal"></span></p>
            <p>Waktu: <span id="m_waktu"></span></p>
            <p>Lokasi: <span id="m_lokasi"></span></p>
            <p>Panitia: <span id="m_panitia"></span></p>
            <p>Deskripsi: <span id="m_deskripsi"></span></p>
        </div>

    </div>
</div>

<!-- MODAL ALASAN -->
<div id="rejectModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl p-6 shadow-xl modal-anim">

        <!-- TITLE -->
        <h2 class="text-lg font-semibold text-gray-800 mb-4">
            Alasan Penolakan
        </h2>

        <!-- TEXTAREA -->
        <textarea id="rejectInput"
            class="w-full border border-gray-200 rounded-lg p-3 text-sm mb-5 focus:outline-none focus:ring-2 focus:ring-[#192853]/20"
            placeholder="Masukkan alasan..."></textarea>

        <!-- BUTTON -->
        <div class="flex justify-end gap-2">

            <button onclick="closeRejectModal()"
                class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 text-sm hover:bg-gray-300 transition">
                Batal
            </button>

            <button onclick="submitReject()"
                class="px-4 py-2 rounded-lg bg-[#192853] text-white text-sm hover:opacity-90 transition">
                Kirim
            </button>

        </div>

    </div>
</div>

<script>
    function setTab(status, el) {

        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('tab-active');
            btn.classList.add('bg-gray-100', 'text-gray-500');
        });

        el.classList.remove('bg-gray-100', 'text-gray-500');
        el.classList.add('tab-active');

        document.querySelectorAll('#tableBody tr').forEach(row => {
            row.style.display = (row.dataset.status === status) ? '' : 'none';
        });

        let showAksi = status === 'pending';

        document.getElementById('aksiHeader').style.display = showAksi ? '' : 'none';

        document.querySelectorAll('.aksiCell').forEach(td => {
            td.style.display = showAksi ? '' : 'none';
        });
    }

    function showModal(n, t, w, l, p, d) {
        document.getElementById('m_nama').innerText = n;
        document.getElementById('m_tanggal').innerText = t;
        document.getElementById('m_waktu').innerText = w;
        document.getElementById('m_lokasi').innerText = l;
        document.getElementById('m_panitia').innerText = p;
        document.getElementById('m_deskripsi').innerText = d;

        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    setTimeout(() => {
        setTab('disetujui', document.querySelector('.tab-btn'));
    }, 100);
</script>

@endsection