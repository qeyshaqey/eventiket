<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Event</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: "#192853",
                        cream: "#EFF8FF",
                        yellow: "#FFE14E",
                        grayCustom: "#475569"
                    },
                    fontFamily: {
                        poppins: ["Poppins", "sans-serif"]
                    }
                }
            }
        }
    </script>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-cream font-poppins">

<!-- NAVBAR -->
<div class="bg-navy text-white px-6 py-4 flex justify-between items-center">
    <h1 class="font-semibold">EVENTIKET</h1>

    <div class="flex items-center gap-3">
    </div>
</div>


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
            <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center bg-navy text-white py-4 rounded-full text-lg font-semibold hover:bg-yellow hover:text-navy transition">
                Beli Tiket
            </a>
        @endif
    </div>

</div>

<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <p id="toast-notice-text" class="font-medium"></p>
</div>

<div id="checkout-modal" class="fixed inset-0 hidden flex items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-2xl rounded-[28px] bg-white p-8 shadow-2xl">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-[#192853]">Konfirmasi Pembelian</h2>
                <p class="mt-2 text-sm text-[#6b7280]">Periksa kembali jumlah tiket sebelum melanjutkan.</p>
            </div>
        </div>

        <div class="mt-8 space-y-4 text-sm text-[#334155]">
            <div class="rounded-2xl bg-[#f8fafc] p-4">
                <p class="font-semibold text-[#192853]">Event</p>
                <p>{{ $event['title'] }}</p>
            </div>
            <div class="rounded-2xl bg-[#f8fafc] p-4">
                <p class="font-semibold text-[#192853]">Jumlah tiket</p>
                <p id="checkoutTotalQty">0</p>
            </div>
            <div class="rounded-2xl bg-[#f8fafc] p-4">
                <p class="font-semibold text-[#192853]">Total harga</p>
                <p id="checkoutTotalPrice">Rp 0</p>
            </div>
        </div>

        <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">
            <button type="button" onclick="closeCheckout()" class="inline-flex w-full justify-center rounded-full border border-[#cbd5e1] bg-white px-6 py-3 text-sm font-semibold text-[#475569] transition hover:bg-yellow hover:text-[#192853] sm:w-auto">Batal</button>
            <button type="button" onclick="confirmCheckout()" class="inline-flex w-full justify-center rounded-full bg-[#192853] px-6 py-3 text-sm font-semibold text-white transition hover:bg-yellow hover:text-[#192853] sm:w-auto">Pesan</button>
        </div>
    </div>
</div>

<!-- SCRIPT -->
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

function showToast(message) {
    if (!toastNotice || !toastNoticeText) return;
    toastNoticeText.innerText = message;
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
        showToast('Pilih minimal 1 tiket terlebih dahulu.');
        return;
    }

    document.getElementById('checkoutTotalQty').innerText = totalQty;
    document.getElementById('checkoutTotalPrice').innerText = 'Rp ' + formatRupiah(quantities.reduce((sum, qty, i) => sum + qty * prices[i], 0));
    document.getElementById('checkout-modal').classList.remove('hidden');
}

function closeCheckout() {
    document.getElementById('checkout-modal').classList.add('hidden');
}

function confirmCheckout() {
    closeCheckout();
    showToast('');
}
</script>

</body>
</html>