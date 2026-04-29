@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<h1 class="text-xl font-semibold mb-6">Data Pengunjung</h1>

<!-- FILTER -->
<div class="bg-white p-4 rounded-xl border shadow mb-5 flex flex-col md:flex-row gap-3">

    <input id="search" type="text" placeholder="Cari pengunjung..."
        class="px-4 py-2 border rounded-lg text-sm flex-1 focus:ring-2 focus:ring-yellow-300 w-full md:w-auto">

    <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
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
    <div class="max-h-[420px] overflow-y-auto overflow-x-auto rounded-xl">

        <table class="w-full text-sm">
            <thead class="bg-[#f5f9ff] text-gray-500 sticky top-0 z-10">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Nama</th>
                    <th class="p-4 text-left">Email</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Event</th>
                </tr>
            </thead>

            <tbody id="tableBody">
                @foreach($data as $i => $d)
                <tr class="border-t"
                    data-kategori="{{ $d['kategori'] }}"
                    data-event="{{ $d['event'] }}">

                    <td class="p-4">{{ $i+1 }}</td>
                    <td class="p-4">{{ $d['nama'] }}</td>
                    <td class="p-4 text-gray-500">{{ $d['email'] }}</td>
                    <td class="p-4 text-gray-500">{{ $d['kategori'] }}</td>
                    <td class="p-4">
                        <span class="bg-yellow-200 text-xs px-3 py-1 rounded-full">
                            {{ $d['event'] }}
                        </span>
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<!-- SCRIPT FILTER -->
<script>
const search = document.getElementById('search');
const kategori = document.getElementById('kategori');
const event = document.getElementById('event');

search.addEventListener('keyup', filter);
kategori.addEventListener('change', filter);
event.addEventListener('change', filter);

function filter(){
    let s = search.value.toLowerCase();
    let k = kategori.value;
    let e = event.value;

    document.querySelectorAll('#tableBody tr').forEach(row=>{
        let nama = row.children[1].innerText.toLowerCase();
        let kategoriRow = row.dataset.kategori;
        let eventRow = row.dataset.event;

        let show =
            (k=="" || k==kategoriRow) &&
            (e=="" || e==eventRow) &&
            nama.includes(s);

        row.style.display = show ? "" : "none";
    });
}
</script>

</div>
@endsection