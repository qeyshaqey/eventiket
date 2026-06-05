@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-[#EFF8FF] min-h-screen p-4 md:p-6">

    <!-- HEADER DATA TRANSAKSI -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-[#192853]">
            DATA TRANSAKSI
        </h1>
    </div>

    <!-- BOX WADAH TABEL TRANSAKSI -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 md:p-6">
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <table class="min-w-[900px] w-full text-sm">
                
                <!-- HEADER TABEL -->
                <thead class="bg-[#192853] text-white text-xs uppercase font-semibold">
                    <tr>
                        <th class="p-3 text-left w-16">No</th>
                        <th class="p-3 text-left">Nama Pembeli</th>
                        <th class="p-3 text-left">Event</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Total</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-center w-28">Aksi</th>
                    </tr>
                </thead>

                <!-- BODY TABEL -->
                <tbody class="divide-y">

                    @forelse($transaksis as $index => $trx)
                    <tr class="hover:bg-gray-50 transition text-sm">

                        <!-- Nomor Urut -->
                        <td class="p-3 text-gray-600 font-medium whitespace-nowrap">
                            {{ $index + 1 }}
                        </td>

                        <!-- Informasi User Pembeli -->
                        <td class="p-3 whitespace-nowrap">
                            <p class="font-semibold text-gray-800">
                                {{ $trx->user->name }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $trx->user->email }}
                            </p>
                        </td>

                        <!-- Judul Event -->
                        <td class="p-3 text-gray-700 whitespace-nowrap">
                            {{ $trx->event->judul ?? '-' }}
                        </td>

                        <!-- Tanggal Transaksi -->
                        <td class="p-3 text-gray-600 text-xs whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                        </td>

                        <!-- Total Bayar -->
                        <td class="p-3 font-semibold text-gray-800 whitespace-nowrap">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>

                        <!-- Status Transaksi (Pending, Paid, Failed) -->
                        <td class="p-3 whitespace-nowrap">
                            @if($trx->status == 'Belum Bayar')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                    Belum Bayar
                                </span>
                            @elseif($trx->status == 'Lunas')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                    Lunas
                                </span>
                            @elseif($trx->status == 'Dibatalkan')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                    Dibatalkan
                                </span>
                            @elseif($trx->status == 'Kedaluwarsa')
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-500 font-semibold">
                                    Kedaluwarsa
                                </span>
                            @endif
                        </td>

                        <!-- Tombol Detail Transaksi -->
                        <td class="p-3 whitespace-nowrap text-center">
                            <button type="button" 
                                onclick="openTrxModal('{{ $trx->user->name }}', '{{ $trx->user->email }}', '{{ $trx->event->judul ?? \'-\' }}', '{{ $trx->jenis_tiket }}', '{{ \Carbon\Carbon::parse($trx->created_at)->format(\'d M Y\') }}', 'Rp {{ number_format($trx->total_harga, 0, \',\', \'.\') }}', '{{ $trx->status }}')"
                                class="bg-[#192853] text-white px-4 py-1.5 rounded-full text-xs font-semibold hover:bg-blue-800 transition shadow">
                                Detail
                            </button>
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-400 text-sm">
                            Tidak ada transaksi
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
    statusEl.innerText = status.toUpperCase();
    
    // Reset kelas warna status
    statusEl.className = 'px-3 py-1 text-xs rounded-full font-semibold';
    
    // Set warna status berdasarkan status transaksi
    if (status === 'Belum Bayar') {
        statusEl.classList.add('bg-yellow-100', 'text-yellow-700');
    } else if (status === 'Lunas') {
        statusEl.classList.add('bg-green-100', 'text-green-700');
    } else if (status === 'Dibatalkan') {
        statusEl.classList.add('bg-red-100', 'text-red-700');
    } else if (status === 'Kedaluwarsa') {
        statusEl.classList.add('bg-gray-100', 'text-gray-500');
    }
    
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