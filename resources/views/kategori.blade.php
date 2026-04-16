@extends('layouts.app')

@section('content')

<h1 class="text-[18px] font-semibold mb-6">Kelola Event</h1>

<div class="bg-white rounded-[16px] border border-[#e6eef8] shadow p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-sm font-semibold">Kategori Event</h2>

        <button onclick="openModal()"
            class="bg-[#192853] text-yellow-400 px-4 py-2 rounded-lg text-sm hover:bg-[#0f1a35]">
            + Tambah
        </button>
    </div>

    <!-- TABLE -->
    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="text-gray-500 border-b">

                <th class="py-3 text-left w-12">No</th>
                <th class="py-3 text-center">Nama Kategori</th>
                <th class="py-3 text-right pr-10 w-32">Aksi</th>

            </tr>
        </thead>

        <tbody>
            @foreach ($kategori as $k)
            <tr class="border-b hover:bg-[#f9fbff]">

                <!-- NO -->
                <td class="py-3 text-left">
                    {{ $loop->iteration }}
                </td>

                <!-- NAMA -->
                <td class="text-center">
                    {{ $k['nama_kategori'] }}
                </td>

                <!-- AKSI -->
                <td class="py-3 text-right pr-6">
                    <div class="inline-flex gap-2">

                        <!-- EDIT -->
                        <button
                            onclick='editData({{ $k["id"] }}, @json($k["nama_kategori"]))'
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-100 transition">
                            <i class="fa-solid fa-pen"></i>
                        </button>

                        <!-- DELETE -->
                        <button
                            class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-100 transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection