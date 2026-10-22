<?php

namespace App\Http\Controllers\Iconnet;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\IconnetData;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Admin: verifikasi akun peserta (setujui / tolak) dan hapus akun.
 * Setujui / tolak = mengubah kolom status (sama dengan PersetujuanController lama),
 * ditambah alasan penolakan. Hapus akun memakai SOFT DELETE: akun tidak bisa login lagi
 * dan hilang dari daftar, tetapi riwayat presensi & izinnya tetap tersimpan.
 */
class PesertaController extends Controller
{
    private function cariPeserta(string $email): User
    {
        return User::where('role', 'karyawan')
            ->whereRaw('LOWER(email) = ?', [Str::lower(trim($email))])
            ->firstOrFail();
    }

    public function verifikasi(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'status' => ['required', 'in:disetujui,ditolak'],
            'alasan' => ['nullable', 'string', 'max:300', 'required_if:status,ditolak'],
        ], [
            'alasan.required_if' => 'Alasan penolakan wajib diisi.',
        ]);

        $peserta = $this->cariPeserta($request->email);

        if ($request->status === 'disetujui') {
            $peserta->status = 'approved';
            $peserta->alasan_penolakan = null;
        } else {
            $peserta->status = 'rejected';
            $peserta->alasan_penolakan = trim($request->alasan);
        }
        $peserta->save();

        return response()->json(['peserta' => IconnetData::semuaPeserta()]);
    }

    public function hapus(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $peserta = $this->cariPeserta($request->email);
        $peserta->delete(); // soft delete

        return response()->json(['peserta' => IconnetData::semuaPeserta()]);
    }
}
