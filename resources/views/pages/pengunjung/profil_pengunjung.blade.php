@extends('layouts.pengunjung')

@section('title', 'Profil Pengunjung')

@section('body_class', 'bg-cream font-poppins min-h-screen flex flex-col')

@section('content')
<!-- CONTENT -->
    <div class="flex-grow flex items-center justify-center p-4 sm:p-10 py-10">
        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] p-6 sm:p-14 shadow-xl border border-slate-100">

            <!-- Profile Section -->
            <div class="flex flex-col items-center mb-10">
                <!-- Profile Image -->
                <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full overflow-hidden border-4 border-slate-100 shadow-md">
                    <img src="" alt="Profile" class="w-full h-full object-cover">
                </div>
                <h2 class="mt-6 text-2xl sm:text-3xl font-bold text-navy text-center tracking-tight">Yohana Abigail
                    Napitu</h2>
            </div>

            <hr class="border-t-[1.5px] border-slate-200 mb-10">

            <!-- Form Section -->
            <div class="space-y-6 max-w-2xl mx-auto">
                <!-- NIM -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                    <label class="font-semibold text-navy w-32 shrink-0 text-lg">NIM</label>
                    <input type="text" value="3312501008" readonly
                        class="w-full border border-grayCustom rounded-xl px-5 py-3.5 text-grayCustom font-medium focus:outline-none bg-slate-50 transition">
                </div>

                <!-- Email -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                    <label class="font-semibold text-navy w-32 shrink-0 text-lg">Email</label>
                    <input type="email" value="yohana@gmail.com" readonly
                        class="w-full border border-grayCustom rounded-xl px-5 py-3.5 text-grayCustom font-medium focus:outline-none bg-slate-50 transition">
                </div>
            </div>

            <!-- Action Button -->
            <div class="mt-16 flex flex-col sm:flex-row justify-between items-center gap-5">
                <!-- Left Button -->
                <a href="{{ route('pengunjung.daftar_panitia') }}"
                    class="w-full sm:w-auto inline-flex justify-center rounded-full bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy shadow-md">
                    Daftar Sebagai Panitia
                </a>

                <!-- Right Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <button type="button" onclick="openEditModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-full bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy shadow-md">
                        Edit Profil
                    </button>
                    <button
                        class="w-full sm:w-auto inline-flex justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-grayCustom transition hover:border-yellow hover:bg-yellow/10 shadow-sm">
                        Keluar
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Edit Profil -->
    <div id="edit-profil-modal"
        class="fixed inset-0 bg-black/60 z-[60] flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div
            class="bg-white w-full max-w-2xl rounded-3xl p-6 sm:p-8 shadow-2xl relative max-h-[95vh] overflow-y-auto transform scale-95 transition-transform duration-300 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

            <form onsubmit="return handleEditSubmit(event)">

                <!-- Profile Picture -->
                <div class="flex flex-col items-center mb-4 mt-2">
                    <div
                        class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border border-slate-200 shadow-md">
                        <img src="" alt="Profile" class="w-full h-full object-cover" id="preview-image">
                    </div>

                    <div class="mt-3 text-center">
                        <label
                            class="inline-flex items-center border border-grayCustom rounded-xl overflow-hidden cursor-pointer hover:bg-slate-50 transition shadow-sm mb-1">
                            <span
                                class="bg-[#E2E8F0] px-4 py-1.5 font-semibold text-grayCustom border-r border-grayCustom text-sm">Browse</span>
                            <span class="px-4 py-1.5 text-grayCustom font-medium text-xs sm:text-sm" id="file-name">No
                                file selected.</span>
                            <input type="file" class="hidden" accept=".jpg,.png"
                                onchange="document.getElementById('file-name').innerText = this.files[0] ? this.files[0].name : 'No file selected.'">
                        </label>
                        <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*kosongkan jika tidak ingin mengubah
                            foto. Format: JPG, PNG, Maks: 2MB</p>
                    </div>
                </div>

                <hr class="border-t border-slate-300 mb-4 w-[108%] -ml-[4%] sm:w-[110%] sm:-ml-[5%]">

                <!-- Edit Profil -->
                <div class="space-y-3 max-w-xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-center gap-1 sm:gap-2">
                        <label class="font-bold text-navy text-sm sm:text-base">Nama</label>
                        <input type="text" value="Yohana Abigail Napitu"
                            class="w-full border border-grayCustom rounded-lg px-3 py-2 text-navy text-sm font-medium focus:outline-none bg-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-start gap-1 sm:gap-2">
                        <label class="font-bold text-navy text-sm sm:text-base mt-2">NIM</label>
                        <div>
                            <input type="text" value="3312501008" readonly
                                class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-lg px-3 py-2 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none">
                            <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*NIM tidak dapat diubah</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-start gap-1 sm:gap-2">
                        <label class="font-bold text-navy text-sm sm:text-base mt-2">Email</label>
                        <div>
                            <input type="email" value="yohana@gmail.com" readonly
                                class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-lg px-3 py-2 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none">
                            <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*email tidak dapat diubah</p>
                        </div>
                    </div>
                </div>

                <hr class="border-t border-slate-300 my-4 w-[108%] -ml-[4%] sm:w-[110%] sm:-ml-[5%]">

                <!-- Password -->
                <div class="max-w-xl mx-auto mb-6 mt-2">
                    <p class="font-bold text-slate-400 mb-3 text-xs sm:text-sm">Ubah Password (Opsional)</p>
                    <div class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-center gap-1 sm:gap-2">
                            <label class="font-bold text-navy text-sm sm:text-base">Kata Sandi Baru</label>
                            <input type="password" placeholder="Masukkan kata sandi baru"
                                class="w-full border border-grayCustom rounded-lg px-3 py-2 text-navy text-sm font-medium focus:outline-none bg-white">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-start gap-1 sm:gap-2">
                            <label class="font-bold text-navy text-sm sm:text-base mt-2">Konfirmasi Kata Sandi</label>
                            <div>
                                <input type="password" placeholder="Konfirmasi kata sandi baru"
                                    class="w-full border border-grayCustom rounded-lg px-3 py-2 text-navy text-sm font-medium focus:outline-none bg-white">
                                <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*kosongkan jika tidak ingin
                                    mengubah kata sandi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="flex justify-end items-center gap-3 pt-2">
                    <button type="button" onclick="closeEditModal()"
                        class="w-full sm:w-auto inline-flex justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-grayCustom transition hover:border-yellow hover:bg-yellow/10 shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="w-full sm:w-auto inline-flex justify-center rounded-full bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy shadow-md">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toast-notice" class="fixed top-24 right-6 z-[70] w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-navy shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
        <p id="toast-notice-text" class="font-medium"></p>
    </div>
