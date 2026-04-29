@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
$eventDisetujui = [
    ["nama"=>"Workshop UI/UX","tanggal"=>"12 Apr","panitia"=>"Inessa","kategori"=>"Workshop", "status"=>"Aktif"],
    ["nama"=>"Seminar Digital Marketing","tanggal"=>"20 Apr","panitia"=>"Andi","kategori"=>"Seminar", "status"=>"Aktif"],
    ["nama"=>"Talkshow Startup","tanggal"=>"25 Apr","panitia"=>"Fajar","kategori"=>"Talkshow", "status"=>"Non aktif"],
    ["nama"=>"Music Festival 2024","tanggal"=>"30 Apr","panitia"=>"Budi","kategori"=>"Festival", "status"=>"Aktif"],
    ["nama"=>"Hackathon Competition","tanggal"=>"05 Mei","panitia"=>"Citra","kategori"=>"Competition", "status"=>"Non aktif"],
    ["nama"=>"Workshop Web Development","tanggal"=>"10 Mei","panitia"=>"Deni","kategori"=>"Workshop", "status"=>"Aktif"],
    ["nama"=>"Seminar AI & Machine Learning","tanggal"=>"15 Mei","panitia"=>"Eka","kategori"=>"Seminar", "status"=>"Non aktif"],
    ["nama"=>"Photography Exhibition","tanggal"=>"18 Mei","panitia"=>"Fira","kategori"=>"Art", "status"=>"Aktif"],
];

$eventDitolak = [
    ["nama"=>"Festival Kampus","tanggal"=>"10 Mei","panitia"=>"Puji","kategori"=>"Festival","alasan"=>"Bentrok jadwal"],
    ["nama"=>"Seminar AI","tanggal"=>"12 Mei","panitia"=>"Raka","kategori"=>"Seminar","alasan"=>"Kuota penuh"],
    ["nama"=>"Charity Run 2024","tanggal"=>"15 Mei","panitia"=>"Gita","kategori"=>"Olahraga","alasan"=>"Izin tidak lengkap"],
    ["nama"=>"Tech Conference","tanggal"=>"20 Mei","panitia"=>"Haryo","kategori"=>"Technology","alasan"=>"Dana tidak mencukupi"],
    ["nama"=>"Art Performance","tanggal"=>"22 Mei","panitia"=>"Indra","kategori"=>"Art","alasan"=>"Lokasi sudah dibooking"],
];

$eventPending = [
    ["nama"=>"Seminar Kewirausahaan","tanggal"=>"18 Mei","panitia"=>"Fariz","kategori"=>"Seminar"],
    ["nama"=>"Workshop Mobile App","tanggal"=>"20 Mei","panitia"=>"Laras","kategori"=>"Workshop"],
    ["nama"=>"Webinar Cyber Security","tanggal"=>"22 Mei","panitia"=>"Maya","kategori"=>"Webinar"],
    ["nama"=>"Photography Workshop","tanggal"=>"25 Mei","panitia"=>"Naufal","kategori"=>"Art"],
    ["nama"=>"Coding Bootcamp","tanggal"=>"01 Jun","panitia"=>"Olivia","kategori"=>"Education"],
    ["nama"=>"Business Plan Competition","tanggal"=>"05 Jun","panitia"=>"Putra","kategori"=>"Competition"],
];
@endphp

