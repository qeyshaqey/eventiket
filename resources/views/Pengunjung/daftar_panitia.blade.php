<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kepanitiaan Event</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
   
    <!-- Tailwind CSS -->
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

    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
        
    <style>
        /* Sembunyikan icon kalender default*/
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            transition: 0.2s;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>
</head>

<body class="bg-cream font-poppins min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <div class="sticky top-0 z-50 bg-navy text-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-5">
            <a href="/home" class="text-xl font-semibold tracking-tight">Eventiket</a>

            <div class="flex items-center gap-3">
                <a href="/tiket_aktif"
                    class="rounded-full border border-white px-4 py-2 text-sm font-medium text-white transition hover:bg-white hover:text-navy">TIKET SAYA</a>

                <!-- ICON USER -->
                <a href="{{ route('pengunjung.profil') }}"
                    class="w-10 h-10 rounded-full border border-white bg-transparent text-white flex items-center justify-center transition hover:bg-white hover:text-navy">
                    <i class="fa-solid fa-user text-lg"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- CONTENT -->
    <div class="flex-grow flex justify-center px-4 sm:px-10 py-6 sm:py-10 pb-20">
        <div class="bg-white w-full max-w-4xl rounded-[2.5rem] overflow-hidden shadow-xl border border-slate-100">

            <!-- Card Header -->
            <div class="px-6 sm:px-12 pt-6 sm:pt-10 pb-5 border-b-2 border-slate-100 bg-white">
                <h2 class="text-2xl sm:text-3xl font-bold text-navy tracking-tight">Form Pengajuan Panitia</h2>
                <p class="text-xs sm:text-sm text-grayCustom mt-1 font-medium">*Lengkapi data event yang akan direncanakan</p>
            </div>

            <!-- Form -->
            <div class="px-6 sm:px-12 pt-5 pb-10">

                <form id="form-pengajuan" action="{{ route('pengunjung.daftar_panitia.store') }}" method="POST" onsubmit="return validateForm(event)">
                    @csrf
                    
                    <div class="space-y-10">
                        <!-- 1. IDENTITAS PENGAJU -->
                        <div>
                            <h3 class="text-xl font-bold text-navy mb-5 tracking-wide">IDENTITAS PENGAJU</h3>
                            <div class="space-y-5">
                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Nama Lengkap*</label>
                                <input type="text" value="Yohana Abigail Napitu" class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 transition">
                            </div>
                            
                            <!-- NIM -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">NIM*</label>
                                <input type="text" value="3312501008" readonly class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-xl px-5 py-3 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none transition">
                                <p class="text-[10px] sm:text-xs text-grayCustom mt-1.5">*NIM tidak dapat diubah</p>
                            </div>
                            
                            <!-- Email -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Email*</label>
                                <input type="email" value="yohana@gmail.com" readonly class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-xl px-5 py-3 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none transition">
                                <p class="text-[10px] sm:text-xs text-grayCustom mt-1.5">*Email tidak dapat diubah</p>
                            </div>
                            
                            <!-- Nama Organisasi -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Nama Organisasi*</label>
                                <div class="relative">
                                    <select id="organisasi" class="w-full appearance-none border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 transition cursor-pointer">
                                        <option value="" disabled selected>Pilih organisasi</option>
                                        <option value="Dewan Perwakilan Mahasiswa">Dewan Perwakilan Mahasiswa</option>
                                        <option value="Badan Eksekutif Mahasiswa">Badan Eksekutif Mahasiswa</option>
                                        <option value="Ikatan Mahasiswa Muslim">Ikatan Mahasiswa Muslim</option>
                                        <option value="Persekutuan Doa El-Shaddai">Persekutuan Doa El-Shaddai</option>
                                        <option value="Himpunan Mahasiswa Teknik Informatika">Himpunan Mahasiswa Teknik Informatika</option>
                                        <option value="Himpunan Mahasiswa Mesin">Himpunan Mahasiswa Mesin</option>
                                        <option value="Himpunan Mahasiswa Elektro">Himpunan Mahasiswa Elektro</option>
                                        <option value="Himpunan Mahasiswa Manajemen Bisnis">Himpunan Mahasiswa Manajemen Bisnis</option>
                                        <option value="Mahasiswa Pecinta Alam">Mahasiswa Pecinta Alam</option>
                                        <option value="Polibatam English Club">Polibatam English Club</option>
                                        <option value="Batam Linux User Group">Batam Linux User Group</option>
                                        <option value="Komite Olahraga Polibatam">Komite Olahraga Polibatam</option>
                                        <option value="Kumpulan Anak Seni">Kumpulan Anak Seni</option>
                                        <option value="Entrepreneur Generation">Entrepreneur Generation</option>
                                        <option value="Reka Multimedia">Reka Multimedia</option>
                                        <option value="Lembaga Pers Mahasiswa">Lembaga Pers Mahasiswa</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-grayCustom">
                                        <i class="fa-solid fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-t-[1.5px] border-slate-200">

                    <!-- 2. DETAIL RENCANA EVENT -->
                    <div>
                        <h3 class="text-xl font-bold text-navy mb-5 tracking-wide">DETAIL RENCANA EVENT</h3>
                        <div class="space-y-5">
                            <!-- Nama Event -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Nama Event yang Direncanakan*</label>
                                <input type="text" id="nama_event" placeholder="Masukkan nama event" class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 placeholder-slate-400 transition">
                            </div>
                            
                            <!-- Kategori Event -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Kategori Event*</label>
                                <div class="relative">
                                    <select id="kategori" class="w-full appearance-none border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 transition cursor-pointer">
                                        <option value="" disabled selected>Pilih kategori</option>
                                        <option value="Seminar">Seminar</option>
                                        <option value="Olahraga">Olahraga</option>
                                        <option value="Keagamaan">Keagamaan</option>
                                        <option value="Hiburan">Hiburan</option>
                                        <option value="Workshop">Workshop</option>
                                        <option value="Kompetisi">Kompetisi</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-5 text-grayCustom">
                                        <i class="fa-solid fa-chevron-down text-sm"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Perkiraan Tanggal -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Perkiraan Tanggal Event*</label>
                                <div class="relative">
                                    <input type="date" id="tanggal" class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 transition uppercase text-grayCustom">
                                </div>
                            </div>
                            
                            <!-- Deskripsi Singkat -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Deskripsi Singkat Event*</label>
                                <textarea id="deskripsi" rows="4" placeholder="Jelaskan rencana event Anda secara singkat..." class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 placeholder-slate-400 transition resize-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Area -->
                    <div class="mt-12 pb-2 max-w-lg mx-auto">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('pengunjung.profil') }}" class="w-full sm:w-1/2 inline-flex justify-center rounded-full border border-slate-300 bg-white px-6 py-3.5 text-sm font-bold text-grayCustom shadow-sm transition hover:border-yellow hover:bg-yellow/10 uppercase tracking-wide">
                                Batal
                            </a>
                            <button type="submit" class="w-full sm:w-1/2 inline-flex justify-center rounded-full bg-navy px-6 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-yellow hover:text-navy hover:shadow-yellow/30 uppercase tracking-wide">
                                Kirim Pengajuan
                            </button>
                        </div>
                        <p class="text-[10px] sm:text-xs text-center text-grayCustom mt-4 font-medium">*Pengajuan akan ditinjau admin dalam 1-7 hari kerja</p>
                    </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toast-notice" class="fixed top-24 right-6 z-[60] w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none transform rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-navy shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
        <p id="toast-notice-text" class="font-medium"></p>
    </div>

    <!-- SCRIPTS -->
    <script>
        let noticeTimeout = null;
        const toastNotice = document.getElementById('toast-notice');
        const toastNoticeText = document.getElementById('toast-notice-text');

        function showToast(message, type = 'success') {
            if (!toastNotice || !toastNoticeText) return;
            toastNoticeText.innerText = message;
            
            // Ubah gaya warna batas berdasarkan tipe (error = merah, success = kuning)
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

        function validateForm(e) {
            const organisasi = document.getElementById('organisasi').value;
            const namaEvent = document.getElementById('nama_event').value.trim();
            const kategori = document.getElementById('kategori').value;
            const tanggal = document.getElementById('tanggal').value;
            const deskripsi = document.getElementById('deskripsi').value.trim();

            if (!organisasi || !namaEvent || !kategori || !tanggal || !deskripsi) {
                e.preventDefault(); // ada nontifikasi gagal
                showToast("Silakan lengkapi form terlebih dahulu", "error");
                return false;
            }
            // Jika sukses, ada notifikasi berhasil
            return true;
        }

        @if(session('success'))
            // Munculkan toast otomatis ketika ada pesan suskes
            window.addEventListener('DOMContentLoaded', (event) => {
                showToast("{{ session('success') }}");
            });
        @endif
    </script>
</body>
</html>
