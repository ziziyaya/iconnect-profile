<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Keunggulan;
use App\Models\Pengaturan;

class HomeController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::instance();
        $banners = Banner::orderBy('urutan')->get();
        $keunggulans = Keunggulan::orderBy('urutan')->get();

        return view('home', [
            'pengaturan' => $pengaturan,
            'banners' => $banners,
            'keunggulans' => $keunggulans,
        ]);
    }
}
