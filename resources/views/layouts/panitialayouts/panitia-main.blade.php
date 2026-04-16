<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Eventix Panitia</title>

    <!--FONT-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EFF8FF] font-[poppins] font-semibold">

<div class="flex">

    <!-- SIDEBAR -->
    <div class="fixed top-0 left-0 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg">

        <!-- HEADER -->
        <div class="p-5 bg-[#0f1a35] border-b border-yellow-300/20">
            <h2 class="text-yellow-400 font-semibold text-sm">Eventix Panitia</h2>
            <p class="text-xs text-white/40">Sistem Manajemen Event</p>
        </div>

        <!-- FUNCTION ACTIVE -->
        @php
function active($route) {
    return request()->is('panitia/' . $route . '*')
        ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400'
        : 'text-white/60 hover:bg-yellow-400/10 hover:text-white';
}
@endphp

        <!-- MENU -->
        <nav class="flex-1 py-4 text-sm">

            <!-- BERANDA -->
            <a href="{{ route('beranda') }}"
                class="flex items-center gap-3 px-5 py-3 {{ active('beranda') }}">
                <i class="bi bi-house"></i> Beranda
            </a>

            <!-- EVENT -->
            <a href="{{ route('event') }}"
                class="flex items-center gap-3 px-5 py-3 {{ active('event') }}">
                <i class="bi bi-calendar"></i> Event
            </a>

            <!-- TIKET -->
            <a href="#"
                class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                <i class="bi bi-ticket-perforated"></i> Tiket
            </a>

            <!-- VERIFIKASI -->
            <a href="#"
                class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                <i class="bi bi-check2-square"></i> Verifikasi
            </a>

            <!-- RIWAYAT -->
            <a href="#"
                class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>

        </nav>

        <!-- FOOTER PROFILE -->
        <div class="p-4 border-t border-gray-500 flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-black text-sm">
                PN
            </div>
            <span>Panitia</span>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="ml-[230px] w-full p-6 overflow-y-auto h-screen">
        @yield('content')
    </div>

</div>

</body>
</html>