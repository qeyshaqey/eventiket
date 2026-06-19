@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="p-4 md:p-6">
    <!-- JUDUL RIWAYAT -->
    <div class="mb-6">
        <h1 class="text-xl font-bold mb-6">RIWAYAT</h1>
    </div>

    <!-- SISTEM TAB (EVENT / TRANSAKSI) -->
    <div data-tabs-toggle="#tab-content">
        <div class="flex flex-wrap gap-3 mb-5">
            <!-- Tab Event Selesai -->
            <button onclick="showTab('event')"
                data-tabs-target="#tab-event"
                id="tabBtn-event"
                class="px-5 py-2 rounded-full text-sm font-semibold transition bg-[#192853] text-yellow-400 shadow">
                Event
            </button>

            <!-- Tab Transaksi Selesai -->
            <button onclick="showTab('transaksi')"
                data-tabs-target="#tab-transaksi"
                id="tabBtn-transaksi"
                class="px-5 py-2 rounded-full text-sm font-semibold transition bg-white text-gray-600 shadow">
                Transaksi
            </button>
        </div>
    </div>

    <!-- BOX WADAH KONTEN UTAMA -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 md:p-6">

        <!-- ========================================== -->
        <!-- TAB KONTEN: RIWAYAT EVENT -->
        <!-- ========================================== -->
        <div id="tab-event">
            
            <!-- FILTER RIWAYAT EVENT -->
            <div class="flex flex-col md:flex-row md:items-center justify-end gap-3 mb-5">
                <form action="{{ route('panitia.riwayat') }}" method="GET" class="flex flex-wrap gap-2 w-full">
                    <input type="hidden" name="tab" value="event">

                    <!-- Search Box -->
                    <div class="relative flex-1 min-w-[180px]">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search_event" value="{{ request('search_event') }}"
                            placeholder="Cari judul event..."
                            onchange="this.form.submit()"
                            class="w-full pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                    </div>

                    <!-- Filter Kategori -->
                    <select name="kategori_id" onchange="this.form.submit()" 
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none bg-white w-full md:w-44">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('kategori_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Filter Judul Event -->
                    <select name="event_filter_id" onchange="this.form.submit()" 
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none bg-white w-full md:w-52">
                        <option value="">Semua Event</option>
                        @foreach($allEvents as $ev)
                            <option value="{{ $ev->id }}" {{ request('event_filter_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->judul }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Tombol Reset Filter -->
                    @if(request('search_event') || request('kategori_id') || request('event_filter_id'))
                        <a href="{{ route('panitia.riwayat') }}?tab=event" 
                            class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition flex items-center gap-1 whitespace-nowrap"
                            title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tabel Data Event Selesai -->
            <div class="overflow-x-auto rounded-xl border">
                <table class="min-w-[600px] w-full text-sm">

                    <thead class="bg-[#192853] text-white text-xs uppercase font-semibold">
                        <tr>
                            <th class="p-3 text-left w-16">No</th>
                            <th class="p-3 text-left">Judul Event</th>
                            <th class="p-3 text-left">Kategori</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($events as $index => $event)
                        <tr class="hover:bg-gray-50 transition text-sm">
                            <td class="p-3 text-gray-600">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-3 font-semibold text-gray-800">
                                {{ $event->judul }}
                            </td>
                            <td class="p-3">
                                <span class="px-3 py-1 text-xs bg-blue-50 text-blue-600 rounded-full">
                                    {{ $event->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>
                            <td class="p-3 text-gray-600 text-sm">
                                {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}
                            </td>
                            <td class="p-3">
                                <span class="px-3 py-1 text-xs rounded-full
                                    {{ $event->status == 'published'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $event->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-gray-400">
                                Belum ada event selesai
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- TAB KONTEN: RIWAYAT TRANSAKSI -->
        <!-- ========================================== -->
        <div id="tab-transaksi" class="hidden">
            
            <!-- FILTER RIWAYAT TRANSAKSI -->
            <div class="flex flex-col md:flex-row md:items-center justify-end gap-3 mb-5">
                <form action="{{ route('panitia.riwayat') }}" method="GET" class="flex flex-wrap gap-2 w-full">
                    <input type="hidden" name="tab" value="transaksi">

                    <!-- Search Box -->
                    <div class="relative flex-1 min-w-[180px]">
                        <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search_trx" value="{{ request('search_trx') }}"
                            placeholder="Cari nama pembeli..."
                            onchange="this.form.submit()"
                            class="w-full pl-9 pr-4 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-[#192853] outline-none">
                    </div>

                    <!-- Filter Kategori Transaksi -->
                    <select name="trx_kategori_id" onchange="this.form.submit()" 
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none bg-white w-full md:w-44">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('trx_kategori_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Filter Event Transaksi -->
                    <select name="event_id" onchange="this.form.submit()" 
                        class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none bg-white w-full md:w-52">
                        <option value="">Semua Event</option>
                        @foreach($allEvents as $ev)
                            <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                                {{ $ev->judul }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Tombol Reset Filter Transaksi -->
                    @if(request('search_trx') || request('trx_kategori_id') || request('event_id'))
                        <a href="{{ route('panitia.riwayat') }}?tab=transaksi" 
                            class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition flex items-center gap-1 whitespace-nowrap"
                            title="Reset Filter">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    @endif
                </form>
            </div>

            <!-- Tabel Data Transaksi Event Selesai -->
            <div class="overflow-x-auto rounded-xl border">
                <table class="min-w-[700px] w-full text-sm">

                    <thead class="bg-[#192853] text-white text-xs uppercase">
                        <tr>
                            <th class="p-3 text-left">No</th>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Event</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($transaksis as $index => $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-3 text-gray-600">
                                {{ $index + 1 }}
                            </td>
                            <td class="p-3 whitespace-nowrap">
                                <p class="font-semibold text-gray-800">{{ $trx->nama }}</p>
                                <p class="text-xs text-gray-400">{{ $trx->email }}</p>
                            </td>
                            <td class="p-3 text-gray-700">
                                {{ $trx->event->judul ?? '-' }}
                            </td>
                            <td class="p-3 text-gray-600 text-sm whitespace-nowrap">
                                {{ $trx->created_at->format('d M Y') }}
                            </td>
                            <td class="p-3 font-semibold text-gray-800 whitespace-nowrap">
                                Rp {{ number_format($trx->total) }}
                            </td>
                            <td class="p-3 whitespace-nowrap">
                                @if($trx->status === 'Belum Bayar')
                                    <span class="px-2.5 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">Belum Bayar</span>
                                @elseif($trx->status === 'Lunas')
                                    <span class="px-2.5 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">Lunas</span>
                                @elseif($trx->status === 'Dibatalkan')
                                    <span class="px-2.5 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">Dibatalkan</span>
                                @else
                                    <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-500 font-semibold">{{ $trx->status }}</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                <button type="button" 
                                    onclick="openTrxModal('{{ addslashes($trx->nama) }}', '{{ addslashes($trx->email) }}', '{{ addslashes($trx->event->judul ?? '-') }}', '{{ addslashes($trx->jenis_tiket) }}', '{{ $trx->created_at->format('d M Y') }}', 'Rp {{ number_format($trx->total) }}', '{{ $trx->status }}')"
                                    class="bg-[#192853] text-white px-3 py-1 rounded-full text-xs font-semibold hover:bg-blue-800 transition">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center">
                                <div class="flex flex-col items-center gap-2 text-gray-400">
                                    <p class="font-semibold">Belum ada transaksi</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</div>

<!-- ========================================== -->
<!-- MODAL DETAIL TRANSAKSI -->
<!-- ========================================== -->
<div id="detailModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4">

    <div class="bg-white w-full max-w-sm rounded-xl shadow-xl overflow-hidden">
        <!-- Header Modal -->
        <div class="bg-[#192853] p-4 flex justify-between items-start">
            <div>
                <h3 id="m_buyer_name" class="text-yellow-400 font-semibold text-sm"></h3>
                <p id="m_buyer_email" class="text-white/60 text-xs"></p>
            </div>
            <button onclick="closeTrxModal()" class="text-white text-lg leading-none">&times;</button>
        </div>

        <!-- Body Detail Transaksi -->
        <div class="p-4 space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500">Event</span>
                <span id="m_event_title" class="font-semibold text-gray-800 text-right max-w-[200px] truncate"></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Jenis Tiket</span>
                <span id="m_ticket_type" class="font-semibold text-gray-800 text-right"></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal Beli</span>
                <span id="m_purchase_date" class="text-gray-800"></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-500">Total</span>
                <span id="m_total_price" class="font-semibold text-gray-800"></span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-gray-500">Status</span>
                <span id="m_status" class="px-3 py-1 text-xs rounded-full font-semibold"></span>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT LOGIC -->
<script>
// Fungsi untuk mengganti tampilan tab aktif (Event / Transaksi)
function showTab(tab) {
    const tabs = ['event', 'transaksi'];

    // Sembunyikan semua tab & ubah status tombol ke inaktif
    tabs.forEach(t => {
        document.getElementById('tab-' + t).classList.add('hidden');

        const btn = document.getElementById('tabBtn-' + t);
        btn.classList.remove('bg-[#192853]', 'text-yellow-400');
        btn.classList.add('bg-white', 'text-gray-600');
    });

    // Tampilkan tab yang dipilih & ubah status tombol menjadi aktif
    document.getElementById('tab-' + tab).classList.remove('hidden');

    const activeBtn = document.getElementById('tabBtn-' + tab);
    activeBtn.classList.add('bg-[#192853]', 'text-yellow-400');
    activeBtn.classList.remove('bg-white', 'text-gray-600');

    // Ubah teks judul halaman secara dinamis
    document.getElementById('cardTitle').innerText =
        tab === 'event' ? 'Riwayat Event' : 'Riwayat Transaksi';
}

// Menampilkan tab yang sesuai ketika pertama kali halaman dimuat berdasarkan parameter URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('event_id') || urlParams.get('tab') === 'transaksi') {
        showTab('transaksi');
    }
});

// Fungsi membuka modal detail transaksi dan mempopulasikan datanya secara dinamis
function openTrxModal(name, email, eventTitle, ticketType, purchaseDate, totalPrice, status) {
    document.getElementById('m_buyer_name').innerText = name;
    document.getElementById('m_buyer_email').innerText = email;
    document.getElementById('m_event_title').innerText = eventTitle;
    document.getElementById('m_event_title').title = eventTitle;
    document.getElementById('m_ticket_type').innerText = ticketType;
    document.getElementById('m_purchase_date').innerText = purchaseDate;
    document.getElementById('m_total_price').innerText = totalPrice;
    
    const statusEl = document.getElementById('m_status');
    statusEl.innerText = status;
    
    // Reset kelas warna status
    statusEl.className = 'px-3 py-1 text-xs rounded-full font-semibold';
    
    // Set warna status berdasarkan nilai DB (Belum Bayar, Lunas, Dibatalkan)
    const statusColors = {
        'Belum Bayar': ['bg-yellow-100', 'text-yellow-700'],
        'Lunas':       ['bg-green-100',  'text-green-700'],
        'Dibatalkan':  ['bg-red-100',    'text-red-700'],
    };
    const colors = statusColors[status] || ['bg-gray-100', 'text-gray-500'];
    statusEl.classList.add(...colors);
    
    // Tampilkan modal
    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

// Fungsi menutup modal detail transaksi
function closeTrxModal() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Menutup modal secara otomatis ketika pengguna mengklik area luar modal (overlay background)
window.addEventListener('click', function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeTrxModal();
    }
});
</script>

@endsection