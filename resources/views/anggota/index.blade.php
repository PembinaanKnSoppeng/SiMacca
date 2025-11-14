@extends('layouts.app')
@section('title','Daftar Anggota')

@section('content')
<div class="space-y-6 animate-fade-in">

    {{-- 🔹 Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
        <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            👥 Daftar Anggota
        </h3>
        <a href="{{ route('anggota.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600
                  text-white px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition transform hover:scale-[1.02] active:scale-95 duration-200">
            ➕ Tambah Anggota
        </a>
    </div>

    {{-- 📋 Tabel Anggota --}}
    <div class="bg-white/90 dark:bg-[#0F172A]/90 backdrop-blur-lg border border-gray-100 dark:border-gray-700 
                rounded-2xl shadow-lg overflow-hidden transition-all duration-500 hover:shadow-xl">

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
            <thead class="bg-gray-50 dark:bg-[#0B132B] text-gray-700 dark:text-gray-300 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($anggota as $a)
                    <tr class="hover:bg-blue-50/40 dark:hover:bg-[#1B2541]/50 transition duration-200">
                        <td class="px-4 py-3 font-medium text-gray-700 dark:text-gray-300">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-gray-800 dark:text-gray-100">{{ $a->nama }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $a->email }}</td>
                        <td class="px-4 py-3">
                            @if ($a->status === 'aktif')
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
                                    ✅ Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                    ⚠️ Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('anggota.edit', $a->id) }}"
                                   class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-semibold transition">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-semibold transition">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 italic">
                            😕 Belum ada data anggota.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 🔽 Pagination --}}
    <div class="mt-4 flex justify-center">
        {{ $anggota->links() }}
    </div>
</div>

{{-- ✨ Animasi Halus --}}
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
  animation: fadeIn 0.6s ease-out both;
}
</style>
@endsection

