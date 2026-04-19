@extends('layouts.app')

@section('content')


    <!-- HEADER -->
    <h1 class="text-lg font-semibold mb-3">Beranda</h1>

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">

        <div class="bg-white p-3 rounded-lg shadow-sm">
            <div class="text-[10px] text-gray-500 uppercase">Total Pengunjung</div>
            <div class="text-xl font-semibold">1248</div>
        </div>

        <div class="bg-white p-3 rounded-lg shadow-sm">
            <div class="text-[10px] text-gray-500 uppercase">Total Panitia</div>
            <div class="text-xl font-semibold">20</div>
        </div>

        <div class="bg-white p-3 rounded-lg shadow-sm">
            <div class="text-[10px] text-gray-500 uppercase">Total Event</div>
            <div class="text-xl font-semibold">15</div>
        </div>

    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

        <!-- LEFT -->
        <div class="lg:col-span-2">

            <h2 class="text-xs font-semibold mb-2">Event Disetujui</h2>

            <div class="bg-white rounded-lg shadow-sm">
                <div class="max-h-[400px] overflow-y-auto p-2 space-y-2">

                    @foreach ($events as $event)
                    <div 
                        class="flex items-center gap-2 p-2 rounded-lg hover:bg-blue-50 cursor-pointer border text-xs transition active:scale-[0.97]"
                        onclick='showModal(
                            @json($event["nama"]),
                            @json($event["kategori"]),
                            @json($event["tanggal"]),
                            @json($event["waktu"]),
                            @json($event["lokasi"]),
                            @json($event["deskripsi"])
                        )'
                    >

                        <!-- TANGGAL -->
                        <div class="bg-[#192853] text-yellow-400 font-semibold px-2 py-1 rounded text-center min-w-[50px] text-[10px]">
                            {{ $event['tanggal'] }}
                        </div>

                        <!-- INFO -->
                        <div class="flex-1">
                            <div class="font-semibold">{{ $event['nama'] }}</div>
                            <div class="text-gray-500 text-[10px]">
                                {{ $event['lokasi'] }} • {{ $event['waktu'] }}
                            </div>
                        </div>

                        <!-- KATEGORI -->
                        <span class="bg-yellow-200 px-2 py-0.5 rounded-full text-[10px]">
                            {{ $event['kategori'] }}
                        </span>

                    </div>
                    @endforeach

                </div>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="space-y-3">

            <!-- LINE CHART -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <h3 class="text-xs font-semibold mb-2">Statistik Pengunjung</h3>

                <div class="h-[150px]">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>

            <!-- PIE CHART -->
            <div class="bg-white p-3 rounded-lg shadow-sm">
                <h3 class="text-xs font-semibold mb-2">Event Berdasarkan Kategori</h3>

                <div class="h-[170px]">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

        </div>

    </div>


<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-sm rounded-lg shadow-xl overflow-hidden">

        <div class="bg-[#192853] p-3 flex justify-between">
            <div>
                <h3 id="m_nama" class="text-yellow-400 font-semibold text-sm"></h3>
                <p id="m_kategori" class="text-white/60 text-xs"></p>
            </div>
            <button onclick="closeModal()" class="text-white text-lg">&times;</button>
        </div>

        <div class="p-3 space-y-2 text-xs">

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
                <span class="text-gray-500">Deskripsi</span>
                <p id="m_deskripsi"></p>
            </div>

        </div>

    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // LINE CHART
    new Chart(document.getElementById('visitorChart'), {
        type: 'line',
        data: {
            labels: ['17 Apr','18 Apr','19 Apr','20 Apr','21 Apr','22 Apr','23 Apr'],
            datasets: [{
                data: [140,130,145,160,190,195,250],
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59,130,246,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    // PIE CHART
    new Chart(document.getElementById('categoryChart'), {
        type: 'pie',
        data: {
            labels: ['Workshop','Seminar','Festival','Konser'],
            datasets: [{
                data: [30,25,22,21],
                backgroundColor: ['#3b82f6','#8b5cf6','#facc15','#f87171']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // MODAL
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