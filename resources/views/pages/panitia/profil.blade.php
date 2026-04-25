@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="p-6 bg-[#EFF8FF] min-h-screen">

    @php
        $user = (object)[
            'name' => session('user'),
            'email' => '-',
            'nim' => '-'
        ];
    @endphp

    <!-- HEADER -->
    <div class="mb-6">
        <h1 class="text-xl font-bold text-[#192853]">Profil Panitia</h1>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-8">

        <!-- AVATAR -->
        <div class="flex flex-col items-center md:w-1/4">

            <img src="https://ui-avatars.com/api/?name={{ $user->name }}" class="w-28 h-28 rounded-full object-cover shadow-md border">

            <!-- BUTTON EDIT PROFIL -->
            <button onclick="openModal()"
                class="mt-4 bg-[#192853] text-yellow-400 px-4 py-2 rounded-lg text-sm hover:opacity-90 transition">
                Edit Profil
            </button>

        </div>

        <!-- INFO -->
        <div class="md:w-3/4">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">Nama</p>
                    <p class="font-semibold text-[#192853]">{{ $user->name ?? '-' }}</p>
                </div>

                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">NIM</p>
                    <p class="font-semibold text-[#192853]">{{ $user->nim ?? '-' }}</p>
                </div>

                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="font-semibold text-[#192853]">{{ $user->email ?? '-' }}</p>
                </div>

                <div class="p-4 bg-[#F8FAFF] rounded-xl border">
                    <p class="text-xs text-gray-500">Role</p>
                    <p class="font-semibold text-yellow-600">Panitia</p>
                </div>

            </div>

        </div>

    </div>

</div>

<!-- ================= MODAL EDIT ================= -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50 transition">

    <div class="bg-white w-[420px] p-6 rounded-2xl shadow-2xl relative animate-fadeIn">

        <!-- CLOSE BUTTON -->
        <button onclick="closeModal()" 
            class="absolute top-3 right-3 text-gray-400 hover:text-black text-xl">
            &times;
        </button>

        <h2 class="text-xl font-bold text-[#192853] mb-4">Edit Profil</h2>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- FOTO PROFIL -->
            <div class="flex flex-col items-center mb-5">

                <div class="relative">
                    <img id="previewImage"
                        src="https://ui-avatars.com/api/?name={{ $user->name }}"
                        class="w-24 h-24 rounded-full object-cover border shadow">

                    <label class="absolute bottom-0 right-0 bg-[#192853] text-yellow-400 p-1 rounded-full cursor-pointer text-xs">
                        ✎
                        <input type="file" name="photo" class="hidden" onchange="previewFoto(event)">
                    </label>
                </div>

                <p class="text-xs text-gray-500 mt-2">Klik ikon untuk ganti foto</p>
            </div>

            <!-- INPUT -->
            <div class="space-y-4">

                <div>
                    <label class="text-sm text-gray-600">Nama</label>
                    <input type="text" name="name"
                        value="{{ $user->name ?? '' }}"
                        class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm text-gray-600">NIM</label>
                    <input type="text" name="nim"
                        value="{{ $user->nim ?? '' }}"
                        class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email"
                        value="{{ $user->email ?? '' }}"
                        class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-[#192853] outline-none">
                </div>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3 mt-6">

                <button type="button" onclick="closeModal()"
                    class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                    Batal
                </button>

                <button type="submit"
                    class="px-4 py-2 bg-[#192853] text-yellow-400 rounded-lg hover:opacity-90 transition">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<!-- SCRIPT -->
<script>
function openModal(){
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('modal').classList.add('hidden');
}

function previewFoto(event){
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('previewImage').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
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

@endsection