<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - Eventiket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite('resources/css/app.css')
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#EFF8FF] text-[#192853]">
    <header class="sticky top-0 z-50 bg-[#192853] text-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5 sm:px-6 lg:px-8">
            <a href="/home_page" class="text-xl font-bold tracking-tight">Eventiket</a>
            
            <!-- Desktop Nav -->
            <nav class="hidden items-center gap-4 md:flex">
                <a href="#home" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Beranda</a>
                <a href="#event" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Event</a>
                <a href="#about" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Tentang</a>
                <a href="#contact" class="rounded-full border border-white px-4 py-2 text-sm font-medium transition hover:bg-white hover:text-[#192853]">Hubungi Kami</a>
                <a href="/login" class="rounded-full border border-white px-4 py-2 text-sm font-semibold transition hover:bg-white hover:text-[#192853]">Masuk</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button type="button" id="mobile-menu-btn" class="inline-flex items-center justify-center rounded-xl p-2.5 text-white bg-white/5 border border-white/10 hover:bg-white/10 md:hidden transition active:scale-95">
                <i class="fa-solid fa-bars text-lg" id="menu-icon"></i>
            </button>
       </div>

       <!-- Mobile Nav Overlay -->
       <div id="mobile-menu" class="fixed inset-0 z-[60] hidden md:hidden">
            <!-- Blur Backdrop -->
            <div class="absolute inset-0 bg-[#192853]/95 backdrop-blur-md opacity-0 transition-opacity duration-300" id="mobile-menu-backdrop"></div>
            
            <!-- Content Container -->
            <div class="relative h-full flex flex-col p-6 transform translate-y-10 opacity-0 transition-all duration-300" id="mobile-menu-content">
                <div class="flex items-center justify-between mb-12">
                    <span class="text-xl font-bold text-white">Eventiket</span>
                    <button type="button" onclick="closeMobileMenu()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/5 border border-white/10 text-white transition active:scale-90">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <nav class="flex flex-col gap-1">
                    <a href="#home" onclick="closeMobileMenu()" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Beranda</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                    <a href="#event" onclick="closeMobileMenu()" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Event</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                    <a href="#about" onclick="closeMobileMenu()" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Tentang</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                    <a href="#contact" onclick="closeMobileMenu()" class="group flex items-center justify-between p-4 rounded-2xl hover:bg-white/5 transition">
                        <span class="text-2xl font-semibold text-white">Hubungi Kami</span>
                        <i class="fa-solid fa-arrow-right text-[#FFE14E] opacity-0 -translate-x-4 transition-all group-hover:opacity-100 group-hover:translate-x-0"></i>
                    </a>
                </nav>

                <div class="mt-auto pb-8">
                    <a href="/login" class="flex items-center justify-center w-full rounded-2xl bg-white py-4 text-lg font-bold text-[#192853] transition-all hover:bg-[#FFE14E] active:scale-[0.98] shadow-lg">
                        Masuk Sekarang
                    </a>
                    <p class="text-center text-white/40 text-xs mt-6 uppercase tracking-widest font-semibold">Eventiket &copy; 2026</p>
                </div>
            </div>
       </div>
    </header>

    <!-- NAVBAR MOBILE  -->
    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuBackdrop = document.getElementById('mobile-menu-backdrop');
        const menuContent = document.getElementById('mobile-menu-content');

        function openMobileMenu() {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                menuBackdrop.classList.replace('opacity-0', 'opacity-100');
                menuContent.classList.replace('translate-y-10', 'translate-y-0');
                menuContent.classList.replace('opacity-0', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            menuBackdrop.classList.replace('opacity-100', 'opacity-0');
            menuContent.classList.replace('translate-y-0', 'translate-y-10');
            menuContent.classList.replace('opacity-100', 'opacity-0');
            setTimeout(() => {
                mobileMenu.classList.add('hidden');
            }, 300);
            document.body.style.overflow = '';
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', openMobileMenu);
        }
    </script>

    <main>
        <section id="home" class="relative overflow-hidden bg-[#192853] text-white" style="background-image: radial-gradient(circle at top, rgba(255,225,78,0.14), transparent 40%), linear-gradient(180deg, rgba(25,40,83,0.95), rgba(25,40,83,0.8));">
            <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="mt-8 text-4xl font-bold tracking-tight sm:text-5xl">Temukan Event Terbaik Kampus</h1>
                    <p class="mt-4 max-w-xl text-base text-white/85 sm:text-lg">Konser, seminar, festival, dan banyak lagi. Jelajahi acara terbaik dengan tampilan yang bersih dan responsif.</p>
                </div>
            </div>
        </section>

        <section id="event" class="bg-[#EFF8FF] py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center">
                    <span class="inline-flex rounded-full bg-[#FFE14E] px-4 py-2 text-sm font-semibold uppercase tracking-[0.24em] text-[#192853] shadow-sm">Etalase Event</span>
                    <h2 class="mt-6 text-3xl font-bold tracking-tight text-[#192853] sm:text-4xl">Temukan Event Seru</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-sm text-[#475569] sm:text-base">Cari event favoritmu, lihat kategori, status, dan detail acara dengan tampilan yang mudah dibaca.</p>
                </div>
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($paginatedEvents as $event)
                        <article class="group overflow-hidden rounded-[32px] border border-[#cbd5e1] bg-white shadow-[0_25px_60px_rgba(25,40,83,0.08)] transition duration-300 hover:-translate-y-1">
                            <a href="{{ route('pengunjung.detail.event', ['id' => $event['id']]) }}" class="block">
                                <div class="overflow-hidden">
                                    <img src="{{ asset('image/' . $event['image']) }}" alt="{{ $event['title'] }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                                </div>
                            </a>
                            <div class="space-y-4 p-6">
                                <div class="flex items-center justify-between gap-3 text-sm font-semibold text-[#475569] flex-nowrap">
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full bg-[#EFF8FF] px-3 py-1 uppercase tracking-[0.12em]">{{ $event['category'] }}</span>
                                    <span class="inline-flex items-center whitespace-nowrap rounded-full bg-[#FFE14E] px-3 py-1 text-[#192853]">{{ $event['status'] }}</span>
                                </div>
                                <h3 class="text-xl font-semibold text-[#192853]">{{ $event['title'] }}</h3>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($paginatedEvents->lastPage() > 1)
                    <div class="mt-12 flex justify-center">
                        <nav aria-label="Pagination">
                            <ul class="inline-flex items-center gap-2">
                                <li>
                                    @if ($paginatedEvents->onFirstPage())
                                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-[#EFF8FF] text-[#475569]">&laquo;</span>
                                    @else
                                        <a href="{{ $paginatedEvents->previousPageUrl() }}#event" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&laquo;</a>
                                    @endif
                                </li>
                                @for ($i = 1; $i <= $paginatedEvents->lastPage(); $i++)
                                    <li>
                                        @if ($paginatedEvents->currentPage() == $i)
                                            <span class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-full bg-[#192853] px-4 text-sm font-semibold text-white">{{ $i }}</span>
                                        @else
                                            <a href="{{ $paginatedEvents->url($i) }}#event" class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-full border border-[#cbd5e1] bg-white px-4 text-sm font-medium text-[#192853] transition hover:bg-[#EFF8FF]">{{ $i }}</a>
                                        @endif
                                    </li>
                                @endfor
                                <li>
                                    @if ($paginatedEvents->hasMorePages())
                                        <a href="{{ $paginatedEvents->nextPageUrl() }}#event" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&raquo;</a>
                                    @else
                                        <span class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-[#EFF8FF] text-[#475569]">&raquo;</span>
                                    @endif
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </section>

        <section id="about" class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-12 text-center">
                    <p class="mx-auto inline-flex rounded-full bg-[#FFE14E] px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-[#192853] shadow-sm">Tentang Eventiket</p>
                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-[#192853] sm:text-4xl">Platform Inovatif Untuk Event Kampus</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-[#475569] sm:text-base">Eventiket membantu Anda menemukan event dengan tampilan modern dan navigasi yang responsif, tanpa gangguan padding berlebih.</p>
                </div>
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-[32px] border border-[#cbd5e1] bg-white p-8 shadow-sm">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-[#192853] text-white">
                            <i class="fa-solid fa-calendar-days text-lg"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#192853]">Event Lengkap</h3>
                        <p class="text-sm leading-7 text-[#475569]">Temukan berbagai acara kampus seperti konser, seminar, dan festival dengan detail yang jelas.</p>
                    </div>
                    <div class="rounded-[32px] border border-[#cbd5e1] bg-white p-8 shadow-sm">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-[#FFE14E] text-[#192853]">
                            <i class="fa-solid fa-map-marker-alt text-lg"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#192853]">Lokasi & Agenda</h3>
                        <p class="text-sm leading-7 text-[#475569]">Dapatkan informasi lokasi dan jadwal acara dengan cepat sehingga Anda bisa merencanakan kehadiran lebih mudah.</p>
                    </div>
                    <div class="rounded-[32px] border border-[#cbd5e1] bg-white p-8 shadow-sm">
                        <div class="mb-6 inline-flex h-14 w-14 items-center justify-center rounded-3xl bg-[#192853] text-white">
                            <i class="fa-solid fa-users-line text-lg"></i>
                        </div>
                        <h3 class="mb-3 text-xl font-semibold text-[#192853]">Bergabung Bersama</h3>
                        <p class="text-sm leading-7 text-[#475569]">Gabung dengan ribuan peserta dan jadikan pengalaman kampus Anda lebih seru dengan event-event pilihan.</p>
                    </div>
                </div>
            </div>
        </section>

    <section id="contact" class="bg-[#EFF8FF] py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="grid gap-10 xl:grid-cols-[1.4fr_1fr]">

            <!-- LEFT FORM -->
            <div class="bg-white rounded-3xl p-8 shadow-xl">

            <!-- TITLE -->
            <span class="inline-block bg-[#FFE14E] text-[#192853] text-xs font-semibold px-4 py-2 rounded-full mb-4 shadow">
                HUBUNGI KAMI
            </span>

            <h2 class="text-3xl font-bold text-[#192853] mb-3">
                Kirim Pesan Sekarang
            </h2>

            <p class="text-sm text-[#475569] mb-8">
                Isi formulir di bawah ini dan kami akan menghubungi Anda dalam 1×24 jam.
            </p>

            <!-- FORM -->
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
                @csrf

                <!-- ROW -->
                <div class="grid gap-6 md:grid-cols-2">

                    <!-- NAMA -->
                    <div>
                        <label class="block text-sm font-semibold text-[#192853] mb-2">
                            Nama Lengkap <span class="text-[#FFE14E]">*</span>
                        </label>
                        <input type="text" name="name" placeholder="Masukkan nama"
                            class="w-full rounded-xl border border-gray-300 bg-[#f8fafc] px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-[#FFE14E] focus:border-[#192853] transition shadow-sm">
                    </div>

                    <!-- EMAIL -->
                    <div>
                        <label class="block text-sm font-semibold text-[#192853] mb-2">
                            Email <span class="text-[#FFE14E]">*</span>
                        </label>
                        <input type="email" name="email" placeholder="Masukkan email"
                            class="w-full rounded-xl border border-gray-300 bg-[#f8fafc] px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-[#FFE14E] focus:border-[#192853] transition shadow-sm">
                    </div>

                </div>

                <!-- SUBJECT -->
                <div>
                    <label class="block text-sm font-semibold text-[#192853] mb-2">
                        Subjek <span class="text-[#FFE14E]">*</span>
                    </label>
                    <input type="text" name="subject" placeholder="Subjek"
                        class="w-full rounded-xl border border-gray-300 bg-[#f8fafc] px-4 py-3 text-sm
                        focus:outline-none focus:ring-2 focus:ring-[#FFE14E] focus:border-[#192853] transition shadow-sm">
                </div>

                <!-- PESAN -->
                <div>
                    <label class="block text-sm font-semibold text-[#192853] mb-2">
                        Pesan <span class="text-[#FFE14E]">*</span>
                    </label>
                    <textarea name="message" rows="5" placeholder="Tuliskan pesanmu di sini..."
                        class="w-full rounded-xl border border-gray-300 bg-[#f8fafc] px-4 py-3 text-sm
                        focus:outline-none focus:ring-2 focus:ring-[#FFE14E] focus:border-[#192853] transition shadow-sm"></textarea>
                </div>

                <!-- BUTTON -->
                <button type="submit"
                    class="w-full bg-[#192853] text-white py-3 rounded-xl font-semibold flex items-center justify-center gap-2
                    hover:bg-[#FFE14E] hover:text-[#192853] transition shadow-md">

                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Pesan
                </button>

            </form>
        </div>

        <!-- RIGHT INFO -->
        <div class="space-y-6">

            <!-- EMAIL -->
            <div class="bg-white rounded-3xl p-6 shadow-lg flex items-start gap-4">
                <div class="w-12 h-12 bg-[#192853] text-white flex items-center justify-center rounded-full">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-[#192853]">Email</h3>
                    <p class="text-sm text-[#475569] mt-1">
                        <a href="mailto:eventiket@gmail.com" class="underline font-medium">
                            eventiket@gmail.com
                        </a>
                    </p>
                </div>
            </div>

            <!-- TELEPON -->
            <div class="bg-white rounded-3xl p-6 shadow-lg flex items-start gap-4">
                <div class="w-12 h-12 bg-[#192853] text-white flex items-center justify-center rounded-full">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-[#192853]">Telepon</h3>
                    <p class="text-sm text-[#475569] mt-1">
                        <a href="tel:+62211234567" class="underline font-medium">
                            +62 21 123 4567
                        </a><br>
                        Senin – Jumat, 08.00 – 17.00 WIB
                    </p>
                </div>
            </div>

            <!-- LOKASI -->
            <div class="bg-white rounded-3xl p-6 shadow-lg flex items-start gap-4">
                <div class="w-12 h-12 bg-[#192853] text-white flex items-center justify-center rounded-full">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div>
                    <h3 class="font-semibold text-[#192853]">Lokasi</h3>
                    <p class="text-sm text-[#475569] mt-1">
                        Batam Center, Kota Batam<br>
                        Kepulauan Riau, Indonesia
                    </p>
                </div>
            </div>
    <!-- MEDIA SOSIAL -->
    <div class="bg-white rounded-3xl p-6 shadow-lg flex items-start gap-4">
    
    <!-- ICON -->
    <div class="w-12 h-12 bg-[#192853] text-white flex items-center justify-center rounded-full">
        <i class="fa-solid fa-share-nodes"></i>
    </div>

    <!-- CONTENT -->
    <div>
        <h3 class="text-lg font-semibold text-[#192853]">Media Sosial</h3>

        <div class="mt-3 flex gap-3">

            <!-- WHATSAPP -->
            <a href="#" aria-label="WhatsApp"
                class="w-11 h-11 flex items-center justify-center rounded-full bg-[#EFF8FF] text-[#192853]
                hover:bg-[#FFE14E] transition">
                <i class="fa-brands fa-whatsapp text-lg"></i>
            </a>

            <!-- INSTAGRAM -->
            <a href="#" aria-label="Instagram"
                class="w-11 h-11 flex items-center justify-center rounded-full bg-[#EFF8FF] text-[#192853]
                hover:bg-[#FFE14E] transition">
                <i class="fa-brands fa-instagram text-lg"></i>
            </a>

            <!-- YOUTUBE -->
            <a href="#" aria-label="YouTube"
                class="w-11 h-11 flex items-center justify-center rounded-full bg-[#EFF8FF] text-[#192853]
                hover:bg-[#FFE14E] transition">
                <i class="fa-brands fa-youtube text-lg"></i>
            </a>

        </div>
    </div>

</div>
        </div>

    </div>

</div>
</section>

    </main>

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
                            <li><a href="#home" class="text-sm text-[#EFF8FF]/80 hover:text-[#FFE14E] transition">Beranda</a></li>
                            <li><a href="#event" class="text-sm text-[#EFF8FF]/80 hover:text-[#FFE14E] transition">Etalase</a></li>
                            <li><a href="#about" class="text-sm text-[#EFF8FF]/80 hover:text-[#FFE14E] transition">Tentang Kami</a></li>
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
</body>
</html>
