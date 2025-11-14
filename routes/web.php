<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route utama aplikasi Sistem Perpustakaan.
| Sudah terstruktur berdasarkan fitur dan role pengguna.
|--------------------------------------------------------------------------
*/

// 🏠 Redirect root ke halaman login
Route::get('/', fn() => redirect()->route('login'));

// =======================
// 🔐 AUTENTIKASI
// =======================
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// =======================
// 📊 DASHBOARD (semua user login bisa akses)
// =======================
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// =======================
// 🔒 FITUR KHUSUS LOGIN
// =======================
Route::middleware(['auth'])->group(function () {

    

    /*
    |--------------------------------------------------------------------------
    | 📚 MANAJEMEN BUKU (Admin & Petugas)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,petugas')->prefix('buku')->name('buku.')->group(function () {
    Route::get('/', [BukuController::class, 'index'])->name('index');
    Route::get('/tambah', [BukuController::class, 'create'])->name('create');
    Route::post('/tambah', [BukuController::class, 'store'])->name('store');

    // 👁️ Detail buku
    Route::get('/{buku}', [BukuController::class, 'show'])->name('show');

    Route::get('/edit/{buku}', [BukuController::class, 'edit'])->name('edit');
    Route::put('/update/{buku}', [BukuController::class, 'update'])->name('update');
    Route::delete('/hapus/{id}', [BukuController::class, 'destroy'])->name('destroy');
});

    /*
    |--------------------------------------------------------------------------
    | 👥 MANAJEMEN ANGGOTA (Admin & Petugas)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,petugas')->prefix('anggota')->name('anggota.')->group(function () {
        Route::get('/', [AnggotaController::class, 'index'])->name('index');
        Route::get('/tambah', [AnggotaController::class, 'create'])->name('create');
        Route::post('/tambah', [AnggotaController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AnggotaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [AnggotaController::class, 'update'])->name('update');
        Route::delete('/hapus/{id}', [AnggotaController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | 📦 MANAJEMEN PEMINJAMAN (Admin & Petugas)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin,petugas')->prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/', [PeminjamanController::class, 'index'])->name('index');
        Route::get('/tambah', [PeminjamanController::class, 'create'])->name('create');
        Route::post('/tambah', [PeminjamanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PeminjamanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PeminjamanController::class, 'update'])->name('update');
        Route::delete('/hapus/{id}', [PeminjamanController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ⚙️ MANAJEMEN PENGGUNA (Hanya Admin)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/tambah', [UserController::class, 'create'])->name('create');
        Route::post('/tambah', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/hapus/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    /*
|--------------------------------------------------------------------------
| 👤 PROFIL PENGGUNA (Semua user login)
|--------------------------------------------------------------------------
*/

Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
Route::put('/profil/update', [ProfileController::class, 'update'])->name('profil.update');
Route::delete('/profil/avatar', [ProfileController::class, 'hapusAvatar'])->name('profil.avatar.delete');

// 🔒 Ganti Password (halaman terpisah)
Route::get('/profil/password', [PasswordController::class, 'index'])->name('profil.password');
Route::put('/profil/password', [PasswordController::class, 'update'])->name('profil.password.update');

// Status update via AJAX
Route::put('/peminjaman/{id}/status', [PeminjamanController::class, 'updateStatus'])
    ->name('peminjaman.updateStatus');


});
    