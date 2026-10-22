<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    // Halaman utama absen — nampilin kamera + tombol sesuai status hari ini
    public function index()
    {
        $user = auth()->user();
        $hariIni = date('Y-m-d');

        $absensiHariIni = Absensi::where('user_id', $user->id)
            ->where('tanggal', $hariIni)
            ->first();

        return view('absen.index', [
            'absensiHariIni' => $absensiHariIni,
        ]);
    }

    // Simpan absen masuk (foto dari kamera)
    public function masuk(Request $request)
    {
        $request->validate([
            'foto' => 'required|string',
        ]);

        $user = auth()->user();
        $hariIni = date('Y-m-d');

        // Cegah absen masuk dobel di hari yang sama
        $sudahAda = Absensi::where('user_id', $user->id)->where('tanggal', $hariIni)->first();
        if ($sudahAda != null) {
            return redirect()->route('absen.index')->with('status', 'Kamu sudah absen masuk hari ini.');
        }

        $namaFile = $this->simpanFotoBase64($request->foto, 'masuk');

        $absensi = new Absensi();
        $absensi->user_id = $user->id;
        $absensi->tanggal = $hariIni;
        $absensi->jam_masuk = date('H:i:s');
        $absensi->foto_masuk = $namaFile;
        $absensi->save();

        return redirect()->route('absen.index')->with('status', 'Absen masuk berhasil disimpan.');
    }

    // Simpan absen pulang (foto dari kamera)
    public function pulang(Request $request)
    {
        $request->validate([
            'foto' => 'required|string',
        ]);

        $user = auth()->user();
        $hariIni = date('Y-m-d');

        $absensi = Absensi::where('user_id', $user->id)->where('tanggal', $hariIni)->first();

        if ($absensi == null) {
            return redirect()->route('absen.index')->with('status', 'Kamu belum absen masuk hari ini.');
        }

        if ($absensi->jam_pulang != null) {
            return redirect()->route('absen.index')->with('status', 'Kamu sudah absen pulang hari ini.');
        }

        $namaFile = $this->simpanFotoBase64($request->foto, 'pulang');

        $absensi->jam_pulang = date('H:i:s');
        $absensi->foto_pulang = $namaFile;
        $absensi->save();

        return redirect()->route('absen.index')->with('status', 'Absen pulang berhasil disimpan.');
    }

    // Riwayat absensi milik user yang login
    public function riwayat()
    {
        $user = auth()->user();

        $daftarAbsensi = Absensi::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('absen.riwayat', [
            'daftarAbsensi' => $daftarAbsensi,
        ]);
    }

    /**
     * Foto dari kamera dikirim dalam bentuk teks base64 (data:image/png;base64,....).
     * Fungsi ini mengubahnya jadi file gambar asli dan menyimpannya di storage.
     */
    private function simpanFotoBase64($teksBase64, $jenis)
    {
        // Buang bagian awal "data:image/png;base64," biar sisa teksnya bisa di-decode
        $pisah = explode(',', $teksBase64);
        $isiGambar = base64_decode(end($pisah));

        $namaFile = 'absensi/'.$jenis.'_'.auth()->id().'_'.time().'.png';

        Storage::disk('public')->put($namaFile, $isiGambar);

        return $namaFile;
    }
}
