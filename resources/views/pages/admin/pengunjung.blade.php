@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<h1 class="text-xl font-semibold mb-6">Data Pengunjung</h1>

<!-- FILTER -->
<div class="bg-white p-4 rounded-xl border shadow mb-5 flex flex-col md:flex-row gap-3">

    <div class="relative flex-1 w-full md:w-auto">
        <input id="search" type="text" placeholder="Cari pengunjung..."
            class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-yellow-300 font-bold">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
    </div>

    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
        <input id="tanggal_beli" type="date" class="px-3 py-2 border rounded-lg text-sm w-full md:w-auto text-gray-500">

        <select id="kategori" class="px-3 py-2 border rounded-lg text-sm w-full md:w-auto">
            <option value="">Kategori</option>
            <option>Seminar</option>
            <option>Workshop</option>
            <option>Pameran</option>
        </select>

        <select id="event" class="px-3 py-2 border rounded-lg text-sm w-full md:w-auto">
            <option value="">Event</option>
            <option>Seminar Kewirausahaan</option>
            <option>Workshop UI/UX Design</option>
            <option>Pameran Teknologi</option>
        </select>
    </div>

</div>

<!-- TABLE -->
<div class="bg-white rounded-xl border shadow">

    <!-- SCROLL AREA (DITINGGIKAN) -->
    <div class="max-h-[65vh] overflow-y-auto overflow-x-auto rounded-xl">

        <table class="w-full text-sm border-separate border-spacing-y-1">
            <thead class="bg-[#f5f9ff] text-gray-500 sticky top-0 z-10">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">NIM</th>
                    <th class="p-4 text-left">Tanggal Beli</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Event</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @if(count($data) == 0)
                <tr class="empty-row bg-white cursor-default">
                    <td colspan="7" class="py-12 px-4 text-center">
                        <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                            <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                            <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                        </div>
                    </td>
                </tr>
                @else
                @foreach($data as $i => $d)
                <tr class="bg-white hover:bg-gray-50 transition shadow-sm"
                    data-kategori="{{ $d['kategori'] }}"
                    data-event="{{ $d['event'] }}"
                    data-tanggal="{{ $d['tanggal_beli'] }}">

                    <td class="py-5 px-4 first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                    <td class="py-5 px-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ $d['foto'] }}" alt="{{ $d['nama'] }}" 
                                class="w-8 h-8 rounded-full object-cover ring-2 ring-gray-200 shadow-sm flex-shrink-0">
                            <span>{{ $d['nama'] }}</span>
                        </div>
                    </td>
                    <td class="py-5 px-4 text-gray-500">{{ $d['email'] }}</td>
                    <td class="py-5 px-4 text-gray-600">{{ $d['nim'] }}</td>
                    <td class="py-5 px-4 text-gray-500">{{ date('d M Y', strtotime($d['tanggal_beli'])) }}</td>
                    <td class="py-5 px-4 text-gray-500">{{ $d['kategori'] }}</td>
                    <td class="py-5 px-4 first:rounded-l-lg last:rounded-r-lg">
                        <span class="bg-yellow-200 text-xs px-3 py-1 rounded-full">
                            {{ $d['event'] }}
                        </span>
                    </td>

                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

    </div>
</div>

<!-- SCRIPT FILTER -->
<script>
const search = document.getElementById('search');
const kategori = document.getElementById('kategori');
const event = document.getElementById('event');
const tanggal_beli = document.getElementById('tanggal_beli');

search.addEventListener('keyup', filter);
kategori.addEventListener('change', filter);
event.addEventListener('change', filter);
tanggal_beli.addEventListener('change', filter);

function filter(){
    let s = search.value.toLowerCase();
    let k = kategori.value;
    let e = event.value;
    let t = tanggal_beli.value; // format: YYYY-MM-DD

    let tbody = document.getElementById('tableBody');
    if (!tbody) return;

    let rows = tbody.querySelectorAll('tr:not(.empty-row)');
    let visibleCount = 0;

    rows.forEach(row=>{
        let nama = row.children[1].innerText.toLowerCase();
        let kategoriRow = row.dataset.kategori;
        let eventRow = row.dataset.event;
        let tanggalRow = row.dataset.tanggal;

        let show =
            (k=="" || k==kategoriRow) &&
            (e=="" || e==eventRow) &&
            (t=="" || t==tanggalRow) &&
            nama.includes(s);

        row.style.display = show ? "" : "none";
        if (show) visibleCount++;
    });

    let emptyRow = tbody.querySelector('.empty-row');
    if (visibleCount === 0) {
        if (!emptyRow) {
            emptyRow = document.createElement('tr');
            emptyRow.className = 'empty-row bg-white hover:bg-white cursor-default';
            emptyRow.innerHTML = `
                <td colspan="7" class="py-12 px-4 text-center">
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
</script>

</div>
@endsection