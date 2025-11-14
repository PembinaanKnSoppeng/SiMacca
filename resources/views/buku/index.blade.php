@extends('layouts.app')
@section('title', 'Daftar Buku')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- ✅ Notifikasi --}}
    @if(session('success'))
        <div class="mb-6 p-3 rounded-md bg-green-50 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-100 dark:border-green-800">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🔍 HEADER + SEARCH + FILTER --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">📚 Daftar Buku</h1>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <form method="GET" action="{{ route('buku.index') }}" class="flex flex-wrap sm:flex-nowrap items-center gap-2">
                <input type="text" name="search" placeholder="Cari judul, pengarang, penerbit..." 
                    value="{{ request('search') }}"
                    class="flex-grow px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent text-gray-800 dark:text-gray-200 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-400">

                <select name="kategori" onchange="this.form.submit()" 
                    class="px-3 py-2 border rounded-lg bg-white dark:bg-[#1C2541] border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-400">
                    <option value="semua">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') === $kategori ? 'selected' : '' }}>
                            {{ ucfirst($kategori) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    🔍 Cari
                </button>
            </form>

            <a href="{{ route('buku.create') }}" 
               class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white shadow-md transition">
                ➕ Tambah
            </a>
        </div>
    </div>

    {{-- 📖 TABEL --}}
    <div class="overflow-x-auto bg-white dark:bg-[#10193A] border border-gray-200 dark:border-gray-700 rounded-2xl shadow-lg">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 dark:bg-[#1B2541] text-gray-700 dark:text-gray-300 uppercase tracking-wide text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Judul Buku</th>
                    <th class="px-4 py-3">Pengarang</th>
                    <th class="px-4 py-3">Penerbit</th>
                    <th class="px-4 py-3">Tahun</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Stok</th>
                    <th class="px-4 py-3">Rak</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku as $item)
                <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#1C2541]/50 transition">
                    <td class="px-4 py-3">{{ $loop->iteration + ($buku->currentPage() - 1) * $buku->perPage() }}</td>

                    {{-- 📘 Cover + Judul --}}
                    <td class="px-4 py-3 flex items-center gap-3">
                        @if($item->cover)
                            <img src="{{ asset('storage/' . $item->cover) }}" 
                                 alt="Cover Buku" 
                                 class="w-10 h-14 rounded-md object-cover border border-gray-200 dark:border-gray-600 shadow-sm">
                        @else
                            <div class="w-10 h-14 rounded-md bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 text-xs">
                                N/A
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $item->judul }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 italic">{{ $item->kategori ?? 'Tanpa Kategori' }}</p>
                        </div>
                    </td>

                    <td class="px-4 py-3">{{ $item->pengarang }}</td>
                    <td class="px-4 py-3">{{ $item->penerbit }}</td>
                    <td class="px-4 py-3">{{ $item->tahun_terbit }}</td>
                    <td class="px-4 py-3">{{ $item->kategori ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $item->stok }}</td>
                    <td class="px-4 py-3">{{ $item->lokasi_rak ?? '-' }}</td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('buku.edit', $item->id) }}" 
                               class="px-3 py-1.5 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-semibold transition shadow-sm">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1.5 rounded-md bg-red-600 hover:bg-red-700 text-white text-xs font-semibold transition shadow-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500 dark:text-gray-400">
                        Tidak ada data buku ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 PAGINATION --}}
    <div class="mt-6">
        {{ $buku->appends(request()->query())->links() }}
    </div>
</div>
@endsection
