@extends('layouts.app')
@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="p-0">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-[#192853]">Data Panitia</h1>
    </div>

    <!-- TAB -->
    <div class="flex gap-2 mb-4">

        <button id="b1" onclick="tab('k')"
            class="px-4 py-2 text-sm rounded-full border bg-[#192853] text-white transition-all">
            Panitia Aktif
        </button>

        <button id="b2" onclick="tab('t')"
            class="px-4 py-2 text-sm rounded-full border bg-white text-yellow-400 transition-all">
            Ditolak
        </button>

        <button id="b3" onclick="tab('p')"
            class="px-4 py-2 text-sm rounded-full border bg-white text-yellow-400 transition-all">
            Pengajuan Panitia
        </button>

    </div>

    <!-- ================= TERIMA ================= -->
    <div id="k" class="bg-white p-5 rounded-xl shadow border">
        <div class="mb-3">
            <div class="relative">
                <input type="text" id="searchKelola" placeholder="Cari panitia..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-collapse" id="tableKelola">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">UKM</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelola as $i => $d)
                    <tr class="border-b transition">
                        <td class="p-3 text-center">{{ $i+1 }}</td>
                        <td class="p-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="p-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="p-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="p-3">{{ $d['ukm'] }}</td>
                        <td class="p-3">
                            <span class="px-3 py-1 rounded-full text-xs 
                                {{ $d['status'] == 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-gray-200 text-gray-600' }}">
                                {{ $d['status'] }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex justify-center">
                                <button onclick="openDeleteModal('{{ $d['nama'] }}')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
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
                <input type="text" id="searchDitolak" placeholder="Cari panitia ditolak..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="max-h-[400px] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-collapse" id="tableDitolak">

                <!-- HEADER FIX -->
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">UKM</th>
                        <th class="p-3 text-left">Alasan</th>
                    </tr>
                </thead>

                <!-- BODY FIX -->
                <tbody id="tbodyDitolak">
                    @foreach($ditolak as $i => $d)
                    <tr class="border-b transition">
                        <td class="p-3 text-center">{{ $i+1 }}</td>
                        <td class="p-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="p-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="p-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="p-3">{{ $d['ukm'] }}</td>
                        <td class="p-3 text-red-500 font-medium">{{ $d['alasan'] }}</td>
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
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">UKM</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($pengajuan as $i => $d)
                    <tr class="border-b transition">
                        <td class="p-3 text-center">{{ $i+1 }}</td>
                        <td class="p-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="p-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="p-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="p-3">{{ $d['tanggal'] }}</td>
                        <td class="p-3">{{ $d['ukm'] }}</td>

                        <td class="p-3">
                            <div class="flex gap-2 justify-center">
                                <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition">
                                    <i class="fa-solid fa-check"></i>
                                </button>

                                <button onclick="openModal('{{ $d['nama'] }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
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

<!-- ================= MODAL ================= -->
<div id="modalTolak" class="fixed inset-0 hidden z-50 items-center justify-center">
    <div class="absolute inset-0 bg-black/40" onclick="closeModal()"></div>

    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-sm p-5 mx-4">
        <h2 class="text-base font-semibold text-gray-700 mb-2">Alasan Penolakan</h2>
        <p id="namaPanitia" class="text-sm text-gray-500 mb-3"></p>

        <textarea id="alasanInput"
            class="w-full border rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-400"
            placeholder="Masukkan alasan..."></textarea>

        <div class="flex justify-end gap-2 mt-4">
            <button onclick="closeModal()" class="px-3 py-1.5 text-sm rounded-lg bg-gray-200">Batal</button>
            <button onclick="submitAlasan()" 
    class="px-3 py-1.5 text-sm rounded-lg bg-[#192853] text-yellow-400 hover:bg-[#0f1a3a] transition">
    Kirim
</button>
        </div>
    </div>
</div>

<!-- ================= MODAL HAPUS ================= -->
<div id="modalHapus" class="fixed inset-0 hidden z-50 items-center justify-center">
    <div class="absolute inset-0 bg-black/40" onclick="closeDeleteModal()"></div>

    <div class="relative bg-white rounded-xl shadow-lg w-full max-w-sm p-6 mx-4 text-center">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-trash-can text-2xl"></i>
        </div>
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Hapus Panitia?</h2>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus <span id="namaPanitiaHapus" class="font-bold text-gray-700"></span> dari daftar panitia aktif?</p>

        <div class="flex justify-center gap-3">
            <button onclick="closeDeleteModal()" 
                class="px-6 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                Batal
            </button>
            <button onclick="confirmDelete()" 
                class="px-6 py-2 text-sm font-medium rounded-lg bg-red-500 text-white hover:bg-red-600 transition shadow-md shadow-red-200">
                Iya, Hapus
            </button>
        </div>
    </div>
</div>

<script>
    <x-admin.tab-search-script />

    setupSearch('searchKelola', 'tableKelola');
    setupSearch('searchPengajuan', 'tablePengajuan');
    setupSearch('searchDitolak', 'tableDitolak');

    // MODAL
    let selectedNama = '';

    function openModal(nama) {
        selectedNama = nama;
        document.getElementById('modalTolak').classList.remove('hidden');
        document.getElementById('modalTolak').classList.add('flex');
        document.getElementById('namaPanitia').innerText = "Nama: " + nama;
    }

    function closeModal() {
        document.getElementById('modalTolak').classList.add('hidden');
        document.getElementById('modalTolak').classList.remove('flex');
        document.getElementById('alasanInput').value = '';
    }

    // MODAL HAPUS
    let deleteNama = '';

    function openDeleteModal(nama) {
        deleteNama = nama;
        document.getElementById('modalHapus').classList.remove('hidden');
        document.getElementById('modalHapus').classList.add('flex');
        document.getElementById('namaPanitiaHapus').innerText = nama;
    }

    function closeDeleteModal() {
        document.getElementById('modalHapus').classList.add('hidden');
        document.getElementById('modalHapus').classList.remove('flex');
    }

    function confirmDelete() {
        console.log("Menghapus panitia:", deleteNama);
        // Tambahkan logika penghapusan di sini
        closeDeleteModal();
    }

    function submitAlasan() {
        let alasan = document.getElementById('alasanInput').value;

        if (alasan.trim() === '') {
            alert('Alasan wajib diisi!');
            return;
        }

        console.log("Nama:", selectedNama);
        console.log("Alasan:", alasan);

        closeModal();
    }
</script>

</div>
@endsection