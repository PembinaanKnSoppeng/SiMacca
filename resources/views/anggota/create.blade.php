@extends('layouts.app')
@section('title','Tambah Anggota')

@section('content')
<div class="max-w-3xl mx-auto bg-white/90 dark:bg-[#0F172A]/90 backdrop-blur-lg border border-gray-100 dark:border-gray-700 rounded-2xl shadow-lg p-8 animate-fade-in">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            ➕ Tambah Anggota
        </h2>
        <a href="{{ route('anggota.index') }}"
           class="px-4 py-2 text-sm font-semibold bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            ← Kembali
        </a>
    </div>

    {{-- Form Tambah --}}
    <form action="{{ route('anggota.store') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama</label>
            <input type="text" name="nama" required value="{{ old('nama') }}"
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 
                          bg-gray-50 dark:bg-[#10193a] text-gray-900 dark:text-white 
                          focus:ring-2 focus:ring-blue-500 outline-none transition">
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 
                          bg-gray-50 dark:bg-[#10193a] text-gray-900 dark:text-white 
                          focus:ring-2 focus:ring-blue-500 outline-none transition">
        </div>

        {{-- Telepon --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telepon</label>
            <input type="text" name="telepon" value="{{ old('telepon') }}"
                   class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 
                          bg-gray-50 dark:bg-[#10193a] text-gray-900 dark:text-white 
                          focus:ring-2 focus:ring-blue-500 outline-none transition">
        </div>

        {{-- Alamat --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full px-4 py-2.5 rounded-lg border border-gray-300 dark:border-gray-600 
                             bg-gray-50 dark:bg-[#10193a] text-gray-900 dark:text-white 
                             focus:ring-2 focus:ring-blue-500 outline-none transition">{{ old('alamat') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-3 pt-3">
            <button type="submit"
                    class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-500 hover:from-blue-700 hover:to-indigo-600 
                           text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition">
                💾 Simpan Anggota
            </button>
        </div>
    </form>
</div>

{{-- Animasi --}}
<style>
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(15px); }
  to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fadeIn 0.6s ease-out both; }
</style>
@endsection
