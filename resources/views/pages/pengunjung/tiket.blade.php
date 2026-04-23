@extends('layouts.pengunjung')

@section('title', 'Tiket Saya')

@section('body_class', 'bg-cream font-poppins')

@section('content')
    @php
        $activeTab = request('tab', 'aktif');
        $currentCategory = request('category');
        $eventsToShow = $activeTab === 'riwayat' ? $historyEvents : $activeEvents;
    @endphp

    <!-- TAB PILIHAN -->
    <div class="px-6 mt-6">
        <div class="mx-auto flex w-full max-w-xl items-center justify-between pb-3">
            <a href="{{ route('pengunjung.tiket') }}?tab=aktif{{ $currentCategory ? '&category='.$currentCategory : '' }}"
               class="text-sm font-semibold transition {{ $activeTab === 'aktif' ? 'text-navy border-b-4 border-yellow pb-2' : 'text-slate-500 hover:text-slate-700' }}">
                TIKET AKTIF
            </a>
            <a href="{{ route('pengunjung.tiket') }}?tab=riwayat{{ $currentCategory ? '&category='.$currentCategory : '' }}"
               class="text-sm font-semibold transition {{ $activeTab === 'riwayat' ? 'text-navy border-b-4 border-yellow pb-2' : 'text-slate-500 hover:text-slate-700' }}">
                RIWAYAT TRANSAKSI
            </a>
        </div>
    </div>

    <!-- FILTER CATEGORY --> 
    <div class="px-6 mt-6">
        <div class="flex gap-3 flex-wrap">

            <!-- BUTTON SEMUA -->
            <a href="{{ route('pengunjung.tiket') }}?tab={{ $activeTab }}"
               class="px-4 py-2 rounded-full text-sm transition
               {{ $currentCategory == null ? 'bg-navy text-white' : 'bg-white hover:bg-yellow' }}">
                Semua
            </a>

            @php
                $categories = ['Seminar','Sosial','Olahraga','Hiburan','Kompetisi','Keagamaan'];
            @endphp

            @foreach($categories as $cat)
                <a href="{{ route('pengunjung.tiket') }}?tab={{ $activeTab }}&category={{ $cat }}"
                   class="px-4 py-2 rounded-full text-sm transition
                   {{ $currentCategory == $cat ? 'bg-navy text-white' : 'bg-white hover:bg-yellow' }}">
                    {{ $cat }}
                </a>
            @endforeach

        </div>
    </div>

    <!-- CONTENT -->
    <div class="px-4 py-8">
        <div class="max-w-3xl mx-auto space-y-6">

            @php
                $filteredEvents = collect($eventsToShow)->filter(function ($event) use ($currentCategory) {
                    return !$currentCategory || $event['category'] === $currentCategory;
                });
            @endphp

            @if($filteredEvents->isEmpty())
                <div class="bg-white rounded-2xl p-8 shadow-sm text-center text-sm text-slate-600">
                    Belum ada tiket yang sesuai dengan pilihan saat ini.
                </div>
            @endif

            @foreach($filteredEvents as $event)

                <div class="bg-white rounded-2xl p-5 shadow-sm relative hover:shadow-md transition">

                    <!-- BADGE CATEGORY -->
                    <div class="flex justify-end mb-2">
                        <span class="bg-yellow text-navy text-xs px-4 py-1 rounded-full font-medium shadow-sm">
                            {{ $event['category'] ?? 'Umum' }}
                        </span>
                    </div>

                    <!-- KODE ORDER -->
                    @if($event['status'] == 'Berhasil Diverifikasi')
                        <div class="grid grid-cols-[140px_10px_1fr] text-sm mb-2">
                            <span class="font-semibold">KODE ORDER</span>
                            <span>:</span>
                            <span class="font-bold">{{ $event['kode_order'] }}</span>
                        </div>
                    @endif

                    <!-- DATA -->
                    <div class="grid grid-cols-[140px_10px_1fr] gap-y-2 text-sm text-grayCustom leading-relaxed">

                        <span>Judul Event</span><span>:</span><span>{{ $event['title'] ?? '-' }}</span>
                        <span>Tanggal</span><span>:</span><span>{{ $event['date'] }}</span>
                        <span>Waktu</span><span>:</span><span>{{ $event['time'] }}</span>
                        <span>Lokasi</span><span>:</span><span>{{ $event['location'] }}</span>

                        <span>Tiket</span><span>:</span>
                        <div class="space-y-1">
                            @foreach($event['tickets'] as $t)
                                <p>{{ $t['name'] }} ({{ $t['qty'] }})</p>
                            @endforeach
                        </div>

                        <span>Status</span><span>:</span>
                        <span class="font-medium
                    @if($event['status'] == 'Belum Bayar') text-red-500
                    @elseif($event['status'] == 'Menunggu Verifikasi') text-yellow-500
                    @elseif($event['status'] == 'Ditolak') text-gray-400
                    @elseif($event['status'] == 'Berhasil Diverifikasi') text-green-500
                    @endif
                ">
                            {{ $event['status'] }}
                        </span>

                    </div>

                    <!-- BUTTON -->
                    @if($event['status'] == 'Belum Bayar')
                            <a href="{{ route('pengunjung.pembayaran') }}" class="mt-5 w-full bg-navy text-white py-2 rounded-full text-sm text-center block font-medium
                        hover:bg-yellow hover:text-navy transition">
                                LAKUKAN PEMBAYARAN
                            </a>
                    @endif

                    <!-- BADGE STATUS AKTIF / SELESAI -->
                    @if($event['status'] == 'Berhasil Diverifikasi')
                        <div class="absolute bottom-4 right-4 bg-gray-200 text-xs px-4 py-1 rounded-full font-medium">
                            {{ $activeTab === 'riwayat' ? 'SELESAI' : 'AKTIF' }}
                        </div>
                    @endif

                </div>

            @endforeach

        </div>
    </div>
@endsection