@endsection

@push('scripts')
<script>
        let noticeTimeout = null;
        const toastNotice = document.getElementById('toast-notice');
        const toastNoticeText = document.getElementById('toast-notice-text');

        function showToast(message, type = 'success') {
            if (!toastNotice || !toastNoticeText) return;
            toastNoticeText.innerText = message;
            
            if (type === 'error') {
                toastNotice.classList.replace('border-yellow', 'border-red-500');
                toastNoticeText.classList.replace('text-navy', 'text-red-600');
            } else {
                toastNotice.classList.replace('border-red-500', 'border-yellow');
                toastNoticeText.classList.replace('text-red-600', 'text-navy');
            }

            toastNotice.classList.remove('opacity-0', 'pointer-events-none');
            toastNotice.classList.add('opacity-100');
            
            clearTimeout(noticeTimeout);
            noticeTimeout = setTimeout(() => {
                toastNotice.classList.remove('opacity-100');
                toastNotice.classList.add('opacity-0', 'pointer-events-none');
            }, 3000);
        }

        function handleEditSubmit(e) {
            e.preventDefault();
            // Tutup pop up edit
            closeEditModal();
            // Munculkan toast suskes 
            showToast("Profil berhasil diperbarui!");
            return false;
        }
        const editModal = document.getElementById('edit-profil-modal');
        const modalContent = editModal.querySelector('div');

        function openEditModal() {
            editModal.classList.remove('hidden');
            setTimeout(() => {
                editModal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        }

        function closeEditModal() {
            editModal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                editModal.classList.add('hidden');
            }, 300);
        }

        // Menutup modal jika klik di luar area container putih
        editModal.addEventListener('click', function (e) {
            if (e.target === editModal) {
                closeEditModal();
            }
        });
    </script>
@endpush
