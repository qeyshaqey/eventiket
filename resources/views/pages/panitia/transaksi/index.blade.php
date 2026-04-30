@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-[#EFF8FF] min-h-screen p-4 md:p-6">

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-[#192853]">
            DATA TRANSAKSI
        </h1>
    </div>

    <!-- TABLE WRAPPER -->
     <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-4 md:p-6">
    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-x-auto">

        <!-- TABLE HEADER -->
        <div class="bg-[#192853] text-white text-xs uppercase grid grid-cols-7 px-4 py-3 font-semibold min-w-[900px]">
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
            <div class="grid grid-cols-7 px-4 py-4 items-center hover:bg-gray-50 transition text-sm min-w-[900px]">

                <div class="text-gray-600 font-medium whitespace-nowrap">
                    {{ $index + 1 }}
                </div>

                <div class="whitespace-nowrap">
                    <p class="font-semibold text-gray-800">
                        {{ $trx->user->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $trx->user->email }}
                    </p>
                </div>

                <div class="text-gray-700 whitespace-nowrap">
                    {{ $trx->event->judul ?? '-' }}
                </div>

                <div class="text-gray-700 whitespace-nowrap">
                    {{ $trx->jumlah_tiket }} tiket
                </div>

                <div class="text-gray-600 text-xs whitespace-nowrap">
                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                </div>

                <div class="font-semibold text-gray-800 whitespace-nowrap">
                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                </div>

                <div class="whitespace-nowrap">
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
</div>

@endsection