<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Timeline "Perjalanan ICONNET" (halaman Tentang Kami)
class Perjalanan extends Model
{
    protected $fillable = ['tahun', 'judul', 'deskripsi', 'urutan'];
}
