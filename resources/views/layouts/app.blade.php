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

            <form id="logoutForm" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="button" onclick="openLogoutModal()"
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

<!-- ===== MODAL LOGOUT ===== -->
<div id="logoutModal" class="fixed inset-0 hidden z-[999] items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeLogoutModal()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <!-- Header -->
        <div class="bg-[#192853] px-6 py-4 flex items-center gap-3">
            <div class="w-9 h-9 flex items-center justify-center rounded-full bg-red-500/20">
                <i class="fa-solid fa-right-from-bracket text-red-400"></i>
            </div>
            <h3 class="text-white font-semibold text-base">Konfirmasi Keluar</h3>
        </div>

        <!-- Body -->
        <div class="px-6 py-5 text-center">
            <p class="text-gray-700 text-sm">Apakah kamu yakin ingin keluar dari <span class="font-semibold text-[#192853]">Eventix Admin</span>?</p>
            <p class="text-gray-400 text-xs mt-1">Sesi kamu akan diakhiri.</p>
        </div>

        <!-- Footer -->
        <div class="px-6 pb-5 flex gap-3 justify-end">
            <button onclick="closeLogoutModal()"
                class="px-4 py-2 text-sm rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                Batal
            </button>
            <button onclick="document.getElementById('logoutForm').submit()"
                class="px-4 py-2 text-sm rounded-lg bg-red-500 text-white hover:bg-red-600 transition flex items-center gap-2">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal jika tekan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLogoutModal();
    });
</script>

</body>

</html>