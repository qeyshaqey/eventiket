@extends('layouts.pengunjung')

@section('title', 'Detail Event')

@section('body_class', 'bg-cream font-poppins')

@section('content')
<!-- CONTENT -->
<div class="max-w-7xl mx-auto px-6 py-12">

    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_1fr] gap-10">

        <!-- LEFT -->
        <div class="space-y-6">

            <!-- IMAGE -->
            <div class="bg-white rounded-2xl h-[450px] overflow-hidden shadow-sm flex items-center justify-center">
                <img src="{{ asset('image/' . ($event['image'] ?? 'default.jpg')) }}"
                     alt="{{ $event['title'] }}"
                     class="w-full h-full object-contain">
            </div>

            <!-- DESKRIPSI -->
            <div class="bg-white rounded-2xl p-6 text-[15px] leading-relaxed text-grayCustom shadow-sm">
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
                <div class="flex items-center justify-between bg-[#F8FAFC] rounded-xl px-5 py-4 mb-4">

                    <!-- INFO -->
                    <div>
                        <p class="font-semibold text-navy text-[15px]">{{ $ticket['type'] }}</p>
                        <p class="text-sm text-grayCustom">
                            Rp {{ number_format($ticket['price'],0,',','.') }}
                        </p>
                    </div>

                    <!-- ACTION -->
                    <div class="flex items-center gap-4">

                        <!-- KUOTA -->
                        <div class="text-xs bg-white px-3 py-1 rounded-full shadow-sm">
                            Kuota {{ $ticket['quota'] }}
                        </div>

                        <!-- COUNTER -->
                        <div class="flex items-center bg-white rounded-full px-2 py-1 shadow-sm">

                            <button onclick="decrease({{ $i }})"
                                class="w-8 h-8 rounded-full hover:bg-gray-100 text-lg">-</button>

                            <input id="qty-{{ $i }}" type="text" inputmode="numeric" pattern="[0-9]*" value="0"
                                class="mx-2 w-16 bg-transparent text-center font-medium outline-none"
                                onchange="setQuantity({{ $i }}, this.value)" oninput="setQuantity({{ $i }}, this.value)">

                            <button onclick="increase({{ $i }})"
                                class="w-8 h-8 rounded-full hover:bg-gray-100 text-lg">+</button>

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
            $isLoggedIn = session()->has('user') && session('role') === 'pengunjung';
        @endphp

        @if($isLoggedIn)
            <button id="buyTicketButton" type="button" onclick="openCheckout()"
                class="inline-flex w-full items-center justify-center bg-navy text-white py-4 rounded-full text-lg font-semibold hover:bg-yellow hover:text-navy transition">
                Beli Tiket
            </button>
        @else
            <button onclick="redirectToLogin()"
                class="inline-flex w-full items-center justify-center bg-navy text-white py-4 rounded-full text-lg font-semibold hover:bg-yellow hover:text-navy transition">
                Beli Tiket
            </button>
        @endif
    </div>

</div>

<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <p id="toast-notice-text" class="font-medium"></p>
</div>

<div id="checkout-modal" class="fixed inset-0 hidden items-center justify-center bg-black/40 p-4 z-50">
    <div class="w-full max-w-2xl rounded-[28px] bg-white p-5 shadow-2xl relative max-h-[calc(100vh-5rem)] overflow-hidden">
        <button type="button" onclick="closeCheckout()" class="absolute right-4 top-4 text-3xl text-slate-400 transition hover:text-navy">&times;</button>

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
                <button type="button" onclick="closeCheckout()" class="inline-flex w-full justify-center rounded-full border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-[#475569] transition hover:border-yellow hover:bg-yellow/10 sm:w-[48%]">Batal</button>
                <button type="submit" class="inline-flex w-full justify-center rounded-full bg-navy px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy sm:w-[48%]">PESAN TIKET</button>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPT -->
@endsection

@push('scripts')
<script>
let prices = @json(array_column($event['tickets'], 'price'));
let quotas = @json(array_column($event['tickets'], 'quota'));
let ticketTypes = @json(array_column($event['tickets'], 'type'));
let quantities = new Array(prices.length).fill(0);
let noticeTimeout = null;
const toastNotice = document.getElementById('toast-notice');
const toastNoticeText = document.getElementById('toast-notice-text');

function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function showToast(message, type = 'success') {
    if (!toastNotice || !toastNoticeText) return;
    toastNoticeText.innerText = message;
    
    if (type === 'error') {
        toastNotice.classList.replace('border-yellow', 'border-red-500');
    } else {
        toastNotice.classList.replace('border-red-500', 'border-yellow');
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
        showToast('Pilih minimal 1 tiket terlebih dahulu.', 'error');
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

    const modal = document.getElementById('checkout-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeCheckout() {
    const modal = document.getElementById('checkout-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function confirmCheckout() {
    closeCheckout();
    showToast('Pesanan tiket berhasil dibuat.');
    setTimeout(() => {
        window.location.href = "{{ route('pengunjung.tiket') }}";
    }, 200);
}

const checkoutModal = document.getElementById('checkout-modal');
if (checkoutModal) {
    checkoutModal.addEventListener('click', function(e) {
        if (e.target === this) {
            closeCheckout();
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
