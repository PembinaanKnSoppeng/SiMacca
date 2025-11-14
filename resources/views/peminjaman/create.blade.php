@extends('layouts.app')
@section('title','Buat Peminjaman')

@section('content')
<div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
    <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block">Anggota</label>
            <select name="anggota_id" required class="w-full p-2 border rounded">
                <option value="">-- Pilih Anggota --</option>
                @foreach($anggota as $a)
                    <option value="{{ $a->id }}">{{ $a->nama }} ({{ $a->telepon }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Buku</label>
            <select name="buku_id" required class="w-full p-2 border rounded">
                <option value="">-- Pilih Buku --</option>
                @foreach($buku as $b)
                    <option value="{{ $b->id }}">{{ $b->judul }} — stok: {{ $b->stok }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" required class="w-full p-2 border rounded" value="{{ date('Y-m-d') }}">
        </div>

        <div>
            <label class="block">Jatuh Tempo</label>
            <input type="date" name="jatuh_tempo" required class="w-full p-2 border rounded" value="{{ date('Y-m-d', strtotime('+7 days')) }}">
            <p class="text-sm text-gray-500">Default 7 hari.</p>
        </div>

        <div>
            <label class="block">Keterangan (opsional)</label>
            <textarea name="keterangan" class="w-full p-2 border rounded"></textarea>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('peminjaman.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Batal</a>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
