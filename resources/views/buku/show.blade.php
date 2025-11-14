@extends('layouts.app')
@section('title', 'Detail Buku')

@section('content')
<div class="max-w-5xl mx-auto bg-white/90 dark:bg-[#0F172A]/90 backdrop-blur-lg border border-gray-100 dark:border-gray-700 rounded-2xl shadow-lg p-8 animate-fade-in">

    {{-- 🔹 Header --}}
    <div class="flex items-center justify-between mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            📖 Detail Buku
        </h2>
        <a href="{{ route('buku.index') }}"
           class="px-4 py-2 text-sm font-semibold bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            ← Kembali
        </a>
    </div>

    {{-- 🔸 Informasi Buku --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
        {{-- Cover --}}
        <div class="flex justify-center md:justify-start">
            @if ($buku->cover ?? false)
                <img src="{{ asset('storage/' . $buku->cover) }}" alt="Cover Buku"
                     class="w-48 h-64 object-cover rounded-lg shadow-lg border border-gray-200 dark:border-gray-700">
            @else
                <div class="w-48 h-64 flex items-center justify-center bg-gray-100 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                    <span class="text-gray-400 text-sm italic">Tidak ada cover</span>
                </div>
            @endif
        </div>

        {{-- Detail Informasi --}}
        <div class="col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Judul</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $buku->judul }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Pengarang</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $buku->pengarang }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Penerbit</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $buku->penerbit }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Tahun Terbit</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $buku->tahun_terbit }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Kategori</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $buku->kategori ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Lokasi Rak</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $buku->lokasi_rak ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- 📊 Statistik Buku --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
        <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg text-center">
            <p class="text-sm text-gray-500 dark:text-gray-300">Total Dipinjam</p>
            <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">{{ $totalDipinjam }}</p>
        </div>
        <div class="p-4 bg-green-50 dark:bg-green-900/30 rounded-lg text-center">
            <p class="text-sm text-gray-500 dark:text-gray-300">Total Peminjam Unik</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-300">{{ $totalPeminjam }}</p>
        </div>
        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg text-center">
            <p class="text-sm text-gray-500 dark:text-gray-300">Terakhir Dipinjam</p>
            <p class="text-lg font-semibold text-yellow-600 dark:text-yellow-300">{{ $terakhirDipinjam ?? '-' }}</p>
        </div>
    </div>

    {{-- 📚 Riwayat Peminjaman --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center gap-2">
            📦 Riwayat Peminjaman
        </h3>

        @if ($riwayat->isEmpty())
            <p class="text-gray-500 dark:text-gray-400 italic">Belum ada riwayat peminjaman untuk buku ini.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                    <thead class="bg-gray-100 dark:bg-[#1C2541] text-gray-700 dark:text-gray-300 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="px-4 py-2 text-left">#</th>
                            <th class="px-4 py-2 text-left">Nama Anggota</th>
                            <th class="px-4 py-2 text-left">Tanggal Pinjam</th>
                            <th class="px-4 py-2 text-left">Tanggal Kembali</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($riwayat as $r)
                            <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#1C2541]/40 transition">
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $r->anggota->nama ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $r->tanggal_pinjam }}</td>
                                <td class="px-4 py-2">{{ $r->tanggal_kembali ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if ($r->status === 'dikembalikan')
                                        <span class="px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 text-xs font-medium">
                                            ✅ Dikembalikan
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300 text-xs font-medium">
                                            ⏳ Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- 🔘 Tombol Aksi --}}
    <div class="flex justify-end gap-3 mt-8">
        <a href="{{ route('buku.edit', $buku->id) }}"
           class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-[1.02] active:scale-95 duration-200">
            ✏️ Edit Buku
        </a>

        <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-[1.02] active:scale-95 duration-200">
                🗑️ Hapus
            </button>
        </form>
    </div>
</div>

{{-- ✨ Animasi --}}
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fadeIn 0.6s ease-out both; }
</style>
@endsection
