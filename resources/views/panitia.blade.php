<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Panitia</title>

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

<style>
body { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>
</head>

<body class="bg-[#EFF8FF]">

<!-- SIDEBAR -->
<div class="fixed w-[230px] h-screen bg-[#192853] text-white shadow-lg">

    <div class="p-5 bg-[#0f1a35] border-b border-white/10">
        <h2 class="text-yellow-400 text-sm font-semibold">Eventix Admin</h2>
        <p class="text-xs text-white/40">Sistem Manajemen Event</p>
    </div>

    <nav class="py-4 text-sm">
        <a class="block px-5 py-3 text-white/60 hover:bg-yellow-400/10">Dashboard</a>
        <a class="block px-5 py-3 text-white/60 hover:bg-yellow-400/10">Data Pengunjung</a>
        <a class="block px-5 py-3 bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400">Data Panitia</a>
        <a class="block px-5 py-3 text-white/60 hover:bg-yellow-400/10">Kelola Event</a>
        <a class="block px-5 py-3 text-white/60 hover:bg-yellow-400/10">Kategori Event</a>
    </nav>

</div>

<!-- MAIN -->
<div class="ml-[230px] p-8">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-[#192853]">Data Panitia</h1>
        <p class="text-sm text-gray-500">Kelola dan pengajuan panitia</p>
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
                        <button class="px-3 py-1 text-xs rounded-full bg-red-500/20 text-red-500">Hapus</button>
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
function tab(x){
    document.getElementById('k').classList.add('hidden');
    document.getElementById('p').classList.add('hidden');

    document.getElementById('b1').classList.remove('bg-[#192853]','text-yellow-400');
    document.getElementById('b2').classList.remove('bg-[#192853]','text-yellow-400');

    if(x==='k'){
        document.getElementById('k').classList.remove('hidden');
        document.getElementById('b1').classList.add('bg-[#192853]','text-yellow-400');
    } else {
        document.getElementById('p').classList.remove('hidden');
        document.getElementById('b2').classList.add('bg-[#192853]','text-yellow-400');
    }
}
</script>

</body>
</html>