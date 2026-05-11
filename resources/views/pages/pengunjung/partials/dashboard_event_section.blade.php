<div id="dashboard-result-list">
    <div class="grid grid-cols-2 gap-3 sm:gap-6 md:grid-cols-2 xl:grid-cols-4">
        <!-- Looping / nge-print kartu event satu per satu sesuai data array yang dikirim dari Controller -->
        @foreach ($paginatedEvents as $event)
            <article class="group overflow-hidden rounded-2xl sm:rounded-[32px] border border-[#cbd5e1] bg-white shadow-md sm:shadow-[0_25px_60px_rgba(25,40,83,0.08)] transition duration-300 hover:-translate-y-1">
                <!-- Bikin seluruh card bisa di-klik dan mengarah ke route detail.event berdasarkan ID-nya -->
                <a href="{{ route('pengunjung.detail.event', ['id' => $event['id']]) }}" class="block">
                    <div class="overflow-hidden">
                        <!-- Nampilin poster event, ditambah efek scale (membesar sedikit) pas kursor di-hover biar UI-nya interaktif  -->
                        <img src="{{ asset('image/' . $event['image']) }}" alt="{{ $event['title'] }}" class="h-40 sm:h-64 w-full object-cover transition duration-500 group-hover:scale-105">
                    </div>
                </a>
                <div class="space-y-2 sm:space-y-4 p-3 sm:p-6">
                    <!-- Menampilkan dua badge kecil: satu buat Kategori (misal: Seminar) dan satu lagi buat status tiket -->
                    <div class="flex flex-wrap items-center justify-between gap-2 text-[10px] sm:text-sm font-semibold text-[#475569]">
                        <span class="inline-flex items-center whitespace-nowrap rounded-full bg-[#EFF8FF] px-2 py-0.5 sm:px-3 sm:py-1 uppercase tracking-wider">{{ $event['category'] }}</span>
                        <span class="inline-flex items-center whitespace-nowrap rounded-full bg-[#FFE14E] px-2 py-0.5 sm:px-3 sm:py-1 text-[#192853]">{{ $event['status'] }}</span>
                    </div>
                    <h3 class="text-sm sm:text-xl font-bold text-[#192853] line-clamp-2">{{ $event['title'] }}</h3>
                </div>
            </article>
        @endforeach
    </div>

    </div>

    <!-- BAGIAN PAGINATION: Cuma dimunculin kalau total data event butuh lebih dari 1 halaman -->
    @if ($paginatedEvents->lastPage() > 1)
        <div class="mt-12 flex justify-center">
            <nav aria-label="Pagination">
                <ul class="inline-flex items-center gap-2">
                    <li>
                        @if ($paginatedEvents->onFirstPage())
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-[#EFF8FF] text-[#475569]">&laquo;</span>
                        @else
                            <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->previousPageUrl() }}#event" class="paginate-link inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&laquo;</a>
                        @endif
                    </li>
                    <!-- Angka halaman yang sedang aktif akan berwarna biru gelap dan ngka halaman yang tidak aktif berwarna putih -->
                    @for ($i = 1; $i <= $paginatedEvents->lastPage(); $i++)
                        <li>
                            @if ($paginatedEvents->currentPage() == $i)
                                <span class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-full bg-[#192853] px-4 text-sm font-semibold text-white">{{ $i }}</span>
                            @else
                                {{-- TIPS PENTING: Pake fungsi appends() biar pas kita nge-klik halaman 2/3, filter search & kategori sebelumnya gak ke-reset ulang --}}
                                <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->url($i) }}#event" class="paginate-link inline-flex h-11 min-w-[44px] items-center justify-center rounded-full border border-[#cbd5e1] bg-white px-4 text-sm font-medium text-[#192853] transition hover:bg-[#EFF8FF]">{{ $i }}</a>
                            @endif
                        </li>
                    @endfor
                    
                    <li>
                        @if ($paginatedEvents->hasMorePages())
                            <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->nextPageUrl() }}#event" class="paginate-link inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&raquo;</a>
                        @else
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-[#EFF8FF] text-[#475569]">&raquo;</span>
                        @endif
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</div>
