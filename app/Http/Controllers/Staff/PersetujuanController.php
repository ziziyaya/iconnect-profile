<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PersetujuanController extends Controller
{
    // Daftar semua karyawan (pending, approved, rejected)
    public function index()
    {
        $daftarKaryawan = User::where('role', 'karyawan')
            ->orderBy('status')
            ->orderBy('name')
            ->get();

        return view('staff.persetujuan.index', [
            'daftarKaryawan' => $daftarKaryawan,
        ]);
    }

    // ACC akun karyawan
    public function approve($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->status = 'approved';
        $karyawan->save();

        return redirect()->route('staff.persetujuan.index')->with('status', 'Akun '.$karyawan->name.' berhasil di-ACC.');
    }

    // Tolak akun karyawan
    public function tolak($id)
    {
        $karyawan = User::findOrFail($id);
        $karyawan->status = 'rejected';
        $karyawan->save();

        return redirect()->route('staff.persetujuan.index')->with('status', 'Akun '.$karyawan->name.' ditolak.');
    }
}
