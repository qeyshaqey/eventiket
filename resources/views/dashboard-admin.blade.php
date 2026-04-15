<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventix Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EFF8FF] text-[#192853]">

    <!-- SIDEBAR -->
    <div class="fixed top-0 left-0 h-full w-[230px] bg-[#192853] text-white flex flex-col shadow-lg">

        <div class="p-5 bg-[#0f1a35] border-b border-yellow-300/20">
            <h2 class="text-yellow-400 font-semibold text-sm">Eventix Admin</h2>
            <p class="text-xs text-white/40">Sistem Manajemen Event</p>
        </div>

        <nav class="flex-1 py-4 text-sm">

            <a href="#" class="flex items-center gap-3 px-5 py-3 bg-yellow-400/10 text-yellow-400 border-l-4 border-yellow-400">
                Dashboard
            </a>

            <a href="#" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                Data Pengunjung
            </a>

            <a href="#" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                Data Panitia
            </a>

            <a href="#" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                Kelola Event
            </a>

            <a href="#" class="flex items-center gap-3 px-5 py-3 text-white/60 hover:bg-yellow-400/10 hover:text-white">
                Kategori Event
            </a>

        </nav>

        <div class="p-4 border-t border-white/10 flex items-center justify-between">

            <span class="text-xs text-white/30">Eventix Admin</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex items-center gap-1 text-xs bg-red-500/20 text-red-400 px-3 py-1 rounded-md hover:bg-red-500/30 transition">
                     Logout
                </button>
            </form>

        </div>

    </div>

    <!-- MAIN -->
    <div class="ml-[230px] p-8">

        <!-- TOPBAR -->
        <div class="mb-6">
            <h1 class="text-xl font-semibold">Dashboard</h1>
        </div>

        <!-- CARDS -->
        <div class="grid grid-cols-3 gap-5 mb-6">

            <div class="bg-white p-5 rounded-xl border shadow">
                <div class="text-xs text-gray-500 mb-2 uppercase">Total Pengunjung</div>
                <div class="text-3xl font-semibold">1248</div>
            </div>

            <div class="bg-white p-5 rounded-xl border shadow">
                <div class="text-xs text-gray-500 mb-2 uppercase">Total Panitia</div>
                <div class="text-3xl font-semibold">20</div>
            </div>

            <div class="bg-white p-5 rounded-xl border shadow">
                <div class="text-xs text-gray-500 mb-2 uppercase">Total Event</div>
                <div class="text-3xl font-semibold">15</div>
            </div>

        </div>

        <!-- EVENT -->
        <div class="mb-3 flex justify-between items-center">
            <h2 class="text-sm font-semibold">Event Disetujui</h2>
        </div>

        <div class="bg-white rounded-xl border shadow">
            <div class="max-h-[360px] overflow-y-auto p-3 space-y-2">

                @foreach ($events as $event)
                <div class="flex items-center gap-3 p-3 rounded-lg cursor-pointer hover:bg-[#EFF8FF] border border-transparent hover:border-[#c8dff5]"
                    onclick='showModal(
          @json($event["nama"]),
          @json($event["kategori"]),
          @json($event["tanggal"]),
          @json($event["waktu"]),
          @json($event["lokasi"]),
          @json($event["deskripsi"])
        )'>

                    <div class="bg-[#192853] text-yellow-400 text-xs font-semibold px-3 py-2 rounded text-center min-w-[55px]">
                        {{ $event['tanggal'] }}
                    </div>

                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ $event['nama'] }}</div>
                        <div class="text-xs text-gray-500">
                            {{ $event['lokasi'] }} • {{ $event['waktu'] }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs bg-yellow-200 px-3 py-1 rounded-full">
                            {{ $event['kategori'] }}
                        </span>
                        <span class="text-gray-400 text-lg">›</span>
                    </div>

                </div>
                @endforeach

            </div>
        </div>

    </div>

    <!-- MODAL -->
    <div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">

        <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden">

            <div class="bg-[#192853] p-5 flex justify-between items-start">
                <div>
                    <h3 id="m_nama" class="text-yellow-400 font-semibold"></h3>
                    <p id="m_kategori" class="text-white/50 text-sm"></p>
                </div>
                <button onclick="closeModal()" class="text-white text-xl">&times;</button>
            </div>

            <div class="p-5 space-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal</span>
                    <span id="m_tanggal"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Waktu</span>
                    <span id="m_waktu"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-500">Lokasi</span>
                    <span id="m_lokasi"></span>
                </div>

                <div>
                    <span class="text-gray-500 block mb-1">Deskripsi</span>
                    <p id="m_deskripsi"></p>
                </div>

            </div>

        </div>
    </div>

    <script>
        function showModal(nama, kategori, tanggal, waktu, lokasi, deskripsi) {
            document.getElementById('m_nama').textContent = nama;
            document.getElementById('m_kategori').textContent = kategori;
            document.getElementById('m_tanggal').textContent = tanggal;
            document.getElementById('m_waktu').textContent = waktu;
            document.getElementById('m_lokasi').textContent = lokasi;
            document.getElementById('m_deskripsi').textContent = deskripsi;

            document.getElementById('modal').classList.remove('hidden');
            document.getElementById('modal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }

        document.getElementById('modal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>

</body>

</html>