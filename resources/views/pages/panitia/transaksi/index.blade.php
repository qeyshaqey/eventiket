@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-[#EFF8FF] min-h-screen p-4 md:p-6">

    <!-- HEADER DATA TRANSAKSI -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-[#192853]">Data Transaksi</h1>
    </div>

    <!-- BOX WADAH TABEL TRANSAKSI -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 md:p-6">

        <!-- FILTER -->
        <form method="GET" action="{{ route('panitia.transaksi') }}" class="flex flex-col md:flex-row gap-3 mb-5">

            <!-- Search Box -->
            <div class="relative flex-1">
                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Cari nama pembeli atau event..."
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

            <!-- Filter Event -->
            <select name="event_id" onchange="this.form.submit()"
                class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#192853] outline-none bg-white w-full md:w-56">
                <option value="">Semua Event</option>
                @foreach($events as $ev)
                    <option value="{{ $ev->id }}" {{ request('event_id') == $ev->id ? 'selected' : '' }}>
                        {{ $ev->judul }}
                    </option>
                @endforeach
            </select>

            <!-- Tombol Reset -->
            @if(request('search') || request('kategori_id') || request('event_id'))
                <a href="{{ route('panitia.transaksi') }}"
                    class="px-3 py-2 bg-gray-100 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition flex items-center gap-1 whitespace-nowrap"
                    title="Reset Filter">
                    <i class="bi bi-arrow-counterclockwise"></i> Reset
                </a>
            @endif

        </form>

        <!-- TABEL TRANSAKSI -->
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-[900px] w-full text-sm">

                <!-- HEADER TABEL -->
                <thead class="bg-[#192853] text-white text-xs uppercase font-semibold">
                    <tr>
                        <th class="p-3 text-center w-12">No</th>
                        <th class="p-3 text-center">Nama Pembeli</th>
                        <th class="p-3 text-center">Event</th>
                        <th class="p-3 text-center">Tanggal</th>
                        <th class="p-3 text-center">Total</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-center w-24">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY TABEL -->
                <tbody class="divide-y divide-gray-100">

                    @forelse($transaksis as $index => $trx)
                    <tr class="hover:bg-gray-50 transition text-sm">

                        <!-- Nomor Urut -->
                        <td class="p-3 text-gray-500 font-medium">
                            {{ $index + 1 }}
                        </td>

                        <!-- Informasi User Pembeli -->
                        <td class="p-3 whitespace-nowrap">
                            <p class="font-semibold text-gray-800">{{ $trx->user->name ?? '-' }}</p>
                            <p class="text-xs text-gray-400">{{ $trx->user->email ?? '' }}</p>
                        </td>

                        <!-- Judul Event -->
                        <td class="p-3 text-gray-700 max-w-[160px]">
                            <span class="line-clamp-2">{{ $trx->event->judul ?? '-' }}</span>
                        </td>

                        <!-- Tanggal Transaksi -->
                        <td class="p-3 text-gray-600 text-xs whitespace-nowrap text-center">
                            {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                        </td>

                        <!-- Total Bayar -->
                        <td class="p-3 font-semibold text-gray-800 whitespace-nowrap text-center">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>

                        <!-- Status Transaksi -->
                        <td class="p-3 whitespace-nowrap text-center">
                            @if($trx->status === 'Belum Bayar')
                                <span class="px-2.5 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    Belum Bayar
                                </span>
                            @elseif($trx->status === 'Lunas')
                                <span class="px-2.5 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                    Lunas
                                </span>
                            @elseif($trx->status === 'Dibatalkan')
                                <span class="px-2.5 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="px-2.5 py-1 text-xs rounded-full bg-gray-100 text-gray-500 font-semibold">
                                    {{ $trx->status }}
                                </span>
                            @endif
                        </td>

                        <!-- Tombol Detail -->
                        <td class="p-3 text-center whitespace-nowrap">
                            <button type="button"
                                onclick="openTrxModal(
                                    '{{ addslashes($trx->user->name ?? '-') }}',
                                    '{{ addslashes($trx->user->email ?? '') }}',
                                    '{{ addslashes($trx->event->judul ?? '-') }}',
                                    '{{ addslashes($trx->jenis_tiket) }}',
                                    '{{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}',
                                    'Rp {{ number_format($trx->total_harga, 0, ',', '.') }}',
                                    '{{ $trx->status }}'
                                )"
                                class="bg-[#192853] text-white px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-blue-800 transition shadow">
                                Detail
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center">
                            <div class="flex flex-col items-center gap-2 text-gray-400">
                                <p class="font-medium">Belum ada transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>

<!-- ========================================== -->
<!-- MODAL DETAIL TRANSAKSI -->
<!-- ========================================== -->
<div id="detailModal"
    class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 px-4">

    <div class="bg-white w-full max-w-sm rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header Modal -->
        <div class="bg-[#192853] p-4 flex justify-between items-start">
            <div>
                <h3 id="m_buyer_name" class="text-yellow-400 font-bold text-sm"></h3>
                <p id="m_buyer_email" class="text-white/60 text-xs mt-0.5"></p>
            </div>
            <button onclick="closeTrxModal()" class="text-white/80 hover:text-white text-xl leading-none transition">&times;</button>
        </div>

        <!-- Body Detail Transaksi -->
        <div class="p-5 space-y-3.5 text-sm">
            <div class="flex justify-between items-start gap-3">
                <span class="text-gray-400 shrink-0">Event</span>
                <span id="m_event_title" class="font-semibold text-gray-800 text-right"></span>
            </div>

            <div class="flex justify-between items-start gap-3">
                <span class="text-gray-400 shrink-0">Jenis Tiket</span>
                <span id="m_ticket_type" class="font-semibold text-gray-800 text-right"></span>
            </div>

            <div class="flex justify-between">
                <span class="text-gray-400">Tanggal Beli</span>
                <span id="m_purchase_date" class="text-gray-700"></span>
            </div>

            <div class="border-t pt-3 flex justify-between">
                <span class="text-gray-400">Total Bayar</span>
                <span id="m_total_price" class="font-bold text-[#192853] text-base"></span>
            </div>

            <div class="flex justify-between items-center">
                <span class="text-gray-400">Status</span>
                <span id="m_status" class="px-3 py-1 text-xs rounded-full font-semibold"></span>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT LOGIC -->
<script>
// Fungsi membuka modal detail transaksi dan mempopulasikan datanya secara dinamis
function openTrxModal(name, email, eventTitle, ticketType, purchaseDate, totalPrice, status) {
    document.getElementById('m_buyer_name').innerText = name;
    document.getElementById('m_buyer_email').innerText = email;
    document.getElementById('m_event_title').innerText = eventTitle;
    document.getElementById('m_ticket_type').innerText = ticketType;
    document.getElementById('m_purchase_date').innerText = purchaseDate;
    document.getElementById('m_total_price').innerText = totalPrice;

    const statusEl = document.getElementById('m_status');
    statusEl.innerText = status;

    // Reset kelas warna status
    statusEl.className = 'px-3 py-1 text-xs rounded-full font-semibold';

    // Set warna status berdasarkan nilai DB
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

// Menutup modal ketika mengklik area luar modal (overlay background)
window.addEventListener('click', function(event) {
    const modal = document.getElementById('detailModal');
    if (event.target === modal) {
        closeTrxModal();
    }
});
</script>

@endsection