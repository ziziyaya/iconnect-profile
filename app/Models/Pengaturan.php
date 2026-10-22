<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $fillable = [
        'nama_perusahaan',
        'tagline',
        'tentang',
        'visi',
        'misi',
        'alamat',
        'kota',
        'no_wa_sales',
<<<<<<< HEAD
        'call_center',
=======
>>>>>>> 655aefec3182cd2b62b58e4cf428a5fa1f1a26e9
        'email',
        'instagram',
        'twitter',
        'facebook',
        'tiktok',
        'jam_operasional',
        'jam_masuk_standar',
        'maps_embed_url',
    ];

    // Data pengaturan cuma ada 1 baris (id = 1)
    public static function instance()
    {
        $data = Pengaturan::find(1);

        if ($data == null) {
            $data = new Pengaturan();
            $data->id = 1;
            $data->nama_perusahaan = 'IConnect';
            $data->save();
        }

        return $data;
    }
}
