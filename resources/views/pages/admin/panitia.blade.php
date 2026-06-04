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



    <!-- ================= TERIMA ================= -->
    <div id="k" class="bg-white p-5 rounded-xl shadow border">
        <!-- Sub Tabs inside Panitia Aktif -->
        <div class="flex gap-2 mb-4 border-b pb-3">
            <button id="sub1" onclick="subTab('aktif')" class="px-4 py-2 text-xs rounded-full border bg-[#192853] text-white transition-all font-bold">
                Semua Panitia
            </button>
            <button id="sub2" onclick="subTab('diturunkan')" class="px-4 py-2 text-xs rounded-full border bg-white text-yellow-400 transition-all font-bold">
                Riwayat Diturunkan
            </button>
        </div>

        <div class="mb-3">
            <div class="relative">
                <input type="text" id="searchKelola" placeholder="Cari panitia..."
                    class="w-full pl-10 pr-4 py-2 border rounded-lg text-sm font-bold">
                <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <!-- TABLE 1: Panitia Aktif -->
        <div id="divAktif" class="max-h-[65vh] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tableKelola">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">Organisasi</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasAktif = false;
                        foreach($kelola as $d) {
                            if($d['status'] === 'Aktif') {
                                $hasAktif = true;
                                break;
                            }
                        }
                    @endphp

                    @if(!$hasAktif)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="7" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @php $idx1 = 1; @endphp
                    @foreach($kelola as $d)
                    @if($d['status'] === 'Aktif')
                    <tr class="bg-white hover:bg-gray-50 transition shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $idx1++ }}</td>
                        <td class="py-4 px-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="py-4 px-3">{{ $d['nama_organisasi'] }}</td>
                        <td class="py-4 px-3">
                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600 font-bold">
                                {{ $d['status'] }}
                            </span>
                        </td>
                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
                            <div class="flex justify-center">
                                <button data-modal-target="modalTurunkan" data-modal-toggle="modalTurunkan" onclick="openDemoteModal('{{ $d['nama'] }}', '{{ $d['id'] }}')" 
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-orange-100 text-orange-600 hover:bg-orange-200 transition" title="Turunkan Jabatan">
                                    <i class="fa-solid fa-user-minus"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- TABLE 2: Riwayat Diturunkan -->
        <div id="divDiturunkan" class="max-h-[65vh] overflow-y-auto overflow-x-auto hidden">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tableDiturunkan">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">Organisasi</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $hasNonaktif = false;
                        foreach($kelola as $d) {
                            if($d['status'] === 'Nonaktif') {
                                $hasNonaktif = true;
                                break;
                            }
                        }
                    @endphp

                    @if(!$hasNonaktif)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="6" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @php $idx2 = 1; @endphp
                    @foreach($kelola as $d)
                    @if($d['status'] === 'Nonaktif')
                    <tr class="bg-white hover:bg-gray-50 transition shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $idx2++ }}</td>
                        <td class="py-4 px-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="py-4 px-3">{{ $d['nama_organisasi'] }}</td>
                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
                            <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600 font-bold">
                                Diturunkan
                            </span>
                        </td>
                    </tr>
                    @endif
                    @endforeach
                    @endif
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

        <div class="max-h-[65vh] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tableDitolak">

                <!-- HEADER FIX -->
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">Organisasi</th>
                        <th class="p-3 text-left">Alasan</th>
                    </tr>
                </thead>

                <!-- BODY FIX -->
                <tbody id="tbodyDitolak">
                    @if(count($ditolak) == 0)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="6" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach($ditolak as $i => $d)
                    <tr class="bg-white hover:bg-gray-50 transition shadow-sm">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="py-4 px-3">{{ $d['nama_organisasi'] }}</td>
                        <td class="py-4 px-3 text-red-500 font-medium first:rounded-l-lg last:rounded-r-lg">{{ $d['alasan'] }}</td>
                    </tr>
                    @endforeach
                    @endif
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

        <div class="max-h-[65vh] overflow-y-auto overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-y-1" id="tablePengajuan">
                <thead class="text-gray-500 border-b bg-gray-50 sticky top-0">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">NIM</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Organisasi</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @if(count($pengajuan) == 0)
                    <tr class="empty-row bg-white cursor-default">
                        <td colspan="7" class="py-12 px-4 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-300 opacity-70">
                                <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                                <p class="text-2xl font-bold drop-shadow-sm">Data tidak tersedia</p>
                            </div>
                        </td>
                    </tr>
                    @else
                    @foreach($pengajuan as $i => $d)
                    <tr class="bg-white hover:bg-gray-50 transition cursor-pointer shadow-sm" onclick="openDetailModal({{ json_encode($d) }})">
                        <td class="py-4 px-3 text-center first:rounded-l-lg last:rounded-r-lg">{{ $i+1 }}</td>
                        <td class="py-4 px-3 font-medium text-gray-700">{{ $d['nama'] }}</td>
                        <td class="py-4 px-3 text-gray-500">{{ $d['email'] }}</td>
                        <td class="py-4 px-3 text-gray-600">{{ $d['nim'] }}</td>
                        <td class="py-4 px-3">{{ $d['tanggal'] }}</td>
                        <td class="py-4 px-3">{{ $d['nama_organisasi'] }}</td>

                        <td class="py-4 px-3 first:rounded-l-lg last:rounded-r-lg">
                            <div class="flex gap-2 justify-center" onclick="event.stopPropagation()">
                                <form action="{{ route('admin.data.panitia.approve', $d['id']) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center rounded-lg bg-green-100 text-green-600 hover:bg-green-200 transition">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>

                                <button data-modal-target="modalTolak" data-modal-toggle="modalTolak" onclick="openModal('{{ $d['nama'] }}', '{{ $d['id'] }}')"
                                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-100 text-red-500 hover:bg-red-200 transition">
                                    <i class="fa-solid fa-xmark"></i>
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

