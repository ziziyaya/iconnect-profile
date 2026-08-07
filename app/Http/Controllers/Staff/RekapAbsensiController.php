<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class RekapAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggalDipilih = $request->tanggal;
        if ($tanggalDipilih == null || $tanggalDipilih == '') {
            $tanggalDipilih = date('Y-m-d');
        }

        $daftarAbsensi = Absensi::with('user')
            ->where('tanggal', $tanggalDipilih)
            ->orderBy('jam_masuk')
            ->get();

        return view('staff.rekap.index', [
            'daftarAbsensi' => $daftarAbsensi,
            'tanggalDipilih' => $tanggalDipilih,
        ]);
    }
}
