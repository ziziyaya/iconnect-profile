<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paket;
use Illuminate\Http\Request;

class PaketController extends Controller
{
    public function index()
    {
        $pakets = Paket::orderBy('urutan')->get();
        return view('admin.pakets.index', ['pakets' => $pakets]);
    }

    public function create()
    {
        return view('admin.pakets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'kategori' => 'required|in:reguler,promo',
            'durasi' => 'nullable|string|max:30',
            'kecepatan_mbps' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'fitur' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $isPopular = false;
        if ($request->has('is_popular')) {
            $isPopular = true;
        }

        $paket = new Paket();
        $paket->nama = $request->nama;
        $paket->kategori = $request->kategori;
        $paket->durasi = $request->durasi;
        $paket->kecepatan_mbps = $request->kecepatan_mbps;
        $paket->harga = $request->harga;
        $paket->fitur = $this->fiturToArray($request->fitur);
        $paket->is_popular = $isPopular;
        $paket->urutan = $request->urutan;
        $paket->save();

        return redirect()->route('admin.pakets.index')->with('status', 'Paket baru berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $paket = Paket::findOrFail($id);
        return view('admin.pakets.edit', ['paket' => $paket]);
    }

    public function update(Request $request, $id)
    {
        $paket = Paket::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:50',
            'kategori' => 'required|in:reguler,promo',
            'durasi' => 'nullable|string|max:30',
            'kecepatan_mbps' => 'required|integer|min:1',
            'harga' => 'required|integer|min:0',
            'fitur' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $isPopular = false;
        if ($request->has('is_popular')) {
            $isPopular = true;
        }

        $paket->nama = $request->nama;
        $paket->kategori = $request->kategori;
        $paket->durasi = $request->durasi;
        $paket->kecepatan_mbps = $request->kecepatan_mbps;
        $paket->harga = $request->harga;
        $paket->fitur = $this->fiturToArray($request->fitur);
        $paket->is_popular = $isPopular;
        $paket->urutan = $request->urutan;
        $paket->save();

        return redirect()->route('admin.pakets.index')->with('status', 'Paket berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $paket = Paket::findOrFail($id);
        $paket->delete();

        return redirect()->route('admin.pakets.index')->with('status', 'Paket berhasil dihapus.');
    }

    private function fiturToArray($teks)
    {
        $hasilArray = [];

        if ($teks == null || $teks == '') {
            return $hasilArray;
        }

        $barisBaris = explode("\n", $teks);

        foreach ($barisBaris as $baris) {
            $baris = trim($baris);
            if ($baris != '') {
                $hasilArray[] = $baris;
            }
        }

        return $hasilArray;
    }
}
