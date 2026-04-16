@extends('layouts.app')
@section('content')

<!-- MAIN -->
<div class=" p-0">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-[#192853]">Data Panitia</h1>
    </div>

    <!-- TAB -->
    <div class="flex gap-2 mb-4">
        <button id="b1" onclick="tab('k')" class="px-4 py-2 text-sm rounded-full border bg-[#192853] text-yellow-400">Kelola Panitia</button>
        <button id="b2" onclick="tab('p')" class="px-4 py-2 text-sm rounded-full border bg-white">Pengajuan Panitia</button>
    </div>

    <!-- KELOLA -->
    <div id="k" class="bg-white p-5 rounded-xl shadow border">

        <table class="w-full text-sm">
            <thead class="text-gray-500 border-b">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">NIM</th>
                    <th class="p-3 text-left">UKM</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($kelola as $i => $d)
                <tr class="border-b hover:bg-[#EFF8FF]">
                    <td class="p-3">{{ $i+1 }}</td>
                    <td class="p-3">{{ $d['nama'] }}</td>
                    <td class="p-3">{{ $d['email'] }}</td>
                    <td class="p-3">{{ $d['nim'] }}</td>
                    <td class="p-3">{{ $d['ukm'] }}</td>
                    <td class="p-3">{{ $d['status'] }}</td>
                    <td class="p-3">
                        <button class="w-9 h-9 flex items-center justify-center rounded-lg bg-red-500/10 text-red-500 hover:bg-red-100 transition">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <!-- PENGAJUAN -->
    <div id="p" class="bg-white p-5 rounded-xl shadow border hidden">

        <table class="w-full text-sm">
            <thead class="text-gray-500 border-b">
                <tr>
                    <th class="p-3 text-left">No</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Tanggal</th>
                    <th class="p-3 text-left">UKM</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($pengajuan as $i => $d)
                <tr class="border-b hover:bg-[#EFF8FF]">
                    <td class="p-3">{{ $i+1 }}</td>
                    <td class="p-3">{{ $d['nama'] }}</td>
                    <td class="p-3">{{ $d['email'] }}</td>
                    <td class="p-3">{{ $d['tanggal'] }}</td>
                    <td class="p-3">{{ $d['ukm'] }}</td>
                    <td class="p-3 space-x-2">
                        <button class="px-3 py-1 text-xs rounded-full bg-green-500/20 text-green-600">✔</button>
                        <button class="px-3 py-1 text-xs rounded-full bg-red-500/20 text-red-500">✖</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

<script>
    function tab(x) {
        document.getElementById('k').classList.add('hidden');
        document.getElementById('p').classList.add('hidden');

        document.getElementById('b1').classList.remove('bg-[#192853]', 'text-yellow-400');
        document.getElementById('b2').classList.remove('bg-[#192853]', 'text-yellow-400');

        if (x === 'k') {
            document.getElementById('k').classList.remove('hidden');
            document.getElementById('b1').classList.add('bg-[#192853]', 'text-yellow-400');
        } else {
            document.getElementById('p').classList.remove('hidden');
            document.getElementById('b2').classList.add('bg-[#192853]', 'text-yellow-400');
        }
    }
</script>
@endsection

</body>

</html>