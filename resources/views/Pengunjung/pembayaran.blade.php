<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tiket</title>
    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
<body class="bg-cream font-poppins min-h-screen pb-12 text-grayCustom">

<!-- NAVBAR -->
<div class="sticky top-0 z-50 bg-navy text-white shadow-sm">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5">
        <a href="/home" class="text-xl font-semibold tracking-tight">Eventiket</a>

        <div class="flex items-center gap-3">
            <a href="/tiket_aktif" class="rounded-full border border-white px-4 py-2 text-sm font-medium text-white transition hover:bg-white hover:text-[#192853]">TIKET SAYA</a>

            <!-- ICON USER -->
            <a href="{{ route('pengunjung.profil') ?? '#' }}" class="w-10 h-10 rounded-full border border-white bg-transparent text-white flex items-center justify-center transition hover:bg-white hover:text-[#192853]">
                <i class="bi bi-person-circle text-lg"></i>
            </a>
        </div>
    </div>
</div>

<!-- KONTEN HALAMAN -->
<div class="max-w-xl mx-auto mt-10 px-4 space-y-8">

    <!-- Card 1: RINGKASAN PEMBAYARAN -->
    <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100/60 bg-gray-50/50">
            <h2 class="font-bold text-navy text-lg">RINGKASAN PEMBAYARAN</h2>
        </div>
        <div class="px-6 py-6 space-y-4 text-sm font-medium">
            <div class="grid grid-cols-[120px_20px_1fr]">
                <span class="text-gray-500">Judul Event</span>
                <span class="text-gray-400">:</span>
                <span class="text-navy font-semibold">Festival Musik Mapala</span>
            </div>
            <div class="grid grid-cols-[120px_20px_1fr]">
                <span class="text-gray-500">Jumlah</span>
                <span class="text-gray-400">:</span>
                <span class="text-navy font-semibold">3 Tiket</span>
            </div>
        </div>
        <div class="px-6 py-5 border-t border-gray-100/60 bg-gray-50/30">
            <div class="grid grid-cols-[120px_20px_1fr] items-center">
                <span class="font-bold text-navy text-base">Total</span>
                <span class="font-bold text-navy text-base">:</span>
                <span class="font-bold text-navy text-xl">Rp 390.000</span>
            </div>
        </div>
    </div>

    <!-- Judul Bagian -->
    <h2 class="font-bold text-navy text-lg tracking-wide pl-1">UNGGAH BUKTI PEMBAYARAN</h2>

    <!-- Card 2: Transfer Ke Rekening -->
    <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100/60 bg-gray-50/50">
            <h3 class="font-semibold text-navy">Transfer Ke Rekening</h3>
        </div>
        <div class="px-6 py-5 flex items-center justify-between">
            <div class="font-bold text-navy text-lg">
                BCA 1234567890 <span class="text-gray-400 font-normal text-base ml-2 hidden sm:inline-block">. a/n Eventiket</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Rekening Tujuan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 pb-2">
        <div class="px-6 py-4 border-b border-gray-100/60 bg-gray-50/50">
            <h3 class="font-semibold text-navy">REKENING TUJUAN</h3>
        </div>
        <div class="px-6 py-5">
            <input type="text" placeholder="Masukkan nomor rekening Anda" 
                   class="w-full border border-gray-300 rounded-lg p-3 outline-none focus:border-navy focus:ring-1 focus:ring-navy transition text-sm">
        </div>
    </div>
    
    <p class="text-[11px] text-grayCustom font-medium ml-2 -mt-4">
        *Isi Rekening Tujuan jika pembayaran ditolak untuk proses pengembalian dana
    </p>

    <!-- Form Container (Untuk handle submit) -->
    <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6 pt-4">

        <!-- Upload Area -->
        <label for="bukti_transfer" class="block w-full bg-white border-2 border-dashed border-gray-300 hover:border-navy rounded-2xl h-48 flex flex-col items-center justify-center text-center shadow-sm cursor-pointer transition hover:bg-gray-50 group">
            <div class="w-12 h-12 flex items-center justify-center text-navy mb-1 group-hover:scale-110 transition-transform">
                <i class="bi bi-cloud-arrow-up-fill text-4xl"></i>
            </div>
            <p class="font-semibold text-navy mt-2">Klik untuk unggah bukti transfer</p>
            <p class="font-semibold text-sm text-navy mt-1">PNG, JPG maks 5MB</p>
            <input type="file" id="bukti_transfer" class="hidden" accept="image/png, image/jpeg" required>
        </label>

        <!-- Preview Upload Image -->
        <div id="image-preview" class="hidden mt-4">
            <div class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 shadow-sm">
                <i class="bi bi-image text-navy text-xl"></i>
                <span id="file-name" class="text-sm text-grayCustom truncate w-full font-medium">nama_file.png</span>
                <button type="button" onclick="clearUpload()" class="text-gray-400 hover:text-red-500 transition">
                    <i class="bi bi-x-circle-fill text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex flex-col items-center mt-10">
            <button type="submit" class="w-full bg-white text-navy font-bold text-base py-3.5 px-6 rounded-2xl shadow-sm border border-gray-200 hover:bg-gray-50 transition duration-300">
                Kirim Bukti Pembayaran
            </button>
            <p class="text-center font-bold text-sm text-navy mt-5">
                Panitia akan memverifikasi dalam 1x24 jam
            </p>
        </div>
    </form>
</div>

<script>
    const inputFile = document.getElementById('bukti_transfer');
    const previewContainer = document.getElementById('image-preview');
    const fileNameDisplay = document.getElementById('file-name');

    inputFile.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileNameDisplay.textContent = this.files[0].name;
            previewContainer.classList.remove('hidden');
            
        } else {
            previewContainer.classList.add('hidden');
        }
    });

    function clearUpload() {
        inputFile.value = '';
        previewContainer.classList.add('hidden');
    }
</script>

</body>
</html>
