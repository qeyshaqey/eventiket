@extends('layouts.pengunjung')

@section('title', 'Dashboard Pengunjung - Eventiket')

@section('body_class', 'min-h-screen bg-[#EFF8FF] text-[#192853]')

@push('styles')
<style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
@endpush

@section('content')
<!-- HERO SECTION -->
    <main>
        <section class="relative overflow-hidden bg-[#192853] text-white" style="background-image: radial-gradient(circle at top, rgba(255,225,78,0.14), transparent 40%), linear-gradient(180deg, rgba(25,40,83,0.95), rgba(25,40,83,0.8));">
            <div class="mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8">
                <div class="max-w-3xl">
                    <h1 class="mt-8 text-4xl font-bold tracking-tight sm:text-5xl">Temukan Event Terbaik Kampus</h1>
                    <p class="mt-4 max-w-xl text-base text-white/85 sm:text-lg">Konser, seminar, festival, dan banyak lagi. Jelajahi acara terbaik dengan tampilan yang bersih dan responsif.</p>
                </div>
            </div>
        </section>

        <section id="event" class="bg-[#EFF8FF] py-12">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <form id="search-form" action="{{ route('pengunjung.dashboard') }}#event" method="GET" class="flex w-full gap-3 md:w-auto md:flex-1">
                        <div class="relative w-full md:flex md:items-center md:gap-3">
                            <div class="relative w-full md:w-auto md:flex-1">
                                <input id="search-input" name="search" value="{{ $search ?? '' }}" type="text" placeholder="Cari event..." class="w-full rounded-full border border-[#cbd5e1] bg-white px-4 py-3 pr-12 text-sm text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none" autocomplete="off" />
                                <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-[#192853] px-3 py-2 text-white transition hover:bg-[#111827]">
                                    <i class="fa-solid fa-search"></i>
                                </button>
                            </div>

                            <!-- FILTER KATEGORI -->
                            <select id="category-select" name="category" class="rounded-full border border-[#cbd5e1] bg-white px-4 py-3 text-sm text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none">
                                <option value="semua" {{ ($category ?? 'semua') === 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                                <option value="Seminar" {{ ($category ?? '') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                <option value="Sosial" {{ ($category ?? '') === 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="Olahraga" {{ ($category ?? '') === 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                <option value="Hiburan" {{ ($category ?? '') === 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                                <option value="Kompetisi" {{ ($category ?? '') === 'Kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                                <option value="Religi" {{ ($category ?? '') === 'Religi' ? 'selected' : '' }}>Religi</option>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- CARD EVENT -->
                <div id="dashboard-results">
                    @include('Pengunjung.partials.dashboard_event_section')
                </div>
            </div>
        </section>
    </main>

    <!-- JAVASCRIPT -->
@endsection

@push('scripts')
<script>
        const searchInput = document.getElementById('search-input');
        const categorySelect = document.getElementById('category-select');
        const searchForm = document.getElementById('search-form');
        const dashboardResults = document.getElementById('dashboard-results');
        const ajaxUrl = "{{ route('pengunjung.dashboard.ajax') }}";
        let timeoutId = null;

        function buildQuery(params) {
            return new URLSearchParams(params).toString();
        }

        async function fetchResults(page = 1) {
            const query = buildQuery({
                search: searchInput.value.trim(),
                category: categorySelect.value,
                page,
            });

            const response = await fetch(`${ajaxUrl}?${query}`);
            if (!response.ok) {
                return;
            }

            const result = await response.json();
            dashboardResults.innerHTML = result.html;
            attachPaginationLinks();
        }

        function attachPaginationLinks() {
            const links = dashboardResults.querySelectorAll('a.paginate-link');
            links.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    const url = new URL(link.href);
                    const page = url.searchParams.get('page') || 1;
                    fetchResults(page);
                });
            });
        }

        if (searchForm) {
            searchForm.addEventListener('submit', function (event) {
                event.preventDefault();
                fetchResults(1);
            });
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    fetchResults(1);
                }, 200);
            });
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', function () {
                fetchResults(1);
            });
        }

        attachPaginationLinks();
    </script>
@endpush
