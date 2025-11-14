@extends('layouts.app')
@section('title', 'Manajemen Pengguna')

@section('content')
<div class="p-6 bg-white dark:bg-[#1C2541] rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
            👥 Manajemen Pengguna
        </h2>
        <a href="{{ route('users.create') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm shadow">
           ➕ Tambah Akun
        </a>
    </div>

    {{-- Tabel Daftar Pengguna --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg text-sm">
            <thead class="bg-gray-100 dark:bg-[#243B55] text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-2 text-center">#</th>
                    <th class="px-4 py-2 text-left">Nama</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Role</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                @php
                    $badgeColors = [
                        'admin' => 'bg-blue-100 text-blue-700 border-blue-300 dark:bg-blue-900/40 dark:text-blue-300',
                        'petugas' => 'bg-green-100 text-green-700 border-green-300 dark:bg-green-900/40 dark:text-green-300',
                        'anggota' => 'bg-gray-100 text-gray-700 border-gray-300 dark:bg-gray-800 dark:text-gray-300',
                    ];
                    $role = $user->role ?? 'anggota';
                @endphp
                <tr class="border-t dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-[#2C3E50] transition">
                    <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $badgeColors[$role] ?? '' }}">
                            {{ ucfirst($role) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 text-center space-x-2">
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="px-3 py-1 bg-yellow-400 hover:bg-yellow-500 rounded-md text-white text-xs shadow">✏️ Edit</a>

                        <button 
                            onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
                            class="px-3 py-1 bg-red-500 hover:bg-red-600 rounded-md text-white text-xs shadow transition">
                            🗑️ Hapus
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>

<div id="deleteModal" 
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm hidden transition-opacity duration-300 opacity-0">
    <div id="modalBox"
         class="bg-white dark:bg-[#0F172A] rounded-2xl shadow-2xl w-[90%] max-w-md p-6 transform scale-90 transition-all duration-300 border border-gray-200 dark:border-gray-700">
        
        {{-- Header --}}
        <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-3 mb-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 flex items-center gap-2">
                ⚠️ Konfirmasi Penghapusan
            </h2>
            <button onclick="closeDeleteModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                ✖
            </button>
        </div>

        {{-- Isi --}}
        <div class="text-sm text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
            Apakah Anda yakin ingin menghapus akun 
            <span id="deleteUserName" class="font-semibold text-red-600 dark:text-red-400"></span>?<br>
            <span class="text-red-500 font-semibold">Tindakan ini tidak dapat dibatalkan!</span>
        </div>

        {{-- Tombol Aksi --}}
        <div class="flex justify-end gap-3">
            <button onclick="closeDeleteModal()" 
                    class="px-4 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition">
                Batal
            </button>
            <form id="deleteForm" method="POST" action="">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 text-sm rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium shadow transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- Script Modal dengan Animasi --}}
<script>
    const modal = document.getElementById('deleteModal');
    const modalBox = document.getElementById('modalBox');
    const deleteForm = document.getElementById('deleteForm');
    const deleteUserName = document.getElementById('deleteUserName');

    function openDeleteModal(userId, userName) {
        const route = "{{ route('users.destroy', ':id') }}".replace(':id', userId);
        deleteForm.action = route;
        deleteUserName.textContent = userName;

        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-90');
            modalBox.classList.add('scale-100');
        }, 20);
    }

    function closeDeleteModal() {
        modal.classList.add('opacity-0');
        modalBox.classList.add('scale-90');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // Klik di luar modal → tutup
    window.addEventListener('click', e => { if (e.target === modal) closeDeleteModal(); });

    // Tombol ESC → tutup
    window.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
</script>

@endsection
