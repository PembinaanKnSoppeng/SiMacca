<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Anggota;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung semua data dari tabel yang sesuai
        $totalBuku = Buku::count();
        $totalAnggota = Anggota::count();
        $peminjamanAktif = Peminjaman::where('status', 'dipinjam')->count();

        // Kirim data ke tampilan dashboard
        return view('dashboard', [
            'totalBuku' => $totalBuku,
            'totalAnggota' => $totalAnggota,
            'peminjamanAktif' => $peminjamanAktif,
        ]);
    }
}

