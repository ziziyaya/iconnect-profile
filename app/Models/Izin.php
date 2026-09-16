<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $fillable = ['user_id', 'tanggal', 'alasan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
