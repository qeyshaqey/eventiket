<!-- ===== MODAL LOGOUT ===== -->
<div id="logoutModal" tabindex="-1" aria-hidden="true" class="fixed inset-0 hidden z-[999] items-center justify-center overflow-y-auto overflow-x-hidden">
    <div class="relative p-4 w-full max-w-sm h-full md:h-auto flex items-center justify-center">
        <!-- Overlay (handled by Flowbite but keeping the relative structure for safety) -->
        <div class="fixed inset-0 bg-black/50" data-modal-hide="logoutModal"></div>

        <div class="relative bg-white rounded-2xl shadow-2xl w-full overflow-hidden">
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
                <button data-modal-hide="logoutModal"
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
</div>