<!-- ================= MODAL ================= -->
<div id="modalTolak" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <div class="fixed inset-0 bg-black/40" data-modal-hide="modalTolak"></div>

        <form id="formTolak" method="POST" class="relative bg-white rounded-xl shadow-lg w-full p-5 text-left">
            @csrf
            <h2 class="text-base font-semibold text-gray-700 mb-2">Alasan Penolakan</h2>
            <p id="namaPanitia" class="text-sm text-gray-500 mb-3"></p>

            <div class="space-y-2 mb-3">
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="radio" name="alasan_opsi" value="Data identitas (NIM/Email) tidak valid atau tidak terdaftar." onchange="setAlasanPanitia(this.value)" class="mt-1" required>
                    <span class="text-sm text-gray-600 leading-tight">Data identitas (NIM/Email) tidak valid atau tidak terdaftar.</span>
                </label>
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="radio" name="alasan_opsi" value="Terdapat kesalahan atau ketidaksesuaian pada pengisian asal UKM/Organisasi." onchange="setAlasanPanitia(this.value)" class="mt-1">
                    <span class="text-sm text-gray-600 leading-tight">Kesalahan/ketidaksesuaian pada asal UKM/Organisasi.</span>
                </label>
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="radio" name="alasan_opsi" value="Kuota panitia untuk posisi/event ini sudah penuh." onchange="setAlasanPanitia(this.value)" class="mt-1">
                    <span class="text-sm text-gray-600 leading-tight">Kuota panitia untuk posisi/event ini sudah penuh.</span>
                </label>
                <label class="flex items-start gap-2 cursor-pointer">
                    <input type="radio" name="alasan_opsi" value="lainnya" onchange="setAlasanPanitia('lainnya')" class="mt-1">
                    <span class="text-sm text-gray-600 leading-tight">Alasan Lainnya:</span>
                </label>
            </div>

            <textarea id="alasanInput" name="alasan_penolakan" required
                class="w-full border rounded-lg p-2 text-sm focus:ring-1 focus:ring-red-400 hidden"
                placeholder="Ketik alasan lainnya di sini..."></textarea>

            <div class="flex justify-end gap-2 mt-4">
                <button type="button" data-modal-hide="modalTolak" class="px-3 py-1.5 text-sm rounded-lg bg-gray-200">Batal</button>
                <button type="submit" 
                    class="px-3 py-1.5 text-sm rounded-lg bg-[#192853] text-yellow-400 hover:bg-[#0f1a3a] transition">
                    Kirim
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL DETAIL EVENT ================= -->
<div id="modalDetail" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-black/50 hidden z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-md h-full md:h-auto flex items-center justify-center">
        <div class="relative bg-white rounded-2xl w-full shadow-lg overflow-hidden border border-gray-100">
            
            <!-- Header -->
            <div class="bg-[#192853] p-4 flex justify-between items-center">
                <h3 id="detEvent" class="text-yellow-400 font-bold text-lg"></h3>
                <button type="button" data-modal-hide="modalDetail" class="text-white hover:text-gray-300 transition text-2xl">&times;</button>
            </div>

            <!-- Body -->
            <div class="p-6 text-sm space-y-4 text-gray-700">
                <div class="grid grid-cols-12 items-start">
                    <b class="col-span-4 text-gray-900">Pendaftar</b> 
                    <span id="detNama" class="col-span-8 font-medium text-[#192853]"></span>
                </div>
                <div class="grid grid-cols-12 items-start">
                    <b class="col-span-4 text-gray-900">NIM / Email</b> 
                    <span id="detIdentitas" class="col-span-8 text-gray-600"></span>
                </div>
                <div class="grid grid-cols-12 items-start">
                    <b class="col-span-4 text-gray-900">Organisasi</b> 
                    <span id="detOrganisasi" class="col-span-8 text-gray-600"></span>
                </div>
                <hr class="border-gray-50">
                <div class="grid grid-cols-12 items-start">
                    <b class="col-span-4 text-gray-900">Kategori</b> 
                    <div class="col-span-8">
                        <span id="detKategori" class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold uppercase tracking-wider"></span>
                    </div>
                </div>
                <div class="grid grid-cols-12 items-start">
                    <b class="col-span-4 text-gray-900">Rencana Tgl</b> 
                    <span id="detTgl" class="col-span-8 text-gray-600"></span>
                </div>
                <div class="flex flex-col gap-2 pt-2">
                    <b class="text-gray-900 font-bold">Deskripsi Singkat</b>
                    <p id="detDeskripsi" class="bg-slate-50 p-4 rounded-2xl italic leading-relaxed text-gray-600 border border-slate-100 text-[13px]"></p>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= MODAL TURUNKAN ================= -->
