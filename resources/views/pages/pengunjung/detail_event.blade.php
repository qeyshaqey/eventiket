@extends('layouts.pengunjung.pengunjung')

@section('title', 'Detail Event')

@section('body_class', 'bg-cream font-poppins')

@push('styles')
<style>
    @keyframes posterPulse {
        0%   { box-shadow: 0 0 0 0px rgba(255,225,78,0.7); }
        50%  { box-shadow: 0 0 0 8px rgba(255,225,78,0.25); }
        100% { box-shadow: 0 0 0 14px rgba(255,225,78,0); }
    }
    #poster-card {
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        outline: none;
    }
    #poster-card:focus {
        border-color: #FFE14E !important;
        animation: posterPulse 0.6s ease-out forwards;
        box-shadow: 0 0 0 3px rgba(255,225,78,0.5), 0 4px 24px rgba(25,40,83,0.10);
    }
</style>
@endpush

@section('content')
<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-10">

        <!-- LEFT -->
        <div class="space-y-6">

            <!-- IMAGE -->
            <div id="poster-card" tabindex="0"
                 class="relative w-full h-[450px] sm:h-[500px] bg-white rounded-[2rem] border-2 border-slate-200/60 shadow-sm overflow-hidden group flex items-center justify-center p-3 select-none">

                <div class="w-full h-full bg-slate-50/80 rounded-3xl overflow-hidden relative flex items-center justify-center">
                    <img src="{{ $event['image'] }}"
                         alt="{{ $event['title'] }}"
                         class="w-full h-full object-contain transition duration-500 group-hover:scale-[1.03]">
                </div>
            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white rounded-2xl p-6 text-[15px] leading-relaxed text-grayCustom shadow-sm break-words max-h-64 overflow-y-auto">
                {{ $event['description'] ?? 'Deskripsi belum tersedia.' }}
            </div>

        </div>

        <!-- RIGHT -->
        <div class="space-y-6">

            <!-- INFO -->
            <div class="bg-white rounded-2xl p-6 shadow-sm text-[15px]">
                <div class="grid grid-cols-[130px_10px_1fr] gap-y-3">
                    <span class="font-semibold">Judul</span><span>:</span><span>{{ $event['title'] }}</span>
                    <span class="font-semibold">Kategori</span><span>:</span><span>{{ $event['category'] }}</span>
                    <span class="font-semibold">Tanggal</span><span>:</span><span>{{ $event['date'] }}</span>
                    <span class="font-semibold">Waktu</span><span>:</span><span>{{ $event['time'] }}</span>
                    <span class="font-semibold">Lokasi</span><span>:</span><span>{{ $event['venue'] }}</span>
                </div>
            </div>

            <!-- TIKET -->
            <div class="bg-white rounded-2xl p-6 shadow-sm">

                <h3 class="font-semibold mb-6 text-lg">Pilih Jenis Tiket</h3>

                @foreach($event['tickets'] as $i => $ticket)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between bg-white sm:bg-[#F8FAFC] rounded-2xl sm:rounded-xl p-5 sm:px-5 sm:py-4 mb-4 border border-slate-100 sm:border-none shadow-[0_8px_30px_rgb(0,0,0,0.04)] sm:shadow-none gap-5 sm:gap-6 transition-all hover:border-[#FFE14E]/50">

                    <!-- INFO -->
                    <div class="flex flex-col sm:block">
                        <div class="flex items-center justify-between sm:block mb-1 sm:mb-0">
                            <div class="flex items-center gap-2">
                                <p class="font-bold sm:font-semibold text-navy text-lg sm:text-[15px] whitespace-nowrap">{{ $ticket['type'] }}</p>
                                @if(!empty($ticket['description']))
                                    <button type="button" onclick="showTicketInfo({{ $i }})" class="text-slate-400 hover:text-navy transition focus:outline-none" title="Lihat Keterangan Tiket">
                                        <i class="fa-solid fa-circle-info text-sm"></i>
                                    </button>
                                @endif
                            </div>
                            <!-- KUOTA & TERJUAL MOBILE -->
                            <div class="sm:hidden flex items-center gap-2 mt-1">
                                <div class="flex items-center whitespace-nowrap gap-1 text-[10px] font-semibold bg-[#FFF7E0] text-[#192853] px-2 py-0.5 rounded border border-[#FFE14E]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#FFE14E]" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Terjual {{ $ticket['sold'] }}
                                </div>
                                <div class="flex items-center whitespace-nowrap gap-1 text-[10px] font-semibold bg-[#EFF8FF] text-[#192853] px-2 py-0.5 rounded border border-blue-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    Kuota {{ $ticket['quota'] }}
                                </div>
                            </div>
                        </div>
                        <p class="text-base sm:text-sm font-semibold sm:font-normal text-[#192853]/70 sm:text-grayCustom">
                            Rp {{ number_format($ticket['price'],0,',','.') }}
                        </p>
                    </div>

                    <!-- ACTION -->
                    <div class="flex items-center justify-between sm:justify-end gap-4">

                        <!-- STATS DESKTOP -->
                        <div class="hidden sm:flex items-center gap-2">
                            <div class="flex items-center whitespace-nowrap gap-1 text-[11px] font-semibold bg-[#FFF7E0] text-[#192853] px-2.5 py-1 rounded-md border border-[#FFE14E] shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#FFE14E]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                Terjual {{ $ticket['sold'] }}
                            </div>
                            <div class="flex items-center whitespace-nowrap gap-1 text-[11px] font-semibold bg-[#EFF8FF] text-[#192853] px-2.5 py-1 rounded-md border border-blue-200 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                                Kuota {{ $ticket['quota'] }}
                            </div>
                        </div>

                        <!-- COUNTER -->
                        <div class="flex items-center bg-white sm:bg-white rounded-2xl sm:rounded-full p-1 sm:px-2 sm:py-1 shadow-sm border border-slate-100 sm:border-none">

                            <button type="button" onclick="decrease({{ $i }})"
                                class="w-10 h-10 sm:w-8 sm:h-8 flex items-center justify-center rounded-xl sm:rounded-full bg-slate-50 sm:bg-transparent hover:bg-[#FFE14E] hover:text-navy transition-all active:scale-90 text-lg font-bold">-</button>

                            <input id="qty-{{ $i }}" type="text" inputmode="numeric" pattern="[0-9]*" value="0"
                                class="w-12 sm:w-16 bg-transparent text-center font-bold sm:font-medium text-navy outline-none text-base"
                                onchange="setQuantity({{ $i }}, this.value)" oninput="setQuantity({{ $i }}, this.value)">

                            <button type="button" onclick="increase({{ $i }})"
                                class="w-10 h-10 sm:w-8 sm:h-8 flex items-center justify-center rounded-xl sm:rounded-full bg-slate-50 sm:bg-transparent hover:bg-[#FFE14E] hover:text-navy transition-all active:scale-90 text-lg font-bold">+</button>

                        </div>

                    </div>
                </div>
                @endforeach

                <!-- TOTAL -->
                <div class="mt-6 space-y-4 text-sm">

                    <div class="flex justify-between items-center">
                        <span>Jumlah Tiket</span>
                        <span id="totalQty" class="bg-gray-200 px-4 py-1 rounded-full">0</span>
                    </div>

                    <div class="flex justify-between bg-[#F1F5F9] px-5 py-4 rounded-xl font-semibold">
                        <span>Total Harga</span>
                        <span id="totalPrice">Rp 0</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- BUTTON -->
    <div class="mt-12">
        @php
            $isLoggedIn = session()->has('user') && in_array(session('role'), ['pengunjung', 'panitia']);
            $isSoldOut = $event['status'] === 'Tiket Habis';
        @endphp

        @if($isSoldOut)
            <button disabled
                class="inline-flex w-full items-center justify-center bg-slate-300 text-slate-500 py-4 rounded-full text-lg font-semibold cursor-not-allowed">
                TIKET HABIS
            </button>
        @elseif($isLoggedIn)
            <button id="buyTicketButton" type="button" onclick="openCheckout()"
                class="inline-flex w-full items-center justify-center bg-navy text-white py-4 rounded-full text-lg font-semibold hover:bg-yellow hover:text-navy transition shadow-md">
                Beli Tiket
            </button>
        @else
            <button onclick="redirectToLogin()"
                class="inline-flex w-full items-center justify-center bg-navy text-white py-4 rounded-full text-lg font-semibold hover:bg-yellow hover:text-navy transition shadow-md">
                Beli Tiket
            </button>
        @endif
    </div>

</div>

<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <p id="toast-notice-text" class="font-medium"></p>
    <span class="hidden !border-red-500 !border-yellow"></span>
</div>

<div id="checkout-modal" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden items-center justify-center bg-black/40 p-4 z-50">
    <!-- Hidden trigger for Flowbite -->
    <button id="checkout-trigger-btn" data-modal-target="checkout-modal" data-modal-toggle="checkout-modal" class="hidden"></button>
    <div class="w-full max-w-2xl rounded-[28px] bg-white p-5 shadow-2xl relative max-h-[calc(100vh-5rem)] overflow-hidden">
        <button type="button" data-modal-hide="checkout-modal" class="absolute right-4 top-4 text-3xl text-slate-400 transition hover:text-navy">&times;</button>

        <div class="mb-4">
            <h2 class="text-2xl font-semibold text-[#192853]">Konfirmasi Pembelian</h2>
            <p class="mt-2 text-sm text-[#64748b]">Periksa kembali data event dan ringkasan tiket sebelum melanjutkan.</p>
        </div>

        <form id="checkout-form" onsubmit="event.preventDefault(); confirmCheckout();">
            <div class="overflow-y-auto pr-1" style="max-height: calc(100vh - 20rem);">
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#475569]">Judul Event</label>
                    <input type="text" id="checkoutTitle" readonly onkeydown="return false" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-900 cursor-not-allowed" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#475569]">Tanggal</label>
                    <input type="text" id="checkoutDate" readonly onkeydown="return false" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-900 cursor-not-allowed" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#475569]">Waktu</label>
                    <input type="text" id="checkoutTime" readonly onkeydown="return false" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-900 cursor-not-allowed" />
                </div>
                <div class="space-y-2">
                    <label class="text-sm font-medium text-[#475569]">Lokasi</label>
                    <input type="text" id="checkoutVenue" readonly onkeydown="return false" class="w-full rounded-2xl border border-slate-300 bg-slate-50 px-3 py-2 text-sm text-slate-900 cursor-not-allowed" />
                </div>
            </div>

            <div class="mt-4 rounded-[32px] border border-slate-200 bg-slate-50 p-4">
                <div class="flex items-center justify-between text-sm font-semibold text-[#192853] mb-3">
                    <span>Ringkasan Tiket</span>
                    <span id="checkoutTicketCount">0 jenis</span>
                </div>
                <div id="checkoutTicketList" class="space-y-2">
                    <p class="text-sm text-[#64748b]">Pilih tiket di halaman event terlebih dahulu.</p>
                </div>
            </div>

            <div class="mt-4 grid gap-2 text-sm text-[#334155]">
                <div class="flex justify-between items-center rounded-2xl border border-slate-200 bg-white px-4 py-3">
                    <span class="font-medium">Jumlah Tiket</span>
                    <span id="checkoutTotalQty">0</span>
                </div>
                <div class="flex justify-between items-center rounded-2xl bg-[#f8fafc] px-4 py-3 font-semibold text-[#192853]">
                    <span>Total Bayar</span>
                    <span id="checkoutTotalPrice">Rp 0</span>
                </div>
            </div>

            <div class="mt-4 flex flex-col gap-2 sm:flex-row sm:justify-between">
                <button type="button" data-modal-hide="checkout-modal" class="inline-flex w-full justify-center rounded-full border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-[#475569] transition hover:border-yellow hover:bg-yellow/10 sm:w-[48%]">Batal</button>
                <button type="submit" class="inline-flex w-full justify-center rounded-full bg-navy px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy sm:w-[48%]">PESAN TIKET</button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT -->
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

let prices = @json(array_column($event['tickets'], 'price'));
let quotas = @json(array_column($event['tickets'], 'quota'));
let ticketTypes = @json(array_column($event['tickets'], 'type'));
let ticketIds = @json(array_column($event['tickets'], 'id'));
let ticketDescriptions = @json(array_column($event['tickets'], 'description'));
let quantities = new Array(prices.length).fill(0);
let noticeTimeout = null;
const toastNotice = document.getElementById('toast-notice');
const toastNoticeText = document.getElementById('toast-notice-text');

function showTicketInfo(i) {
    let desc = ticketDescriptions[i] ? ticketDescriptions[i].replace(/\n/g, '<br>') : 'Tidak ada keterangan tambahan.';
    Swal.fire({
        html: `
            <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-[#FFE14E] rounded-full flex items-center justify-center mb-4 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-[#192853]" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M21.2 5.5H2.8a.8.8 0 0 0-.8.8v3.6c0 .4.3.8.8.8.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5a.8.8 0 0 0-.8.8v3.6c0 .4.4.8.8.8h18.4c.4 0 .8-.4.8-.8v-3.6c0-.4-.3-.8-.8-.8-.8 0-1.5-.7-1.5-1.5s.7-1.5 1.5-1.5c.4 0 .8-.4.8-.8V6.3a.8.8 0 0 0-.8-.8ZM12 15.5l-2.4 1.3.5-2.7-2-2 2.7-.4L12 9l1.2 2.7 2.7.4-2 2 .5 2.7L12 15.5Z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-[#192853] mb-2">${ticketTypes[i]}</h3>
                <div class="text-sm text-slate-600 leading-relaxed text-center px-2">
                    ${desc}
                </div>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonColor: '#192853',
        confirmButtonText: 'Tutup',
        customClass: {
            popup: 'rounded-3xl p-6',
            confirmButton: 'rounded-full px-8 py-2.5 font-semibold mt-4 hover:bg-[#FFE14E] hover:text-[#192853] transition-colors'
        }
    });
}

function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function showToast(message, type = 'success') {
    if (!toastNotice || !toastNoticeText) return;
    toastNoticeText.innerText = message;
    
    if (type === 'error') {
        toastNotice.classList.replace('!border-yellow', '!border-red-500');
        if (!toastNotice.classList.contains('!border-red-500')) {
            toastNotice.classList.remove('border-yellow');
            toastNotice.classList.add('!border-red-500');
        }
    } else {
        toastNotice.classList.replace('!border-red-500', '!border-yellow');
        if (!toastNotice.classList.contains('!border-yellow')) {
            toastNotice.classList.remove('!border-red-500');
            toastNotice.classList.add('!border-yellow');
        }
    }

    toastNotice.classList.remove('opacity-0', 'pointer-events-none');
    toastNotice.classList.add('opacity-100');
    clearTimeout(noticeTimeout);
    noticeTimeout = setTimeout(() => {
        toastNotice.classList.remove('opacity-100');
        toastNotice.classList.add('opacity-0', 'pointer-events-none');
    }, 2500);
}

function updateUI() {
    let totalQty = quantities.reduce((a, b) => a + b, 0);
    let totalPrice = quantities.reduce((sum, qty, i) => sum + qty * prices[i], 0);

    document.getElementById("totalQty").innerText = totalQty;
    document.getElementById("totalPrice").innerText = "Rp " + formatRupiah(totalPrice);
}

function setQuantity(i, value) {
    let parsed = parseInt(value, 10);
    if (isNaN(parsed) || parsed < 0) {
        parsed = 0;
    }

    if (parsed > quotas[i]) {
        parsed = quotas[i];
        showToast(`Jumlah tiket melebihi kuota tersedia untuk tiket ini`);
    }

    quantities[i] = parsed;
    const input = document.getElementById("qty-" + i);
    if (input) {
        input.value = parsed;
    }

    updateUI();
}

function increase(i) {
    if (quantities[i] >= quotas[i]) {
        showToast(`Jumlah tiket melebihi kuota tersedia tiket ini`);
        return;
    }

    quantities[i]++;
    const input = document.getElementById("qty-" + i);
    if (input) {
        input.value = quantities[i];
    }
    updateUI();
}

function decrease(i) {
    if (quantities[i] > 0) {
        quantities[i]--;
        const input = document.getElementById("qty-" + i);
        if (input) {
            input.value = quantities[i];
        }
        updateUI();
    }
}

function openCheckout() {
    const totalQty = quantities.reduce((a, b) => a + b, 0);
    if (totalQty <= 0) {
        showToast('Pilih minimal 1 tiket terlebih dahulu', 'error');
        return;
    }

    document.getElementById('checkoutTitle').value = `{{ $event['title'] }}`;
    document.getElementById('checkoutDate').value = `{{ $event['date'] }}`;
    document.getElementById('checkoutTime').value = `{{ $event['time'] }}`;
    document.getElementById('checkoutVenue').value = `{{ $event['venue'] }}`;

    const ticketList = document.getElementById('checkoutTicketList');
    ticketList.innerHTML = '';
    let selectedCount = 0;
    quantities.forEach((qty, i) => {
        if (qty > 0) {
            selectedCount++;
            const row = document.createElement('div');
            row.className = 'rounded-3xl bg-white p-4 shadow-sm';
            row.innerHTML = `
                <div class="flex items-center justify-between gap-4 text-sm">
                    <div>
                        <p class="font-semibold text-[#192853]">${ticketTypes[i]}</p>
                        <p class="text-sm text-[#64748b]">Rp ${formatRupiah(prices[i])} x ${qty}</p>
                    </div>
                    <p class="font-semibold text-[#192853]">${qty}</p>
                </div>
            `;
            ticketList.appendChild(row);
        }
    });

    if (selectedCount === 0) {
        ticketList.innerHTML = '<p class="text-sm text-[#64748b]">Pilih tiket di halaman event terlebih dahulu.</p>';
    }

    document.getElementById('checkoutTicketCount').innerText = `${selectedCount} jenis`;
    document.getElementById('checkoutTotalQty').innerText = totalQty;
    document.getElementById('checkoutTotalPrice').innerText = 'Rp ' + formatRupiah(quantities.reduce((sum, qty, i) => sum + qty * prices[i], 0));

    document.getElementById('checkout-trigger-btn').click();
}

function confirmCheckout() {
    const totalQty = quantities.reduce((a, b) => a + b, 0);
    if (totalQty <= 0) {
        showToast('Pilih minimal 1 tiket terlebih dahulu', 'error');
        return;
    }

    // Prepare data
    const tickets = {};
    let hasTickets = false;
    quantities.forEach((qty, i) => {
        if (qty > 0) {
            const ticketId = ticketIds[i];
            tickets[ticketId] = qty;
            hasTickets = true;
        }
    });

    if (!hasTickets) return;

    // Show loading state
    const submitBtn = document.querySelector('#checkout-form button[type="submit"]') || document.querySelector('[onclick="confirmCheckout()"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerText = 'MEMPROSES...';
    }

    // Send AJAX POST
    fetch("{{ route('pengunjung.checkout') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            event_id: "{{ $event['id'] }}",
            tickets: tickets
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const closeBtn = document.querySelector('[data-modal-hide="checkout-modal"]');
            if (closeBtn) closeBtn.click();
            showToast('Pesanan tiket berhasil dibuat.');
            setTimeout(() => {
                window.location.href = "{{ route('pengunjung.tiket') }}";
            }, 1000);
        } else {
            showToast(data.message || 'Gagal memesan tiket', 'error');
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Konfirmasi & Bayar';
            }
        }
    })
    .catch(error => {
        console.error(error);
        showToast('Terjadi kesalahan koneksi', 'error');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Konfirmasi & Bayar';
        }
    });
}

function redirectToLogin() {
    showToast('Login terlebih dahulu!', 'error');
    setTimeout(() => {
        window.location.href = "{{ route('login') }}";
    }, 1500);
}
</script>
@endpush
