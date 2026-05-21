@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
$eventDisetujui = [
    ["nama"=>"Workshop UI/UX","tanggal"=>"12 Apr 2024","panitia"=>"Inessa","kategori"=>"Workshop", "status"=>"Aktif"],
    ["nama"=>"Seminar Digital Marketing","tanggal"=>"20 Apr 2024","panitia"=>"Andi","kategori"=>"Seminar", "status"=>"Aktif"],
    ["nama"=>"Talkshow Startup","tanggal"=>"25 Apr 2025","panitia"=>"Fajar","kategori"=>"Talkshow", "status"=>"Non aktif"],
    ["nama"=>"Music Festival 2024","tanggal"=>"30 Apr 2024","panitia"=>"Budi","kategori"=>"Festival", "status"=>"Aktif"],
    ["nama"=>"Hackathon Competition","tanggal"=>"05 Mei 2025","panitia"=>"Citra","kategori"=>"Competition", "status"=>"Non aktif"],
    ["nama"=>"Workshop Web Development","tanggal"=>"10 Mei 2026","panitia"=>"Deni","kategori"=>"Workshop", "status"=>"Aktif"],
    ["nama"=>"Seminar AI & Machine Learning","tanggal"=>"15 Mei 2026","panitia"=>"Eka","kategori"=>"Seminar", "status"=>"Non aktif"],
    ["nama"=>"Photography Exhibition","tanggal"=>"18 Mei 2026","panitia"=>"Fira","kategori"=>"Art", "status"=>"Aktif"],
];

$eventDitolak = [
    ["nama"=>"Festival Kampus","tanggal"=>"10 Mei 2024","panitia"=>"Puji","kategori"=>"Festival","alasan"=>"Bentrok jadwal"],
    ["nama"=>"Seminar AI","tanggal"=>"12 Mei 2024","panitia"=>"Raka","kategori"=>"Seminar","alasan"=>"Kuota penuh"],
    ["nama"=>"Charity Run 2024","tanggal"=>"15 Mei 2024","panitia"=>"Gita","kategori"=>"Olahraga","alasan"=>"Izin tidak lengkap"],
    ["nama"=>"Tech Conference","tanggal"=>"20 Mei 2025","panitia"=>"Haryo","kategori"=>"Technology","alasan"=>"Dana tidak mencukupi"],
    ["nama"=>"Art Performance","tanggal"=>"22 Mei 2026","panitia"=>"Indra","kategori"=>"Art","alasan"=>"Lokasi sudah dibooking"],
];

