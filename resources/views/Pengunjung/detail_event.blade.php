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
                            Kuota 10
                        </div>

                        <!-- COUNTER -->
                        <div class="flex items-center bg-white rounded-full px-2 py-1 shadow-sm">

                            <button onclick="decrease({{ $i }})"
                                class="w-8 h-8 rounded-full hover:bg-gray-100 text-lg">-</button>

                            <span id="qty-{{ $i }}" class="w-6 text-center font-medium">0</span>

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
        <a href="{{ route('login') }}" class="inline-flex w-full items-center justify-center bg-navy text-white py-4 rounded-full text-lg font-semibold hover:bg-yellow hover:text-navy transition">
            Beli Tiket
        </a>
    </div>

</div>

<!-- SCRIPT -->
<script>
let prices = @json(array_column($event['tickets'], 'price'));
let quantities = new Array(prices.length).fill(0);

function formatRupiah(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function updateUI() {
    let totalQty = quantities.reduce((a, b) => a + b, 0);
    let totalPrice = quantities.reduce((sum, qty, i) => sum + qty * prices[i], 0);

    document.getElementById("totalQty").innerText = totalQty;
    document.getElementById("totalPrice").innerText = "Rp " + formatRupiah(totalPrice);
}

function increase(i) {
    quantities[i]++;
    document.getElementById("qty-" + i).innerText = quantities[i];
    updateUI();
}

function decrease(i) {
    if (quantities[i] > 0) {
        quantities[i]--;
        document.getElementById("qty-" + i).innerText = quantities[i];
        updateUI();
    }
}
</script>

</body>
</html>