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
        'fitur',
        'is_popular',
        'urutan',
    ];

    protected $casts = [
        'fitur' => 'array',
        'is_popular' => 'boolean',
    ];
}
