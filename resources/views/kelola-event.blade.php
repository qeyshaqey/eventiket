@extends('layouts.app')

@section('content')

@php
$eventDisetujui = [
["nama"=>"Workshop UI/UX","tanggal"=>"12 Apr","panitia"=>"Inessa","kategori"=>"Workshop"],
["nama"=>"Seminar Digital Marketing","tanggal"=>"20 Apr","panitia"=>"Andi","kategori"=>"Seminar"],
["nama"=>"Talkshow Startup","tanggal"=>"25 Apr","panitia"=>"Fajar","kategori"=>"Talkshow"],
["nama"=>"Pelatihan Public Speaking","tanggal"=>"30 Apr","panitia"=>"Dimas","kategori"=>"Pelatihan"],
["nama"=>"Workshop Laravel","tanggal"=>"5 Mei","panitia"=>"Rizky","kategori"=>"Workshop"],
];

$eventDitolak = [
["nama"=>"Festival Kampus","tanggal"=>"10 Mei","panitia"=>"Puji","kategori"=>"Festival","alasan"=>"Bentrok"],
["nama"=>"Seminar AI","tanggal"=>"12 Mei","panitia"=>"Raka","kategori"=>"Seminar","alasan"=>"Kuota penuh"],
];

$eventPending = [
["nama"=>"Seminar Kewirausahaan","tanggal"=>"18 Mei","panitia"=>"Fariz","kategori"=>"Seminar"],
["nama"=>"Workshop Mobile App","tanggal"=>"20 Mei","panitia"=>"Laras","kategori"=>"Workshop"],
];
@endphp

<div class="max-w-6xl mx-auto">

    <!-- TITLE -->
    <h1 class="text-2xl font-semibold text-[#192853] mb-6">
        Kelola Event
    </h1>

    <!-- TAB -->
    <div class="flex gap-2 mb-6">
        <button data-status="disetujui"
            class="tab-btn px-4 py-2 text-sm rounded-full border bg-[#192853] text-white">
            Event Aktif
        </button>

        <button data-status="ditolak"
            class="tab-btn px-4 py-2 text-sm rounded-full border bg-white text-yellow-400">
            Ditolak
        </button>

        <button data-status="pending"
            class="tab-btn px-4 py-2 text-sm rounded-full border bg-white text-yellow-400">
            Pengajuan Event
        </button>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl p-6 shadow border border-gray-100">

        <!-- TABLE -->
        <div class="overflow-y-auto max-h-[450px]">

            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="text-gray-400 text-xs uppercase border-b">
                    <tr>
                        <th class="px-4 py-4">No</th>
                        <th class="px-4 py-4 text-left">Nama Event</th>
                        <th class="px-4 py-4 text-left">Tanggal</th>
                        <th class="px-4 py-4 text-left">Panitia</th>
                        <th class="px-4 py-4 text-left">Kategori</th>
                        <th class="px-4 py-4 text-left">Info</th>
                        <th id="aksiHeader" class="px-4 py-4 text-left hidden">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">

                    <!-- DISETUJUI -->
                    @foreach ($eventDisetujui as $i => $e)
                    <tr data-status="disetujui"
                        onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Deskripsi')"
                        class="border-b border-gray-200 cursor-pointer hover:bg-blue-50">

                        <td class="px-4 py-4">{{ $i+1 }}</td>
                        <td class="px-4 py-4 font-medium text-[#192853]">{{ $e['nama'] }}</td>
                        <td class="px-4 py-4">{{ $e['tanggal'] }}</td>
                        <td class="px-4 py-4">{{ $e['panitia'] }}</td>
                        <td class="px-4 py-4">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                {{ $e['kategori'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-green-600 text-xs">Aktif</td>
                        <td class="aksiCell hidden"></td>
                    </tr>
                    @endforeach

                    <!-- DITOLAK -->
                    @foreach ($eventDitolak as $i => $e)
                    <tr data-status="ditolak"
                        class="border-b border-gray-200 hidden cursor-pointer hover:bg-blue-50">

                        <td class="px-4 py-4">{{ $i+1 }}</td>
                        <td class="px-4 py-4 font-medium text-[#192853]">{{ $e['nama'] }}</td>
                        <td class="px-4 py-4">{{ $e['tanggal'] }}</td>
                        <td class="px-4 py-4">{{ $e['panitia'] }}</td>
                        <td class="px-4 py-4">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                {{ $e['kategori'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-red-500 text-xs">{{ $e['alasan'] }}</td>
                        <td class="aksiCell hidden"></td>
                    </tr>
                    @endforeach

                    <!-- PENDING -->
                    @foreach ($eventPending as $i => $e)
                    <tr data-status="pending"
                        class="border-b border-gray-200 hidden cursor-pointer hover:bg-blue-50">

                        <td class="px-4 py-4">{{ $i+1 }}</td>
                        <td class="px-4 py-4 font-medium text-[#192853]">{{ $e['nama'] }}</td>
                        <td class="px-4 py-4">{{ $e['tanggal'] }}</td>
                        <td class="px-4 py-4">{{ $e['panitia'] }}</td>
                        <td class="px-4 py-4">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                {{ $e['kategori'] }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-yellow-500 text-xs">Menunggu</td>

                        <td class="aksiCell hidden">
                            <div class="flex gap-2">
                                <button class="bg-green-100 text-green-600 px-3 py-1 rounded">✔</button>
                                <button onclick="openRejectModal()" class="bg-red-100 text-red-500 px-3 py-1 rounded">✖</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- JS -->
<script>
    document.addEventListener("DOMContentLoaded", () => {

        const buttons = document.querySelectorAll(".tab-btn");

        buttons.forEach(btn => {
            btn.addEventListener("click", () => {

                buttons.forEach(b => {
                    b.classList.remove("bg-[#192853]", "text-white");
                    b.classList.add("bg-white", "text-yellow-400");
                });

                btn.classList.remove("bg-white", "text-yellow-400");
                btn.classList.add("bg-[#192853]", "text-white");

                const status = btn.dataset.status;

                document.querySelectorAll("#tableBody tr").forEach(row => {
                    row.classList.toggle("hidden", row.dataset.status !== status);
                });

                document.getElementById("aksiHeader")
                    .classList.toggle("hidden", status !== "pending");

                document.querySelectorAll(".aksiCell").forEach(td => {
                    td.classList.toggle("hidden", status !== "pending");
                });

            });
        });

    });
</script>

@endsection