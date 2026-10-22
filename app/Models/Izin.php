<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
<<<<<<< HEAD
    protected $fillable = ['user_id', 'jenis', 'tanggal', 'tanggal_selesai', 'alasan', 'bukti', 'bukti_nama', 'status'];
=======
    protected $fillable = ['user_id', 'tanggal', 'alasan', 'status'];
>>>>>>> 655aefec3182cd2b62b58e4cf428a5fa1f1a26e9

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
