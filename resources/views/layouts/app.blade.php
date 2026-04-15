<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Eventix Admin' }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-[#EFF8FF] text-[#192853]">

    <!-- SIDEBAR -->
    <div class="fixed top-0 left-0 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg">

        <div class="p-5 bg-[#0f1a35] border-b border-yellow-300/20">
            <h2 class="text-yellow-400 font-semibold text-sm">Eventix Admin</h2>
            <p class="text-xs text-white/40">Sistem Manajemen Event</p>
        </div>

        <nav class="flex-1 py-4 text-sm">

            <!-- Dashboard -->
            <a href="/dashboard-admin"
                class="flex items-center gap-3 px-5 py-3 
                {{ request()->is('dashboard-admin') ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' : 'text-white/60 hover:bg-yellow-400/10 hover:text-white' }}">
                Dashboard
            </a>

            <!-- Data Pengunjung -->
            <a href="{{ route('data.pengunjung') }}"
                class="flex items-center gap-3 px-5 py-3 
                {{ request()->is('data-pengunjung') ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' : 'text-white/60 hover:bg-yellow-400/10 hover:text-white' }}">
                Data Pengunjung
            </a>

            <!-- Data Panitia -->
            <a href="#"
                class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                Data Panitia
            </a>

            <!-- Kelola Event -->
            <a href="/event"
                class="flex items-center gap-3 px-5 py-3 
                {{ request()->is('event') ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' : 'text-white/60 hover:bg-yellow-400/10 hover:text-white' }}">
                Kelola Event
            </a>

            <!-- Kategori Event -->
            <a href="#"
                class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                Kategori Event
            </a>

        </nav>

        <!-- FOOTER -->
        <div class="p-4 border-t border-white/10 flex items-center justify-between">
            <span class="text-xs text-white/30">Eventix Admin</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="text-xs bg-red-500/20 text-red-400 px-3 py-1 rounded-md hover:bg-red-500/30">
                    Logout
                </button>
            </form>
        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="ml-[230px] p-8">
        @yield('content')
    </div>

</body>
</html>