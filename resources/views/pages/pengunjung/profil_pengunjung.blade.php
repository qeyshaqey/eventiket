@extends('layouts.pengunjung.pengunjung')

@section('title', 'Profil Pengunjung')

@section('body_class', 'bg-cream font-poppins min-h-screen flex flex-col')

@section('content')
<!-- Bagian isi konten halaman -->
    <div class="flex-grow flex items-center justify-center p-4 sm:p-10 py-10">
        <div class="bg-white w-full max-w-3xl rounded-2xl p-6 sm:p-12 shadow-xl border border-slate-100">

            <!-- Profile Section -->
            <div class="flex flex-col items-center mb-6">
                <!-- Nampilin foto profil -->
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-slate-100 shadow-md">
                    <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=192853&color=fff' }}" alt="Profil" class="w-full h-full object-cover">
                </div>
                <h2 class="mt-5 text-2xl sm:text-3xl font-bold text-navy text-center tracking-tight">{{ $user->name }}</h2>
            </div>

            <hr class="border-t-[1.5px] border-slate-200 mb-8">

            <!-- List data profil pengunjung -->
            <div class="space-y-5 max-w-2xl mx-auto">
                <!-- Kolom inputan NIM -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                    <label class="font-semibold text-navy w-24 shrink-0 text-base">NIM</label>
                    <input type="text" value="{{ $user->nim }}" readonly
                        class="w-full border border-grayCustom rounded-xl px-5 py-3 text-grayCustom font-medium focus:outline-none bg-slate-50 transition text-sm">
                </div>

                <!-- Kolom inputan email -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-6">
                    <label class="font-semibold text-navy w-24 shrink-0 text-base">Email</label>
                    <input type="email" value="{{ $user->email }}" readonly
                        class="w-full border border-grayCustom rounded-xl px-5 py-3 text-grayCustom font-medium focus:outline-none bg-slate-50 transition text-sm">
                </div>
            </div>

            <!-- Tombol aksi edit / logout -->
            <div class="mt-10 flex flex-col sm:flex-row justify-between items-center gap-4">
                <!-- Tombol kiri (daftar panitia) -->
                <a href="{{ route('pengunjung.daftar_panitia') }}"
                    class="w-full sm:w-auto inline-flex justify-center rounded-full bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy shadow-md">
                    Daftar Sebagai Panitia
                </a>

                <!-- Tombol kanan (edit & logout) -->
                <div class="flex flex-col sm:flex-row gap-4 w-full sm:w-auto">
                    <button type="button" data-modal-target="edit-profil-modal" data-modal-toggle="edit-profil-modal"
                        class="w-full sm:w-auto inline-flex justify-center rounded-full bg-navy px-6 py-3 text-sm font-semibold text-white transition hover:bg-yellow hover:text-navy shadow-md">
                        Edit Profil
                    </button>
                    <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto" id="logout-form">
                        @csrf
                        <button type="button" data-modal-target="logout-modal" data-modal-toggle="logout-modal"
                            class="w-full inline-flex justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-grayCustom transition hover:border-yellow hover:bg-yellow/10 shadow-sm">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <!-- Pop up modal buat edit profil -->
    <div id="edit-profil-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 bg-black/60 z-[60] flex items-center justify-center hidden p-4">
        <div
            class="bg-white w-full max-w-2xl rounded-3xl p-6 sm:p-8 shadow-2xl relative max-h-[95vh] overflow-y-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">

            <form action="{{ route('pengunjung.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Edit foto profil di modal -->
                <div class="flex flex-col items-center mb-4 mt-2">
                    <div
                        class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden border border-slate-200 shadow-md">
                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=192853&color=fff' }}" alt="Profil" class="w-full h-full object-cover" id="preview-image">
                    </div>

                    <div class="mt-3 text-center">
                        <label
                            class="inline-flex items-center border border-grayCustom rounded-xl overflow-hidden cursor-pointer hover:bg-slate-50 transition shadow-sm mb-1">
                            <span
                                class="bg-[#E2E8F0] px-4 py-1.5 font-semibold text-grayCustom border-r border-grayCustom text-sm">Pilih File</span>
                            <span class="px-4 py-1.5 text-grayCustom font-medium text-xs sm:text-sm" id="file-name">Tidak ada file dipilih.</span>
                            <input type="file" name="photo" class="hidden" accept=".jpg,.png,.jpeg"
                                onchange="document.getElementById('file-name').innerText = this.files[0] ? this.files[0].name : 'Tidak ada file dipilih.'; handleImagePreview(this);">
                        </label>
                        @error('photo')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*kosongkan jika tidak ingin mengubah
                            foto. Format: JPG, JPEG, PNG, Maks: 2MB</p>
                    </div>
                </div>

                <hr class="border-t border-slate-300 mb-4 w-[108%] -ml-[4%] sm:w-[110%] sm:-ml-[5%]">

                <!-- Inputan form edit profil -->
                <div class="space-y-3 max-w-xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-center gap-1 sm:gap-2">
                        <label class="font-bold text-navy text-sm sm:text-base">Nama</label>
                        <div>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="w-full border @error('name') border-red-500 @else border-grayCustom @enderror rounded-lg px-3 py-2 text-navy text-sm font-medium focus:outline-none bg-white">
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-start gap-1 sm:gap-2">
                        <label class="font-bold text-navy text-sm sm:text-base mt-2">NIM</label>
                        <div>
                            <input type="text" value="{{ $user->nim }}" readonly
                                class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-lg px-3 py-2 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none">
                            <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*NIM tidak dapat diubah</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-start gap-1 sm:gap-2">
                        <label class="font-bold text-navy text-sm sm:text-base mt-2">Email</label>
                        <div>
                            <input type="email" value="{{ $user->email }}" readonly
                                class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-lg px-3 py-2 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none">
                            <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*email tidak dapat diubah</p>
                        </div>
                    </div>
                </div>

                <hr class="border-t border-slate-300 my-4 w-[108%] -ml-[4%] sm:w-[110%] sm:-ml-[5%]">

                <!-- Bagian ubah password (opsional) -->
                <div class="max-w-xl mx-auto mb-6 mt-2">
                    <p class="font-bold text-slate-400 mb-3 text-xs sm:text-sm">Ubah Password (Opsional)</p>
                    <div class="space-y-3">
                        <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-center gap-1 sm:gap-2">
                            <label class="font-bold text-navy text-sm sm:text-base">Kata Sandi Baru</label>
                            <div>
                                <input type="password" name="password" placeholder="Masukkan kata sandi baru"
                                    class="w-full border @error('password') border-red-500 @else border-grayCustom @enderror rounded-lg px-3 py-2 text-navy text-sm font-medium focus:outline-none bg-white">
                                @error('password')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-[160px_1fr] items-start gap-1 sm:gap-2">
                            <label class="font-bold text-navy text-sm sm:text-base mt-2">Konfirmasi Kata Sandi</label>
                            <div>
                                <input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi baru"
                                    class="w-full border border-grayCustom rounded-lg px-3 py-2 text-navy text-sm font-medium focus:outline-none bg-white">
                                <p class="text-[10px] sm:text-xs text-grayCustom mt-1">*kosongkan jika tidak ingin
                                    mengubah kata sandi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tombol batal / simpan modal -->
                <div class="flex justify-end items-center gap-3 pt-2">
                    <button type="button" data-modal-hide="edit-profil-modal"
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

    <!-- Pop up modal buat konfirmasi logout -->
    <div id="logout-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 bg-black/60 z-[70] flex items-center justify-center hidden p-4">
        <div
            class="bg-white w-full max-w-sm rounded-[24px] p-6 sm:p-8 shadow-2xl relative text-center">
            
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-50 mb-5 border border-red-100">
                <i class="fa-solid fa-arrow-right-from-bracket text-2xl text-red-500"></i>
            </div>
            
            <h3 class="text-xl font-bold text-navy mb-2 tracking-tight">Konfirmasi Keluar</h3>
            <p class="text-sm text-grayCustom mb-8 font-medium">Apakah Anda yakin ingin keluar dari akun Anda? Anda harus login kembali untuk memesan tiket.</p>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button type="button" data-modal-hide="logout-modal"
                    class="w-full sm:w-1/2 inline-flex justify-center rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-grayCustom transition hover:border-yellow hover:bg-yellow/10 shadow-sm">
                    Batal
                </button>
                <button type="button" onclick="submitLogout()"
                    class="w-full sm:w-1/2 inline-flex justify-center rounded-full bg-red-500 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-600 shadow-md">
                    Ya, Keluar
                </button>
            </div>
        </div>
    </div>

    <!-- Toast notifikasi melayang -->
    <div id="toast-notice" class="fixed top-24 right-6 z-[70] w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-navy shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
        <p id="toast-notice-text" class="font-medium"></p>
        <span class="hidden !border-red-500 !border-yellow"></span>
    </div>
