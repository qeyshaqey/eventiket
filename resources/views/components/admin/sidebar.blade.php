<!-- SIDEBAR -->
<div id="adminSidebar" class="fixed inset-y-0 left-0 z-50 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out" tabindex="-1" aria-labelledby="drawer-label">

    <!-- LOGO -->
    <div class="p-5 border-b border-yellow-300/20 flex items-center justify-between">
        <div>
            <h2 class="text-yellow-400 font-semibold text-sm">Eventix Admin</h2>
            <p class="text-xs text-white/40">Manajemen Event dan Tiket</p>
        </div>
        <button type="button" data-drawer-hide="adminSidebar" aria-controls="adminSidebar" class="md:hidden text-gray-400 hover:text-white transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
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

        <!-- Data Panitia -->
        <button type="button" class="flex items-center w-full gap-3 px-5 py-3 group {{ request()->routeIs('admin.data.panitia') ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' : 'text-white/60 hover:bg-yellow-400/10 hover:text-white' }}" aria-controls="dropdown-panitia" data-collapse-toggle="dropdown-panitia">
            <i class="fa-solid fa-user-tie"></i>
            <span class="flex-1 text-left whitespace-nowrap">Data Panitia</span>
            <i class="fa-solid fa-chevron-down w-3 h-3 text-xs transition-transform"></i>
        </button>
        <ul id="dropdown-panitia" class="{{ request()->routeIs('admin.data.panitia') ? '' : 'hidden' }} py-1 bg-[#0f1a3a]/30">
            <li><a href="{{ route('admin.data.panitia') }}?tab=k" class="flex items-center w-full py-2 pl-11 pr-5 text-sm {{ (request()->routeIs('admin.data.panitia') && (request('tab') == 'k' || request('tab') == null)) ? 'text-yellow-400 font-bold' : 'text-white/60 hover:text-white hover:bg-yellow-400/10' }}">Panitia Aktif</a></li>
            <li><a href="{{ route('admin.data.panitia') }}?tab=t" class="flex items-center w-full py-2 pl-11 pr-5 text-sm {{ (request()->routeIs('admin.data.panitia') && request('tab') == 't') ? 'text-yellow-400 font-bold' : 'text-white/60 hover:text-white hover:bg-yellow-400/10' }}">Ditolak</a></li>
            <li><a href="{{ route('admin.data.panitia') }}?tab=p" class="flex items-center w-full py-2 pl-11 pr-5 text-sm {{ (request()->routeIs('admin.data.panitia') && request('tab') == 'p') ? 'text-yellow-400 font-bold' : 'text-white/60 hover:text-white hover:bg-yellow-400/10' }}">Pengajuan Panitia</a></li>
        </ul>

        <!-- Kelola Event -->
        <button type="button" class="flex items-center w-full gap-3 px-5 py-3 group {{ request()->routeIs('admin.kelola.event') ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' : 'text-white/60 hover:bg-yellow-400/10 hover:text-white' }}" aria-controls="dropdown-event" data-collapse-toggle="dropdown-event">
            <i class="fa-solid fa-calendar-check"></i>
            <span class="flex-1 text-left whitespace-nowrap">Kelola Event</span>
            <i class="fa-solid fa-chevron-down w-3 h-3 text-xs transition-transform"></i>
        </button>
        <ul id="dropdown-event" class="{{ request()->routeIs('admin.kelola.event') ? '' : 'hidden' }} py-1 bg-[#0f1a3a]/30">
            <li><a href="{{ route('admin.kelola.event') }}?tab=k" class="flex items-center w-full py-2 pl-11 pr-5 text-sm {{ (request()->routeIs('admin.kelola.event') && (request('tab') == 'k' || request('tab') == null)) ? 'text-yellow-400 font-bold' : 'text-white/60 hover:text-white hover:bg-yellow-400/10' }}">Semua Event</a></li>
            <li><a href="{{ route('admin.kelola.event') }}?tab=t" class="flex items-center w-full py-2 pl-11 pr-5 text-sm {{ (request()->routeIs('admin.kelola.event') && request('tab') == 't') ? 'text-yellow-400 font-bold' : 'text-white/60 hover:text-white hover:bg-yellow-400/10' }}">Ditolak</a></li>
            <li><a href="{{ route('admin.kelola.event') }}?tab=p" class="flex items-center w-full py-2 pl-11 pr-5 text-sm {{ (request()->routeIs('admin.kelola.event') && request('tab') == 'p') ? 'text-yellow-400 font-bold' : 'text-white/60 hover:text-white hover:bg-yellow-400/10' }}">Pengajuan Event</a></li>
        </ul>

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
            <button type="button" data-modal-target="logoutModal" data-modal-toggle="logoutModal"
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition">
                <i class="bi bi-box-arrow-right text-lg"></i>
            </button>
        </form>
    </div>

</div>
