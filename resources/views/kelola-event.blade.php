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
["nama"=>"Workshop Game Dev","tanggal"=>"15 Mei","panitia"=>"Budi","kategori"=>"Workshop","alasan"=>"Tidak sesuai"],
];

$eventPending = [
["nama"=>"Seminar Kewirausahaan","tanggal"=>"18 Mei","panitia"=>"Fariz","kategori"=>"Seminar"],
["nama"=>"Workshop Mobile App","tanggal"=>"20 Mei","panitia"=>"Laras","kategori"=>"Workshop"],
["nama"=>"Seminar Kepemimpinan","tanggal"=>"22 Mei","panitia"=>"Rizky","kategori"=>"Seminar"],
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

        <!-- SEARCH -->
        <input type="text" placeholder="Cari event..."
            class="w-full mb-6 px-4 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-[#192853]/20">

        <!-- TABLE -->
        <div class="overflow-y-auto max-h-[450px] scroll-smooth">

            <table class="w-full text-sm">

                <!-- HEADER -->
                <thead class="text-gray-400 text-xs uppercase border-b">
                    <tr>
                        <th class="px-4 py-3">No</th>
                        <th class="px-4 py-3 text-left">Nama Event</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-left">Panitia</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Info</th>
                        <th id="aksiHeader" class="px-4 py-3 text-left hidden">Aksi</th>
                    </tr>
                </thead>

                <tbody id="tableBody">

                    <!-- ================= DISETUJUI ================= -->
                    @foreach ($eventDisetujui as $i => $e)
                    <tr data-status="disetujui"
                        onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Deskripsi event')"
                        class="border-b border-gray-200 cursor-pointer hover:bg-blue-50">

                        <td class="px-4 py-3">{{ $i+1 }}</td>
                        <td class="px-4 py-3 font-medium text-[#192853]">{{ $e['nama'] }}</td>
                        <td class="px-4 py-3">{{ $e['tanggal'] }}</td>
                        <td class="px-4 py-3">{{ $e['panitia'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                {{ $e['kategori'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-green-600 text-xs">Aktif</td>
                        <td class="aksiCell hidden"></td>
                    </tr>
                    @endforeach

                    <!-- ================= DITOLAK ================= -->
                    @foreach ($eventDitolak as $i => $e)
                    <tr data-status="ditolak"
                        onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','{{ $e['alasan'] }}')"
                        class="border-b border-gray-200 hidden cursor-pointer hover:bg-blue-50">

                        <td class="px-4 py-3">{{ $i+1 }}</td>
                        <td class="px-4 py-3 font-medium text-[#192853]">{{ $e['nama'] }}</td>
                        <td class="px-4 py-3">{{ $e['tanggal'] }}</td>
                        <td class="px-4 py-3">{{ $e['panitia'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                {{ $e['kategori'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-red-500 text-xs">{{ $e['alasan'] }}</td>
                        <td class="aksiCell hidden"></td>
                    </tr>
                    @endforeach

                    <!-- ================= PENDING ================= -->
                    @foreach ($eventPending as $i => $e)
                    <tr data-status="pending"
                        onclick="showModal('{{ $e['nama'] }}','{{ $e['tanggal'] }}','09:00','Aula','{{ $e['panitia'] }}','Menunggu persetujuan')"
                        class="border-b border-gray-200 hidden cursor-pointer hover:bg-blue-50">

                        <td class="px-4 py-3">{{ $i+1 }}</td>
                        <td class="px-4 py-3 font-medium text-[#192853]">{{ $e['nama'] }}</td>
                        <td class="px-4 py-3">{{ $e['tanggal'] }}</td>
                        <td class="px-4 py-3">{{ $e['panitia'] }}</td>
                        <td class="px-4 py-3">
                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                {{ $e['kategori'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-yellow-500 text-xs">Menunggu</td>

                        <td class="aksiCell hidden">
                            <div class="flex gap-2">
                                <button onclick="event.stopPropagation()"
                                    class="bg-green-100 text-green-600 px-3 py-1 rounded">✔</button>

                                <button onclick="event.stopPropagation(); openRejectModal()"
                                    class="bg-red-100 text-red-500 px-3 py-1 rounded">✖</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-2xl">
        <div class="bg-[#192853] p-5 flex justify-between">
            <h3 id="m_nama" class="text-yellow-400"></h3>
            <button onclick="closeModal()" class="text-white">&times;</button>
        </div>

        <div class="p-5 text-sm space-y-2">
            <p>Tanggal: <span id="m_tanggal"></span></p>
            <p>Waktu: <span id="m_waktu"></span></p>
            <p>Lokasi: <span id="m_lokasi"></span></p>
            <p>Panitia: <span id="m_panitia"></span></p>
            <p>Deskripsi: <span id="m_deskripsi"></span></p>
        </div>
    </div>
</div>

<!-- ================= MODAL REJECT ================= -->
<div id="rejectModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center">
    <div class="bg-white w-full max-w-md rounded-2xl p-6">
        <h2 class="text-lg font-semibold mb-4">Alasan Penolakan</h2>

        <textarea id="rejectInput"
            class="w-full border rounded-lg p-3 text-sm mb-4"
            placeholder="Masukkan alasan..."></textarea>

        <div class="flex justify-end gap-2">
            <button onclick="closeRejectModal()" class="px-4 py-2 bg-gray-200 rounded">Batal</button>
            <button onclick="submitReject()" class="px-4 py-2 bg-[#192853] text-white rounded">Kirim</button>
        </div>
    </div>
</div>

<!-- ================= JS ================= -->
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

                const showAksi = status === "pending";

                document.getElementById("aksiHeader")
                    .classList.toggle("hidden", !showAksi);

                document.querySelectorAll(".aksiCell").forEach(td => {
                    td.classList.toggle("hidden", !showAksi);
                });

            });
        });

    });

    // MODAL
    function showModal(n, t, w, l, p, d) {
        m_nama.innerText = n;
        m_tanggal.innerText = t;
        m_waktu.innerText = w;
        m_lokasi.innerText = l;
        m_panitia.innerText = p;
        m_deskripsi.innerText = d;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }

    function openRejectModal() {
        rejectModal.classList.remove('hidden');
        rejectModal.classList.add('flex');
    }

    function closeRejectModal() {
        rejectModal.classList.add('hidden');
    }

    function submitReject() {
        console.log("Alasan:", rejectInput.value);
        closeRejectModal();
    }
</script>

@endsection