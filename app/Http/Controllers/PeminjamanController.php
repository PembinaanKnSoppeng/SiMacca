<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Anggota;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * 📋 Tampilkan daftar peminjaman
     */
    public function index()
    {
        $peminjaman = Peminjaman::with(['anggota', 'buku'])
            ->latest()
            ->paginate(15);

        return view('peminjaman.index', compact('peminjaman'));
    }

    /**
     * ➕ Form tambah peminjaman baru
     */
    public function create()
    {
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('anggota', 'buku'));
    }

    /**
     * 💾 Simpan data peminjaman baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggota,id',
            'buku_id' => 'required|exists:bukus,id', // ✅ perbaikan: tabel buku bukan bukus
            'tanggal_pinjam' => 'required|date',
            'jatuh_tempo' => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Pastikan buku masih tersedia
        $buku = Buku::findOrFail($request->buku_id);
        if ($buku->stok <= 0) {
            return back()->withErrors(['buku_id' => 'Stok buku ini sudah habis!']);
        }

        // Buat peminjaman baru
        Peminjaman::create([
            'anggota_id' => $request->anggota_id,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'jatuh_tempo' => $request->jatuh_tempo,
            'status' => 'dipinjam',
            'keterangan' => $request->keterangan,
        ]);

        // Kurangi stok buku
        $buku->decrement('stok', 1);

        return redirect()->route('peminjaman.index')->with('success', '📘 Peminjaman berhasil dibuat!');
    }

    /**
     * ✏️ Form edit peminjaman
     */
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $anggota = Anggota::where('status', 'aktif')->get();
        $buku = Buku::all();

        return view('peminjaman.edit', compact('peminjaman', 'anggota', 'buku'));
    }

    /**
     * 🔄 Update data peminjaman
     */
    public function update(Request $request, $id)
    {
        $p = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Jika status berubah jadi dikembalikan
        if ($p->status === 'dipinjam' && $request->status === 'dikembalikan') {
            $p->update([
                'tanggal_kembali' => $request->tanggal_kembali ?? Carbon::now()->toDateString(),
                'status' => 'dikembalikan',
                'keterangan' => $request->keterangan,
            ]);

            // Tambah stok buku kembali
            $buku = Buku::find($p->buku_id);
            if ($buku) $buku->increment('stok', 1);
        } else {
            // Update data lain jika bukan perubahan status
            $p->update($request->only(['tanggal_pinjam', 'jatuh_tempo', 'keterangan', 'status']));
        }

        return redirect()->route('peminjaman.index')->with('success', '✅ Data peminjaman berhasil diperbarui.');
    }
    public function updateStatus(Request $request, $id)
{
    $peminjaman = Peminjaman::find($id);

    if (!$peminjaman) {
        return response()->json(['message' => 'Data tidak ditemukan.'], 404);
    }

    if ($request->status === 'dikembalikan' && $peminjaman->status === 'dipinjam') {
        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()->toDateString(),
        ]);

        // Tambah stok buku
        $buku = Buku::find($peminjaman->buku_id);
        if ($buku) {
            $buku->increment('stok', 1);
        }

        return response()->json([
            'message' => '📗 Buku berhasil dikembalikan!',
            'tanggal_kembali' => $peminjaman->tanggal_kembali,
        ], 200);
    }

    return response()->json(['message' => 'Tidak ada perubahan atau data tidak valid.'], 400);
}



    /**
     * ❌ Hapus peminjaman
     */
    public function destroy($id)
    {
        $p = Peminjaman::findOrFail($id);

        // Jika masih dipinjam → kembalikan stok
        if ($p->status === 'dipinjam') {
            $buku = Buku::find($p->buku_id);
            if ($buku) $buku->increment('stok', 1);
        }

        $p->delete();

        return redirect()->route('peminjaman.index')->with('success', '🗑️ Data peminjaman telah dihapus.');
    }
}
