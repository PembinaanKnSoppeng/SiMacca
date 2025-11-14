<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota'; // pastikan sesuai migrasi
    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'status',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }
}
