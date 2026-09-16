<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::orderBy('urutan')->orderBy('tanggal', 'desc')->get();
        return view('admin.testimonis.index', ['testimonis' => $testimonis]);
    }

    public function create()
    {
        return view('admin.testimonis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'foto' => 'required|image|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        $namaFile = $request->file('foto')->store('testimonis', 'public');

        $testimoni = new Testimoni();
        $testimoni->judul = $request->judul;
        $testimoni->deskripsi = $request->deskripsi;
        $testimoni->tanggal = $request->tanggal;
        $testimoni->foto = $namaFile;
        $testimoni->urutan = $request->urutan;
        $testimoni->save();

        return redirect()->route('admin.testimonis.index')->with('status', 'Testimoni berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        return view('admin.testimonis.edit', ['testimoni' => $testimoni]);
    }

    public function update(Request $request, $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
            'foto' => 'nullable|image|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        $testimoni->judul = $request->judul;
        $testimoni->deskripsi = $request->deskripsi;
        $testimoni->tanggal = $request->tanggal;
        $testimoni->urutan = $request->urutan;

        if ($request->hasFile('foto')) {
            Storage::disk('public')->delete($testimoni->foto);
            $testimoni->foto = $request->file('foto')->store('testimonis', 'public');
        }

        $testimoni->save();

        return redirect()->route('admin.testimonis.index')->with('status', 'Testimoni berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        Storage::disk('public')->delete($testimoni->foto);
        $testimoni->delete();

        return redirect()->route('admin.testimonis.index')->with('status', 'Testimoni berhasil dihapus.');
    }
}
