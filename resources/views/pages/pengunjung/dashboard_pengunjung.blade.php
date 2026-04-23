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
                    <form id="search-form" action="{{ route('pengunjung.dashboard') }}#event" method="GET" class="w-full">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <!-- SEARCH INPUT -->
                            <div class="relative flex-1">
                                <input id="search-input" name="search" value="{{ $search ?? '' }}" type="text" placeholder="Cari event..." class="w-full h-12 rounded-full border border-slate-300 bg-white pl-6 pr-14 text-sm text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none transition" autocomplete="off" />
                                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 aspect-square rounded-full bg-[#192853] flex items-center justify-center text-white transition hover:bg-[#FFE14E] hover:text-[#192853]">
                                    <i class="fa-solid fa-search text-sm"></i>
                                </button>
                            </div>

                            <!-- FILTER KATEGORI -->
                            <div class="relative w-full sm:w-56 shrink-0">
                                <select id="category-select" name="category" onchange="this.form.submit()" class="w-full h-12 appearance-none rounded-full border border-slate-300 bg-white pl-6 pr-10 text-sm font-medium text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none transition cursor-pointer">
                                    <option value="semua" {{ ($category ?? 'semua') === 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                                    <option value="Seminar" {{ ($category ?? '') === 'Seminar' ? 'selected' : '' }}>Seminar</option>
                                    <option value="Sosial" {{ ($category ?? '') === 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                    <option value="Olahraga" {{ ($category ?? '') === 'Olahraga' ? 'selected' : '' }}>Olahraga</option>
                                    <option value="Hiburan" {{ ($category ?? '') === 'Hiburan' ? 'selected' : '' }}>Hiburan</option>
                                    <option value="Kompetisi" {{ ($category ?? '') === 'Kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                                    <option value="Religi" {{ ($category ?? '') === 'Religi' ? 'selected' : '' }}>Religi</option>
                                </select>
                                <!-- Custom Dropdown Icon -->
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- CARD EVENT -->
                <div id="dashboard-results">
                    @include('pages.pengunjung.partials.dashboard_event_section')
                </div>
            </div>
        </section>
    </main>

    <!-- JAVASCRIPT -->
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
            try {
                const query = buildQuery({
                    search: searchInput.value.trim(),
                    category: categorySelect.value,
                    page,
                });

                const response = await fetch(`${ajaxUrl}?${query}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!response.ok) return;

                const result = await response.json();
                if (dashboardResults && result.html !== undefined) {
                    dashboardResults.innerHTML = result.html;
                    attachPaginationLinks();
                }
            } catch (error) {
                console.error("AJAX Error:", error);
                // Fallback to normal form submit if AJAX fails
                searchForm.submit();
            }
        }

        function attachPaginationLinks() {
            if (!dashboardResults) return;
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
            // Live Search (tanpa enter)
            searchInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    fetchResults(1);
                }, 400); // 400ms debounce
            });
        }

        if (categorySelect) {
            // Live Filter (tanpa reload penuh jika AJAX berhasil)
            categorySelect.removeAttribute('onchange'); // Hapus fallback native submit jika JS jalan
            categorySelect.addEventListener('change', function () {
                fetchResults(1);
            });
        }

        attachPaginationLinks();
    });
</script>