<div id="modalTurunkan" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden z-50 items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <div class="fixed inset-0 bg-black/40" data-modal-hide="modalTurunkan"></div>

        <div class="relative bg-white rounded-xl shadow-lg w-full p-6 text-center">
            <div class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-user-minus text-2xl"></i>
            </div>
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Turunkan Jabatan?</h2>
            <p class="text-sm text-gray-500 mb-6">Apakah Anda yakin ingin menurunkan jabatan <span id="namaPanitiaTurunkan" class="font-bold text-gray-700"></span> dari daftar panitia aktif?</p>

            <form id="formTurunkan" method="POST" class="flex justify-center gap-3">
                @csrf
                <button type="button" data-modal-hide="modalTurunkan" 
                    class="px-6 py-2 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="submit" 
                    class="px-6 py-2 text-sm font-medium rounded-lg bg-orange-500 text-white hover:bg-orange-600 transition shadow-md shadow-orange-200">
                    Iya, Turunkan
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    <x-admin.tab-search-script />

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('tab')) {
        tab(urlParams.get('tab'));
    }

    setupSearch('searchKelola', 'tableKelola');
    setupSearch('searchKelola', 'tableDiturunkan');
    setupSearch('searchPengajuan', 'tablePengajuan');
    setupSearch('searchDitolak', 'tableDitolak');

    // MODAL
    let selectedNama = '';

    function setAlasanPanitia(val) {
        let textarea = document.getElementById('alasanInput');
        if(val === 'lainnya') {
            textarea.classList.remove('hidden');
            textarea.value = '';
            textarea.focus();
        } else {
            textarea.classList.add('hidden');
            textarea.value = val;
        }
    }

    function openModal(nama, id) {
        selectedNama = nama;
        document.getElementById('namaPanitia').innerText = "Nama: " + nama;
        let form = document.getElementById('formTolak');
        form.action = "/admin/data-panitia/reject/" + id;
        
        // Reset form
        form.reset();
        document.getElementById('alasanInput').classList.add('hidden');
    }

    function closeModal() {
        document.getElementById('alasanInput').value = '';
        const modal = FlowbiteInstances.getInstance('Modal', 'modalTolak');
        if (modal) modal.hide();
    }

    // MODAL DETAIL
    function openDetailModal(data) {
        document.getElementById('detNama').innerText = data.nama;
        document.getElementById('detIdentitas').innerText = data.nim + " / " + data.email;
        document.getElementById('detOrganisasi').innerText = data.nama_organisasi;
        document.getElementById('detEvent').innerText = data.event_nama;
        document.getElementById('detKategori').innerText = data.kategori_event;
        document.getElementById('detTgl').innerText = data.tgl_event;
        document.getElementById('detDeskripsi').innerText = data.deskripsi;

        const modalEl = document.getElementById('modalDetail');
        modalEl.classList.remove('hidden');
        modalEl.classList.add('flex');
    }

    // Close logic for all modals with data-modal-hide
    document.querySelectorAll('[data-modal-hide]').forEach(btn => {
        btn.addEventListener('click', () => {
            const modalId = btn.getAttribute('data-modal-hide');
            const modalEl = document.getElementById(modalId);
            modalEl.classList.add('hidden');
            modalEl.classList.remove('flex');
        });
    });

    // SUB TAB
    function subTab(type) {
        const divAktif = document.getElementById('divAktif');
        const divDiturunkan = document.getElementById('divDiturunkan');
        const sub1 = document.getElementById('sub1');
        const sub2 = document.getElementById('sub2');

        if (type === 'aktif') {
            divAktif.classList.remove('hidden');
            divDiturunkan.classList.add('hidden');
            sub1.classList.remove('bg-white', 'text-yellow-400');
            sub1.classList.add('bg-[#192853]', 'text-white');
            sub2.classList.remove('bg-[#192853]', 'text-white');
            sub2.classList.add('bg-white', 'text-yellow-400');
        } else {
            divAktif.classList.add('hidden');
            divDiturunkan.classList.remove('hidden');
            sub2.classList.remove('bg-white', 'text-yellow-400');
            sub2.classList.add('bg-[#192853]', 'text-white');
            sub1.classList.remove('bg-[#192853]', 'text-white');
            sub1.classList.add('bg-white', 'text-yellow-400');
        }
    }

    // MODAL TURUNKAN
    let demoteNama = '';

    function openDemoteModal(nama, id) {
        demoteNama = nama;
        document.getElementById('namaPanitiaTurunkan').innerText = nama;
        document.getElementById('formTurunkan').action = "/admin/data-panitia/demote/" + id;
    }

    function closeDemoteModal() {
        const modalEl = document.getElementById('modalTurunkan');
        modalEl.classList.add('hidden');
        modalEl.classList.remove('flex');
    }


</script>

</div>
@endsection