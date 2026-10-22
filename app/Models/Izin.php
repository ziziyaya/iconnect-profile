<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $fillable = ['user_id', 'jenis', 'tanggal', 'tanggal_selesai', 'alasan', 'bukti', 'bukti_nama', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
