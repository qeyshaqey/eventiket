@extends('layouts.app')

@section('content')

<h1 class="text-[18px] font-semibold mb-6">Data Pengunjung</h1>

<div class="bg-white rounded-[16px] border border-[#e6eef8] shadow p-6">

    <div class="flex justify-between items-center mb-5">
        <h2 class="text-sm font-semibold">Kategori Event</h2>

        <button onclick="openModal()"
            class="bg-[#192853] text-yellow-400 px-4 py-2 rounded-lg text-sm hover:bg-[#0f1a35]">
            + Tambah
        </button>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="text-gray-400 border-b">
                <th class="py-3">No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($kategori as $k)
            <tr class="border-b text-center hover:bg-[#f9fbff]">
                <td class="py-3">{{ $loop->iteration }}</td>
                <td>{{ $k['nama_kategori'] }}</td>

                <td class="space-x-2">

                    <button
                        onclick='editData({{ $k["id"] }}, @json($k["nama_kategori"]))'
                        class="bg-blue-100 text-blue-500 p-2 rounded-md hover:bg-blue-200">
                        ✏️
                    </button>

                    <a href="{{ route('kategori.delete', $k['id']) }}">
                        <button class="bg-red-100 text-red-500 p-2 rounded-md hover:bg-red-200">
                            🗑️
                        </button>
                    </a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">

    <div id="modalBox"
        class="bg-white w-full max-w-sm rounded-xl p-6 shadow-xl scale-95 opacity-0 transition">

        <h3 class="text-sm font-semibold mb-4">Kategori Event</h3>

        <form method="POST" action="{{ route('kategori.store') }}">
            @csrf

            <input type="hidden" name="id" id="id">

            <input type="text" name="nama" id="nama"
                class="w-full border rounded-lg p-2 mb-4"
                placeholder="Nama kategori">

            <div class="flex justify-end gap-2">
                <button class="bg-[#192853] text-yellow-400 px-4 py-2 rounded">
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
</script>

@endsection