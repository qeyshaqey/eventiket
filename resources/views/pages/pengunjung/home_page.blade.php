@extends('layouts.pengunjung.pengunjung')

@section('title', 'Beranda - Eventiket')

@section('body_class', 'min-h-screen bg-[#EFF8FF] text-[#192853]')

@section('content')
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
@endsection
