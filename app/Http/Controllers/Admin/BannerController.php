<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('urutan')->get();
        return view('admin.banners.index', ['banners' => $banners]);
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:255',
            'gambar' => 'required|image|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        $namaFile = $request->file('gambar')->store('banners', 'public');

        $banner = new Banner();
        $banner->judul = $request->judul;
        $banner->deskripsi = $request->deskripsi;
        $banner->gambar = $namaFile;
        $banner->urutan = $request->urutan;
        $banner->save();

        return redirect()->route('admin.banners.index')->with('status', 'Banner berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        return view('admin.banners.edit', ['banner' => $banner]);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|max:4096',
            'urutan' => 'nullable|integer',
        ]);

        $banner->judul = $request->judul;
        $banner->deskripsi = $request->deskripsi;
        $banner->urutan = $request->urutan;

        // Gambar cuma diganti kalau upload file baru
        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($banner->gambar);
            $banner->gambar = $request->file('gambar')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('admin.banners.index')->with('status', 'Banner berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        Storage::disk('public')->delete($banner->gambar);
        $banner->delete();

        return redirect()->route('admin.banners.index')->with('status', 'Banner berhasil dihapus.');
    }
}
