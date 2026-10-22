<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['jenis', 'judul', 'deskripsi', 'teks_tombol', 'aktif', 'gambar', 'urutan'];

    protected $casts = [
        'aktif' => 'boolean',
    ];
}
