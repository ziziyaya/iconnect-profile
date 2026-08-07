<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Cek role
    public function isSuperadmin()
    {
        if ($this->role == 'superadmin') {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        if ($this->role == 'admin') {
            return true;
        }
        return false;
    }

    public function isKaryawan()
    {
        if ($this->role == 'karyawan') {
            return true;
        }
        return false;
    }

    // Admin & superadmin sama-sama boleh approve akun karyawan & lihat rekap
    public function isStaff()
    {
        if ($this->role == 'admin' || $this->role == 'superadmin') {
            return true;
        }
        return false;
    }

    public function sudahDiApprove()
    {
        if ($this->status == 'approved') {
            return true;
        }
        return false;
    }

    // Relasi ke data absensi milik user ini
    public function absensis()
    {
        return $this->hasMany(Absensi::class);
    }

    /**
     * Inisial buat avatar bulat di navbar. Contoh: "Budi Santoso" -> "BS"
     */
    public function getInitialsAttribute()
    {
        $nama = $this->name;
        $kataKata = explode(' ', $nama);

        $inisial = '';
        $jumlahKata = count($kataKata);

        for ($i = 0; $i < $jumlahKata; $i++) {
            if ($i >= 2) {
                break;
            }
            $kata = $kataKata[$i];
            if (strlen($kata) > 0) {
                $inisial = $inisial . strtoupper(substr($kata, 0, 1));
            }
        }

        if ($inisial == '') {
            $inisial = 'U';
        }

        return $inisial;
    }
}
