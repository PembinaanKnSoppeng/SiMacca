@extends('layouts.app')
@section('title', 'Tambah Buku')

@section('content')
<div class="max-w-4xl mx-auto bg-white dark:bg-[#0F172A] p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100 flex items-center gap-2">
        ➕ Tambah Buku
    </h1>

    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Judul Buku</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pengarang</label>
                <input type="text" name="pengarang" value="{{ old('pengarang') }}" required class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penerbit</label>
                <input type="text" name="penerbit" value="{{ old('penerbit') }}" required class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kategori</label>
                <input type="text" name="kategori" value="{{ old('kategori') }}" class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}" required class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Rak 📚</label>
                <input type="text" name="lokasi_rak" value="{{ old('lokasi_rak') }}" class="w-full p-2.5 rounded-lg border border-gray-300 dark:border-gray-600 bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>

            {{-- Upload Cover --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cover Buku</label>
                <input type="file" name="cover" accept="image/*" class="w-full p-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-transparent focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('buku.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Simpan</button>
        </div>
    </form>
</div>
@endsection
