@php
    $isLoggedIn = session()->has('user') && session('role') === 'pengunjung';
@endphp

@if(request()->routeIs('home'))
    <header class="sticky top-0 z-50 bg-[#192853] text-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">Eventiket</a>
            
            <!-- Desktop Nav -->
            <nav class="hidden items-center gap-4 md:flex">
                <a href="#home" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Beranda</a>
                <a href="#event" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Event</a>
                <a href="#about" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Tentang</a>
                <a href="#contact" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Hubungi Kami</a>
                @if($isLoggedIn)
                    <a href="{{ route('pengunjung.dashboard') }}" class="rounded-full border border-white px-4 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#192853]">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-white px-4 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#192853]">Masuk</a>
                @endif
            </nav>

            <!-- Mobile Menu Button -->
            <button type="button" data-collapse-toggle="mobile-menu" class="inline-flex items-center justify-center rounded-xl p-2.5 text-white bg-white/5 border border-white/10 hover:bg-white/10 md:hidden transition active:scale-95">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
       </div>

       <!-- Mobile Nav Overlay -->
       <div id="mobile-menu" class="fixed inset-0 z-[60] hidden md:hidden">
            <!-- Blur Backdrop -->
            <div class="absolute inset-0 bg-[#192853]/95 backdrop-blur-md opacity-100"></div>
            
            <!-- Content Container -->
            <div class="relative h-full flex flex-col p-6 transform translate-y-0 opacity-100">
                <div class="flex items-center justify-between mb-12">
                    <span class="text-xl font-bold text-white">Eventiket</span>
                    <button type="button" data-collapse-toggle="mobile-menu" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-white transition active:scale-90">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <nav class="flex flex-col gap-1">
                    <a href="#home" data-collapse-toggle="mobile-menu" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Beranda</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                    <a href="#event" data-collapse-toggle="mobile-menu" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Event</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                    <a href="#about" data-collapse-toggle="mobile-menu" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Tentang</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                    <a href="#contact" data-collapse-toggle="mobile-menu" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Hubungi Kami</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                </nav>

                <div class="mt-auto pb-8">
                    @if($isLoggedIn)
                        <a href="{{ route('pengunjung.dashboard') }}" class="flex items-center justify-center w-full rounded-2xl bg-white py-4 text-lg font-bold text-[#192853] transition-all hover:bg-[#FFE14E] active:scale-[0.98] shadow-lg">
                            Ke Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex items-center justify-center w-full rounded-2xl bg-white py-4 text-lg font-bold text-[#192853] transition-all hover:bg-[#FFE14E] active:scale-[0.98] shadow-lg">
                            Masuk Sekarang
                        </a>
                    @endif
                    <p class="text-center text-white/40 text-xs mt-6 uppercase tracking-widest font-semibold">Eventiket &copy; 2026</p>
                </div>
            </div>
       </div>
    </header>

    <!-- NAVBAR MOBILE (FLOWBITE IMPLEMENTED) -->
@else
    <header class="sticky top-0 z-50 bg-[#192853] text-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5">
            <a href="{{ $isLoggedIn ? route('pengunjung.dashboard') : route('home') }}" class="text-xl font-semibold tracking-tight">Eventiket</a>

            <div class="flex items-center gap-3">
                @if($isLoggedIn)
                    <a href="{{ route('pengunjung.tiket') }}" class="rounded-full border border-white px-4 py-2 text-sm font-medium text-white transition hover:bg-white hover:text-[#192853]">TIKET SAYA</a>

                    <!-- ICON USER -->
                    <a href="{{ route('pengunjung.profil') }}" class="w-10 h-10 rounded-full border border-white bg-transparent text-white flex items-center justify-center transition hover:bg-white hover:text-[#192853]">
                        <i class="fa-solid fa-user-circle text-lg"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-white px-6 py-2 text-sm font-semibold text-[#192853] bg-white transition hover:bg-[#FFE14E] hover:border-[#FFE14E]">Masuk</a>
                @endif
            </div>
        </div>
    </header>
@endif
