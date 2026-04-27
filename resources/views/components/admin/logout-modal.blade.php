<!-- ===== MODAL LOGOUT ===== -->
<div id="logoutModal" class="fixed inset-0 hidden z-[999] items-center justify-center">
    <div class="absolute inset-0 bg-black/50 " onclick="closeLogoutModal()"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden">
        <!-- Header -->
        <div class="bg-[#192853] px-6 py-4 flex items-center gap-3">
            <div class="w-9 h-9 flex items-center justify-center rounded-full bg-red-500/20">
                <i class="fa-solid fa-right-from-bracket text-red-400"></i>
            </div>
            <h3 class="text-white font-semibold text-base">Konfirmasi Keluar</h3>
        </div>

        <!-- Body -->
        <div class="px-6 py-5 text-center">
            <p class="text-gray-700 text-sm">Apakah kamu yakin ingin keluar dari <span class="font-semibold text-[#192853]">Eventix Admin</span>?</p>
            <p class="text-gray-400 text-xs mt-1">Sesi kamu akan diakhiri.</p>
        </div>

        <!-- Footer -->
        <div class="px-6 pb-5 flex gap-3 justify-end">
            <button onclick="closeLogoutModal()"
                class="px-4 py-2 text-sm rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                Batal
            </button>
            <button onclick="document.getElementById('logoutForm').submit()"
                class="px-4 py-2 text-sm rounded-lg bg-red-500 text-white hover:bg-red-600 transition flex items-center gap-2">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                Ya, Keluar
            </button>
        </div>
    </div>
</div>

<script>
    function openLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeLogoutModal() {
        const modal = document.getElementById('logoutModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal jika tekan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeLogoutModal();
    });
</script>
