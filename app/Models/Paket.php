<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = [
        'nama',
        'kategori',
        'durasi',
        'kecepatan_mbps',
        'harga',
<<<<<<< HEAD
        'harga_normal',
=======
>>>>>>> 655aefec3182cd2b62b58e4cf428a5fa1f1a26e9
        'fitur',
        'is_popular',
        'urutan',
    ];

    protected $casts = [
        'fitur' => 'array',
        'is_popular' => 'boolean',
    ];
}
