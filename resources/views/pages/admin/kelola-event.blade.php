@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

@php
// Arrays are now populated from the database via EventController
@endphp

<div class="p-0">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold text-[#192853]">Kelola Event</h1>
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
                <div class="relative w-full md:w-auto">
                    <input type="date" id="filterTanggalAktif" class="w-full px-3 py-2 border rounded-lg text-sm text-gray-500 font-bold focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all">
                </div>
                <div class="relative w-full md:w-auto">
                    <select id="filterStatusAktif" class="w-full pl-4 pr-10 py-2 border rounded-lg text-sm text-gray-500 font-bold appearance-none bg-white focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="disetujui">Disetujui</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>
        </div>

        <div class="max-h-[65vh] overflow-y-auto overflow-x-auto">
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
                    @if(count($eventDisetujui) == 0)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="6" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach ($eventDisetujui as $i => $e)
                    @php
                        $tgl = \Carbon\Carbon::parse($e->tanggal_mulai)->format('d M Y');
                        $tglSelesai = $e->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($e->tanggal_selesai)->format('d M Y') : '';
                        $wkt = \Carbon\Carbon::parse($e->waktu_mulai)->format('H:i');
                        $wktSelesai = $e->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($e->waktu_selesai)->format('H:i') : '';
                    @endphp
                    <tr data-modal-target="modal" data-modal-toggle="modal" onclick="showModal('{{ $e->judul }}','{{ $tgl . $tglSelesai }}','{{ $wkt . $wktSelesai }}','{{ $e->lokasi }}','{{ $e->panitia->name ?? '-' }}','{{ $e->deskripsi }}')" class="bg-white hover:bg-blue-50 transition cursor-pointer shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-bold text-gray-700">{{ $e->judul }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $tgl . $tglSelesai }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $e->panitia->name ?? '-' }}</td>
                        <td class="py-4 px-3">{{ $e->kategori->nama_kategori ?? '-' }}</td>
                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-600">
                                Disetujui
                            </span>
                        </td>
                    </tr>
                    @endforeach
                    @endif
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
                <div class="relative w-full md:w-auto">
                    <input type="date" id="filterTanggalDitolak" class="w-full px-3 py-2 border rounded-lg text-sm text-gray-500 font-bold focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all">
                </div>
            </div>
        </div>

        <div class="max-h-[65vh] overflow-y-auto overflow-x-auto">
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
                    @if(count($eventDitolak) == 0)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="6" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach ($eventDitolak as $i => $e)
                    @php
                        $tgl = \Carbon\Carbon::parse($e->tanggal_mulai)->format('d M Y');
                        $tglSelesai = $e->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($e->tanggal_selesai)->format('d M Y') : '';
                        $wkt = \Carbon\Carbon::parse($e->waktu_mulai)->format('H:i');
                        $wktSelesai = $e->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($e->waktu_selesai)->format('H:i') : '';
                    @endphp
                    <tr data-modal-target="modal" data-modal-toggle="modal" onclick="showModal('{{ $e->judul }}','{{ $tgl . $tglSelesai }}','{{ $wkt . $wktSelesai }}','{{ $e->lokasi }}','{{ $e->panitia->name ?? '-' }}','{{ $e->alasan_penolakan }}')" class="bg-white hover:bg-red-50 transition cursor-pointer shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-bold text-gray-700">{{ $e->judul }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $tgl . $tglSelesai }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $e->panitia->name ?? '-' }}</td>
                        <td class="py-4 px-3">{{ $e->kategori->nama_kategori ?? '-' }}</td>
                        <td class="py-4 px-3 text-red-500 text-sm first:rounded-l-lg last:rounded-r-lg">{{ $e->alasan_penolakan }}</td>
                    </tr>
                    @endforeach
                    @endif
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
                <div class="relative w-full md:w-auto">
                    <input type="date" id="filterTanggalPengajuan" class="w-full px-3 py-2 border rounded-lg text-sm text-gray-500 font-bold focus:outline-none focus:ring-2 focus:ring-[#192853] transition-all">
                </div>
            </div>
        </div>

        <div class="max-h-[65vh] overflow-y-auto overflow-x-auto">
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
                    @if(count($eventPending) == 0)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="7" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach ($eventPending as $i => $e)
                    @php
                        $tgl = \Carbon\Carbon::parse($e->tanggal_mulai)->format('d M Y');
                        $tglSelesai = $e->tanggal_selesai ? ' - ' . \Carbon\Carbon::parse($e->tanggal_selesai)->format('d M Y') : '';
                        $wkt = \Carbon\Carbon::parse($e->waktu_mulai)->format('H:i');
                        $wktSelesai = $e->waktu_selesai ? ' - ' . \Carbon\Carbon::parse($e->waktu_selesai)->format('H:i') : '';
                    @endphp
                    <tr data-modal-target="modal" data-modal-toggle="modal" onclick="showModal('{{ $e->judul }}','{{ $tgl . $tglSelesai }}','{{ $wkt . $wktSelesai }}','{{ $e->lokasi }}','{{ $e->panitia->name ?? '-' }}','{{ $e->deskripsi }}')" class="bg-white hover:bg-blue-50 transition cursor-pointer shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-bold text-gray-700">{{ $e->judul }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $tgl . $tglSelesai }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $e->panitia->name ?? '-' }}</td>
                        <td class="py-4 px-3">{{ $e->kategori->nama_kategori ?? '-' }}</td>
                        <td class="py-4 px-3"><span class="text-yellow-600 text-xs font-bold bg-yellow-100 px-3 py-1 rounded-full">Pending</span></td>

                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
                            <div class="flex gap-2 justify-center">
                                <button type="button" onclick="event.stopPropagation(); openApproveModal({{ $e->id }}, '{{ addslashes($e->judul) }}')" class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition">
                                    <i class="fa-solid fa-check text-lg font-black" style="-webkit-text-stroke: 1px currentColor;"></i>
                                </button>
                                <button onclick="event.stopPropagation(); openRejectModal({{ $e->id }})" class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
                                    <i class="fa-solid fa-xmark text-lg font-black" style="-webkit-text-stroke: 1px currentColor;"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
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
                <p class="flex items-start"><b class="w-28 shrink-0 text-gray-900">Tanggal</b> <span class="mr-2">:</span> <span id="m_tanggal" class="flex-1"></span></p>
                <p class="flex items-start"><b class="w-28 shrink-0 text-gray-900">Waktu</b> <span class="mr-2">:</span> <span id="m_waktu" class="flex-1"></span></p>
                <p class="flex items-start"><b class="w-28 shrink-0 text-gray-900">Lokasi</b> <span class="mr-2">:</span> <span id="m_lokasi" class="flex-1"></span></p>
                <p class="flex items-start"><b class="w-28 shrink-0 text-gray-900">Panitia</b> <span class="mr-2">:</span> <span id="m_panitia" class="flex-1"></span></p>
                <p class="flex items-start"><b class="w-28 shrink-0 text-gray-900">Deskripsi</b> <span class="mr-2">:</span> <span id="m_deskripsi" class="flex-1 text-justify"></span></p>
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL REJECT ================= -->
<div id="rejectModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <div class="fixed inset-0 bg-black/40" data-modal-hide="rejectModal" onclick="closeRejectModal()"></div>

        <div class="relative bg-white rounded-xl shadow-lg w-full p-5 text-left">
            <h2 class="text-base font-bold text-gray-700 mb-3">Alasan Penolakan</h2>

            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="space-y-2 mb-3">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="radio" name="alasan_opsi" value="Deskripsi event tidak jelas atau kurang lengkap." onchange="setAlasanEvent(this.value)" class="mt-1" required>
                        <span class="text-sm text-gray-600 leading-tight">Deskripsi event tidak jelas atau kurang lengkap.</span>
                    </label>
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="radio" name="alasan_opsi" value="Poster event melanggar ketentuan atau tidak pantas." onchange="setAlasanEvent(this.value)" class="mt-1">
                        <span class="text-sm text-gray-600 leading-tight">Poster event melanggar ketentuan atau tidak pantas.</span>
                    </label>
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="radio" name="alasan_opsi" value="Jadwal event bentrok dengan acara utama kampus/fakultas." onchange="setAlasanEvent(this.value)" class="mt-1">
                        <span class="text-sm text-gray-600 leading-tight">Jadwal event bentrok dengan acara utama kampus.</span>
                    </label>
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="radio" name="alasan_opsi" value="lainnya" onchange="setAlasanEvent('lainnya')" class="mt-1">
                        <span class="text-sm text-gray-600 leading-tight">Alasan Lainnya:</span>
                    </label>
                </div>

                <textarea name="alasan" id="rejectInput" class="w-full border rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-400 hidden" placeholder="Ketik alasan lainnya di sini..." required></textarea>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" onclick="closeRejectModal()" class="px-3 py-1.5 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 transition">Batal</button>
                    <button type="submit" class="px-3 py-1.5 text-sm rounded-lg bg-[#192853] text-yellow-400 hover:bg-[#0f1a3a] transition">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= MODAL APPROVE ================= -->
