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
        <p class="text-sm text-grayCustom max-w-xl mx-auto">Satu langkah lagi untuk mendapatkan tiket Anda. Pilih metode pembayaran yang Anda inginkan melalui sistem otomatis kami.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start justify-center">
        <!-- Center columns for a cleaner look since we removed the manual bank card -->
        <div class="lg:col-start-3 lg:col-span-8 space-y-6 opacity-0 animate-fade-in-up" style="animation-delay: 0.1s;">
            
            <!-- Ringkasan Card -->
            <div class="glass-card rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-full bg-navy/5 flex items-center justify-center">
                        <i class="bi bi-receipt text-navy text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-navy text-lg">Ringkasan Pesanan</h2>
                        <p class="text-xs text-gray-500">Order ID: {{ $pembayaran->order_id }}</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-gray-500 font-medium text-sm">Event</span>
                        <span class="text-navy font-semibold text-right text-sm">{{ $pembayaran->tiket->event->judul ?? 'Festival Musik' }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-3 border-b border-gray-100">
                        <span class="text-gray-500 font-medium text-sm">Jenis Tiket</span>
                        <span class="text-navy font-semibold text-right text-sm">{{ $pembayaran->tiket->nama ?? 'Reguler' }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <span class="text-gray-600 font-bold text-base">Total Pembayaran</span>
                        <span class="font-extrabold text-navy text-2xl drop-shadow-sm">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-dashed border-gray-200">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
                        <div class="flex gap-3">
                            <i class="bi bi-info-circle-fill text-blue-500 mt-0.5"></i>
                            <div class="text-xs text-blue-800 leading-relaxed">
                                <p class="font-bold mb-1">Informasi Pembayaran Otomatis</p>
                                <p>Anda akan diarahkan ke jendela pembayaran aman Midtrans. Anda bisa membayar menggunakan QRIS, GoPay, ShopeePay, Virtual Account, atau Kartu Kredit. Status akan otomatis diperbarui setelah pembayaran berhasil.</p>
                            </div>
                        </div>
                    </div>

                    <button id="pay-button" class="w-full bg-navy text-white py-4 rounded-2xl text-base font-bold hover:bg-yellow hover:text-navy transition-all duration-300 shadow-lg hover:shadow-yellow/20 flex items-center justify-center gap-2 group">
                        <i class="bi bi-shield-lock-fill"></i>
                        Bayar Sekarang
                        <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    
                    <div class="flex items-center justify-center gap-4 mt-6 opacity-60">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo.svg" class="h-4" alt="OVO">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana.svg" class="h-4" alt="DANA">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_gopay.svg" class="h-4" alt="GOPAY">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_LinkAja.svg" class="h-4" alt="LinkAja">
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('pengunjung.tiket') }}" class="text-sm text-grayCustom hover:text-navy transition-colors font-medium">
                    <i class="bi bi-arrow-left"></i> Kembali ke Tiket Saya
                </a>
            </div>
        </div>
    </div>
</div>

<!-- TOAST NOTIFICATION -->
<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <p id="toast-notice-text" class="font-medium"></p>
</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    const payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Panggil popup Midtrans Snap
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                // Kalau pembayaran berhasil
                showToast('Pembayaran Berhasil!', 'success');
                console.log(result);
                setTimeout(() => {
                    window.location.href = "{{ route('pengunjung.tiket') }}";
                }, 2000);
            },
            onPending: function(result){
                // Kalau user belum bayar (masih nunggu)
                showToast('Menunggu Pembayaran...', 'warning');
                console.log(result);
                setTimeout(() => {
                    window.location.href = "{{ route('pengunjung.tiket') }}";
                }, 2000);
            },
            onError: function(result){
                // Kalau ada error atau pembayaran gagal
                showToast('Pembayaran Gagal!', 'error');
                console.log(result);
            },
            onClose: function(){
                // Kalau user nutup popup secara sengaja
                showToast('Anda menutup jendela pembayaran sebelum selesai.', 'error');
            }
        });
    });

    // --- TOAST LOGIC ---
    let noticeTimeout = null;
    const toastNotice = document.getElementById('toast-notice');
    const toastNoticeText = document.getElementById('toast-notice-text');

    function showToast(message, type = 'success') {
        if (!toastNotice || !toastNoticeText) return;
        toastNoticeText.innerText = message;
        
        if (type === 'error') {
            toastNotice.classList.remove('!border-yellow', '!border-orange-400');
            toastNotice.classList.add('!border-red-500');
        } else if (type === 'warning') {
            toastNotice.classList.remove('!border-yellow', '!border-red-500');
            toastNotice.classList.add('!border-orange-400');
        } else {
            toastNotice.classList.remove('!border-red-500', '!border-orange-400');
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
</script>
@endpush
