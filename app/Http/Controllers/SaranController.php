<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;

class SaranController extends Controller
{
    public function index()
    {
        $pengaturan = Pengaturan::instance();

        return view('saran', [
            'pengaturan' => $pengaturan,
        ]);
    }
}
