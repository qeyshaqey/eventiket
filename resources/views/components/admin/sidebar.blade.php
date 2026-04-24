<div class="fixed top-0 left-0 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg">

    <!-- LOGO -->
    <div class="p-5 bg-[#0f1a35] border-b border-yellow-300/20">
        <h2 class="text-yellow-400 font-semibold text-sm">Eventix Admin</h2>
        <p class="text-xs text-white/40">Sistem Manajemen Event</p>
    </div>

    @php
    if (!function_exists('active')) {
        function active($route) {
            return request()->routeIs($route)
            ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400'
            : 'text-white/60 hover:bg-yellow-400/10 hover:text-white';
        }
    }
    @endphp

    <!-- MENU -->
    <nav class="flex-1 py-4 text-sm">

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-5 py-3 {{ active('admin.dashboard') }}">
            <i class="fa-solid fa-house"></i>
            Beranda
        </a>

        <a href="{{ route('admin.data.pengunjung') }}" class="flex items-center gap-3 px-5 py-3 {{ active('admin.data.pengunjung') }}">
            <i class="fa-solid fa-users"></i>
            Data Pengunjung
        </a>

        <a href="{{ route('admin.data.panitia') }}" class="flex items-center gap-3 px-5 py-3 {{ active('admin.data.panitia') }}">
            <i class="fa-solid fa-user-tie"></i>
            Data Panitia
        </a>

        <a href="{{ route('admin.kelola.event') }}" class="flex items-center gap-3 px-5 py-3 {{ active('admin.kelola.event') }}">
            <i class="fa-solid fa-calendar-check"></i>
            Kelola Event
        </a>

        <a href="{{ route('admin.kategori') }}" class="flex items-center gap-3 px-5 py-3 {{ active('admin.kategori') }}">
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
