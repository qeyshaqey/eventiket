@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold mb-3">Data Transaksi</h1>
    </div>

    <!-- TABLE -->
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">NO</th>
                <th class="border p-2">NAMA PEMBELI</th>
                <th class="border p-2">EVENT</th>
                <th class="border p-2">TIKET</th>
                <th class="border p-2">TANGGAL</th>
                <th class="border p-2">TOTAL</th>
                <th class="border p-2">STATUS</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @forelse($transaksis as $index => $trx)
            <tr>
                <td class="border p-2">{{ $index + 1 }}</td>

                <td class="border p-2 text-left">
                    <div class="font-semibold">{{ $trx->user->name }}</div>
                    <div class="text-xs text-gray-500">{{ $trx->user->email }}</div>
                </td>

                <td class="border p-2">{{ $trx->event->judul ?? '-' }}</td>

                <td class="border p-2">
                    {{ $trx->jumlah_tiket }} tiket
                </td>

                <td class="border p-2">
                    {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                </td>

                <td class="border p-2">
                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                </td>

                <td class="border p-2">
                    @if($trx->status == 'pending')
                        <span class="text-yellow-500 font-semibold">Pending</span>
                    @elseif($trx->status == 'paid')
                        <span class="text-green-500 font-semibold">Paid</span>
                    @else
                        <span class="text-red-500 font-semibold">Failed</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border p-4 text-center text-gray-500">
                    Tidak ada transaksi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection