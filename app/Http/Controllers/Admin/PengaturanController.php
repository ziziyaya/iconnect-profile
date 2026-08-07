<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function edit()
    {
        $pengaturan = Pengaturan::instance();
        return view('admin.pengaturan.edit', ['pengaturan' => $pengaturan]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:100',
            'tagline' => 'nullable|string|max:150',
            'tentang' => 'nullable|string',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'no_wa_sales' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'jam_operasional' => 'nullable|string|max:100',
            'maps_embed_url' => 'nullable|string',
        ]);

        $pengaturan = Pengaturan::instance();

        $pengaturan->nama_perusahaan = $request->nama_perusahaan;
        $pengaturan->tagline = $request->tagline;
        $pengaturan->tentang = $request->tentang;
        $pengaturan->alamat = $request->alamat;
        $pengaturan->kota = $request->kota;
        $pengaturan->no_wa_sales = $request->no_wa_sales;
        $pengaturan->email = $request->email;
        $pengaturan->jam_operasional = $request->jam_operasional;
        $pengaturan->maps_embed_url = $request->maps_embed_url;
        $pengaturan->save();

        return redirect()->route('admin.pengaturan.edit')->with('status', 'Pengaturan situs berhasil disimpan.');
    }
}
