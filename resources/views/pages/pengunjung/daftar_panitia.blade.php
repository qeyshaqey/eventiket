@extends('layouts.pengunjung.pengunjung')

@section('title', 'Daftar Kepanitiaan Event')

@section('body_class', 'bg-cream font-poppins min-h-screen flex flex-col')

@push('styles')
<style>
    input[type="date"]::-webkit-calendar-picker-indicator { cursor:pointer; opacity:.6; transition:.2s; }
    input[type="date"]::-webkit-calendar-picker-indicator:hover { opacity:1; }

    /* Custom Dropdown Piih Organisasi dan Pilih Kategori */
    .dd { position:relative; }
    .dd-trigger { display:flex; justify-content:space-between; align-items:center; width:100%; padding:.75rem 1.25rem; border:1px solid #94a3b8; border-radius:.75rem; background:#f8fafc; font-size:.875rem; font-weight:500; color:#94a3b8; cursor:pointer; user-select:none; transition:border-color .2s,box-shadow .2s; }
    .dd-trigger.selected { color:#1e3a5f; }
    .dd-trigger.open, .dd-trigger:focus { outline:none; border-color:#1e3a5f; box-shadow:0 0 0 1px #1e3a5f; }
    .dd-trigger i { transition:transform .2s; flex-shrink:0; margin-left:.5rem; }
    .dd-trigger.open i { transform:rotate(180deg); }
    .dd-list { display:none; position:absolute; left:0; right:0; top:calc(100% + 4px); z-index:50; background:#fff; border:1px solid #e2e8f0; border-radius:.75rem; box-shadow:0 8px 24px rgba(0,0,0,.12); max-height:210px; overflow-y:auto; overflow-x:hidden; }
    .dd-list.open { display:block; }
    .dd-item { padding:.6rem 1.25rem; font-size:.875rem; color:#1e3a5f; cursor:pointer; word-break:break-word; }
    .dd-item:hover, .dd-item.active { background:#f1f5f9; }
    .dd-item.placeholder-opt { color:#94a3b8; pointer-events:none; }
</style>
@endpush

@section('content')
<div class="flex-grow flex justify-center px-4 sm:px-10 py-6 sm:py-10 pb-20">
    <div class="bg-white w-full max-w-4xl rounded-[2.5rem] shadow-xl border border-slate-100">

        <!-- Card Header -->
        <div class="px-6 sm:px-12 pt-6 sm:pt-10 pb-5 border-b-2 border-slate-100 rounded-t-[2.5rem]">
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

                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Nama Lengkap*</label>
                                <input type="text" value="Yohana Abigail Napitu" class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 transition">
                            </div>

                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">NIM*</label>
                                <input type="text" value="3312501008" readonly class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-xl px-5 py-3 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none">
                                <p class="text-[10px] sm:text-xs text-grayCustom mt-1.5">*NIM tidak dapat diubah</p>
                            </div>

                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Email*</label>
                                <input type="email" value="yohana@gmail.com" readonly class="w-full border border-grayCustom bg-[#cbd5e1]/50 rounded-xl px-5 py-3 text-grayCustom text-sm font-semibold cursor-not-allowed outline-none">
                                <p class="text-[10px] sm:text-xs text-grayCustom mt-1.5">*Email tidak dapat diubah</p>
                            </div>

                            <!-- Nama Organisasi -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Nama Organisasi*</label>
                                <input type="hidden" id="organisasi" name="organisasi">
                                <div class="dd" data-for="organisasi">
                                    <div class="dd-trigger" tabindex="0">
                                        <span>Pilih organisasi</span>
                                        <i class="fa-solid fa-chevron-down text-sm text-grayCustom"></i>
                                    </div>
                                    <div class="dd-list">
                                        <div class="dd-item placeholder-opt">Pilih organisasi</div>
                                        <div class="dd-item" data-v="Dewan Perwakilan Mahasiswa">Dewan Perwakilan Mahasiswa</div>
                                        <div class="dd-item" data-v="Badan Eksekutif Mahasiswa">Badan Eksekutif Mahasiswa</div>
                                        <div class="dd-item" data-v="Ikatan Mahasiswa Muslim">Ikatan Mahasiswa Muslim</div>
                                        <div class="dd-item" data-v="Persekutuan Doa El-Shaddai">Persekutuan Doa El-Shaddai</div>
                                        <div class="dd-item" data-v="Himpunan Mahasiswa Teknik Informatika">Himpunan Mahasiswa Teknik Informatika</div>
                                        <div class="dd-item" data-v="Himpunan Mahasiswa Mesin">Himpunan Mahasiswa Mesin</div>
                                        <div class="dd-item" data-v="Himpunan Mahasiswa Elektro">Himpunan Mahasiswa Elektro</div>
                                        <div class="dd-item" data-v="Himpunan Mahasiswa Manajemen Bisnis">Himpunan Mahasiswa Manajemen Bisnis</div>
                                        <div class="dd-item" data-v="Mahasiswa Pecinta Alam">Mahasiswa Pecinta Alam</div>
                                        <div class="dd-item" data-v="Polibatam English Club">Polibatam English Club</div>
                                        <div class="dd-item" data-v="Batam Linux User Group">Batam Linux User Group</div>
                                        <div class="dd-item" data-v="Komite Olahraga Polibatam">Komite Olahraga Polibatam</div>
                                        <div class="dd-item" data-v="Kumpulan Anak Seni">Kumpulan Anak Seni</div>
                                        <div class="dd-item" data-v="Entrepreneur Generation">Entrepreneur Generation</div>
                                        <div class="dd-item" data-v="Reka Multimedia">Reka Multimedia</div>
                                        <div class="dd-item" data-v="Lembaga Pers Mahasiswa">Lembaga Pers Mahasiswa</div>
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

                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Nama Event yang Direncanakan*</label>
                                <input type="text" id="nama_event" name="nama_event" placeholder="Masukkan nama event" class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 placeholder-slate-400 transition">
                            </div>

                            <!-- Kategori Event -->
                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Kategori Event*</label>
                                <input type="hidden" id="kategori" name="kategori">
                                <div class="dd" data-for="kategori">
                                    <div class="dd-trigger" tabindex="0">
                                        <span>Pilih kategori</span>
                                        <i class="fa-solid fa-chevron-down text-sm text-grayCustom"></i>
                                    </div>
                                    <div class="dd-list">
                                        <div class="dd-item placeholder-opt">Pilih kategori</div>
                                        <div class="dd-item" data-v="Seminar">Seminar</div>
                                        <div class="dd-item" data-v="Olahraga">Olahraga</div>
                                        <div class="dd-item" data-v="Keagamaan">Keagamaan</div>
                                        <div class="dd-item" data-v="Hiburan">Hiburan</div>
                                        <div class="dd-item" data-v="Workshop">Workshop</div>
                                        <div class="dd-item" data-v="Kompetisi">Kompetisi</div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Perkiraan Tanggal Event*</label>
                                <input type="date" id="tanggal" name="tanggal" class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 transition text-grayCustom">
                            </div>

                            <div>
                                <label class="block font-semibold text-navy text-sm mb-2">Deskripsi Singkat Event*</label>
                                <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Jelaskan rencana event Anda secara singkat..." class="w-full border border-grayCustom rounded-xl px-5 py-3 text-navy text-sm font-medium focus:outline-none focus:border-navy focus:ring-1 focus:ring-navy bg-slate-50 placeholder-slate-400 transition resize-none"></textarea>
                            </div>

                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="pb-2 max-w-lg mx-auto">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                            <a href="{{ route('pengunjung.profil') }}" class="w-full sm:w-1/2 inline-flex justify-center rounded-full border border-slate-300 bg-white px-6 py-3.5 text-sm font-bold text-grayCustom shadow-sm transition hover:border-yellow hover:bg-yellow/10 uppercase tracking-wide">Batal</a>
                            <button type="submit" class="w-full sm:w-1/2 inline-flex justify-center rounded-full bg-navy px-6 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-yellow hover:text-navy hover:shadow-yellow/30 uppercase tracking-wide">Kirim Pengajuan</button>
                        </div>
                        <p class="text-[10px] sm:text-xs text-center text-grayCustom mt-4 font-medium">*Pengajuan akan ditinjau admin dalam 1-7 hari kerja</p>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast-notice" class="fixed top-24 right-6 z-[60] w-[min(360px,calc(100%-2rem))] opacity-0 pointer-events-none rounded-[24px] border border-slate-200 border-r-8 border-yellow bg-white/95 px-5 py-4 text-sm text-navy shadow-2xl backdrop-blur-sm transition duration-300 ease-out">
    <p id="toast-notice-text" class="font-medium"></p>
    <span class="hidden !border-red-500 !border-yellow"></span>
</div>
@endsection

@push('scripts')
<script>
    // Custom Dropdown
    document.querySelectorAll('.dd').forEach(dd => {
        const btn  = dd.querySelector('.dd-trigger');
        const list = dd.querySelector('.dd-list');
        const inp  = document.getElementById(dd.dataset.for);
        const lbl  = btn.querySelector('span');

        const open  = () => { btn.classList.add('open');    list.classList.add('open'); };
        const close = () => { btn.classList.remove('open'); list.classList.remove('open'); };

        btn.addEventListener('click', e => { e.stopPropagation(); list.classList.contains('open') ? close() : open(); });
        btn.addEventListener('keydown', e => { if (e.key==='Enter'||e.key===' ') { e.preventDefault(); list.classList.contains('open') ? close() : open(); } if(e.key==='Escape') close(); });

        list.querySelectorAll('.dd-item[data-v]').forEach(item => {
            item.addEventListener('click', () => {
                inp.value = lbl.textContent = item.dataset.v;
                btn.classList.add('selected');
                list.querySelectorAll('.active').forEach(a => a.classList.remove('active'));
                item.classList.add('active');
                close();
            });
        });

        document.addEventListener('click', e => { if (!dd.contains(e.target)) close(); });
    });

    // Toast
    let toastTimer = null;
    const toast = document.getElementById('toast-notice');
    const toastMsg = document.getElementById('toast-notice-text');

    function showToast(msg, type = 'success') {
        if (!toast || !toastMsg) return;
        toastMsg.innerText = msg;
        toast.classList.toggle('!border-red-500', type === 'error');
        toast.classList.toggle('border-yellow', type !== 'error');
        toast.classList.remove('opacity-0', 'pointer-events-none');
        toast.classList.add('opacity-100');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { toast.classList.remove('opacity-100'); toast.classList.add('opacity-0', 'pointer-events-none'); }, 3000);
    }

    function validateForm(e) {
        const ok = ['organisasi','nama_event','kategori','tanggal','deskripsi'].every(id => document.getElementById(id)?.value?.trim());
        if (!ok) { e.preventDefault(); showToast('Silakan lengkapi form terlebih dahulu', 'error'); return false; }
        return true;
    }

    @if(session('success'))
        window.addEventListener('DOMContentLoaded', () => showToast("{{ session('success') }}"));
    @endif
</script>
@endpush
