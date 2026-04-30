@extends('layouts.app')

@section('content')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e5e7eb;
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #d1d5db;
    }
</style>

<div style="font-family: 'Poppins', sans-serif; font-weight: bold;">


    <!-- HEADER -->
    <h1 class="text-lg font-semibold mb-3">Beranda</h1>

    <!-- CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

        <div class="bg-white p-5 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-pointer flex flex-col items-center text-center">
            <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center mb-3 text-xl">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">Total Pengunjung</div>
            <div class="text-2xl font-bold">1,248</div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-pointer flex flex-col items-center text-center">
            <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center mb-3 text-xl">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">Total Panitia</div>
            <div class="text-2xl font-bold">20</div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-pointer flex flex-col items-center text-center">
            <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center mb-3 text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">Total Event</div>
            <div class="text-2xl font-bold">98</div>
        </div>

    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

        <!-- LEFT -->
        <div class="lg:col-span-2 flex flex-col">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex-1 flex flex-col transition-all duration-300 hover:shadow-md">
                <!-- HEADER & SEARCH -->
                <div class="p-4 border-b border-gray-50 bg-gray-50/30">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xs font-bold text-[#192853] uppercase tracking-wider">Event Disetujui</h2>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchEvent" placeholder="Cari event..." 
                            class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all shadow-sm">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div id="eventList" class="h-[450px] overflow-y-auto p-3 space-y-2 custom-scrollbar">

                    @foreach ($events as $event)
                    <div 
                        class="event-card flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 cursor-pointer border border-gray-100 text-xs transition-all hover:border-blue-200 active:scale-[0.98]"
                        data-modal-target="modal" data-modal-toggle="modal"
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
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-[#192853] uppercase tracking-wider">Statistik Pengunjung</h3>
                    <div class="bg-yellow-50 text-yellow-600 p-1.5 rounded-lg text-xs">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                </div>

                <div class="h-[150px]">
                    <canvas id="visitorChart"></canvas>
                </div>
            </div>

            <!-- PIE CHART -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-[#192853] uppercase tracking-wider">Event Berdasarkan Kategori</h3>
                    <div class="bg-yellow-50 text-yellow-600 p-1.5 rounded-lg text-xs">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>

                <div class="relative h-[180px] flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-2xl font-black text-[#192853]">98</span>
                        <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest">Total</span>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-x-4 gap-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#bfdbfe]"></div>
                            <span class="text-[10px] text-gray-500 font-medium">Workshop</span>
                        </div>
                        <span class="text-[10px] font-bold text-[#192853]">30</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#60a5fa]"></div>
                            <span class="text-[10px] text-gray-500 font-medium">Seminar</span>
                        </div>
                        <span class="text-[10px] font-bold text-[#192853]">25</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#3b82f6]"></div>
                            <span class="text-[10px] text-gray-500 font-medium">Festival</span>
                        </div>
                        <span class="text-[10px] font-bold text-[#192853]">22</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-[#1d4ed8]"></div>
                            <span class="text-[10px] text-gray-500 font-medium">Konser</span>
                        </div>
                        <span class="text-[10px] font-bold text-[#192853]">21</span>
                    </div>
                </div>
            </div>

        </div>

    </div>


<!-- MODAL -->
<div id="modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <div class="relative bg-white w-full rounded-lg shadow-xl overflow-hidden">

            <div class="bg-[#192853] p-3 flex justify-between">
                <div>
                    <h3 id="m_nama" class="text-yellow-400 font-semibold text-sm"></h3>
                    <p id="m_kategori" class="text-white/60 text-xs"></p>
                </div>
                <button type="button" data-modal-hide="modal" class="text-white text-lg">&times;</button>
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

    // PIE CHART -> DOUGHNUT
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: ['Workshop','Seminar','Festival','Konser'],
            datasets: [{
                data: [30, 25, 22, 21],
                backgroundColor: [
                    '#bfdbfe', // blue-200
                    '#60a5fa', // blue-400
                    '#3b82f6', // blue-500
                    '#1d4ed8'  // blue-700
                ],
                borderWidth: 0,
                hoverOffset: 10,
                borderRadius: 4,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#192853',
                    titleFont: { size: 12, weight: 'bold', family: 'Poppins' },
                    bodyFont: { size: 11, family: 'Poppins' },
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true,
                    boxPadding: 6
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
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
    }

    document.getElementById('modal').addEventListener('click', function(e) {
        if (e.target === this) {
             const modal = FlowbiteInstances.getInstance('Modal', 'modal');
             if (modal) modal.hide();
        }
    });

    // SEARCH EVENT
    document.getElementById('searchEvent').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        let cards = document.querySelectorAll('.event-card');
        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            card.style.display = text.includes(value) ? 'flex' : 'none';
        });
    });
</script>

</div>
@endsection