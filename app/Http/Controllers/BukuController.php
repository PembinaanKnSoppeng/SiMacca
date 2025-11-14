<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * 📚 Tampilkan daftar buku dengan pencarian & filter kategori
     */
    public function index(Request $request)
    {
        $query = Buku::query();

        // 🔍 Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%")
                  ->orWhere('penerbit', 'like', "%{$search}%")
                  ->orWhere('lokasi_rak', 'like', "%{$search}%");
            });
        }

        // 🏷️ Filter kategori
        if ($request->filled('kategori') && $request->kategori !== 'semua') {
            $query->where('kategori', $request->kategori);
        }

        // 🔢 Ambil data buku
        $buku = $query->orderBy('created_at', 'desc')
                      ->paginate(10)
                      ->withQueryString();

        // 📂 Daftar kategori unik untuk dropdown
        $kategoriList = Buku::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter();

        return view('buku.index', compact('buku', 'kategoriList'));
    }

    /**
     * ➕ Halaman tambah buku
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * 💾 Simpan data buku baru
     */
   public function store(Request $request)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'pengarang' => 'required|string|max:255',
        'penerbit' => 'required|string|max:255',
        'tahun_terbit' => 'required|digits:4',
        'kategori' => 'nullable|string|max:255',
        'stok' => 'required|integer|min:0',
        'lokasi_rak' => 'nullable|string|max:100',
        'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->except('cover');

    // ✅ Simpan cover ke storage
    if ($request->hasFile('cover')) {
        $path = $request->file('cover')->store('covers', 'public');
        $data['cover'] = $path;
    }

    Buku::create($data);

    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
}


    /**
     * 👁️ Detail buku + riwayat peminjaman
     */
    public function show(Buku $buku)
    {
        $riwayat = $buku->peminjaman()
            ->with('anggota')
            ->orderByDesc('tanggal_pinjam')
            ->take(10)
            ->get();

        $totalDipinjam = $buku->peminjaman()->count();
        $totalPeminjam = $buku->peminjaman()->distinct('anggota_id')->count('anggota_id');
        $terakhirDipinjam = $buku->peminjaman()->max('tanggal_pinjam');

        return view('buku.show', compact('buku', 'riwayat', 'totalDipinjam', 'totalPeminjam', 'terakhirDipinjam'));
    }

    /**
     * ✏️ Halaman edit buku
     */
    public function edit(Buku $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    /**
     * 🔄 Update data buku
     */
    public function update(Request $request, Buku $buku)
{
    $request->validate([
        'judul' => 'required|string|max:255',
        'pengarang' => 'required|string|max:255',
        'penerbit' => 'required|string|max:255',
        'tahun_terbit' => 'required|digits:4',
        'kategori' => 'nullable|string|max:255',
        'stok' => 'required|integer|min:0',
        'lokasi_rak' => 'nullable|string|max:100',
        'cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $data = $request->except('cover');

    // ✅ Ganti cover baru jika diunggah
    if ($request->hasFile('cover')) {
        // hapus file lama (opsional)
        if ($buku->cover && file_exists(storage_path('app/public/' . $buku->cover))) {
            unlink(storage_path('app/public/' . $buku->cover));
        }

        $path = $request->file('cover')->store('covers', 'public');
        $data['cover'] = $path;
    }

    $buku->update($data);

    return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
}

    /**
     * 🗑️ Hapus buku (dan cover jika ada)
     */
    public function destroy(Buku $buku)
    {
        if ($buku->cover && Storage::disk('public')->exists($buku->cover)) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return redirect()->route('buku.index')->with('success', '🗑️ Buku berhasil dihapus!');
    }
}
