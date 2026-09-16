<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasis = Prestasi::orderBy('urutan')->get();
        return view('admin.prestasis.index', ['prestasis' => $prestasis]);
    }

    public function create()
    {
        return view('admin.prestasis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        $namaFile = $request->file('foto')->store('prestasis', 'public');

        $prestasi = new Prestasi();
        $prestasi->judul = $request->judul;
        $prestasi->deskripsi = $request->deskripsi;
        $prestasi->foto = $namaFile;
        $prestasi->urutan = $request->urutan;
        $prestasi->save();

        return redirect()->route('admin.prestasis.index')->with('status', 'Prestasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        return view('admin.prestasis.edit', ['prestasi' => $prestasi]);
    }

    public function update(Request $request, $id)
    {
        $prestasi = Prestasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        $prestasi->judul = $request->judul;
        $prestasi->deskripsi = $request->deskripsi;
        $prestasi->urutan = $request->urutan;

        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($prestasi->foto);
            $prestasi->foto = $request->file('foto')->store('prestasis', 'public');
        }

        $prestasi->save();

        return redirect()->route('admin.prestasis.index')->with('status', 'Prestasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        Storage::disk('public')->delete($prestasi->foto);
        $prestasi->delete();

        return redirect()->route('admin.prestasis.index')->with('status', 'Prestasi berhasil dihapus.');
    }
}
