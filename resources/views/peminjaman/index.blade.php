@extends('layouts.app')
@section('title','Daftar Peminjaman')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                📚 Daftar Peminjaman
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola dan pantau status peminjaman buku.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <select id="filterStatus" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-[#0B132B] text-sm text-gray-700 dark:text-gray-300 focus:ring-blue-500">
                <option value="all">Semua Status</option>
                <option value="dipinjam">Dipinjam</option>
                <option value="dikembalikan">Dikembalikan</option>
            </select>
            <a href="{{ route('peminjaman.create') }}"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                ➕ Buat Peminjaman
            </a>
        </div>
    </div>

    {{-- 📋 Tabel --}}
    <div class="bg-white dark:bg-[#10193a] border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg overflow-hidden animate-fade-in-slow">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm" id="tabelPeminjaman">
            <thead class="bg-gray-50 dark:bg-[#0B132B] text-gray-800 dark:text-gray-200 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Anggota</th>
                    <th class="px-4 py-3 text-left">Buku</th>
                    <th class="px-4 py-3 text-left">Tgl Pinjam</th>
                    <th class="px-4 py-3 text-left">Tgl Kembali</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse ($peminjaman as $p)
                <tr id="row-{{ $p->id }}" data-status="{{ $p->status }}" class="hover:bg-gray-50 dark:hover:bg-[#0f1b3d] transition">
                    <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">{{ $loop->iteration }}</td>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-100">{{ $p->anggota->nama ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-800 dark:text-gray-100">{{ $p->buku->judul ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $p->tanggal_pinjam }}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300" id="tgl-{{ $p->id }}">{{ $p->tanggal_kembali ?? '-' }}</td>
                    <td class="px-4 py-3" id="status-{{ $p->id }}">
                        @if ($p->status === 'dipinjam')
                            <span class="status-badge bg-yellow-100 text-yellow-800 dark:bg-yellow-900/40 dark:text-yellow-300 animate-pulse">
                                📘 Dipinjam
                            </span>
                        @else
                            <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300">
                                ✅ Dikembalikan
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center" id="aksi-{{ $p->id }}">
                        @if ($p->status === 'dipinjam')
                            <button 
                                class="btn-kembalikan text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition"
                                data-id="{{ $p->id }}"
                                data-nama="{{ $p->buku->judul }}"
                                data-anggota="{{ $p->anggota->nama ?? '-' }}"
                                data-pinjam="{{ $p->tanggal_pinjam }}"
                                data-kembali="{{ $p->tanggal_kembali ?? '-' }}"
                                data-status="{{ $p->status }}">
                                🔄 Kembalikan
                            </button>
                        @else
                            <span class="text-gray-400 text-sm italic">Selesai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">
                        😕 Belum ada data peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        {{ $peminjaman->links() }}
    </div>
</div>

{{-- 🔔 Toast --}}
<div id="toast" class="fixed top-6 right-6 z-50 hidden"></div>

{{-- 🌫 Modal Detail + Konfirmasi --}}
<div id="modalKonfirmasi" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-40">
    <div class="bg-white dark:bg-[#1B2541] rounded-2xl shadow-2xl p-6 w-[400px] transform scale-95 opacity-0 transition-all duration-300">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Konfirmasi Pengembalian</h2>

        <div class="bg-gray-50 dark:bg-[#10193a] rounded-lg p-3 text-sm mb-4 text-gray-700 dark:text-gray-300">
            <p><strong>📘 Buku:</strong> <span id="mBuku"></span></p>
            <p><strong>👤 Anggota:</strong> <span id="mAnggota"></span></p>
            <p><strong>📅 Tgl Pinjam:</strong> <span id="mPinjam"></span></p>
            <p><strong>⌛ Tgl Kembali:</strong> <span id="mKembali"></span></p>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
            Apakah kamu yakin ingin menandai buku ini sebagai <span class="font-semibold text-blue-500">dikembalikan</span>?
        </p>

        <div class="flex justify-end gap-3">
            <button id="batalBtn" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 rounded-md text-sm">Batal</button>
            <button id="konfirmasiBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm">Ya, Kembalikan</button>
        </div>
    </div>
</div>

{{-- ⚙️ Script --}}
<script>
const modal = document.getElementById('modalKonfirmasi');
const modalBox = modal.querySelector('div');
const toast = document.getElementById('toast');
let currentId = null;

// 🔄 Buka modal dengan detail
document.querySelectorAll('.btn-kembalikan').forEach(btn => {
    btn.addEventListener('click', () => {
        currentId = btn.dataset.id;
        document.getElementById('mBuku').textContent = btn.dataset.nama;
        document.getElementById('mAnggota').textContent = btn.dataset.anggota;
        document.getElementById('mPinjam').textContent = btn.dataset.pinjam;
        document.getElementById('mKembali').textContent = btn.dataset.kembali;
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.add('flex');
            modalBox.classList.remove('scale-95', 'opacity-0');
            modalBox.classList.add('scale-100', 'opacity-100');
        }, 10);
    });
});

// ❌ Tutup modal
document.getElementById('batalBtn').addEventListener('click', () => {
    modalBox.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 200);
});

// ✅ Konfirmasi pengembalian (AJAX)
document.getElementById('konfirmasiBtn').addEventListener('click', async () => {
    if (!currentId) return;
    try {
        const response = await fetch(`{{ route('peminjaman.updateStatus', ':id') }}`.replace(':id', currentId), {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: 'dikembalikan' })
        });

        if (response.ok) {
            const tanggal = new Date().toISOString().split('T')[0];
            document.getElementById(`tgl-${currentId}`).innerText = tanggal;
            document.getElementById(`status-${currentId}`).innerHTML = `
                <span class="status-badge bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-300 fade-in">
                    ✅ Dikembalikan
                </span>`;
            document.getElementById(`aksi-${currentId}`).innerHTML =
                `<span class="text-gray-400 text-sm italic fade-in">Selesai</span>`;
            document.getElementById(`row-${currentId}`).setAttribute('data-status', 'dikembalikan');
            showToast('success', '📗 Buku berhasil dikembalikan!');
        } else {
            showToast('error', '❌ Gagal mengubah status!');
        }
    } catch {
        showToast('error', '⚠️ Koneksi ke server gagal!');
    }
    modalBox.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 200);
});

// 🔔 Toast
function showToast(type, message) {
    const colors = { success: 'bg-green-600', error: 'bg-red-600', info: 'bg-blue-600' };
    toast.innerHTML = `<div class="${colors[type] || 'bg-gray-700'} text-white px-5 py-3 rounded-xl shadow-lg animate-fade-in">${message}</div>`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('opacity-0'), 2500);
    setTimeout(() => toast.classList.add('hidden'), 3000);
}

// 🧭 Filter status
document.getElementById('filterStatus').addEventListener('change', e => {
    const val = e.target.value;
    document.querySelectorAll('#tabelPeminjaman tbody tr').forEach(row => {
        const status = row.getAttribute('data-status');
        if (val === 'all' || status === val) row.classList.remove('hidden');
        else row.classList.add('hidden');
    });
});
</script>

<style>
.status-badge {
    @apply inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full transition;
}
.fade-in { animation: fadeIn 0.4s ease-in-out; }
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}
@keyframes fadeInSlow {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in-slow { animation: fadeInSlow 0.5s ease-in-out; }
</style>
@endsection
