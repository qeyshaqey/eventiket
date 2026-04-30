@extends('layouts.pengunjung.pengunjung')

@section('title', 'Pembayaran Tiket - Eventiket')

@section('body_class', 'bg-cream font-poppins min-h-screen text-grayCustom relative overflow-x-hidden selection:bg-yellow selection:text-navy pb-16')

@push('styles')
<style>
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #EFF8FF;
        }
        ::-webkit-scrollbar-thumb {
            background: #192853;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
@endpush

@section('content')
<!-- Animasi Background-->
<div class="fixed inset-0 w-full h-full pointer-events-none z-0 overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-navy/10 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
    <div class="absolute top-[20%] right-[-10%] w-96 h-96 bg-yellow/20 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-[-20%] left-[20%] w-[30rem] h-[30rem] bg-navy/5 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob" style="animation-delay: 4s;"></div>
</div>

<!-- KONTEN HALAMAN -->
<div class="relative z-10 max-w-5xl mx-auto mt-4 mb-10 px-4">
    
    <!-- Header Section -->
    <div class="text-center mb-6 opacity-0 animate-fade-in-up">
        <h1 class="text-2xl md:text-3xl font-bold text-navy mb-2 drop-shadow-sm">Selesaikan Pembayaran Anda</h1>
        <p class="text-sm text-grayCustom max-w-xl mx-auto">Satu langkah lagi untuk mendapatkan tiket Anda. Silakan ikuti instruksi pembayaran di bawah ini.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <div class="lg:col-span-5 space-y-8 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">
            
            <!-- Ringkasan Card -->
            <div class="glass-card rounded-2xl p-5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-navy/5 flex items-center justify-center">
                        <i class="bi bi-receipt text-navy text-xl"></i>
                    </div>
                    <h2 class="font-bold text-navy text-lg">Ringkasan Pesanan</h2>
                </div>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-gray-500 font-medium text-sm">Judul Event</span>
                        <span class="text-navy font-semibold text-right text-sm">Festival Musik Mapala</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-gray-500 font-medium text-sm">Jumlah Tiket</span>
                        <span class="text-navy font-semibold bg-navy/5 px-3 py-1 rounded-full text-sm">3 Tiket</span>
                    </div>
                    <div class="flex justify-between items-center pt-1">
                        <span class="text-gray-500 font-medium text-sm">Total Pembayaran</span>
                        <span class="font-bold text-navy text-xl drop-shadow-sm">Rp 390.000</span>
                    </div>
                </div>
            </div>

            <!-- Bank Card -->
            <div class="relative overflow-hidden rounded-2xl bg-navy text-white shadow-2xl p-5 group hover:-translate-y-1 transition-all duration-300">
                <!-- Card Background Effects -->
                <div class="absolute top-[-50px] right-[-50px] w-32 h-32 bg-yellow/20 rounded-full blur-2xl"></div>
                <div class="absolute bottom-[-30px] left-[-30px] w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-5">
                        <div>
                            <p class="text-white/70 text-xs font-medium mb-1">Transfer ke Rekening</p>
                            <h3 class="font-bold text-base text-yellow tracking-wider">BANK BCA</h3>
                        </div>
                        <i class="bi bi-bank text-2xl text-white/50 group-hover:text-yellow/80 transition-colors"></i>
                    </div>
                    
                    <div class="mb-4">
                        <p class="font-mono text-xl md:text-2xl tracking-[0.15em] font-semibold drop-shadow-md">1234 5678 90</p>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <i class="bi bi-person-check-fill text-white text-sm"></i>
                        </div>
                        <span class="text-white/90 font-medium tracking-wide">a/n Eventiket</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Form & Upload (Takes up 7 columns on lg) -->
        <div class="lg:col-span-7 opacity-0 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="glass-card rounded-2xl p-5 md:p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border-t-4 border-t-yellow">
                
                <h2 class="font-bold text-navy text-lg mb-4 flex items-center gap-2">
                    <i class="bi bi-cloud-arrow-up-fill text-yellow"></i>
                    Konfirmasi Pembayaran
                </h2>

                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">

                    <!-- Pilih Bank (Custom Dropdown) -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-navy ml-1">Bank Pengembalian Dana</label>
                        <div class="relative w-full">
                            <input type="hidden" id="bank-input" name="bank_pengembalian" value="">

                            <!-- Trigger Button -->
                            <button type="button" id="bank-btn" data-dropdown-toggle="bank-menu"
                                class="w-full flex items-center justify-between bg-white/80 border-2 border-transparent hover:border-navy/30 rounded-xl py-2.5 pl-10 pr-4 shadow-sm text-sm font-medium transition-all duration-200 text-left cursor-pointer">
                                <span id="bank-label" class="text-gray-400 font-normal">Pilih Bank</span>
                                <i id="bank-icon" class="bi bi-chevron-down text-gray-400 transition-transform duration-200"></i>
                            </button>

                            <!-- Ikon bank di kiri -->
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="bi bi-bank2 text-gray-400"></i>
                            </div>

                            <!-- Dropdown Menu: w-full agar tidak melebar keluar -->
                            <div id="bank-menu"
                                class="absolute left-0 right-0 top-full mt-1.5 z-[100] hidden bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden">
                                <div class="p-1.5">
                                    @foreach(['BNI', 'BCA', 'MANDIRI'] as $bank)
                                    <button type="button" onclick="selectBank('{{ $bank }}')"
                                        class="w-full text-left px-4 py-2.5 rounded-xl text-sm font-medium text-navy hover:bg-[#EFF8FF] transition-colors duration-150">
                                        {{ $bank }}
                                    </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rekening Tujuan -->
                    <div class="space-y-1.5 group">
                        <label class="block text-xs font-semibold text-navy ml-1">Rekening Pengembalian Dana</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <i class="bi bi-credit-card-2-front text-gray-400 group-focus-within:text-navy transition-colors"></i>
                            </div>
                            <input type="text" id="rekening_pengembalian" placeholder="Masukkan nomor rekening Anda" 
                                   class="w-full bg-white/80 border-2 border-transparent focus:border-navy focus:bg-white rounded-xl py-2.5 pl-10 pr-4 outline-none transition-all duration-300 shadow-sm text-sm text-navy font-medium placeholder:font-normal placeholder:text-gray-400">
                        </div>
                        <p class="text-xs text-gray-500 ml-1 font-medium flex items-center gap-1">
                            <i class="bi bi-info-circle"></i>
                            Diperlukan jika terjadi penolakan untuk proses refund.
                        </p>
                    </div>

                    <!-- Upload Area -->
                    <div class="space-y-1.5 pt-1">
                        <label class="block text-xs font-semibold text-navy ml-1">Bukti Transfer</label>
                        
                        <label for="bukti_transfer" class="relative block w-full bg-white/60 border-2 border-dashed border-gray-300 hover:border-yellow rounded-xl p-5 flex flex-col items-center justify-center text-center shadow-sm cursor-pointer transition-all duration-300 group hover:bg-yellow/5">
                            
                            <!-- Dotted circle animation -->
                            <div class="absolute inset-0 rounded-xl border-2 border-navy/0 group-hover:border-navy/10 transition-colors duration-500 pointer-events-none"></div>

                            <div class="w-12 h-12 bg-navy/5 rounded-full flex items-center justify-center text-navy mb-2 group-hover:scale-110 group-hover:bg-yellow/20 group-hover:text-yellow transition-all duration-300 shadow-sm">
                                <i class="bi bi-file-earmark-image text-xl"></i>
                            </div>
                            
                            <h3 class="font-bold text-navy text-base mb-1 group-hover:text-yellow transition-colors">Unggah Bukti Pembayaran</h3>
                            <p class="text-xs text-grayCustom mb-2">Klik atau seret file gambar ke area ini</p>
                            
                            <div class="flex items-center gap-2 text-xs font-semibold text-navy bg-navy/5 px-3 py-1 rounded-full">
                                <span>PNG, JPG</span>
                                <span class="w-1 h-1 bg-grayCustom rounded-full"></span>
                                <span>Maks 5MB</span>
                            </div>
                            
                            <input type="file" id="bukti_transfer" class="hidden" accept="image/png, image/jpeg">
                        </label>
                    </div>

                    <!-- Preview Upload Image -->
                    <div id="image-preview" class="hidden overflow-hidden transition-all duration-300 ease-in-out">
                        <div class="flex items-center gap-4 p-4 bg-white rounded-xl border border-gray-100 shadow-sm relative overflow-hidden group">
                            <!-- Left accent border -->
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-green-400"></div>
                            
                            <div class="w-10 h-10 rounded-full bg-green-50 flex items-center justify-center flex-shrink-0">
                                <i class="bi bi-check-circle-fill text-green-500 text-lg"></i>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <p id="file-name" class="text-sm text-navy font-semibold truncate">nama_file.png</p>
                                <p class="text-xs text-green-600 font-medium mt-0.5">Berhasil dilampirkan</p>
                            </div>
                            
                            <button type="button" onclick="clearUpload()" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors duration-300 focus:outline-none" title="Hapus file">
                                <i class="bi bi-trash3-fill text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Submit Section -->
                    <div class="pt-4">
                        <button type="submit" class="mt-3 w-full bg-navy text-white py-2.5 rounded-full text-sm text-center block font-medium hover:bg-yellow hover:text-navy transition">
                            Kirim Konfirmasi Pembayaran
                        </button>
                        
                        <div class="flex items-center justify-center gap-1.5 mt-3 text-xs text-grayCustom font-medium">
                            <i class="bi bi-shield-check text-green-500 text-base"></i>
                            <span>Panitia akan memverifikasi pembayaran dalam <strong>1x24 jam</strong></span>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        
    </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <p id="toast-notice-text" class="font-medium"></p>
</div>
<span class="hidden !border-red-500 !border-yellow"></span>
@endsection

@push('scripts')
<script>
    // Bank Dropdown
    function selectBank(v) {
        document.getElementById('bank-input').value = v;
        const lbl = document.getElementById('bank-label');
        lbl.textContent = v;
        lbl.className = 'text-navy font-medium';
        
        // Hide dropdown (Flowbite)
        const btn = document.getElementById('bank-btn');
        if (btn) btn.click();
    }

    const inputFile = document.getElementById('bukti_transfer');
    const previewContainer = document.getElementById('image-preview');
    const fileNameDisplay = document.getElementById('file-name');

    inputFile.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            fileNameDisplay.textContent = this.files[0].name;
            
            // Animate in
            previewContainer.classList.remove('hidden');
            previewContainer.style.opacity = '0';
            previewContainer.style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                previewContainer.style.transition = 'all 0.3s ease';
                previewContainer.style.opacity = '1';
                previewContainer.style.transform = 'translateY(0)';
            }, 10);
            
        } else {
            clearUpload();
        }
    });

    function clearUpload() {
        // Animate out
        previewContainer.style.opacity = '0';
        previewContainer.style.transform = 'translateY(10px)';
        
        setTimeout(() => {
            inputFile.value = '';
            previewContainer.classList.add('hidden');
        }, 300);
    }
    
    // Drag and drop functionality for the upload area
    const dropZone = inputFile.closest('label');
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        dropZone.classList.add('border-navy', 'bg-navy/5');
        dropZone.classList.remove('border-gray-300');
    }
    
    function unhighlight(e) {
        dropZone.classList.remove('border-navy', 'bg-navy/5');
        dropZone.classList.add('border-gray-300');
    }
    
    dropZone.addEventListener('drop', handleDrop, false);
    
    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        if (files.length > 0) {
            inputFile.files = files;
            // Trigger change event manually
            const event = new Event('change');
            inputFile.dispatchEvent(event);
        }
    }

    // --- TOAST & VALIDATION LOGIC ---
    let noticeTimeout = null;
    const toastNotice = document.getElementById('toast-notice');
    const toastNoticeText = document.getElementById('toast-notice-text');

    function showToast(message, type = 'success') {
        if (!toastNotice || !toastNoticeText) return;
        toastNoticeText.innerText = message;
        
        if (type === 'error') {
            toastNotice.classList.remove('!border-yellow');
            toastNotice.classList.add('!border-red-500');
        } else {
            toastNotice.classList.remove('!border-red-500');
            toastNotice.classList.add('!border-yellow');
        }

        toastNotice.classList.remove('opacity-0', 'pointer-events-none');
        toastNotice.classList.add('opacity-100');
        clearTimeout(noticeTimeout);
        noticeTimeout = setTimeout(() => {
            toastNotice.classList.remove('opacity-100');
            toastNotice.classList.add('opacity-0', 'pointer-events-none');
        }, 3000);
    }

    const form = document.querySelector('form');
    const bankInput = document.getElementById('bank-input');
    const rekeningInput = document.getElementById('rekening_pengembalian');

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        const noBank = !bankInput || !bankInput.value;
        const noRek  = !rekeningInput.value.trim();
        const noFile = !inputFile.files || inputFile.files.length === 0;

        if (noBank || noRek || noFile) {
            showToast('Silahkan lengkapi form terlebih dahulu', 'error');
            return;
        }

        showToast('Konfirmasi pembayaran berhasil dikirim.', 'success');
        setTimeout(() => {
            window.location.href = "{{ route('pengunjung.tiket') }}";
        }, 1500);
    });
</script>
@endpush
