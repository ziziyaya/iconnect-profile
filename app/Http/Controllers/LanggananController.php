<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pengaturan;

class LanggananController extends Controller
{
    public function index()
    {
        $pakets = Paket::orderBy('urutan')->get();
        $pengaturan = Pengaturan::instance();

        return view('langganan', [
            'pakets' => $pakets,
            'pengaturan' => $pengaturan,
        ]);
    }
}
