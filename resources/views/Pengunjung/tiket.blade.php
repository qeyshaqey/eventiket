<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: "#192853",
                        cream: "#EFF8FF",
                        yellow: "#FFE14E",
                        grayCustom: "#475569"
                    },
                    fontFamily: {
                        poppins: ["Poppins", "sans-serif"]
                    }
                }
            }
        }
    </script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-cream font-poppins">

<!-- NAVBAR -->
<div class="bg-navy text-white px-6 py-4 flex justify-between items-center">
    <h1 class="font-semibold">EVENTIKET</h1>

    <div class="flex items-center gap-3">
        <button class="bg-white text-navy px-4 py-1 rounded-full text-sm font-medium">
            TIKET SAYA
        </button>
    
        <!-- ICON USER -->
        <button class="w-9 h-9 bg-white rounded-full flex items-center justify-center hover:bg-yellow transition">
            <i class="bi bi-person-circle text-navy text-lg"></i>
        </button>
</button>
    </div>
</div>

<!-- FILTER CATEGORY -->
<div class="px-6 mt-6">
    <div class="flex gap-3 flex-wrap">

        <!-- BUTTON SEMUA -->
        <a href="/tiket_aktif"
           class="px-4 py-2 rounded-full text-sm transition
           {{ request('category') == null ? 'bg-navy text-white' : 'bg-white hover:bg-yellow' }}">
            Semua
        </a>

        @php
            $categories = ['Seminar','Sosial','Olahraga','Hiburan','Kompetisi','Keagamaan'];
        @endphp

        @foreach($categories as $cat)
            <a href="?category={{ $cat }}"
               class="px-4 py-2 rounded-full text-sm transition
               {{ request('category') == $cat ? 'bg-navy text-white' : 'bg-white hover:bg-yellow' }}">
                {{ $cat }}
            </a>
        @endforeach

    </div>
</div>

<!-- CONTENT -->
<div class="px-4 py-8">
<div class="max-w-3xl mx-auto space-y-6">

@foreach($events as $event)

    {{-- FILTER LOGIC --}}
    @if(request('category') && $event['category'] != request('category'))
        @continue
    @endif

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
            @if($event['status']=='Belum Bayar') text-red-500
            @elseif($event['status']=='Menunggu Verifikasi') text-yellow-500
            @elseif($event['status']=='Ditolak') text-gray-400
            @elseif($event['status']=='Berhasil Diverifikasi') text-green-500
            @endif
        ">
            {{ $event['status'] }}
        </span>

    </div>

    <!-- BUTTON -->
    @if($event['status'] == 'Belum Bayar')
    <button class="mt-5 w-full bg-navy text-white py-2 rounded-full text-sm
        hover:bg-yellow hover:text-navy transition">
        LAKUKAN PEMBAYARAN
    </button>
    @endif

    <!-- BADGE AKTIF -->
    @if($event['status'] == 'Berhasil Diverifikasi')
    <div class="absolute bottom-4 right-4 bg-gray-200 text-xs px-4 py-1 rounded-full font-medium">
        AKTIF
    </div>
    @endif

</div>

@endforeach

</div>
</div>

</body>
</html>