<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keunggulan;
use Illuminate\Http\Request;

class KeunggulanController extends Controller
{
    public function index()
    {
        $keunggulans = Keunggulan::orderBy('urutan')->get();
        return view('admin.keunggulans.index', ['keunggulans' => $keunggulans]);
    }

    public function create()
    {
        return view('admin.keunggulans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'urutan' => 'nullable|integer',
        ]);

        $keunggulan = new Keunggulan();
        $keunggulan->judul = $request->judul;
        $keunggulan->deskripsi = $request->deskripsi;
        $keunggulan->icon = $request->icon;
        $keunggulan->urutan = $request->urutan;
        $keunggulan->save();

        return redirect()->route('admin.keunggulans.index')->with('status', 'Keunggulan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $keunggulan = Keunggulan::findOrFail($id);
        return view('admin.keunggulans.edit', ['keunggulan' => $keunggulan]);
    }

    public function update(Request $request, $id)
    {
        $keunggulan = Keunggulan::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'urutan' => 'nullable|integer',
        ]);

        $keunggulan->judul = $request->judul;
        $keunggulan->deskripsi = $request->deskripsi;
        $keunggulan->icon = $request->icon;
        $keunggulan->urutan = $request->urutan;
        $keunggulan->save();

        return redirect()->route('admin.keunggulans.index')->with('status', 'Keunggulan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keunggulan = Keunggulan::findOrFail($id);
        $keunggulan->delete();

        return redirect()->route('admin.keunggulans.index')->with('status', 'Keunggulan berhasil dihapus.');
    }
}
