@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<h1 class="text-[18px] font-semibold mb-6">Kategori Event</h1>

<div class="bg-white rounded-[16px] border border-[#e6eef8] shadow p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-5">
        <div class="w-full md:flex-1">
            <div class="relative">
                <input type="text" id="searchKategori" placeholder="Cari kategori..." 
                    class="w-full pl-10 pr-4 py-2 border rounded-xl text-sm focus:ring-1 focus:ring-[#192853] outline-none font-normal">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <button type="button" onclick="openModal()"
            class="flex items-center gap-2 bg-[#192853] text-yellow-400 px-4 py-2 rounded-xl text-sm hover:bg-[#0f1a35] transition shrink-0">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Kategori
        </button>
    </div>

    <!-- SCROLL TABLE -->
    <div class="max-h-[65vh] overflow-y-auto overflow-x-auto rounded-lg border">

        <table class="w-full text-sm border-collapse" id="tableKategori">

            <!-- HEADER (STICKY) -->
            <thead class="sticky top-0 bg-white z-10">
                <tr class="text-gray-500 border-b">
                    <th class="py-3 text-left pl-4 w-12">No</th>
                    <th class="py-3 text-center">Nama Kategori</th>
                    <th class="py-3 text-right pr-6 w-32">Aksi</th>
                </tr>
            </thead>

            <!-- BODY -->
            <tbody>
                @foreach ($kategori as $k)
                <tr class="border-b hover:bg-[#f9fbff] transition">

                    <!-- NO -->
                    <td class="py-3 pl-4 text-left">
                        {{ $loop->iteration }}
                    </td>

                    <!-- NAMA -->
                    <td class="text-center">
                        {{ $k['nama_kategori'] }}
                    </td>

                    <!-- AKSI -->
                    <td class="py-3 pr-6 text-right">
                        <div class="inline-flex gap-2">

                            <!-- EDIT -->
                            <button
                                onclick='editData({{ $k["id"] }}, @json($k["nama_kategori"]))'
                                class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-500/10 text-blue-500 hover:bg-blue-100 transition">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            <!-- DELETE -->
                            <button
                                onclick='openDeleteModal({{ $k["id"] }}, @json($k["nama_kategori"]))'
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

</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div id="modalBox"
        class="bg-white w-full max-w-sm rounded-xl p-6 shadow-xl scale-95 opacity-0 transition mx-4">

        <h3 class="text-sm font-semibold mb-4">Kategori Event</h3>

        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf

            <input type="hidden" name="id" id="id">

            <input type="text" name="nama" id="nama"
                class="w-full border rounded-lg p-2 mb-4"
                placeholder="Nama kategori">

            <div class="flex justify-end gap-2">
                <button type="submit"
                    class="bg-[#192853] text-yellow-400 px-4 py-2 rounded">
                    Simpan
                </button>

                <button type="button" onclick="closeModal()"
                    class="bg-gray-300 px-4 py-2 rounded">
                    Batal
                </button>
            </div>
        </form>
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
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Hapus Kategori?</h2>
        <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menghapus kategori <span id="namaKategoriHapus" class="font-bold text-gray-700"></span>?</p>

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

<!-- SCRIPT -->
<script>
const modal = document.getElementById('modal')
const modalBox = document.getElementById('modalBox')
const nama = document.getElementById('nama')
const idInput = document.getElementById('id')

function openModal() {
    modal.classList.remove('hidden')
    modal.classList.add('flex')

    setTimeout(() => {
        modalBox.classList.remove('scale-95', 'opacity-0')
    }, 10)

    nama.value = ''
    idInput.value = ''
}

function closeModal() {
    modalBox.classList.add('scale-95', 'opacity-0')

    setTimeout(() => {
        modal.classList.add('hidden')
    }, 150)
}

function editData(id, namaVal) {
    openModal()
    nama.value = namaVal
    idInput.value = id
}

modal.addEventListener('click', function(e) {
    if (e.target === modal) closeModal()
})

// MODAL HAPUS
let deleteId = null;

function openDeleteModal(id, namaVal) {
    deleteId = id;
    document.getElementById('namaKategoriHapus').innerText = namaVal;
    document.getElementById('modalHapus').classList.remove('hidden');
    document.getElementById('modalHapus').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('modalHapus').classList.add('hidden');
    document.getElementById('modalHapus').classList.remove('flex');
}

    function confirmDelete() {
        if (deleteId) {
            console.log("Menghapus kategori dengan ID:", deleteId);
            // Logika hapus bisa diarahkan ke route delete jika sudah ada
        }
        closeDeleteModal();
    }

    // SEARCH
    <x-admin.tab-search-script />
    setupSearch('searchKategori', 'tableKategori');
</script>

</div>
@endsection