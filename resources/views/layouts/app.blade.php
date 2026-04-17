<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Eventix Admin' }}</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EFF8FF] text-[#192853]">

    <!-- SIDEBAR -->
    <div class="fixed top-0 left-0 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg">

        <!-- LOGO -->
        <div class="p-5 bg-[#0f1a35] border-b border-yellow-300/20">
            <h2 class="text-yellow-400 font-semibold text-sm">Eventix Admin</h2>
            <p class="text-xs text-white/40">Sistem Manajemen Event</p>
        </div>

        @php
        function active($route) {
        return request()->is($route)
        ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400'
        : 'text-white/60 hover:bg-yellow-400/10 hover:text-white';
        }
        @endphp

        <!-- MENU -->
        <nav class="flex-1 py-4 text-sm">

            <a href="/dashboard-admin" class="flex items-center gap-3 px-5 py-3 {{ active('dashboard-admin') }}">
                <i class="fa-solid fa-house"></i>
                Beranda
            </a>

            <a href="{{ route('data.pengunjung') }}" class="flex items-center gap-3 px-5 py-3 {{ active('data-pengunjung') }}">
                <i class="fa-solid fa-users"></i>
                Data Pengunjung
            </a>

            <a href="{{ route('data.panitia') }}" class="flex items-center gap-3 px-5 py-3 {{ active('data-panitia') }}">
                <i class="fa-solid fa-user-tie"></i>
                Data Panitia
            </a>

            <a href="{{ route('kelola.event') }}" class="flex items-center gap-3 px-5 py-3 {{ active('kelola-event') }}">
                <i class="fa-solid fa-calendar-check"></i>
                Kelola Event
            </a>

            <a href="{{ route('kategori') }}" class="flex items-center gap-3 px-5 py-3 {{ active('kategori') }}">
                <i class="fa-solid fa-tags"></i>
                Kategori Event
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <span class="text-xs text-white/30">@Eventix Admin 2026</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>

    </div>

    <!-- MAIN -->
    <div class="ml-[230px] min-h-screen flex flex-col">


        <!-- CONTENT -->
        <div class="p-8 flex-1">
            @yield('content')
        </div>

    </div>

</body>

</html>