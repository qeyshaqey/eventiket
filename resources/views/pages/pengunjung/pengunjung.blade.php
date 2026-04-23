@extends('layouts.pengunjung')

@section('title', 'Dashboard Pengunjung - Eventiket')

@section('body_class', 'min-h-screen bg-[#EFF8FF] text-[#192853]')

@push('styles')
<style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
@endpush

@section('content')
<main>
        <section class="relative overflow-hidden bg-[#192853] text-white" style="background-image: radial-gradient(circle at top, rgba(255,225,78,0.14), transparent 40%), linear-gradient(180deg, rgba(25,40,83,0.95), rgba(25,40,83,0.8));">
            <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="mt-8 text-4xl font-bold tracking-tight sm:text-5xl">Temukan Event Terbaik Kampus</h1>
                    <p class="mt-4 max-w-xl text-base text-white/85 sm:text-lg">Semua event tampil serupa, tetapi sekarang Anda sudah berada di dashboard akun dan bisa langsung melihat tiket serta profil.</p>
                </div>
            </div>
        </section>

        <section class="bg-[#EFF8FF] py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <form action="{{ route('pengunjung.dashboard') }}" method="GET" class="flex w-full gap-3 md:w-auto md:flex-1">
                        <div class="relative w-full">
                            <input name="search" value="{{ $search ?? '' }}" type="text" placeholder="Cari event..." class="w-full rounded-full border border-[#cbd5e1] bg-white px-4 py-3 pr-12 text-sm text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none" />
                            <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-[#192853] px-3 py-2 text-white transition hover:bg-[#111827]">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <form action="{{ route('pengunjung.dashboard') }}" method="GET" class="flex items-center gap-3">
                        <input type="hidden" name="search" value="{{ $search ?? '' }}">
                        <select name="category" class="rounded-full border border-[#cbd5e1] bg-white px-4 py-3 text-sm text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none">
                            <option value="semua" {{ ($category ?? 'semua') === 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                            <option value="Musik" {{ ($category ?? '') === 'Musik' ? 'selected' : '' }}>Musik</option>
                            <option value="Pameran" {{ ($category ?? '') === 'Pameran' ? 'selected' : '' }}>Pameran</option>
                            <option value="Workshop" {{ ($category ?? '') === 'Workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="Seminar" {{ ($category ?? '') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                            <option value="Kompetisi" {{ ($category ?? '') === 'Kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                            <option value="Talkshow" {{ ($category ?? '') === 'Talkshow' ? 'selected' : '' }}>Talkshow</option>
                            <option value="Festival" {{ ($category ?? '') === 'Festival' ? 'selected' : '' }}>Festival</option>
                        </select>
                        <button type="submit" class="rounded-full bg-[#192853] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#111827]">Filter</button>
                    </form>
                </div>

                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($paginatedEvents as $event)
                        <article class="group overflow-hidden rounded-[32px] border border-[#cbd5e1] bg-white shadow-[0_25px_60px_rgba(25,40,83,0.08)] transition duration-300 hover:-translate-y-1">
                            <a href="{{ route('detail.event', ['id' => $event['id']]) }}" class="block">
                                <div class="overflow-hidden">
                                    <img src="{{ asset('image/' . $event['image']) }}" alt="{{ $event['title'] }}" class="h-64 w-full object-cover transition duration-500 group-hover:scale-105" />
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
                                        <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->previousPageUrl() }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&laquo;</a>
                                    @endif
                                </li>
                                @for ($i = 1; $i <= $paginatedEvents->lastPage(); $i++)
                                    <li>
                                        @if ($paginatedEvents->currentPage() == $i)
                                            <span class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-full bg-[#192853] px-4 text-sm font-semibold text-white">{{ $i }}</span>
                                        @else
                                            <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->url($i) }}" class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-full border border-[#cbd5e1] bg-white px-4 text-sm font-medium text-[#192853] transition hover:bg-[#EFF8FF]">{{ $i }}</a>
                                        @endif
                                    </li>
                                @endfor
                                <li>
                                    @if ($paginatedEvents->hasMorePages())
                                        <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->nextPageUrl() }}" class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&raquo;</a>
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
    </main>
@endsection

