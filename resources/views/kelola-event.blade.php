@extends('layouts.app')

@section('content')

@php
$events = [
    [
        "nama"=>"Workshop UI/UX Design",
        "tanggal"=>"12 Apr",
        "waktu"=>"09:00 - 12:00",
        "lokasi"=>"Aula Kampus",
        "panitia"=>"Inessa Putri",
        "kategori"=>"Workshop",
        "deskripsi"=>"Pelatihan desain UI/UX untuk mahasiswa tingkat akhir"
    ],
    [
        "nama"=>"Seminar Kewirausahaan",
        "tanggal"=>"06 Jun",
        "waktu"=>"13:00 - 15:00",
        "lokasi"=>"Ruang Seminar",
        "panitia"=>"Fariz Ramadhan",
        "kategori"=>"Seminar",
        "deskripsi"=>"Belajar bisnis dari nol"
    ],
    [
        "nama"=>"Festival Budaya Kampus",
        "tanggal"=>"30 Jul",
        "waktu"=>"08:00",
        "lokasi"=>"Lapangan",
        "panitia"=>"Puji Davi",
        "kategori"=>"Festival",
        "deskripsi"=>"Acara budaya tahunan"
    ],
    [
        "nama"=>"Pelatihan Public Speaking",
        "tanggal"=>"02 Mei",
        "waktu"=>"10:00 - 12:00",
        "lokasi"=>"Ruang Aula",
        "panitia"=>"Dimas Saputra",
        "kategori"=>"Pelatihan",
        "deskripsi"=>"Meningkatkan kemampuan berbicara di depan umum"
    ],
    [
        "nama"=>"Workshop Web Development",
        "tanggal"=>"15 Mei",
        "waktu"=>"09:00 - 13:00",
        "lokasi"=>"Lab Komputer",
        "panitia"=>"Siti Aisyah",
        "kategori"=>"Workshop",
        "deskripsi"=>"Belajar membuat website dari dasar"
    ],
    [
        "nama"=>"Seminar Digital Marketing",
        "tanggal"=>"20 Jun",
        "waktu"=>"13:00 - 16:00",
        "lokasi"=>"Ruang Seminar",
        "panitia"=>"Andi Wijaya",
        "kategori"=>"Seminar",
        "deskripsi"=>"Strategi pemasaran digital modern"
    ],
    [
        "nama"=>"Pameran Teknologi",
        "tanggal"=>"25 Jul",
        "waktu"=>"08:00 - 17:00",
        "lokasi"=>"Gedung Serbaguna",
        "panitia"=>"Putri Maharani",
        "kategori"=>"Pameran",
        "deskripsi"=>"Menampilkan inovasi teknologi terbaru"
    ],
    [
        "nama"=>"Talkshow Startup",
        "tanggal"=>"10 Agu",
        "waktu"=>"14:00 - 16:00",
        "lokasi"=>"Auditorium",
        "panitia"=>"Fajar Nugroho",
        "kategori"=>"Talkshow",
        "deskripsi"=>"Berbagi pengalaman membangun startup"
    ],
    [
        "nama"=>"Workshop Mobile App",
        "tanggal"=>"18 Agu",
        "waktu"=>"09:00 - 12:00",
        "lokasi"=>"Lab Mobile",
        "panitia"=>"Larasati Dewi",
        "kategori"=>"Workshop",
        "deskripsi"=>"Membuat aplikasi Android sederhana"
    ],
    [
        "nama"=>"Seminar Kepemimpinan",
        "tanggal"=>"05 Sep",
        "waktu"=>"13:00 - 15:00",
        "lokasi"=>"Ruang Seminar",
        "panitia"=>"Rizky Prakoso",
        "kategori"=>"Seminar",
        "deskripsi"=>"Membangun jiwa kepemimpinan mahasiswa"
    ],
];
@endphp

<div class="max-w-5xl mx-auto px-6">

    <h1 class="text-2xl font-semibold text-[#192853] mb-6">
        Kelola Event
    </h1>

    <div class="bg-white rounded-2xl p-5 shadow">

        <!-- SCROLL -->
        <div class="max-h-[460px] overflow-y-auto">

            <table class="w-full text-sm">
                <thead class="text-gray-500 border-b sticky top-0 bg-white z-10">
                    <tr>
                        <th class="p-3 text-left">No</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Nama Event</th>
                        <th class="p-3 text-left">Panitia</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($events as $i => $event)
                    <tr class="border-b hover:bg-[#EFF8FF] cursor-pointer"
                        onclick='showModal(
                            @json($event["nama"]),
                            @json($event["tanggal"]),
                            @json($event["waktu"]),
                            @json($event["lokasi"]),
                            @json($event["panitia"]),
                            @json($event["deskripsi"])
                        )'>

                        <td class="p-3">{{ $i+1 }}</td>

                        <td class="p-3">
                            <span class="bg-[#192853] text-yellow-400 text-xs px-2 py-1 rounded">
                                {{ $event['tanggal'] }}
                            </span>
                        </td>

                        <td class="p-3 font-medium text-[#192853]">
                            {{ $event['nama'] }}
                        </td>

                        <td class="p-3">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">
                                {{ $event['panitia'] }}
                            </span>
                        </td>

                        <td class="p-3">
                            <span class="text-xs bg-yellow-200 px-3 py-1 rounded-full">
                                {{ $event['kategori'] }}
                            </span>
                        </td>

                        <td class="p-3 space-x-2">
                            <button onclick="event.stopPropagation()"
                                class="px-3 py-1 text-xs rounded-full bg-green-500/20 text-green-600">
                                ✔
                            </button>

                            <button onclick="event.stopPropagation()"
                                class="px-3 py-1 text-xs rounded-full bg-red-500/20 text-red-500">
                                ✖
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

        <div class="bg-[#192853] p-5 flex justify-between">
            <h3 id="m_nama" class="text-yellow-400 font-semibold"></h3>
            <button onclick="closeModal()" class="text-white text-xl">&times;</button>
        </div>

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

            <div class="flex justify-between">
                <span class="text-gray-500">Panitia</span>
                <span id="m_panitia"></span>
            </div>

            <div>
                <span class="text-gray-500">Deskripsi</span>
                <p id="m_deskripsi"></p>
            </div>

        </div>

        <div class="p-4 border-t">
            <button onclick="closeModal()"
                class="w-full py-2 rounded-lg bg-gray-200 hover:bg-gray-300">
                Tutup
            </button>
        </div>

    </div>

</div>

<script>
    function showModal(nama, tanggal, waktu, lokasi, panitia, deskripsi) {
        document.getElementById('m_nama').textContent = nama;
        document.getElementById('m_tanggal').textContent = tanggal;
        document.getElementById('m_waktu').textContent = waktu;
        document.getElementById('m_lokasi').textContent = lokasi;
        document.getElementById('m_panitia').textContent = panitia;
        document.getElementById('m_deskripsi').textContent = deskripsi;

        document.getElementById('modal').classList.remove('hidden');
        document.getElementById('modal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
</script>

@endsection