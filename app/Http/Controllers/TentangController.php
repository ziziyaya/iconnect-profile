<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Prestasi;

class TentangController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::instance();
        $prestasis = Prestasi::orderBy('urutan')->get();

        return view('tentang', [
            'pengaturan' => $pengaturan,
            'prestasis' => $prestasis,
        ]);
    }
}
