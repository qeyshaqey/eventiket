@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

    <!-- TABS -->
    <div class="flex gap-3 mb-5">

        <button onclick="showTab('event')"
            id="tabBtn-event"
            class="tab-btn px-5 py-2 rounded-full text-sm font-semibold transition bg-[#192853] text-yellow-400 shadow">

            Riwayat Event
        </button>

        <button onclick="showTab('transaksi')"
            id="tabBtn-transaksi"
            class="tab-btn px-5 py-2 rounded-full text-sm font-semibold transition bg-white text-gray-600 shadow">

            Riwayat Transaksi
        </button>

    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">

        <h2 id="cardTitle" class="text-lg font-bold text-[#192853] mb-4">
            Riwayat Event
        </h2>

        <!-- ===================== -->
        <!-- EVENT -->
        <!-- ===================== -->
        <div id="tab-event">

            <div class="overflow-hidden rounded-xl border">

                <table class="w-full text-sm">

                    <thead class="bg-[#192853] text-white text-xs uppercase">
                        <tr>
                            <th class="p-3 text-left">Judul</th>
                            <th class="p-3 text-left">Kategori</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($events as $event)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="p-3 font-medium text-gray-800">
                                {{ $event->judul }}
                            </td>

                            <td class="p-3">
                                <span class="px-3 py-1 text-xs bg-blue-50 text-blue-600 rounded-full">
                                    {{ $event->kategori }}
                                </span>
                            </td>

                            <td class="p-3 text-gray-600 text-sm">
                                {{ $event->tanggal_mulai }}
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
                            <td colspan="4" class="p-6 text-center text-gray-400">
                                Belum ada event
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

        </div>

        <!-- ===================== -->
        <!-- TRANSAKSI -->
        <!-- ===================== -->
        <div id="tab-transaksi" class="hidden">

            <div class="overflow-hidden rounded-xl border">

                <table class="w-full text-sm">

                    <thead class="bg-[#192853] text-white text-xs uppercase">
                        <tr>
                            <th class="p-3 text-left">No</th>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Event</th>
                            <th class="p-3 text-left">Tiket</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Total</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @forelse($transaksis as $index => $trx)
                        <tr class="hover:bg-gray-50 transition">

                            <td class="p-3 text-gray-600">
                                {{ $index + 1 }}
                            </td>

                            <td class="p-3">
                                <p class="font-semibold text-gray-800">
                                    {{ $trx->nama }}
                                </p>
                            </td>

                            <td class="p-3 text-gray-700">
                                {{ $trx->event->judul ?? '-' }}
                            </td>

                            <td class="p-3 text-gray-700">
                                {{ $trx->tiket->nama ?? '-' }}
                            </td>

                            <td class="p-3 text-gray-600 text-sm">
                                {{ $trx->created_at->format('d M Y') }}
                            </td>

                            <td class="p-3 font-semibold text-gray-800">
                                Rp {{ number_format($trx->total) }}
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-gray-400">
                                Belum ada transaksi
                            </td>
                        </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>
</div>

<!-- SCRIPT -->
<script>

function showTab(tab) {

    const tabs = ['event', 'transaksi'];

    tabs.forEach(t => {
        document.getElementById('tab-' + t).classList.add('hidden');

        const btn = document.getElementById('tabBtn-' + t);

        if (btn) {
            btn.classList.remove('bg-[#192853]', 'text-yellow-400');
            btn.classList.add('bg-white', 'text-gray-600');
        }
    });

    document.getElementById('tab-' + tab).classList.remove('hidden');

    const activeBtn = document.getElementById('tabBtn-' + tab);
    activeBtn.classList.add('bg-[#192853]', 'text-yellow-400');
    activeBtn.classList.remove('bg-white', 'text-gray-600');

    document.getElementById('cardTitle').innerText =
        tab === 'event' ? 'Riwayat Event' : 'Riwayat Transaksi';
}

</script>

@endsection