@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="space-y-8 animate-fade-in">

    {{-- 📊 Statistik Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Total Buku --}}
        <div class="group relative overflow-hidden p-6 rounded-2xl bg-white/90 dark:bg-[#0F172A]/90 
                    border border-gray-100 dark:border-gray-700 shadow-md backdrop-blur-lg 
                    transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-200/30">
            <div class="absolute top-0 right-0 w-24 h-24 bg-blue-100/40 dark:bg-blue-500/10 rounded-full blur-2xl translate-x-8 -translate-y-8"></div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-2 relative z-10">
                📚 Total Buku
            </h4>
            <div class="text-5xl font-bold mt-1 text-blue-600 dark:text-blue-400 relative z-10">
                {{ $totalBuku ?? 0 }}
            </div>
            <div class="text-xs text-gray-400 mt-2 relative z-10 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition">
                Jumlah seluruh koleksi buku
            </div>
        </div>

        {{-- Total Anggota --}}
        <div class="group relative overflow-hidden p-6 rounded-2xl bg-white/90 dark:bg-[#0F172A]/90 
                    border border-gray-100 dark:border-gray-700 shadow-md backdrop-blur-lg 
                    transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-green-200/30">
            <div class="absolute top-0 right-0 w-24 h-24 bg-green-100/40 dark:bg-green-500/10 rounded-full blur-2xl translate-x-8 -translate-y-8"></div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-2 relative z-10">
                👥 Total Anggota
            </h4>
            <div class="text-5xl font-bold mt-1 text-green-600 dark:text-green-400 relative z-10">
                {{ $totalAnggota ?? 0 }}
            </div>
            <div class="text-xs text-gray-400 mt-2 relative z-10 group-hover:text-green-500 dark:group-hover:text-green-400 transition">
                Jumlah anggota aktif terdaftar
            </div>
        </div>

        {{-- Peminjaman Aktif --}}
        <div class="group relative overflow-hidden p-6 rounded-2xl bg-white/90 dark:bg-[#0F172A]/90 
                    border border-gray-100 dark:border-gray-700 shadow-md backdrop-blur-lg 
                    transition-all duration-500 hover:-translate-y-1 hover:shadow-xl hover:shadow-amber-200/30">
            <div class="absolute top-0 right-0 w-24 h-24 bg-amber-100/40 dark:bg-amber-500/10 rounded-full blur-2xl translate-x-8 -translate-y-8"></div>
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 flex items-center gap-2 relative z-10">
                📦 Peminjaman Aktif
            </h4>
            <div class="text-5xl font-bold mt-1 text-amber-600 dark:text-amber-400 relative z-10">
                {{ $peminjamanAktif ?? 0 }}
            </div>
            <div class="text-xs text-gray-400 mt-2 relative z-10 group-hover:text-amber-500 dark:group-hover:text-amber-400 transition">
                Jumlah buku yang sedang dipinjam
            </div>
        </div>
    </div>

    {{-- 💬 Welcome Card --}}
    <div class="relative p-8 bg-white/90 dark:bg-[#0F172A]/90 border border-gray-100 dark:border-gray-700 
                rounded-2xl shadow-lg hover:shadow-xl transition-all duration-500 backdrop-blur-lg 
                overflow-hidden">
        <div class="absolute -right-10 top-0 w-64 h-64 bg-blue-200/30 dark:bg-blue-500/10 blur-3xl rounded-full"></div>
        <h3 class="text-xl font-semibold mb-3 flex items-center gap-2 text-[#004AAD] dark:text-blue-300 relative z-10">
            📘 Selamat Datang di Sistem Perpustakaan
        </h3>
        <p class="text-gray-600 dark:text-gray-300 leading-relaxed relative z-10">
            Sistem ini membantu Anda mengelola data buku, anggota, dan peminjaman dengan cara yang mudah, cepat, dan efisien.
            Gunakan menu di sebelah kiri untuk mengakses fitur utama perpustakaan.
        </p>
    </div>

</div>

{{-- ✨ Animasi --}}
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
