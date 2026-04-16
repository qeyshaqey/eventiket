@extends('layouts.panitialayouts.panitia-main')

@section('content')
<div class="bg-[#EFF8FF] min-h-screen p-6">

    <h1 class="text-xl font-bold mb-6">TIKET YANG DIKELOLA</h1>

    <div id="tiketContainer"></div>

</div>

<script>
let events = JSON.parse(localStorage.getItem('events')) || [];

// ================= RENDER =================
function renderTiket() {
    const container = document.getElementById('tiketContainer');
    container.innerHTML = "";

    events.forEach((event, index) => {

        container.innerHTML += `
        <div class="bg-white rounded-xl shadow p-4 mb-6">

            <div class="flex gap-4">

                <!-- GAMBAR -->
                <div class="w-32 h-32 bg-gray-200 rounded flex items-center justify-center">
                    ${event.gambar 
                        ? `<img src="${event.gambar}" class="w-full h-full object-cover rounded">`
                        : `<i class="bi bi-image text-2xl text-gray-400"></i>`
                    }
                </div>

                <!-- DETAIL -->
                <div class="flex-1 text-sm space-y-1">
                    <p><b>Judul Event :</b> ${event.judul}</p>
                    <p><b>Kategori :</b> ${event.kategori}</p>
                    <p><b>Tanggal :</b> ${event.tanggalMulai}</p>
                    <p><b>Waktu :</b> ${event.waktu}</p>
                    <p><b>Lokasi :</b> ${event.lokasi}</p>
                </div>

            </div>

            <!-- DESKRIPSI -->
            <div class="mt-3 text-sm">
                <p class="font-semibold">Deskripsi :</p>
                <p>${event.deskripsi}</p>
            </div>

            <!-- LIST TIKET -->
            <div class="mt-4">
                <p class="font-semibold mb-2 text-sm">Tiket:</p>

                ${
                    event.tiket && event.tiket.length > 0
                    ? event.tiket.map((t, i) => `
                        <div class="flex justify-between items-center border p-2 rounded mb-2">
                            <div>
                                <p class="font-semibold text-sm">${t.nama}</p>
                                <p class="text-gray-500 text-xs">
                                    Rp ${t.harga} • Kuota: ${t.kuota}
                                </p>
                            </div>

                            <div class="flex gap-2">

    <!-- EDIT -->
    <button onclick="editTiket(${index}, ${i})" 
        class="text-yellow-500 hover:scale-110 transition">
        <i class="bi bi-pencil-square"></i>
    </button>

    <!-- HAPUS -->
    <button onclick="hapusTiket(${index}, ${i})" 
        class="text-red-500 hover:scale-110 transition">
        <i class="bi bi-trash"></i>
    </button>

</div>
                    `).join('')
                    : `<p class="text-gray-400 text-sm">Belum ada tiket</p>`
                }
            </div>

            <!-- ACTION -->
            <div class="flex justify-between items-center mt-4">

                <button onclick="openModal(${index})"
                    class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                    + Tambah Tiket
                </button>

                <span class="text-xs text-gray-500">
                    Status: ${event.status}
                </span>

            </div>

        </div>`;
    });
}

// ================= MODAL =================
let currentEventIndex = null;

function openModal(index) {
    currentEventIndex = index;
    document.getElementById('modalTiket').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modalTiket').classList.add('hidden');
    document.getElementById('namaTiket').value = "";
    document.getElementById('hargaTiket').value = "";
    document.getElementById('kuotaTiket').value = "";
}

// ================= TAMBAH =================
function tambahTiket() {
    const nama = document.getElementById('namaTiket').value;
    const harga = document.getElementById('hargaTiket').value;
    const kuota = document.getElementById('kuotaTiket').value;

    if (!nama || !harga || !kuota) {
        alert("Isi semua data!");
        return;
    }

    if (!events[currentEventIndex].tiket) {
        events[currentEventIndex].tiket = [];
    }

    events[currentEventIndex].tiket.push({
        nama: nama,
        harga: harga,
        kuota: kuota
    });

    // update status
    events[currentEventIndex].status = "Published";

    localStorage.setItem('events', JSON.stringify(events));

    renderTiket();
    closeModal();
}

// ================= HAPUS =================
function hapusTiket(eventIndex, tiketIndex) {
    if (confirm("Hapus tiket ini?")) {
        events[eventIndex].tiket.splice(tiketIndex, 1);

        if (events[eventIndex].tiket.length === 0) {
            events[eventIndex].status = "Draft";
        }

        localStorage.setItem('events', JSON.stringify(events));
        renderTiket();
    }
}

// INIT
renderTiket();
</script>

<!-- MODAL -->
<div id="modalTiket" class="fixed inset-0 bg-black/50 hidden flex justify-center items-center">

    <div class="bg-white p-6 rounded-xl shadow w-96">

        <h2 class="font-bold mb-4">Tambah Tiket</h2>

        <input id="namaTiket" type="text" placeholder="Nama Tiket"
            class="w-full border p-2 mb-3 rounded">

        <input id="hargaTiket" type="number" placeholder="Harga"
            class="w-full border p-2 mb-3 rounded">

        <input id="kuotaTiket" type="number" placeholder="Kuota"
            class="w-full border p-2 mb-4 rounded">

        <div class="flex justify-end gap-2">
            <button onclick="closeModal()" class="bg-gray-400 text-white px-3 py-1 rounded">
                Batal
            </button>

            <button onclick="tambahTiket()" class="bg-blue-500 text-white px-3 py-1 rounded">
                Simpan
            </button>
        </div>

    </div>

</div>

@endsection