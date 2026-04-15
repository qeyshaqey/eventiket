@extends('layouts.app')

@section('content')

<h1 class="text-xl font-semibold mb-6">Data Pengunjung</h1>

<!-- FILTER -->
<div class="bg-white p-4 rounded-xl border shadow mb-5 flex gap-3">

    <input id="search" type="text" placeholder="Cari pengunjung..."
        class="px-4 py-2 border rounded-lg text-sm w-[220px] focus:ring-2 focus:ring-yellow-300">

    <select id="kategori" class="px-3 py-2 border rounded-lg text-sm">
        <option value="">Kategori</option>
        <option>Seminar</option>
        <option>Workshop</option>
        <option>Pameran</option>
    </select>

    <select id="event" class="px-3 py-2 border rounded-lg text-sm">
        <option value="">Event</option>
        <option>Seminar Kewirausahaan</option>
        <option>Workshop UI/UX Design</option>
        <option>Pameran Teknologi</option>
    </select>

</div>

<!-- TABLE -->
<div class="bg-white rounded-xl border shadow overflow-hidden">

    <table class="w-full text-sm">
        <thead class="bg-[#f5f9ff] text-gray-500">
            <tr>
                <th class="p-4 text-left">No</th>
                <th class="p-4 text-left">Nama</th>
                <th class="p-4 text-left">Email</th>
                <th class="p-4 text-left">NIM</th>
                <th class="p-4 text-left">Event</th>
            </tr>
        </thead>

        <tbody id="tableBody">
            @foreach($data as $i => $d)
            <tr class="border-t hover:bg-[#EFF8FF]"
                data-kategori="{{ $d['kategori'] }}"
                data-event="{{ $d['event'] }}">

                <td class="p-4">{{ $i+1 }}</td>
                <td class="p-4">{{ $d['nama'] }}</td>
                <td class="p-4 text-gray-500">{{ $d['email'] }}</td>
                <td class="p-4">{{ $d['nim'] }}</td>
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

@endsection