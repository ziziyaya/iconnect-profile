<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
<<<<<<< HEAD
    protected $fillable = ['jenis', 'judul', 'deskripsi', 'teks_tombol', 'aktif', 'gambar', 'urutan'];

    protected $casts = [
        'aktif' => 'boolean',
    ];
=======
    protected $fillable = ['judul', 'deskripsi', 'gambar', 'urutan'];
>>>>>>> 655aefec3182cd2b62b58e4cf428a5fa1f1a26e9
}