@endsection

@push('scripts')
<script>
        // buat ngatur timeout notifikasi
        let noticeTimeout = null;
        const toastNotice = document.getElementById('toast-notice');
        const toastNoticeText = document.getElementById('toast-notice-text');

        // fungsi buat nampilin notifikasi kuning / merah
        function showToast(message, type = 'success') {
            if (!toastNotice || !toastNoticeText) return;
            toastNoticeText.innerText = message;
            
            toastNotice.classList.toggle('!border-red-500', type === 'error');
            toastNotice.classList.toggle('border-yellow', type !== 'error');

            toastNotice.classList.remove('opacity-0', 'pointer-events-none');
            toastNotice.classList.add('opacity-100');
            
            clearTimeout(noticeTimeout);
            noticeTimeout = setTimeout(() => {
                toastNotice.classList.remove('opacity-100');
                toastNotice.classList.add('opacity-0', 'pointer-events-none');
            }, 3000);
        }

        // fungsi buat preview gambar yang baru diupload
        function handleImagePreview(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // submit form logout
        function submitLogout() {
            document.getElementById('logout-form').submit();
        }

        // kalau session sukses dikirim dari controller, panggil toast
        @if(session('profile_success'))
            window.addEventListener('DOMContentLoaded', (event) => {
                showToast("{{ session('profile_success') }}");
            });
        @endif

        // kalau ada error validasi Laravel, modal otomatis kebuka lagi
        @if ($errors->any())
            window.addEventListener('DOMContentLoaded', (event) => {
                const modal = document.getElementById('edit-profil-modal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
                showToast("Terjadi kesalahan validasi!", "error");
            });
        @endif
    </script>
@endpush
