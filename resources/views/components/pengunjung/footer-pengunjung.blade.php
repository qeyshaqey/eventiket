<footer class="bg-[#192853] py-8 border-t border-white/10 mt-auto">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-6">
            
            <!-- BRANDING -->
            <div class="md:w-1/3">
                <a href="/home_page" class="text-xl font-bold tracking-tight text-white mb-2 inline-block">
                    Eventiket<span class="text-[#FFE14E]">.</span>
                </a>
                <p class="text-sm leading-6 text-[#EFF8FF]/80 mt-1 max-w-xs">
                    Platform terpercaya menemukan event menarik di kampus. Bergabunglah dengan ribuan mahasiswa lainnya!
                </p>
            </div>

            <!-- MENU -->
            <div class="flex gap-12 md:w-2/3 md:justify-end">
                <!-- NAVIGASI -->
                <div>
                    <h3 class="text-base font-semibold text-white mb-3">Navigasi</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ request()->routeIs('home') ? '#home' : route('home') . '#home' }}" class="text-sm text-[#EFF8FF]/80 hover:text-[#FFE14E] transition">Beranda</a></li>
                        <li><a href="{{ request()->routeIs('home') ? '#event' : route('home') . '#event' }}" class="text-sm text-[#EFF8FF]/80 hover:text-[#FFE14E] transition">Etalase</a></li>
                        <li><a href="{{ request()->routeIs('home') ? '#about' : route('home') . '#about' }}" class="text-sm text-[#EFF8FF]/80 hover:text-[#FFE14E] transition">Tentang Kami</a></li>
                    </ul>
                </div>

                <!-- BANTUAN -->
                <div>
                    <h3 class="text-base font-semibold text-white mb-3">Pusat Bantuan</h3>
                    <ul class="space-y-2 text-sm text-[#EFF8FF]/80">
                        <li><i class="fa-solid fa-envelope w-4 text-[#FFE14E]"></i> eventiket@gmail.com</li>
                        <li><i class="fa-solid fa-phone w-4 text-[#FFE14E]"></i> +62 21 123 4567</li>
                        <li><i class="fa-solid fa-location-dot w-4 text-[#FFE14E]"></i> Batam Center</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- COPYRIGHT -->
        <div class="pt-4 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-[#EFF8FF]/50 text-center md:text-left">
                &copy; 2026 Eventiket. Hak Cipta Dilindungi.
            </p>
            <div class="flex gap-4 text-sm">
                <a href="#" aria-label="WhatsApp" class="text-[#EFF8FF]/70 hover:text-[#FFE14E] transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="#" aria-label="Instagram" class="text-[#EFF8FF]/70 hover:text-[#FFE14E] transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" aria-label="YouTube" class="text-[#EFF8FF]/70 hover:text-[#FFE14E] transition hover:-translate-y-0.5">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
