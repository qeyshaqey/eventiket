<div class="w-64 bg-[#192853] text-white flex flex-col justify-between min-h-screen">

    <!-- TOP -->
    <div>
        <!-- LOGO -->
        <div class="p-4 border-b border-gray-500">
    
    <!-- JUDUL -->
    <div class="text-lg font-bold text-yellow-400">
        EventiX <span class="text-white">Panitia</span>
    </div>

    <!-- SUBTITLE -->
    <div class="text-xs font-light text-gray-300 mt-1">
        Manajemen Event dan Tiket
    </div>

</div>

        <!-- MENU -->
        <div class="mt-4 flex flex-col text-sm">

            <!-- BERANDA -->
            <a href="{{ route('panitia.beranda') }}"
                class="flex items-center gap-3 px-4 py-2 
                hover:bg-[#0f1a35] hover:text-yellow-400
                {{ request()->routeIs('panitia.beranda') ? 'bg-[#0f1a35] text-yellow-400' : '' }}">
                <i class="bi bi-house"></i>
                Beranda
            </a>

            <!-- EVENT -->
            <a href="{{ route('panitia.event') }}"
                class="flex items-center gap-3 px-4 py-2 
                hover:bg-[#0f1a35] hover:text-yellow-400
                {{ request()->routeIs('panitia.event') ? 'bg-[#0f1a35] text-yellow-400' : '' }}">
                <i class="bi bi-calendar-event"></i>
                Event
            </a>

            <!-- TIKET -->
            <a href="{{ route('panitia.tiket') }}"
                class="flex items-center gap-3 px-4 py-2 
                hover:bg-[#0f1a35] hover:text-yellow-400
                {{ request()->routeIs('panitia.tiket') ? 'bg-[#0f1a35] text-yellow-400' : '' }}">
                <i class="bi bi-ticket-perforated"></i>
                Tiket
            </a>

            <!-- TRANSAKSI -->
            <a href="{{ route('panitia.transaksi') }}"
                class="flex items-center gap-3 px-4 py-2 
                hover:bg-[#0f1a35] hover:text-yellow-400
                {{ request()->routeIs('panitia.transaksi') ? 'bg-[#0f1a35] text-yellow-400' : '' }}">
                <i class="bi bi-cash-stack"></i>
                Transaksi
            </a>

        </div>
    </div>

    <!-- BOTTOM -->
    <div class="p-4 border-t border-gray-500 text-sm">
        <button class="w-full text-left hover:text-red-400">
            <i class="bi bi-box-arrow-right"></i> Logout
        </button>
    </div>

</div>