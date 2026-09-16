<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use Illuminate\Http\Request;

class IzinController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $daftarIzin = Izin::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('izin', ['daftarIzin' => $daftarIzin]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'alasan' => 'required|string|max:500',
        ]);

        $izin = new Izin();
        $izin->user_id = auth()->id();
        $izin->tanggal = $request->tanggal;
        $izin->alasan = $request->alasan;
        $izin->status = 'pending';
        $izin->save();

        return redirect()->route('izin.index')->with('status', 'Pengajuan izin berhasil dikirim, menunggu persetujuan admin.');
    }
}
