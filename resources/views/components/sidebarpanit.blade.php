<!-- SIDEBAR -->
<div id="sidebar"
    class="fixed inset-y-0 left-0 z-50 h-full w-[260px] bg-[#192853] text-white flex flex-col shadow-lg
    transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    <!-- TOP -->
    <div class="flex-1 flex flex-col overflow-y-auto">

        <!-- LOGO -->
        <div class="p-5 border-b border-yellow-300/20">
            <div class="text-lg font-bold text-yellow-400">
                EventiX <span class="text-white">Panitia</span>
            </div>
            <div class="text-xs text-white/40 mt-1">
                Manajemen Event dan Tiket
            </div>
        </div>

        <!-- MENU -->
        <nav class="mt-4 flex flex-col text-sm px-2 space-y-1">

            <a href="{{ route('panitia.beranda') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg
               {{ request()->routeIs('panitia.beranda') 
                    ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' 
                    : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition' }}">
                <i class="bi bi-house"></i> Beranda
            </a>

            <a href="{{ route('panitia.event') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg
               {{ request()->routeIs('panitia.event') 
                    ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' 
                    : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition' }}">
                <i class="bi bi-calendar-event"></i> Event
            </a>

            <a href="{{ route('panitia.tiket') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg
               {{ request()->routeIs('panitia.tiket') 
                    ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' 
                    : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition' }}">
                <i class="bi bi-ticket-perforated"></i> Tiket
            </a>

            <a href="{{ route('panitia.transaksi') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg
               {{ request()->routeIs('panitia.transaksi') 
                    ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' 
                    : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition' }}">
                <i class="bi bi-cash-stack"></i> Transaksi
            </a>

            <a href="{{ route('panitia.riwayat') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg
               {{ request()->routeIs('panitia.riwayat') 
                    ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' 
                    : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition' }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>

            <a href="{{ route('pengunjung.dashboard') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg
               {{ request()->routeIs('pengunjung.dashboard') 
                    ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400' 
                    : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition' }}">
                <i class="bi bi-person-badge"></i> Mode Pengunjung
            </a>

        </nav>

    </div>

    <!-- BOTTOM -->
    <div class="p-4 border-t border-white/10 flex items-center justify-between">
        <span class="text-xs text-white/30">@Eventix Panitia</span>

        <div class="flex items-center gap-2">
            <!-- PROFIL -->
            <a href="{{ route('panitia.profil') }}"
               class="w-9 h-9 flex items-center justify-center rounded-lg bg-yellow-400/10 text-yellow-400 hover:bg-yellow-400 hover:text-[#192853] transition"
               title="Profil Panitia">
                <i class="bi bi-person-circle text-lg"></i>
            </a>

            <!-- LOGOUT -->
            <button data-modal-target="logoutModal" data-modal-toggle="logoutModal"
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition"
                title="Keluar">
                <i class="bi bi-box-arrow-right text-lg"></i>
            </button>
        </div>
    </div>

</div>