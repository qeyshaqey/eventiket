<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Eventix Panitia</title>

    <!--FONT-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EFF8FF] font-[poppins] font-semibold">

<!-- TOAST NOTIFICATION -->
<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform translate-y-2 rounded-[24px] border border-slate-200 border-r-8 bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <div class="flex items-center gap-3">
        <i id="toast-icon" class="bi bi-bell-fill text-lg"></i>
        <span id="toast-message"></span>
    </div>
</div>

<div class="flex">

    <!-- SIDEBAR -->
    <div class="fixed top-0 left-0 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg">

        <!-- HEADER -->
        <div class="p-5 bg-[#0f1a35] border-b border-yellow-300/20">
            <h2 class="text-yellow-400 font-semibold text-sm">Eventix Panitia</h2>
            <p class="text-xs text-white/40">Sistem Manajemen Event</p>
        </div>

        <!-- FUNCTION ACTIVE -->
        @php
function active($route) {
    return request()->is('panitia/' . $route . '*')
        ? 'bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400'
        : 'text-white/60 hover:bg-yellow-400/10 hover:text-white';
}
@endphp

        <!-- MENU -->
        <nav class="flex-1 py-4 text-sm">

            <!-- BERANDA -->
            <a href="{{ route('panitia.beranda') }}"
                class="flex items-center gap-3 px-5 py-3 {{ active('beranda') }}">
                <i class="bi bi-house"></i> Beranda
            </a>

            <!-- EVENT -->
            <a href="{{ route('panitia.event') }}"
                class="flex items-center gap-3 px-5 py-3 {{ active('event') }}">
                <i class="bi bi-calendar"></i> Event
            </a>

            <!-- TIKET -->
            <a href="{{ route('panitia.tiket') }}"
                class="flex items-center gap-3 px-5 py-3 {{ active('tiket') }}">
                <i class="bi bi-ticket-perforated"></i>Tiket
            </a>

            <!-- TRANSAKSI -->
            <a href="{{ route('panitia.transaksi') }}"
                class="flex items-center gap-3 px-5 py-3 {{ active('transaksi') }}">
                <i class="bi bi-credit-card"></i> Data Transaksi
            </a>

            <!-- RIWAYAT -->
            <a href="#"
                class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                <i class="bi bi-clock-history"></i> Riwayat
            </a>

        </nav>

        <!-- FOOTER PROFILE -->
        <div class="p-4 border-t border-gray-500 flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-black text-sm">
                PN
            </div>
            <span>Panitia</span>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="ml-[230px] w-full p-6 overflow-y-auto h-screen">
        @yield('content')
    </div>

</div>

<!-- TOAST SCRIPT -->
<script>
function showToast(message, type = 'success', duration = 3000) {
    const toast = document.getElementById('toast-notice');
    const toastMessage = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');
    
    // Set warna berdasarkan tipe
    if (type === 'error') {
        toast.classList.remove('border-yellow');
        toast.classList.add('border-red-500');
        toastIcon.classList.remove('text-yellow-500');
        toastIcon.classList.add('text-red-500');
        toastIcon.classList.remove('bi-bell-fill');
        toastIcon.classList.add('bi-exclamation-circle-fill');
    } else {
        toast.classList.remove('border-red-500');
        toast.classList.add('border-yellow');
        toastIcon.classList.remove('text-red-500');
        toastIcon.classList.add('text-yellow-500');
        toastIcon.classList.remove('bi-exclamation-circle-fill');
        toastIcon.classList.add('bi-bell-fill');
    }
    
    toastMessage.textContent = message;
    toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-2');
    toast.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
    
    setTimeout(() => {
        toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-2');
        toast.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
    }, duration);
}

// Tampilkan toast jika ada session message
@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showToast('{{ session('error') }}', 'error', 5000);
@endif
</script>

</body>
</html>