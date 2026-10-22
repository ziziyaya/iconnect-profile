<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Izin;

class IzinPersetujuanController extends Controller
{
    public function index()
    {
        $daftarIzin = Izin::with('user')->orderBy('tanggal', 'desc')->get();

        return view('staff.izin.index', ['daftarIzin' => $daftarIzin]);
    }

    public function approve($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = 'approved';
        $izin->save();

        return redirect()->route('staff.izin.index')->with('status', 'Izin disetujui.');
    }

    public function tolak($id)
    {
        $izin = Izin::findOrFail($id);
        $izin->status = 'rejected';
        $izin->save();

        return redirect()->route('staff.izin.index')->with('status', 'Izin ditolak.');
    }
}
