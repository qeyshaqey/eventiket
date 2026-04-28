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
                <div class="mb-8">
                    <form id="search-form" action="{{ route('pengunjung.dashboard') }}#event" method="GET" class="w-full">
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- SEARCH INPUT -->
                            <div class="relative flex-1">
                                <input id="search-input" name="search" value="{{ $search ?? '' }}" type="text" placeholder="Cari event..." class="w-full h-11 sm:h-12 rounded-full border border-slate-300 bg-white pl-5 sm:pl-6 pr-12 sm:pr-14 text-sm text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none transition" autocomplete="off" />
                                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 aspect-square rounded-full bg-[#192853] flex items-center justify-center text-white transition hover:bg-[#FFE14E] hover:text-[#192853]">
                                    <i class="fa-solid fa-search text-sm"></i>
                                </button>
                            </div>

                            <!-- FILTER KATEGORI (CUSTOM DROPDOWN) -->
                            <div class="relative w-full md:w-64 shrink-0" id="category-dropdown-container">
                                <input type="hidden" name="category" id="category-input" value="{{ $category ?? 'semua' }}">
                                <button type="button" id="category-btn" class="flex items-center justify-between w-full h-11 sm:h-12 rounded-full border border-slate-300 bg-white px-5 sm:px-6 text-sm font-medium text-[#192853] shadow-sm focus:border-[#192853] focus:outline-none transition text-left">
                                    <span id="category-label">{{ ($category ?? 'semua') === 'semua' ? 'Semua Kategori' : $category }}</span>
                                    <i class="fa-solid fa-chevron-down text-xs text-slate-500 transition-transform duration-300" id="category-icon"></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="category-menu" class="absolute left-0 right-0 top-full mt-2 z-50 hidden opacity-0 translate-y-2 transition-all duration-200">
                                    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                                        <div class="p-2">
                                            @foreach(['semua', 'Seminar', 'Sosial', 'Olahraga', 'Hiburan', 'Kompetisi', 'Keagamaan'] as $cat)
                                                <button type="button" 
                                                    onclick="selectCategory('{{ $cat }}')"
                                                    class="w-full text-left px-4 py-2.5 text-sm rounded-xl transition hover:bg-[#EFF8FF] hover:text-[#192853] {{ ($category ?? 'semua') === $cat ? 'bg-[#EFF8FF] text-[#192853] font-semibold' : 'text-slate-600' }}">
                                                    {{ $cat === 'semua' ? 'Semua Kategori' : $cat }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
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
    // Fungsi global agar bisa dipanggil dari onclick="..."
    function toggleCategoryMenu() {
        const menu = document.getElementById('category-menu');
        const icon = document.getElementById('category-icon');
        if (!menu || !icon) return;

        const isHidden = menu.classList.contains('hidden');
        if (isHidden) {
            menu.classList.remove('hidden');
            setTimeout(() => {
                menu.classList.remove('opacity-0', 'translate-y-2');
                icon.classList.add('rotate-180');
            }, 10);
        } else {
            closeCategoryMenu();
        }
    }

    function closeCategoryMenu() {
        const menu = document.getElementById('category-menu');
        const icon = document.getElementById('category-icon');
        if (!menu || !icon) return;

        menu.classList.add('opacity-0', 'translate-y-2');
        icon.classList.remove('rotate-180');
        setTimeout(() => {
            menu.classList.add('hidden');
        }, 200);
    }

    function selectCategory(value) {
        const input = document.getElementById('category-input');
        const label = document.getElementById('category-label');
        if (!input || !label) return;

        input.value = value;
        label.innerText = value === 'semua' ? 'Semua Kategori' : value;
        closeCategoryMenu();
        
        // Trigger AJAX fetch
        input.dispatchEvent(new Event('change'));
    }

    document.addEventListener('DOMContentLoaded', function() {
        const categoryBtn = document.getElementById('category-btn');
        const categoryMenu = document.getElementById('category-menu');
        const searchInput = document.getElementById('search-input');
        const categoryInput = document.getElementById('category-input');
        const searchForm = document.getElementById('search-form');
        const dashboardResults = document.getElementById('dashboard-results');
        const ajaxUrl = "{{ route('pengunjung.dashboard.ajax') }}";
        let timeoutId = null;

        if (categoryBtn) {
            categoryBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                toggleCategoryMenu();
            });
        }

        document.addEventListener('click', (e) => {
            if (categoryMenu && !categoryMenu.contains(e.target) && e.target !== categoryBtn) {
                closeCategoryMenu();
            }
        });

        function buildQuery(params) {
            return new URLSearchParams(params).toString();
        }

        async function fetchResults(page = 1) {
            try {
                const query = buildQuery({
                    search: searchInput ? searchInput.value.trim() : '',
                    category: categoryInput ? categoryInput.value : 'semua',
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
                if (searchForm) searchForm.submit();
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
            searchInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(function () {
                    fetchResults(1);
                }, 400);
            });
        }

        if (categoryInput) {
            categoryInput.addEventListener('change', function () {
                fetchResults(1);
            });
        }

        attachPaginationLinks();
    });
</script>

