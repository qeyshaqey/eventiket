@extends('layouts.app')

@section('content')

<div class="flex">

    <!-- CONTENT -->
    <div class="flex-1 px-6 py-8">

        <div class="max-w-5xl mx-auto">

            <!-- HEADER -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-[#192853]">Kelola Event</h1>
            </div>

            <!-- LIST EVENT -->
            <div class="space-y-4">

                @forelse ($events as $i => $event)
                <div class="bg-white rounded-xl border border-[#c8dff5] shadow-sm px-6 py-4 flex items-center justify-between hover:bg-[#EFF8FF] transition">

                    <!-- LEFT -->
                    <div class="flex items-center gap-5">

                        <!-- NOMOR -->
                        <div class="text-base font-semibold text-[#192853] w-6">
                            {{ $loop->iteration }}
                        </div>

                        <!-- DATE -->
                        <div class="bg-gray-200 text-sm font-medium px-4 py-2 rounded-lg">
                            {{ $event['tanggal'] }}
                        </div>

                        <!-- TITLE -->
                        <div class="text-base font-medium text-[#192853]">
                            {{ $event['nama'] }}
                        </div>

                    </div>

                    <!-- ACTION -->
                    <div class="flex items-center gap-3">

                        <a href="/event-approve/{{ $i }}"
                           class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-200 hover:bg-green-100 transition text-sm">
                            ✔
                        </a>

                        <a href="/event-delete/{{ $i }}"
                           class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-200 hover:bg-red-100 transition text-sm">
                            ✖
                        </a>

                    </div>

                </div>

                @empty
                <div class="text-center text-gray-400 py-10">
                    Tidak ada event
                </div>
                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection