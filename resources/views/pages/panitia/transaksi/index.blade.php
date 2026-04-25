@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-[#EFF8FF] min-h-screen p-6">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-bold text-[#192853]">
            DATA TRANSAKSI
        </h1>
    </div>

    <!-- TABLE WRAPPER -->
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">

        <!-- TABLE HEADER -->
        <div class="bg-[#192853] text-white text-xs uppercase grid grid-cols-7 px-4 py-3 font-semibold">
            <div>No</div>
            <div>Nama Pembeli</div>
            <div>Event</div>
            <div>Tiket</div>
            <div>Tanggal</div>
            <div>Total</div>
            <div>Status</div>
        </div>

        <!-- TABLE BODY -->
        <div class="divide-y">

            @forelse($transaksis as $index => $trx)
            <div class="grid grid-cols-7 px-4 py-4 items-center hover:bg-gray-50 transition text-sm">

                <!-- NO -->
                <div class="text-gray-600 font-medium">
                    {{ $index + 1 }}
                </div>

                <!-- USER -->
                <div>
                    <p class="font-semibold text-gray-800">
                        {{ $trx->user->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $trx->user->email }}
                    </p>
                </div>

                <!-- EVENT -->
                <div class="text-gray-700">
                    {{ $trx->event->judul ?? '-' }}
                </div>

                <!-- TIKET -->
                <div class="text-gray-700">
                    {{ $trx->jumlah_tiket }} tiket
                </div>

                <!-- TANGGAL -->
                <div class="text-gray-600 text-xs">
                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                </div>

                <!-- TOTAL -->
                <div class="font-semibold text-gray-800">
                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                </div>

                <!-- STATUS -->
                <div>
                    @if($trx->status == 'pending')
                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                            Pending
                        </span>

                    @elseif($trx->status == 'paid')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                            Paid
                        </span>

                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                            Failed
                        </span>
                    @endif
                </div>

            </div>
            @empty

            <div class="p-6 text-center text-gray-400 text-sm">
                Tidak ada transaksi
            </div>

            @endforelse

        </div>
    </div>

</div>

@endsection