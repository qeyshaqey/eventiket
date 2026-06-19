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
            <div class="text-2xl font-bold">{{ number_format($total_pengunjung) }}</div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-pointer flex flex-col items-center text-center">
            <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center mb-3 text-xl">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">Total Panitia</div>
            <div class="text-2xl font-bold">{{ number_format($total_panitia) }}</div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md cursor-pointer flex flex-col items-center text-center">
            <div class="bg-yellow-100 text-yellow-600 w-12 h-12 rounded-full flex items-center justify-center mb-3 text-xl">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="text-[10px] text-gray-500 uppercase tracking-wider mb-1">Total Event</div>
            <div class="text-2xl font-bold">{{ number_format($total_event) }}</div>
        </div>

    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3 items-stretch">

        <!-- LEFT -->
        <div class="lg:col-span-2 flex flex-col h-full">

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex-1 flex flex-col transition-all duration-300 hover:shadow-md h-full">
                <!-- HEADER & SEARCH -->
                <div class="p-4 border-b border-gray-50 bg-gray-50/30">
                    <div class="flex items-center justify-between mb-3">
                        <h2 class="text-xs font-bold text-[#192853] uppercase tracking-wider">Event Aktif Bulan Ini — {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h2>
                    </div>
                    <div class="relative">
                        <input type="text" id="searchEvent" placeholder="Cari event..." 
                            class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none transition-all shadow-sm">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <div id="eventList" class="h-[370px] overflow-y-auto p-3 space-y-2 custom-scrollbar">

                    <div id="emptyEventMessage" class="flex flex-col items-center justify-center py-12 text-gray-300 opacity-70 {{ count($eventsBulanIni) == 0 ? '' : 'hidden' }}">
                        <i class="fa-solid fa-box-open text-[150px] mb-4 drop-shadow-2xl"></i>
                        <p class="text-xl font-bold drop-shadow-sm">Tidak ada event aktif bulan ini</p>
                    </div>

                    @foreach ($eventsBulanIni as $event)
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
        <div class="h-full">

            <!-- PIE CHART -->
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-md h-full flex flex-col justify-between">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-[#192853] uppercase tracking-wider">Event Berdasarkan Kategori</h3>
                    <div class="bg-yellow-50 text-yellow-600 p-1.5 rounded-lg text-xs">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                </div>

                <div class="relative h-[260px] flex items-center justify-center">
                    <canvas id="categoryChart"></canvas>
                    <div class="absolute flex flex-col items-center">
                        <span class="text-2xl font-black text-[#192853]">{{ $categories->sum('events_count') }}</span>
                        <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest">Total</span>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-2 gap-x-4 gap-y-2">
                    @php
                        $colors = ['#bfdbfe', '#60a5fa', '#3b82f6', '#1d4ed8', '#1e3a8a', '#93c5fd', '#2563eb', '#60a5fa'];
                    @endphp
                    @foreach($categories as $index => $cat)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full" style="background-color: {{ $colors[$index % count($colors)] }}"></div>
                            <span class="text-[10px] text-gray-500 font-medium">{{ $cat->nama_kategori }}</span>
                        </div>
                        <span class="text-[10px] font-bold text-[#192853]">{{ $cat->events_count }}</span>
                    </div>
                    @endforeach
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
                    <p id="m_deskripsi" class="text-sm leading-relaxed break-words bg-gray-50 p-3 rounded-lg max-h-48 overflow-y-auto mt-1"></p>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>


    // PIE CHART -> DOUGHNUT
    @php
        $colors = ['#bfdbfe', '#60a5fa', '#3b82f6', '#1d4ed8', '#1e3a8a', '#93c5fd', '#2563eb', '#60a5fa'];
        $chartColors = [];
        foreach($categories as $index => $cat) {
            $chartColors[] = $colors[$index % count($colors)];
        }
    @endphp
    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: @json($categories->pluck('nama_kategori')),
            datasets: [{
                data: @json($categories->pluck('events_count')),
                backgroundColor: @json($chartColors),
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
        let visibleCount = 0;
        
        cards.forEach(card => {
            let text = card.innerText.toLowerCase();
            let show = text.includes(value);
            card.style.display = show ? 'flex' : 'none';
            if (show) visibleCount++;
        });

        let emptyMsg = document.getElementById('emptyEventMessage');
        if (emptyMsg) {
            if (visibleCount > 0) {
                emptyMsg.classList.add('hidden');
            } else {
                emptyMsg.classList.remove('hidden');
            }
        }
    });
</script>

</div>
@endsection