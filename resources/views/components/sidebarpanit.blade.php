<div class="w-64 bg-[#192853] text-white flex flex-col h-screen">

    <!-- TOP -->
    <div class="flex-1 flex flex-col overflow-y-auto">

        <!-- LOGO -->
        <div class="p-5 border-b border-yellow-300/20">
            <div class="text-lg font-bold text-yellow-400">
                EventiX <span class="text-white">Panitia</span>
            </div>
            <div class="text-xs font-light text-white/40 mt-1">
                Manajemen Event dan Tiket
            </div>
        </div>

        <!-- MENU -->
        <nav class="mt-4 flex flex-col text-sm px-2 space-y-1">

            @php
                function activePanitia($route) {
                    return request()->routeIs($route)
                        ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400'
                        : 'text-white/60 hover:bg-yellow-400/10 hover:text-white transition';
                }
            @endphp

            <a href="{{ route('panitia.beranda') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg {{ activePanitia('panitia.beranda') }}">
                <i class="bi bi-house"></i> Beranda
            </a>

            <a href="{{ route('panitia.event') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg {{ activePanitia('panitia.event') }}">
                <i class="bi bi-calendar-event"></i> Event
            </a>

            <a href="{{ route('panitia.tiket') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg {{ activePanitia('panitia.tiket') }}">
                <i class="bi bi-ticket-perforated"></i> Tiket
            </a>

            <a href="{{ route('panitia.transaksi') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg {{ activePanitia('panitia.transaksi') }}">
                <i class="bi bi-cash-stack"></i> Transaksi
            </a>

            <a href="{{ route('panitia.riwayat') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-r-lg {{ activePanitia('panitia.riwayat') }}">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>

        </nav>

    </div>

    <!-- BOTTOM -->
    <div class="p-4 border-t border-white/10">

        <div class="flex items-center justify-between">

           <!-- PROFILE -->
<a href="{{ route('panitia.profil') }}"
   class="flex items-center gap-3 hover:opacity-80 transition">

    <img src="https://ui-avatars.com/api/?name={{ session('user') }}" 
         class="w-10 h-10 rounded-full object-cover shadow-md border">

    <div class="leading-tight">
        <p class="text-sm font-semibold text-white">
            {{ session('user') ?? 'User' }}
        </p>
        <p class="text-xs text-white/40">
            Panitia
        </p>
    </div>
</a>

            <!-- LOGOUT -->
            <button onclick="openLogoutModal()" 
    class="flex items-center gap-2 text-red-500 hover:text-red-600">
    <i class="bi bi-box-arrow-right"></i>
</button>

            </form>

        </div>

    </div>

</div>