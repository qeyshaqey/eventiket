<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
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
<div id="toast-notice" class="fixed top-6 right-6 z-50 w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform translate-y-2 rounded-[24px] border border-slate-200 border-r-8 bg-white/95 px-5 py-4 text-sm text-slate-900 shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <div class="flex items-center gap-3">
        <i id="toast-icon" class="bi bi-bell-fill text-lg"></i>
        <span id="toast-message"></span>
    </div>
</div>

<div class="flex">

    <!-- SIDEBAR COMPONENT -->
    <x-sidebarpanit />

    <!-- CONTENT -->
    <div class="flex-1 p-6 overflow-y-auto h-screen">
        @yield('content')
    </div>

</div>

<!-- TOAST SCRIPT -->
<script>
function showToast(message, type = 'success', duration = 3000) {
    const toast = document.getElementById('toast-notice');
    const toastMessage = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');
    
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

@if(session('success'))
    showToast('{{ session('success') }}', 'success');
@endif

@if(session('error'))
    showToast('{{ session('error') }}', 'error', 5000);
@endif
</script>
@yield('script')

<!-- ================= LOGOUT MODAL ================= -->
<div id="logoutModal" class="fixed inset-0 hidden z-50 items-center justify-center">

    <!-- BACKDROP -->
    <div class="absolute inset-0 bg-black/50" onclick="closeLogoutModal()"></div>

    <!-- CONTENT -->
    <div class="relative bg-white w-[380px] rounded-2xl shadow-xl p-6 animate-fadeIn">

        <div class="flex justify-center mb-4">
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100">
                <i class="bi bi-box-arrow-right text-red-500 text-lg"></i>
            </div>
        </div>

        <h2 class="text-center font-bold text-[#192853] text-lg">
            Keluar dari akun?
        </h2>

        <p class="text-center text-sm text-gray-500 mt-1">
            Kamu akan keluar dari sistem Eventix
        </p>

        <div class="flex gap-3 mt-6">
            <button onclick="closeLogoutModal()"
                class="w-full py-2 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                Batal
            </button>

            <button onclick="document.getElementById('logoutForm').submit()"
                class="w-full py-2 rounded-lg bg-red-500 text-white hover:bg-red-600 transition">
                Keluar
            </button>
        </div>

    </div>
</div>

<!-- FORM LOGOUT -->
<form id="logoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<!-- SCRIPT LOGOUT -->
<script>
function openLogoutModal(){
    const modal = document.getElementById('logoutModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeLogoutModal(){
    const modal = document.getElementById('logoutModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('keydown', function(e){
    if(e.key === 'Escape') closeLogoutModal();
});
</script>

<!-- ANIMASI -->
<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.2s ease-out;
}
</style>
</body>
</html>