@extends('layouts.app')
@section('content')

    <div class=" p-8">

        <!-- TOPBAR -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Dashboard</h1>
        </div>

               <!-- CARDS -->
        <div class="grid grid-cols-3 gap-5 mb-6">

            <div class="bg-white p-5 rounded-xl border shadow">
                <div class="text-xs text-gray-500 mb-2 uppercase">Total Pengunjung</div>
                <div class="text-3xl font-semibold">1248</div>
            </div>

            <div class="bg-white p-5 rounded-xl border shadow">
                <div class="text-xs text-gray-500 mb-2 uppercase">Total Panitia</div>
                <div class="text-3xl font-semibold">20</div>
            </div>

            <div class="bg-white p-5 rounded-xl border shadow">
                <div class="text-xs text-gray-500 mb-2 uppercase">Total Event</div>
                <div class="text-3xl font-semibold">15</div>
            </div>

        </div>

        <!-- EVENT -->
        <div class="mb-3 flex justify-between items-center">
            <h2 class="text-sm font-semibold">Event Disetujui</h2>
        </div>

        <div class="bg-white rounded-xl border shadow">
            <div class="max-h-[360px] overflow-y-auto p-3 space-y-2">

                @foreach ($events as $event)
                <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer hover:bg-[#EFF8FF] border border-transparent hover:border-[#c8dff5]"
                    onclick='showModal(
          @json($event["nama"]),
          @json($event["kategori"]),
          @json($event["tanggal"]),
          @json($event["waktu"]),
          @json($event["lokasi"]),
          @json($event["deskripsi"])
        )'>

                    <div class="bg-[#192853] text-yellow-400 text-xs font-semibold px-3 py-2 rounded text-center min-w-[55px]">
                        {{ $event['tanggal'] }}
                    </div>

                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ $event['nama'] }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $event['lokasi'] }} • {{ $event['waktu'] }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs bg-yellow-200 px-3 py-1 rounded-full">
                            {{ $event['kategori'] }}
                        </span>
                        <span class="text-gray-400 text-lg">›</span>
                    </div>

                </div>
                @endforeach

            </div>
        </div>

    </div>

    <!-- MODAL -->
    <div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

            <div class="bg-[#192853] p-5 flex justify-between items-start">
                <div>
                    <h3 id="m_nama" class="text-yellow-400 font-semibold"></h3>
                    <p id="m_kategori" class="text-white/50 text-sm"></p>
                </div>
                <button onclick="closeModal()" class="text-white text-xl">&times;</button>
            </div>

            <div class="p-5 space-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal</span>
                    <span id="m_tanggal"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Waktu</span>
                    <span id="m_waktu"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Lokasi</span>
                    <span id="m_lokasi"></span>
                </div>

                <div>
                    <span class="text-gray-500 block mb-1">Deskripsi</span>
                    <p id="m_deskripsi"></p>
                </div>

            </div>

        </div>
    </div>


    <script>
        function showModal(nama, kategori, tanggal, waktu, lokasi, deskripsi) {
            document.getElementById('m_nama').textContent = nama;
            document.getElementById('m_kategori').textContent = kategori;
            document.getElementById('m_tanggal').textContent = tanggal;
            document.getElementById('m_waktu').textContent = waktu;
            document.getElementById('m_lokasi').textContent = lokasi;
            document.getElementById('m_deskripsi').textContent = deskripsi;

            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>


@endsection