$eventPending = [
    ["nama"=>"Seminar Kewirausahaan","tanggal"=>"18 Mei 2024","panitia"=>"Fariz","kategori"=>"Seminar"],
    ["nama"=>"Workshop Mobile App","tanggal"=>"20 Mei 2024","panitia"=>"Laras","kategori"=>"Workshop"],
    ["nama"=>"Webinar Cyber Security","tanggal"=>"22 Mei 2025","panitia"=>"Maya","kategori"=>"Webinar"],
    ["nama"=>"Photography Workshop","tanggal"=>"25 Mei 2025","panitia"=>"Naufal","kategori"=>"Art"],
    ["nama"=>"Coding Bootcamp","tanggal"=>"01 Jun 2026","panitia"=>"Olivia","kategori"=>"Education"],
    ["nama"=>"Business Plan Competition","tanggal"=>"05 Jun 2026","panitia"=>"Putra","kategori"=>"Competition"],
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
        <div class="mb-4">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text" id="searchAktif" placeholder="Cari semua event..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative w-full md:w-48">
                    <select id="filterBulanAktif" class="w-full pl-10 pr-8 py-2 border rounded-lg text-sm font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Bulan</option>
                        <option value="Jan">Januari</option>
                        <option value="Feb">Februari</option>
                        <option value="Mar">Maret</option>
                        <option value="Apr">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Jun">Juni</option>
                        <option value="Jul">Juli</option>
                        <option value="Agt">Agustus</option>
                        <option value="Sep">September</option>
                        <option value="Okt">Oktober</option>
                        <option value="Nov">November</option>
                        <option value="Des">Desember</option>
                    </select>
                    <i class="fa-solid fa-calendar-days absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                <div class="relative w-full md:w-40">
                    <select id="filterTahunAktif" class="w-full pl-10 pr-8 py-2 border rounded-lg text-sm font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Tahun</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                    <i class="fa-solid fa-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tableAktif">
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
                    <tr data-modal-target="modal" data-modal-toggle="modal" onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Event aktif')" class="bg-white hover:bg-blue-50 transition cursor-pointer shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-bold text-gray-700">{{ $e['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $e['tanggal'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $e['panitia'] }}</td>
                        <td class="py-4 px-3">{{ $e['kategori'] }}</td>
                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
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
        <div class="mb-4">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text" id="searchDitolak" placeholder="Cari event ditolak..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative w-full md:w-48">
                    <select id="filterBulanDitolak" class="w-full pl-10 pr-8 py-2 border rounded-lg text-sm font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Bulan</option>
                        <option value="Jan">Januari</option>
                        <option value="Feb">Februari</option>
                        <option value="Mar">Maret</option>
                        <option value="Apr">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Jun">Juni</option>
                        <option value="Jul">Juli</option>
                        <option value="Agt">Agustus</option>
                        <option value="Sep">September</option>
                        <option value="Okt">Oktober</option>
                        <option value="Nov">November</option>
                        <option value="Des">Desember</option>
                    </select>
                    <i class="fa-solid fa-calendar-days absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                <div class="relative w-full md:w-40">
                    <select id="filterTahunDitolak" class="w-full pl-10 pr-8 py-2 border rounded-lg text-sm font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Tahun</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                    <i class="fa-solid fa-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tableDitolak">
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
                    <tr data-modal-target="modal" data-modal-toggle="modal" onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','{{ $e['alasan'] }}')" class="bg-white hover:bg-red-50 transition cursor-pointer shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-bold text-gray-700">{{ $e['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $e['tanggal'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $e['panitia'] }}</td>
                        <td class="py-4 px-3">{{ $e['kategori'] }}</td>
                        <td class="py-4 px-3 text-red-500 text-sm first:rounded-l-lg last:rounded-r-lg">{{ $e['alasan'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ================= PENGAJUAN ================= -->
    <div id="p" class="bg-white p-5 rounded-xl shadow border hidden">
        <div class="mb-4">
            <div class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-1">
                    <input type="text" id="searchPengajuan" placeholder="Cari pengajuan..."
                        class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="relative w-full md:w-48">
                    <select id="filterBulanPengajuan" class="w-full pl-10 pr-8 py-2 border rounded-lg text-sm font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Bulan</option>
                        <option value="Jan">Januari</option>
                        <option value="Feb">Februari</option>
                        <option value="Mar">Maret</option>
                        <option value="Apr">April</option>
                        <option value="Mei">Mei</option>
                        <option value="Jun">Juni</option>
                        <option value="Jul">Juli</option>
                        <option value="Agt">Agustus</option>
                        <option value="Sep">September</option>
                        <option value="Okt">Oktober</option>
                        <option value="Nov">November</option>
                        <option value="Des">Desember</option>
                    </select>
                    <i class="fa-solid fa-calendar-days absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
                <div class="relative w-full md:w-40">
                    <select id="filterTahunPengajuan" class="w-full pl-10 pr-8 py-2 border rounded-lg text-sm font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Tahun</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                    <i class="fa-solid fa-calendar-check absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tablePengajuan">
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
                    <tr data-modal-target="modal" data-modal-toggle="modal" onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Menunggu persetujuan')" class="bg-white hover:bg-blue-50 transition cursor-pointer shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-bold text-gray-700">{{ $e['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $e['tanggal'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $e['panitia'] }}</td>
                        <td class="py-4 px-3">{{ $e['kategori'] }}</td>
                        <td class="py-4 px-3"><span class="text-yellow-600 text-xs font-bold bg-yellow-100 px-3 py-1 rounded-full">Pending</span></td>

                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
                            <div class="flex gap-2 justify-center">
                                <button onclick="event.stopPropagation()" class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                                <button onclick="event.stopPropagation(); openRejectModal()" data-modal-target="rejectModal" data-modal-toggle="rejectModal" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto flex items-center justify-center">
        <div class="relative bg-white rounded-2xl w-full shadow-lg overflow-hidden">

            <div class="bg-[#192853] p-4 flex justify-between items-center">
                <h3 id="m_nama" class="text-yellow-400 font-bold text-lg"></h3>
                <button type="button" data-modal-hide="modal" class="text-white hover:text-gray-300 transition text-xl">&times;</button>
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
</div>

<!-- ================= MODAL REJECT ================= -->
<div id="rejectModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <div class="fixed inset-0 bg-black/40" data-modal-hide="rejectModal"></div>

        <div class="relative bg-white rounded-xl shadow-lg w-full p-5 text-left">
            <h2 class="text-base font-bold text-gray-700 mb-3">Alasan Penolakan</h2>

            <textarea id="rejectInput" class="w-full border rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-400" placeholder="Masukkan alasan penolakan..."></textarea>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" data-modal-hide="rejectModal" class="px-3 py-1.5 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition">Batal</button>
                <button onclick="submitReject()" class="px-3 py-1.5 text-sm rounded-lg bg-[#192853] text-yellow-400 hover:bg-[#0f1a3a] transition">Kirim</button>
            </div>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
    <x-admin.tab-search-script />

    function setupAdvancedSearch(inputId, bulanId, tahunId, tableId) {
        const inputEl = document.getElementById(inputId);
        const bulanEl = document.getElementById(bulanId);
        const tahunEl = document.getElementById(tahunId);
        const tableEl = document.getElementById(tableId);

        if (!tableEl) return;

        function filterTable() {
            const searchValue = inputEl ? inputEl.value.toLowerCase() : '';
            const bulanValue = bulanEl ? bulanEl.value.toLowerCase() : '';
            const tahunValue = tahunEl ? tahunEl.value.toLowerCase() : '';

            const tbody = tableEl.querySelector('tbody');
            if (!tbody) return;

            const rows = tbody.querySelectorAll('tr:not(.empty-row)');
            let visibleCount = 0;

            rows.forEach(row => {
                const cells = row.getElementsByTagName('td');
                if (cells.length < 3) return;

                // Text search checks all columns in the row
                const rowText = row.innerText.toLowerCase();
                const matchesSearch = rowText.includes(searchValue);

                // Date cell check (Tanggal is column index 2)
                const dateCellText = cells[2].innerText.toLowerCase();
                
                const matchesBulan = bulanValue === '' || dateCellText.includes(bulanValue);
                const matchesTahun = tahunValue === '' || dateCellText.includes(tahunValue);

                if (matchesSearch && matchesBulan && matchesTahun) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            let emptyRow = tbody.querySelector('.empty-row');
            if (visibleCount === 0) {
                if (!emptyRow) {
                    let thead = tableEl.querySelector('thead tr');
                    let colCount = thead ? thead.children.length : 10;
                    emptyRow = document.createElement('tr');
                    emptyRow.className = 'empty-row bg-white hover:bg-white cursor-default';
                    emptyRow.innerHTML = `<td colspan="${colCount}" class="py-8 px-4 text-center text-gray-500 font-medium">Data tidak tersedia</td>`;
                    tbody.appendChild(emptyRow);
                }
                emptyRow.style.display = '';
            } else if (emptyRow) {
                emptyRow.style.display = 'none';
            }
        }

        if (inputEl) inputEl.addEventListener('keyup', filterTable);
        if (bulanEl) bulanEl.addEventListener('change', filterTable);
        if (tahunEl) tahunEl.addEventListener('change', filterTable);
    }

    setupAdvancedSearch('searchAktif', 'filterBulanAktif', 'filterTahunAktif', 'tableAktif');
    setupAdvancedSearch('searchPengajuan', 'filterBulanPengajuan', 'filterTahunPengajuan', 'tablePengajuan');
    setupAdvancedSearch('searchDitolak', 'filterBulanDitolak', 'filterTahunDitolak', 'tableDitolak');

    // MODAL DETAIL
    function showModal(n, t, w, l, p, d) {
        document.getElementById('m_nama').innerText = n;
        document.getElementById('m_tanggal').innerText = t;
        document.getElementById('m_waktu').innerText = w;
        document.getElementById('m_lokasi').innerText = l;
        document.getElementById('m_panitia').innerText = p;
        document.getElementById('m_deskripsi').innerText = d;
    }

    // MODAL REJECT
    function openRejectModal() {
        // Just for data prep if needed, Flowbite handles showing
    }

    function closeRejectModal() {
        document.getElementById('rejectInput').value = '';
        const modal = FlowbiteInstances.getInstance('Modal', 'rejectModal');
        if (modal) modal.hide();
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