@extends('layouts.pengunjung.pengunjung')

@section('title', 'Tiket Saya')

@section('body_class', 'bg-cream font-poppins')

@section('content')
    @php
        $activeTab = request('tab', 'aktif');
        $currentCategory = request('category', 'semua');
        $currentStatus = request('status', 'semua');
        $searchQuery = request('search', '');
        $eventsToShow = $activeTab === 'riwayat' ? $historyEvents : $activeEvents;
    @endphp

    <!-- TAB PILIHAN -->
    <div class="px-6 mt-6">
        <div class="mx-auto flex w-full max-w-xl items-center justify-between pb-3">
            <a href="{{ route('pengunjung.tiket') }}?tab=aktif{{ $currentCategory ? '&category='.$currentCategory : '' }}"
               class="text-sm font-semibold transition {{ $activeTab === 'aktif' ? 'text-navy border-b-4 border-yellow pb-2' : 'text-slate-500 hover:text-slate-700' }}">
                TIKET AKTIF
            </a>
            <a href="{{ route('pengunjung.tiket') }}?tab=riwayat{{ $currentCategory ? '&category='.$currentCategory : '' }}"
               class="text-sm font-semibold transition {{ $activeTab === 'riwayat' ? 'text-navy border-b-4 border-yellow pb-2' : 'text-slate-500 hover:text-slate-700' }}">
                RIWAYAT TRANSAKSI
            </a>
        </div>
    </div>

    <!-- FILTER & SEARCH BAR --> 
    <div class="px-6 mt-6 max-w-3xl mx-auto">
        <!-- UNIFIED PILL CONTAINER -->
        <div class="bg-white md:rounded-full rounded-[24px] p-2 md:p-1.5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 flex flex-col md:flex-row items-center transition-all duration-300 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]">
            
            <!-- SEARCH INPUT -->
            <div class="relative flex-1 w-full flex items-center px-4 py-2 md:py-0">
                <i class="fa-solid fa-search text-slate-400 mr-3"></i>
                <input type="text" id="filter-search" value="{{ request('search') }}" placeholder="Cari judul event..." class="w-full bg-transparent border-transparent focus:border-transparent focus:ring-0 p-0 text-sm text-navy placeholder-slate-400 font-medium outline-none" autocomplete="off" />
            </div>

            <!-- DIVIDER -->
            <div class="hidden md:block w-px h-8 bg-slate-200"></div>
            <div class="md:hidden w-full h-px bg-slate-100 my-1"></div>

            <!-- STATUS DROPDOWN -->
            <div class="relative w-full md:w-auto px-2 py-1 md:py-0 group">
                <select id="filter-status" class="w-full md:w-44 bg-transparent border-transparent focus:border-transparent focus:ring-0 py-2 pl-4 pr-8 text-sm font-semibold text-navy cursor-pointer appearance-none truncate outline-none">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="belum bayar" {{ request('status') == 'Belum Bayar' ? 'selected' : '' }}>Belum Bayar</option>
                    <option value="lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    @if($activeTab === 'riwayat')
                        <option value="dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        <option value="kedaluwarsa" {{ request('status') == 'Kedaluwarsa' ? 'selected' : '' }}>Kedaluwarsa</option>
                    @endif
                </select>
                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none transition-transform group-hover:text-navy"></i>
            </div>

            <!-- DIVIDER -->
            <div class="hidden md:block w-px h-8 bg-slate-200"></div>
            <div class="md:hidden w-full h-px bg-slate-100 my-1"></div>

            <!-- CATEGORY DROPDOWN -->
            <div class="relative w-full md:w-auto px-2 py-1 md:py-0 group">
                <select id="filter-category" class="w-full md:w-44 bg-transparent border-transparent focus:border-transparent focus:ring-0 py-2 pl-4 pr-8 text-sm font-semibold text-navy cursor-pointer appearance-none truncate outline-none">
                    <option value="semua" {{ request('category') == 'semua' ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach(\App\Models\Kategori::pluck('nama_kategori') as $cat)
                        <option value="{{ strtolower($cat) }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
                <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none transition-transform group-hover:text-navy"></i>
            </div>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="px-4 py-8">
        <div class="max-w-3xl mx-auto space-y-6">

            @php
                $filteredEvents = $eventsToShow;
            @endphp

            {{-- Empty state: data memang kosong (belum punya tiket) --}}
            @if(collect($filteredEvents)->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-center" id="empty-state-server">
                    <div class="mb-4 text-navy opacity-25">
                        <i class="fa-solid fa-ticket text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-navy">Belum ada tiket</h3>
                    <p class="mt-2 text-sm text-slate-500">Anda belum memiliki tiket pada bagian ini. Yuk, jelajahi event dan pesan tiket!</p>
                    <a href="{{ route('pengunjung.dashboard') }}" class="mt-5 inline-flex items-center gap-2 bg-navy text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-yellow hover:text-navy transition shadow-sm">
                        <i class="fa-solid fa-compass"></i>
                        Jelajahi Event
                    </a>
                </div>
            @endif

            {{-- Empty state: hasil filter/search kosong (ditampilkan oleh JS) --}}
            <div id="empty-state" class="flex flex-col items-center justify-center py-16 text-center" style="display: none;">
                <div class="mb-4 text-navy opacity-25">
                    <i class="fa-solid fa-magnifying-glass text-6xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-navy">Tiket tidak ditemukan</h3>
                <p class="mt-2 text-sm text-slate-500">Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
            </div>

            @foreach($filteredEvents as $event)

                <div class="ticket-card bg-white rounded-2xl shadow-sm relative hover:shadow-md transition overflow-hidden"
                     data-title="{{ strtolower($event['title'] ?? '') }}"
                     data-status="{{ strtolower($event['status'] == 'Berhasil Diverifikasi' ? 'lunas' : $event['status']) }}"
                     data-category="{{ strtolower($event['category'] ?? 'umum') }}">

                    <!-- LEFT ACCENT BORDER -->
                    <div class="flex">
                        <div class="w-1.5 shrink-0 bg-navy rounded-l-2xl"></div>

                        <div class="flex-1 p-5">

                            <!-- BADGE CATEGORY -->
                            <div class="flex justify-end mb-3">
                                <span class="bg-yellow text-navy text-xs px-4 py-1 rounded-full font-medium shadow-sm">
                                    {{ $event['category'] ?? 'Umum' }}
                                </span>
                            </div>

                            <!-- KODE ORDER -->
                            @if($event['status'] == 'Berhasil Diverifikasi')
                                <div class="grid grid-cols-[140px_10px_1fr] text-sm mb-2">
                                    <span class="font-semibold">KODE ORDER</span>
                                    <span>:</span>
                                    <span class="font-bold">{{ $event['kode_order'] }}</span>
                                </div>
                            @endif

                            <!-- DATA -->
                            <div class="grid grid-cols-[140px_10px_1fr] gap-y-3 text-sm text-grayCustom leading-relaxed">

                                <span class="flex items-center gap-2"><i class="fa-solid fa-star text-navy/40 text-xs w-4 text-center"></i> Judul Event</span>
                                <span>:</span><span class="font-medium text-navy">{{ $event['title'] ?? '-' }}</span>

                                <span class="flex items-center gap-2"><i class="fa-regular fa-calendar text-navy/40 text-xs w-4 text-center"></i> Tanggal</span>
                                <span>:</span><span>{{ $event['date'] }}</span>

                                <span class="flex items-center gap-2"><i class="fa-regular fa-clock text-navy/40 text-xs w-4 text-center"></i> Waktu</span>
                                <span>:</span><span>{{ $event['time'] }}</span>

                                <span class="flex items-center gap-2"><i class="fa-solid fa-location-dot text-navy/40 text-xs w-4 text-center"></i> Lokasi</span>
                                <span>:</span><span>{{ $event['location'] }}</span>

                                <span class="flex items-center gap-2"><i class="fa-solid fa-ticket text-navy/40 text-xs w-4 text-center"></i> Tiket</span>
                                <span>:</span>
                                <div class="space-y-1">
                                    @foreach($event['tickets'] as $t)
                                        <p>{{ $t['name'] }} ({{ $t['qty'] }})</p>
                                    @endforeach
                                </div>

                                <span class="flex items-center gap-2"><i class="fa-solid fa-circle-info text-navy/40 text-xs w-4 text-center"></i> Status</span>
                                <span>:</span>
                                <span class="font-semibold
                                    @if($event['status'] == 'Belum Bayar') text-red-500
                                    @elseif($event['status'] == 'Menunggu Verifikasi') text-yellow-500
                                    @elseif($event['status'] == 'Ditolak') text-gray-400
                                    @elseif($event['status'] == 'Berhasil Diverifikasi' || $event['status'] == 'Lunas') text-emerald-500
                                    @endif
                                ">
                                    {{ $event['status'] == 'Berhasil Diverifikasi' ? 'Lunas' : $event['status'] }}
                                    {{-- Badge AKTIF/SELESAI: hanya muncul di mobile, inline --}}
                                    @if($event['status'] == 'Berhasil Diverifikasi' || $event['status'] == 'Lunas')
                                        <span class="sm:hidden inline-flex items-center ml-1 bg-gray-200 text-navy text-[10px] px-3 py-0.5 rounded-full font-bold tracking-wide align-middle">
                                            {{ $activeTab === 'riwayat' ? 'SELESAI' : 'AKTIF' }}
                                        </span>
                                    @endif
                                </span>

                            </div>

                    <!-- BUTTON BAYAR -->
                    @if($event['status'] == 'Belum Bayar')
                        <div class="mt-5 flex gap-3">
                            <button type="button" onclick="confirmCancel('{{ $event['id'] ?? '' }}')" class="w-1/3 inline-flex items-center justify-center rounded-full border border-slate-300 bg-white py-2 text-sm font-semibold text-grayCustom transition hover:border-yellow hover:bg-yellow/10 shadow-sm">
                                Batal
                            </button>
                            <a href="{{ route('pengunjung.pembayaran') }}" class="w-2/3 inline-flex items-center justify-center bg-navy text-white py-2 rounded-full text-sm font-semibold hover:bg-yellow hover:text-navy transition shadow-sm">
                                Lakukan Pembayaran
                            </a>
                        </div>
                    @endif

                    {{-- Badge AKTIF/SELESAI: hanya muncul di desktop, absolute --}}
                    @if($event['status'] == 'Berhasil Diverifikasi' || $event['status'] == 'Lunas')
                        <div class="hidden sm:block absolute bottom-4 right-4 bg-gray-200 text-xs px-4 py-1 rounded-full font-medium">
                            {{ $activeTab === 'riwayat' ? 'SELESAI' : 'AKTIF' }}
                        </div>
                    @endif

                        </div>{{-- end flex-1 p-5 --}}
                    </div>{{-- end flex (left accent) --}}

                </div>{{-- end card --}}

            @endforeach

            <!-- PAGINATION CONTAINER (Di-generate oleh JS) -->
            <div id="pagination-container" class="mt-8 flex justify-center items-center gap-2"></div>

        </div>
    </div>
@endsection

@push('scripts')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCancel(eventId) {
            Swal.fire({
                title: 'Batalkan Tiket?',
                text: "Apakah Anda yakin ingin membatalkan pesanan tiket ini? Tindakan ini tidak dapat diurungkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#192853',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Kembali',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    
                    // Ambil CSRF token
                    const csrfToken = document.querySelector('meta[name="csrf-token"]') 
                        ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        : '{{ csrf_token() }}';

                    // Lakukan request ke backend
                    fetch(`{{ url('pengunjung/tiket') }}/${eventId}/batal`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                title: 'Dibatalkan!',
                                text: 'Pesanan tiket berhasil dibatalkan.',
                                icon: 'success',
                                confirmButtonColor: '#192853'
                            }).then(() => {
                                // Arahkan ke tab riwayat transaksi
                                window.location.href = "{{ route('pengunjung.tiket') }}?tab=riwayat";
                            });
                        } else {
                            Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Gagal!', 'Tidak dapat terhubung ke server.', 'error');
                    });
                }
            })
        }

        // FUNGSI PENCARIAN REAL-TIME & PAGINATION (Client-Side)
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('filter-search');
            const statusSelect = document.getElementById('filter-status');
            const categorySelect = document.getElementById('filter-category');
            const cards = document.querySelectorAll('.ticket-card');
            const emptyState = document.getElementById('empty-state');
            const emptyStateServer = document.getElementById('empty-state-server');
            
            const ITEMS_PER_PAGE = 5;
            let currentPage = 1;
            let matchedCards = [];

            function filterTickets() {
                const searchVal = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const statusVal = statusSelect ? statusSelect.value.toLowerCase() : 'semua';
                const catVal = categorySelect ? categorySelect.value.toLowerCase() : 'semua';
                const isFiltering = searchVal !== '' || statusVal !== 'semua' || catVal !== 'semua';
                
                matchedCards = [];
                
                cards.forEach(card => {
                    const title = card.getAttribute('data-title');
                    const status = card.getAttribute('data-status');
                    const category = card.getAttribute('data-category');
                    
                    const matchSearch = searchVal === '' || title.includes(searchVal);
                    const matchStatus = statusVal === 'semua' || status === statusVal;
                    const matchCat = catVal === 'semua' || category === catVal;
                    
                    if (matchSearch && matchStatus && matchCat) {
                        matchedCards.push(card);
                    }
                    card.style.display = 'none'; // Sembunyikan semua dulu
                });
                
                // Reset ke halaman 1 setiap filter berubah
                currentPage = 1;
                renderPage();
                
                // Sembunyikan empty state server jika user sedang memfilter
                if (emptyStateServer) {
                    emptyStateServer.style.display = (matchedCards.length === 0 && !isFiltering && cards.length === 0) ? 'flex' : 'none';
                }
                
                // Tampilkan empty state JS hanya jika user memfilter dan hasilnya kosong
                if (emptyState) {
                    emptyState.style.display = (matchedCards.length === 0 && (isFiltering || cards.length > 0)) ? 'flex' : 'none';
                }
            }

            function renderPage() {
                // Sembunyikan semua matched cards dulu
                matchedCards.forEach(card => card.style.display = 'none');
                
                const totalPages = Math.ceil(matchedCards.length / ITEMS_PER_PAGE);
                if (currentPage > totalPages) currentPage = totalPages || 1;
                
                const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
                const endIndex = startIndex + ITEMS_PER_PAGE;
                
                // Tampilkan yang masuk dalam rentang halaman ini
                matchedCards.slice(startIndex, endIndex).forEach(card => {
                    card.style.display = 'block';
                });
                
                renderPagination(totalPages);
            }

            function renderPagination(totalPages) {
                const container = document.getElementById('pagination-container');
                if (!container) return;
                
                container.innerHTML = '';
                if (totalPages <= 1) return; // Jangan tampilkan jika cuma 1 halaman
                
                // Prev Button
                const prevBtn = document.createElement('button');
                prevBtn.innerHTML = '<i class="fa-solid fa-chevron-left text-xs"></i>';
                prevBtn.className = `w-8 h-8 rounded-full flex items-center justify-center border transition focus:outline-none ${currentPage === 1 ? 'border-slate-200 text-slate-300 cursor-not-allowed' : 'border-slate-300 text-navy hover:bg-navy hover:text-white'}`;
                prevBtn.disabled = currentPage === 1;
                prevBtn.onclick = () => { 
                    if(currentPage > 1) { 
                        currentPage--; 
                        renderPage(); 
                        document.querySelector('.max-w-3xl').scrollIntoView({behavior: 'smooth', block: 'start'});
                    } 
                };
                container.appendChild(prevBtn);
                
                // Page Numbers
                for (let i = 1; i <= totalPages; i++) {
                    const pageBtn = document.createElement('button');
                    pageBtn.innerText = i;
                    if (i === currentPage) {
                        pageBtn.className = 'w-8 h-8 rounded-full flex items-center justify-center bg-navy text-white font-medium shadow-sm focus:outline-none';
                    } else {
                        pageBtn.className = 'w-8 h-8 rounded-full flex items-center justify-center border border-slate-300 text-slate-600 font-medium hover:bg-slate-50 transition focus:outline-none';
                    }
                    pageBtn.onclick = () => { 
                        currentPage = i; 
                        renderPage(); 
                        document.querySelector('.max-w-3xl').scrollIntoView({behavior: 'smooth', block: 'start'});
                    };
                    container.appendChild(pageBtn);
                }
                
                // Next Button
                const nextBtn = document.createElement('button');
                nextBtn.innerHTML = '<i class="fa-solid fa-chevron-right text-xs"></i>';
                nextBtn.className = `w-8 h-8 rounded-full flex items-center justify-center border transition focus:outline-none ${currentPage === totalPages ? 'border-slate-200 text-slate-300 cursor-not-allowed' : 'border-slate-300 text-navy hover:bg-navy hover:text-white'}`;
                nextBtn.disabled = currentPage === totalPages;
                nextBtn.onclick = () => { 
                    if(currentPage < totalPages) { 
                        currentPage++; 
                        renderPage(); 
                        document.querySelector('.max-w-3xl').scrollIntoView({behavior: 'smooth', block: 'start'});
                    } 
                };
                container.appendChild(nextBtn);
            }

            if (searchInput) searchInput.addEventListener('input', filterTickets);
            if (statusSelect) statusSelect.addEventListener('change', filterTickets);
            if (categorySelect) categorySelect.addEventListener('change', filterTickets);

            // Inisialisasi awal saat halaman dimuat
            filterTickets();
        });
    </script>
@endpush
