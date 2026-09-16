<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Keunggulan;
use App\Models\Pengaturan;
use App\Models\Testimoni;

class HomeController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::instance();
        $banners = Banner::orderBy('urutan')->get();
        $keunggulans = Keunggulan::orderBy('urutan')->get();
        $testimonis = Testimoni::orderBy('urutan')->orderBy('tanggal', 'desc')->take(3)->get();

        return view('home', [
            'pengaturan' => $pengaturan,
            'banners' => $banners,
            'keunggulans' => $keunggulans,
            'testimonis' => $testimonis,
        ]);
    }
}
