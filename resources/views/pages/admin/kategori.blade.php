@extends('layouts.app')

@section('content')
<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">

<h1 class="text-[18px] font-semibold mb-6">Kategori Event</h1>

<div class="bg-white rounded-[16px] border border-[#e6eef8] shadow p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-5">
        <h2 class="text-sm font-semibold">Buat Kategori</h2>

        <button type="button" onclick="openModal()"
            class="flex items-center gap-2 bg-[#192853] text-yellow-400 px-3 py-2 rounded-lg text-sm hover:bg-[#0f1a35] transition">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah
        </button>
    </div>

    <!-- SCROLL TABLE -->
    <div class="max-h-[65vh] overflow-y-auto overflow-x-auto rounded-lg border">

        <table class="w-full text-sm border-collapse">

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
</script>

</div>
@endsection