<div class="p-0">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold text-[#192853]">Kelola Event</h1>
    </div>

    <!-- TAB -->
    <div class="flex gap-2 mb-4">
        <button id="b1" onclick="tab('k')"
            class="px-4 py-2 text-sm rounded-full border bg-[#192853] text-white transition-all">
            Semua Event
        </button>
        <button id="b2" onclick="tab('t')"
            class="px-4 py-2 text-sm rounded-full border bg-white text-yellow-400 transition-all">
            Ditolak
        </button>
        <button id="b3" onclick="tab('p')"
            class="px-4 py-2 text-sm rounded-full border bg-white text-yellow-400 transition-all">
            Pengajuan Event
        </button>
    </div>

    <!-- ================= SEMUA EVENT ================= -->
    <div id="k" class="bg-white p-5 rounded-xl shadow border">
        <div class="mb-3">
            <div class="relative">
                <input type="text" id="searchAktif" placeholder="Cari semua event..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-collapse" id="tableAktif">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Panitia</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventDisetujui as $i => $e)
                    <tr onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Event aktif')" class="border-b hover:bg-blue-50 transition cursor-pointer">
                        <td class="p-3 text-center">{{ $i+1 }}</td>
                        <td class="p-3 font-bold text-gray-700">{{ $e['nama'] }}</td>
                        <td class="p-3 text-gray-500">{{ $e['tanggal'] }}</td>
                        <td class="p-3 text-gray-600">{{ $e['panitia'] }}</td>
                        <td class="p-3">{{ $e['kategori'] }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $e['status'] == 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $e['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- ================= DITOLAK ================= -->
    <div id="t" class="bg-white p-5 rounded-xl shadow border hidden">
        <div class="mb-3">
            <div class="relative">
                <input type="text" id="searchDitolak" placeholder="Cari event ditolak..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-collapse" id="tableDitolak">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Panitia</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Alasan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventDitolak as $i => $e)
                    <tr onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','{{ $e['alasan'] }}')" class="border-b hover:bg-red-50 transition cursor-pointer">
                        <td class="p-3 text-center">{{ $i+1 }}</td>
                        <td class="p-3 font-bold text-gray-700">{{ $e['nama'] }}</td>
                        <td class="p-3 text-gray-500">{{ $e['tanggal'] }}</td>
                        <td class="p-3 text-gray-600">{{ $e['panitia'] }}</td>
                        <td class="p-3">{{ $e['kategori'] }}</td>
                        <td class="p-3 text-red-500 text-sm">{{ $e['alasan'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= PENGAJUAN ================= -->
    <div id="p" class="bg-white p-5 rounded-xl shadow border hidden">
        <div class="mb-3">
            <div class="relative">
                <input type="text" id="searchPengajuan" placeholder="Cari pengajuan..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-collapse" id="tablePengajuan">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Panitia</th>
                        <th class="p-3 text-left">Kategori</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($eventPending as $i => $e)
                    <tr onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Menunggu persetujuan')" class="border-b hover:bg-blue-50 transition cursor-pointer">
                        <td class="p-3 text-center">{{ $i+1 }}</td>
                        <td class="p-3 font-bold text-gray-700">{{ $e['nama'] }}</td>
                        <td class="p-3 text-gray-500">{{ $e['tanggal'] }}</td>
                        <td class="p-3 text-gray-600">{{ $e['panitia'] }}</td>
                        <td class="p-3">{{ $e['kategori'] }}</td>
                        <td class="p-3"><span class="text-yellow-600 text-xs font-bold bg-yellow-100 px-3 py-1 rounded-full">Pending</span></td>

                        <td class="p-3 flex gap-2 justify-center">
                            <button onclick="event.stopPropagation()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            <button onclick="event.stopPropagation(); openRejectModal()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl w-full max-w-md shadow-lg overflow-hidden mx-4">

        <div class="bg-[#192853] p-4 flex justify-between items-center">
            <h3 id="m_nama" class="text-yellow-400 font-bold text-lg"></h3>
            <button onclick="closeModal()" class="text-white hover:text-gray-300 transition text-xl">&times;</button>
        </div>

        <div class="p-5 text-sm space-y-3 text-gray-700">
            <p class="flex items-start"><b class="w-24 text-gray-900">Tanggal</b> <span class="mr-2">:</span> <span id="m_tanggal"></span></p>
            <p class="flex items-start"><b class="w-24 text-gray-900">Waktu</b> <span class="mr-2">:</span> <span id="m_waktu"></span></p>
            <p class="flex items-start"><b class="w-24 text-gray-900">Lokasi</b> <span class="mr-2">:</span> <span id="m_lokasi"></span></p>
            <p class="flex items-start"><b class="w-24 text-gray-900">Panitia</b> <span class="mr-2">:</span> <span id="m_panitia"></span></p>
            <p class="flex items-start"><b class="w-24 text-gray-900">Deskripsi</b> <span class="mr-2">:</span> <span id="m_deskripsi"></span></p>
        </div>

    </div>
</div>

<!-- ================= MODAL REJECT ================= -->
<div id="rejectModal" class="fixed inset-0 hidden z-50 items-center justify-center">
    <div class="absolute inset-0 bg-black/40" onclick="closeRejectModal()"></div>

    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-sm p-5 mx-4">
        <h2 class="text-base font-bold text-gray-700 mb-3">Alasan Penolakan</h2>

        <textarea id="rejectInput" class="w-full border rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-400" placeholder="Masukkan alasan penolakan..."></textarea>

        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeRejectModal()" class="px-3 py-1.5 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition">Batal</button>
            <button onclick="submitReject()" class="px-3 py-1.5 text-sm rounded-lg bg-[#192853] text-yellow-400 hover:bg-[#0f1a3a] transition">Kirim</button>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
    <x-admin.tab-search-script />

    setupSearch('searchAktif', 'tableAktif');
    setupSearch('searchPengajuan', 'tablePengajuan');
    setupSearch('searchDitolak', 'tableDitolak');

    // MODAL DETAIL
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
        document.getElementById('modal').classList.remove('flex');
    }

    // MODAL REJECT
    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
        document.getElementById('rejectInput').value = '';
    }

    function submitReject() {
        let alasan = document.getElementById('rejectInput').value;
        if (alasan.trim() === '') {
            alert('Alasan wajib diisi!');
            return;
        }
        console.log("Alasan:", alasan);
        closeRejectModal();
    }
</script>

</div>
@endsection