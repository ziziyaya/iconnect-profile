<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;

class InformasiController extends Controller
{
    public function index()
    {
        $daftarInformasi = Informasi::orderBy('tanggal', 'desc')->get();
        return view('admin.informasis.index', ['daftarInformasi' => $daftarInformasi]);
    }

    public function create()
    {
        return view('admin.informasis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'tanggal' => 'required|date',
        ]);

        $informasi = new Informasi();
        $informasi->judul = $request->judul;
        $informasi->deskripsi = $request->deskripsi;
        $informasi->icon = $request->icon;
        $informasi->tanggal = $request->tanggal;
        $informasi->save();

        return redirect()->route('admin.informasis.index')->with('status', 'Informasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('admin.informasis.edit', ['informasi' => $informasi]);
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'tanggal' => 'required|date',
        ]);

        $informasi->judul = $request->judul;
        $informasi->deskripsi = $request->deskripsi;
        $informasi->icon = $request->icon;
        $informasi->tanggal = $request->tanggal;
        $informasi->save();

        return redirect()->route('admin.informasis.index')->with('status', 'Informasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->delete();

        return redirect()->route('admin.informasis.index')->with('status', 'Informasi berhasil dihapus.');
    }
}