<div id="approveModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <div class="fixed inset-0 bg-black/40" data-modal-hide="approveModal" onclick="closeApproveModal()"></div>

        <div class="relative bg-white rounded-xl shadow-lg w-full p-6 text-center">
            <div class="w-16 h-16 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-check text-3xl"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Setujui Event?</h2>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menyetujui event <span id="namaEventApprove" class="font-bold text-gray-700"></span>?</p>

            <form id="approveForm" method="POST" class="flex justify-center gap-3">
                @csrf
                <button type="button" onclick="closeApproveModal()" 
                    class="px-6 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" 
                    class="px-6 py-2 text-sm font-medium rounded-lg bg-green-500 text-white hover:bg-green-600 transition shadow-md shadow-green-200">
                    Iya, Setujui
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
<script>
    <x-admin.tab-search-script />

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('tab')) {
        tab(urlParams.get('tab'));
    }

    function setupAdvancedSearch(inputId, tanggalId, tableId, statusId = null) {
        const inputEl = document.getElementById(inputId);
        const tanggalEl = document.getElementById(tanggalId);
        const statusEl = statusId ? document.getElementById(statusId) : null;
        const tableEl = document.getElementById(tableId);

        if (!tableEl) return;

        const months = {"jan":"01","feb":"02","mar":"03","apr":"04","mei":"05","jun":"06","jul":"07","agt":"08","sep":"09","okt":"10","nov":"11","des":"12"};

        function filterTable() {
            const searchValue = inputEl ? inputEl.value.toLowerCase() : '';
            const tanggalValue = tanggalEl ? tanggalEl.value : '';
            const statusValue = statusEl ? statusEl.value.toLowerCase() : '';

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

                // Date formatting and checking
                let matchesTanggal = true;
                if (tanggalValue !== '') {
                    const dateCellText = cells[2].innerText.toLowerCase().trim(); // e.g. "12 apr 2024"
                    const parts = dateCellText.split(' ');
                    if (parts.length === 3) {
                        const d = parts[0].padStart(2, '0');
                        const m = months[parts[1]] || '00';
                        const y = parts[2];
                        const rowDateStr = `${y}-${m}-${d}`;
                        matchesTanggal = (tanggalValue === rowDateStr);
                    } else {
                        matchesTanggal = false;
                    }
                }

                let matchesStatus = true;
                if (statusValue !== '' && cells.length > 5) {
                    const statusCellText = cells[5].innerText.toLowerCase().trim();
                    matchesStatus = (statusCellText === statusValue);
                }

                if (matchesSearch && matchesTanggal && matchesStatus) {
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
                    emptyRow.innerHTML = `
                        <td colspan="${colCount}" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    `;
                    tbody.appendChild(emptyRow);
                }
                emptyRow.style.display = '';
            } else if (emptyRow) {
                emptyRow.style.display = 'none';
            }
        }

        if (inputEl) inputEl.addEventListener('keyup', filterTable);
        if (tanggalEl) tanggalEl.addEventListener('change', filterTable);
        if (statusEl) statusEl.addEventListener('change', filterTable);
    }

    setupAdvancedSearch('searchAktif', 'filterTanggalAktif', 'tableAktif', 'filterStatusAktif');
    setupAdvancedSearch('searchPengajuan', 'filterTanggalPengajuan', 'tablePengajuan');
    setupAdvancedSearch('searchDitolak', 'filterTanggalDitolak', 'tableDitolak');

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
    function setAlasanEvent(val) {
        let textarea = document.getElementById('rejectInput');
        if(val === 'lainnya') {
            textarea.classList.remove('hidden');
            textarea.value = '';
            textarea.focus();
        } else {
            textarea.classList.add('hidden');
            textarea.value = val;
        }
    }

    function openRejectModal(id) {
        let form = document.getElementById('rejectForm');
        form.action = `/admin/event-reject/${id}`;
        
        // Reset form
        form.reset();
        document.getElementById('rejectInput').classList.add('hidden');
        
        document.getElementById('rejectModal').classList.remove('hidden');
        document.getElementById('rejectModal').classList.add('flex');
    }

    function closeRejectModal() {
        document.getElementById('rejectInput').value = '';
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectModal').classList.remove('flex');
    }

    // MODAL APPROVE
    function openApproveModal(id, judul) {
        let form = document.getElementById('approveForm');
        form.action = `/admin/event-approve/${id}`;
        document.getElementById('namaEventApprove').innerText = judul;
        document.getElementById('approveModal').classList.remove('hidden');
        document.getElementById('approveModal').classList.add('flex');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
        document.getElementById('approveModal').classList.remove('flex');
    }
</script>

</div>
@endsection