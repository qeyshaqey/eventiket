@extends('layouts.panitialayouts.panitia-main')

@section('content')

<div class="bg-white rounded shadow p-4">

    <!-- HEADER -->
    <div class="mb-4">
        <h1 class="text-xl font-bold mb-3">Verifikasi Pembayaran</h1>
    </div>

    <!-- TABLE -->
    <table class="w-full text-sm border">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2">NO</th>
                <th class="border p-2">PEMBELI</th>
                <th class="border p-2">EVENT</th>
                <th class="border p-2">TIKET</th>
                <th class="border p-2">JUMLAH</th>
                <th class="border p-2">BUKTI</th>
                <th class="border p-2">AKSI</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @forelse($pembayarans as $index => $pembayaran)
            <tr>
                <td class="border p-2">{{ $index + 1 }}</td>
                <td class="border p-2">
                    <div class="text-left">
                        <div class="font-semibold">{{ $pembayaran->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $pembayaran->user->email }}</div>
                    </div>
                </td>
                <td class="border p-2">{{ $pembayaran->tiket->event->judul ?? '-' }}</td>
                <td class="border p-2">{{ $pembayaran->tiket->nama }}</td>
                <td class="border p-2">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</td>
                <td class="border p-2">
                    @if($pembayaran->bukti_pembayaran)
                    <button onclick="lihatBukti('{{ $pembayaran->bukti_pembayaran }}')" class="text-blue-500 hover:text-blue-700 text-xs underline">
                        Lihat Bukti
                    </button>
                    @else
                    <span class="text-gray-400">-</span>
                    @endif
                </td>
                <td class="border p-2 space-x-1">
                    <button onclick="konfirmasiPembayaran({{ $pembayaran->id }})" class="text-green-500 hover:text-green-700" title="Konfirmasi">
                        <i class="bi bi-check-circle"></i>
                    </button>
                    <button onclick="tolakPembayaran({{ $pembayaran->id }})" class="text-red-500 hover:text-red-700" title="Tolak">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="border p-4 text-center text-gray-500">Tidak ada pembayaran yang perlu diverifikasi</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

<!-- MODAL BUKTI PEMBAYARAN -->
<div id="buktiModal" class="fixed inset-0 bg-black/50 hidden z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold">Bukti Pembayaran</h3>
            <button onclick="closeBuktiModal()" class="text-red-500 hover:text-red-700 text-xl">&times;</button>
        </div>
        <img id="buktiImage" src="" class="w-full h-auto rounded">
    </div>
</div>

<script>
function konfirmasiPembayaran(id) {
    if (confirm('Konfirmasi pembayaran ini?')) {
        fetch(`/panitia/verifikasi/${id}/konfirmasi`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                showToast('Pembayaran dikonfirmasi!', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Gagal mengonfirmasi!', 'error');
            }
        }).catch(() => {
            showToast('Terjadi kesalahan!', 'error');
        });
    }
}

function tolakPembayaran(id) {
    if (confirm('Tolak pembayaran ini?')) {
        fetch(`/panitia/verifikasi/${id}/tolak`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                showToast('Pembayaran ditolak!', 'error');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Gagal menolak!', 'error');
            }
        }).catch(() => {
            showToast('Terjadi kesalahan!', 'error');
        });
    }
}

function lihatBukti(bukti) {
    document.getElementById('buktiImage').src = '/storage/' + bukti;
    document.getElementById('buktiModal').classList.remove('hidden');
}

function closeBuktiModal() {
    document.getElementById('buktiModal').classList.add('hidden');
}
</script>

@endsection
            showToast('Terjadi kesalahan!', 'error');
        });
    }
}

function tolakPanitia(id) {
    if (confirm('Tolak verifikasi panitia ini?')) {
        fetch(`/panitia/verifikasi/${id}/tolak`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                showToast('Panitia ditolak!', 'error');
                setTimeout(() => location.reload(), 1500);
            } else {
                showToast('Gagal menolak!', 'error');
            }
        }).catch(() => {
            showToast('Terjadi kesalahan!', 'error');
        });
    }
}
</script>

@endsection