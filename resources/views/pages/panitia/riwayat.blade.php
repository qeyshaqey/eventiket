@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="p-6">

    <!-- 🔥 TAB DI LUAR CARD -->
    <div class="flex gap-4 mb-4">
        <button onclick="showTab('event')" 
            class="tab-btn bg-[#192853] text-yellow-400 px-4 py-2 rounded">
            Riwayat Event
        </button>

        <button onclick="showTab('transaksi')" 
            class="tab-btn bg-gray-300 px-4 py-2 rounded">
            Riwayat Transaksi
        </button>
    </div>

    <!--CARD-->
<div class="bg-white p-6 rounded shadow">

    <h2 id="cardTitle" class="text-lg font-bold mb-4">
        Riwayat Event
    </h2>

    <!-- ===================== -->
    <!-- RIWAYAT EVENT -->
    <!-- ===================== -->
    <div id="tab-event">

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">Judul</th>
                    <th class="border p-2">Kategori</th>
                    <th class="border p-2">Tanggal</th>
                    <th class="border p-2">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($events as $event)
                <tr>
                    <td class="border p-2">{{ $event->judul }}</td>
                    <td class="border p-2">{{ $event->kategori }}</td>
                    <td class="border p-2">{{ $event->tanggal_mulai }}</td>
                    <td class="border p-2">{{ $event->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center p-4">Belum ada event</td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    <!-- ===================== -->
    <!-- RIWAYAT TRANSAKSI -->
    <!-- ===================== -->
    <div id="tab-transaksi" class="hidden">

        <table class="w-full text-sm border">
    <thead class="bg-gray-100">
        <tr>
            <th class="border p-2">No</th>
            <th class="border p-2">Nama Pembeli</th>
            <th class="border p-2">Event</th>
            <th class="border p-2">Tiket</th>
            <th class="border p-2">Tanggal</th>
            <th class="border p-2">Total</th>
        </tr>
    </thead>

    <tbody class="text-center">
        @forelse($transaksis as $index => $trx)
        <tr>
            <!-- NO -->
            <td class="border p-2">{{ $index + 1 }}</td>

            <!-- NAMA -->
            <td class="border p-2">{{ $trx->nama }}</td>

            <!-- EVENT -->
            <td class="border p-2">
                {{ $trx->event->judul ?? '-' }}
            </td>

            <!-- TIKET -->
            <td class="border p-2">
                {{ $trx->tiket->nama ?? '-' }}
            </td>

            <!-- TANGGAL -->
            <td class="border p-2">
                {{ $trx->created_at->format('d M Y') }}
            </td>

            <!-- TOTAL -->
            <td class="border p-2">
                Rp {{ number_format($trx->total) }}
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="p-4 text-gray-400">
                Belum ada transaksi
            </td>
        </tr>
        @endforelse
    </tbody>
</table>

    </div>

</div>

<script>
function showTab(tab) {
    document.getElementById('tab-event').classList.add('hidden');
    document.getElementById('tab-transaksi').classList.add('hidden');

    document.getElementById('tab-' + tab).classList.remove('hidden');

    const title = document.getElementById('cardTitle');

    if (tab === 'event') {
        title.innerText = 'Riwayat Event';
    } else {
        title.innerText = 'Riwayat Transaksi';
    }
}
</script>
@endsection