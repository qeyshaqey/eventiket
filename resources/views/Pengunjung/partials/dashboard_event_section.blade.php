<div id="dashboard-result-list">
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
                        <span class="inline-flex max-w-[8rem] items-center overflow-hidden text-ellipsis whitespace-nowrap rounded-full bg-[#EFF8FF] px-2 py-1 uppercase tracking-[0.1em]">{{ $event['category'] }}</span>
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
                            <a href="{{ $paginatedEvents->appends(['search' => $search ?? '', 'category' => $category ?? 'semua'])->previousPageUrl() }}#event" class="paginate-link inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#cbd5e1] bg-white text-[#192853] transition hover:bg-[#EFF8FF]">&laquo;</a>
                        @endif
                    </li>
                    @for ($i = 1; $i <= $paginatedEvents->lastPage(); $i++)
                        <li>
                            @if ($paginatedEvents->currentPage() == $i)
                                <span class="inline-flex h-11 min-w-[44px] items-center justify-center rounded-full bg-[#192853] px-4 text-sm font-semibold text-white">{{ $i }}</span>
                            @else
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
