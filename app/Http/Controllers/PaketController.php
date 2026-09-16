<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index(Request $request)
    {
        $filterKategori = $request->kategori; // null (semua), 'promo', atau 'reguler'

        $query = Paket::orderBy('urutan');

        if ($filterKategori == 'promo' || $filterKategori == 'reguler') {
            $query = $query->where('kategori', $filterKategori);
        }

        $pakets = $query->paginate(8)->withQueryString();
        $pengaturan = Pengaturan::instance();

        return view('paket', [
            'pakets' => $pakets,
            'pengaturan' => $pengaturan,
            'filterKategori' => $filterKategori,
        ]);
    }
}
