<header class="sticky top-0 z-50 bg-[#192853] text-white shadow-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5">
        <a href="{{ route('pengunjung.dashboard') }}" class="text-xl font-semibold tracking-tight">Eventiket</a>

        <div class="flex items-center gap-3">
            <a href="{{ route('pengunjung.tiket') }}" class="rounded-full border border-white px-4 py-2 text-sm font-medium text-white transition hover:bg-white hover:text-[#192853]">TIKET SAYA</a>

            <!-- ICON USER -->
            <a href="{{ route('pengunjung.profil') }}" class="w-10 h-10 rounded-full border border-white bg-transparent text-white flex items-center justify-center transition hover:bg-white hover:text-[#192853]">
                <i class="fa-solid fa-user-circle text-lg"></i>
            </a>
        </div>
    </div>
</header>
