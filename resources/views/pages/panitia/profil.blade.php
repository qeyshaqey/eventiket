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
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-[#192853]">Profil Panitia</h1>
            <p class="text-sm text-gray-500">Informasi akun dan data pribadi</p>
        </div>

        <button onclick="openModal()"
            class="bg-[#192853] text-yellow-400 px-4 py-2 rounded-lg text-sm hover:opacity-90 transition">
            Edit Profil
        </button>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row gap-8">

        <!-- AVATAR -->
        <div class="flex flex-col items-center md:w-1/4">

            <div class="w-28 h-28 rounded-full bg-[#192853] text-yellow-400 flex items-center justify-center text-3xl font-bold shadow-md">
                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
            </div>

            <p class="mt-4 font-semibold text-[#192853] text-lg">
                {{ $user->name ?? '-' }}
            </p>

            <span class="mt-1 px-3 py-1 text-xs rounded-full bg-yellow-400/20 text-yellow-600 font-semibold">
                Panitia
            </span>

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
<div id="modal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">

    <div class="bg-white w-[400px] p-6 rounded-xl shadow-lg">

        <h2 class="text-lg font-bold mb-4">Edit Profil</h2>

        <form action="#" method="POST">

            <div class="space-y-3">

                <div>
                    <label class="text-sm">Nama</label>
                    <input type="text" name="name"
                        value="{{ $user->name ?? '' }}"
                        class="w-full border p-2 rounded-lg">
                </div>

                <div>
                    <label class="text-sm">NIM</label>
                    <input type="text" name="nim"
                        value="{{ $user->nim ?? '' }}"
                        class="w-full border p-2 rounded-lg">
                </div>

                <div>
                    <label class="text-sm">Email</label>
                    <input type="email" name="email"
                        value="{{ $user->email ?? '' }}"
                        class="w-full border p-2 rounded-lg">
                </div>

            </div>

            <div class="flex justify-end gap-2 mt-5">
                <button type="button" onclick="closeModal()"
                    class="px-3 py-1 bg-gray-300 rounded-lg">
                    Batal
                </button>

                <button type="submit"
                    class="px-3 py-1 bg-[#192853] text-yellow-400 rounded-lg">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

<script>
function openModal(){
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal(){
    document.getElementById('modal').classList.add('hidden');
}
</script>

@endsection