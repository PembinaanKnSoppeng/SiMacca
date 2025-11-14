@extends('layouts.app')
@section('title','Ubah Peminjaman')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
    <form action="{{ route('peminjaman.update',$peminjaman->id) }}" method="POST" class="space-y-4">
        @csrf @method('PUT')

        <div>
            <label class="block">Anggota</label>
            <select name="anggota_id" class="w-full p-2 border rounded" disabled>
                <option>{{ $peminjaman->anggota->nama }}</option>
            </select>
        </div>

        <div>
            <label class="block">Buku</label>
            <select name="buku_id" class="w-full p-2 border rounded" disabled>
                <option>{{ $peminjaman->buku->judul }}</option>
            </select>
        </div>

        <div>
            <label class="block">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" value="{{ $peminjaman->tanggal_pinjam }}" class="w-full p-2 border rounded" disabled>
        </div>

        <div>
            <label class="block">Jatuh Tempo</label>
            <input type="date" name="jatuh_tempo" value="{{ $peminjaman->jatuh_tempo }}" class="w-full p-2 border rounded">
        </div>

        <div>
            <label class="block">Status</label>
            <select name="status" class="w-full p-2 border rounded">
                <option value="dipinjam" {{ $peminjaman->status == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="dikembalikan" {{ $peminjaman->status == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            </select>
        </div>

        <div>
            <label class="block">Tanggal Kembali (isi jika dikembalikan)</label>
            <input type="date" name="tanggal_kembali" value="{{ $peminjaman->tanggal_kembali }}" class="w-full p-2 border rounded">
        </div>

        <div>
            <label class="block">Keterangan</label>
            <textarea name="keterangan" class="w-full p-2 border rounded">{{ $peminjaman->keterangan }}</textarea>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
