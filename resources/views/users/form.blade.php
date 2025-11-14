@extends('layouts.app')
@section('title', $user->exists ? 'Edit Akun' : 'Tambah Akun')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-[#1C2541] p-6 rounded-xl shadow">
    <h2 class="text-xl font-semibold mb-4">{{ $user->exists ? '✏️ Edit Akun' : '➕ Tambah Akun' }}</h2>

    <form method="POST" action="{{ $user->exists ? route('users.update', $user->id) : route('users.store') }}">
        @csrf
        @if($user->exists)
            @method('PUT')
        @endif

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                   class="w-full px-4 py-2 rounded-md border dark:bg-[#0B132B] dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                   class="w-full px-4 py-2 rounded-md border dark:bg-[#0B132B] dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Password {{ $user->exists ? '(biarkan kosong jika tidak diganti)' : '' }}</label>
            <input type="password" name="password"
                   class="w-full px-4 py-2 rounded-md border dark:bg-[#0B132B] dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                   class="w-full px-4 py-2 rounded-md border dark:bg-[#0B132B] dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Role</label>
            <select name="role"
                    class="w-full px-4 py-2 rounded-md border dark:bg-[#0B132B] dark:border-gray-600 focus:outline-none focus:ring focus:ring-blue-400">
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role', $user->role) === 'petugas' ? 'selected' : '' }}>Petugas</option>
                <option value="anggota" {{ old('role', $user->role) === 'anggota' ? 'selected' : '' }}>Anggota</option>
            </select>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md text-sm">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm">
                💾 Simpan
            </button>
        </div>
    </form>
</div>
@endsection
