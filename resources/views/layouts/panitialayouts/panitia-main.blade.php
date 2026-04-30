<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventix Panitia</title>

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- TAILWIND -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#EFF8FF] font-[poppins] font-semibold">

<!-- TOAST -->
<div id="toast-notice"
    class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform translate-y-2 rounded-[24px] border border-slate-200 border-r-8 bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <div class="flex items-center gap-3">
        <i id="toast-icon" class="bi bi-bell-fill text-lg"></i>
        <span id="toast-message"></span>
    </div>
</div>

<!-- SIDEBAR -->
<x-sidebarpanit />

<!-- MAIN WRAPPER -->
<div class="md:ml-[260px] min-h-screen flex flex-col transition-all duration-300">

    <!-- TOPBAR MOBILE -->
    <div class="md:hidden bg-white border-b px-4 py-3 flex items-center justify-between shadow-sm sticky top-0 z-30">
        <h1 class="font-bold text-[#192853]">Menu</h1>

        <!-- ✅ FLOWBITE DRAWER -->
        <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" class="text-2xl text-[#192853]">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <!-- CONTENT -->
    <div class="p-4 md:p-6 flex-1 w-full overflow-x-hidden">
        @yield('content')
    </div>

</div>

<!-- TOAST SCRIPT (INI BOLEH, bukan UI toggle) -->
<script>
function showToast(message, type = 'success', duration = 3000) {
    const toast = document.getElementById('toast-notice');
    const toastMessage = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');

    if (type === 'error') {
        toast.classList.add('border-red-500');
        toastIcon.classList.add('text-red-500','bi-exclamation-circle-fill');
    } else {
        toast.classList.add('border-yellow');
        toastIcon.classList.add('text-yellow-500','bi-bell-fill');
    }

    toastMessage.textContent = message;
    toast.classList.remove('opacity-0','pointer-events-none','translate-y-2');
    toast.classList.add('opacity-100','pointer-events-auto','translate-y-0');

    setTimeout(() => {
        toast.classList.add('opacity-0','pointer-events-none','translate-y-2');
        toast.classList.remove('opacity-100','pointer-events-auto','translate-y-0');
    }, duration);
}
</script>

@yield('script')

<!-- FLOWBITE MODAL -->
<div id="logoutModal"
    tabindex="-1"
    class="fixed inset-0 hidden z-50 items-center justify-center">

    <!-- overlay (Flowbite auto close) -->
    <div class="absolute inset-0 bg-black/50" data-modal-hide="logoutModal"></div>

    <div class="relative bg-white w-[90%] max-w-[380px] rounded-2xl shadow-xl p-6">
        <h2 class="text-center font-bold text-[#192853] text-lg">Keluar dari akun?</h2>

        <div class="flex gap-3 mt-6">
            <!-- CLOSE -->
            <button data-modal-hide="logoutModal" class="w-full py-2 bg-gray-100 rounded-lg">
                Batal
            </button>

            <!-- tetap submit -->
            <button onclick="document.getElementById('logoutForm').submit()" 
                class="w-full py-2 bg-red-500 text-white rounded-lg">
                Keluar
            </button>
        </div>
    </div>
</div>

<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<!-- FLOWBITE -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>
</html>