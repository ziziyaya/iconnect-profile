<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $fillable = ['foto', 'judul', 'deskripsi', 'tanggal', 'urutan'];
}
