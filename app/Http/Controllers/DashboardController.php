<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Informasi;
use App\Models\Izin;
use App\Models\Pengaturan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $pengaturan = Pengaturan::instance();

        $bulanIni = date('Y-m');
        $tanggalMulai = date('Y-m-01');
        $tanggalAkhir = date('Y-m-t'); // tanggal terakhir bulan ini

        // Hitung jumlah hari kerja (Senin-Jumat) di bulan ini
        $jumlahHariKerja = $this->hitungHariKerja($tanggalMulai, $tanggalAkhir);

        // Total kehadiran: jumlah hari yang ada absen masuk bulan ini
        $totalKehadiran = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->whereNotNull('jam_masuk')
            ->count();

        // Terlambat: absen masuk yang jam-nya lewat dari jam masuk standar
        $totalTerlambat = Absensi::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->whereNotNull('jam_masuk')
            ->where('jam_masuk', '>', $pengaturan->jam_masuk_standar)
            ->count();

        // Izin yang sudah di-ACC bulan ini
        $totalIzin = Izin::where('user_id', $user->id)
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->where('status', 'approved')
            ->count();

        // Alpa = hari kerja - hadir - izin (gak boleh minus)
        $totalAlpa = $jumlahHariKerja - $totalKehadiran - $totalIzin;
        if ($totalAlpa < 0) {
            $totalAlpa = 0;
        }

        $informasiTerbaru = Informasi::orderBy('tanggal', 'desc')->take(3)->get();

        return view('dashboard', [
            'user' => $user,
            'pengaturan' => $pengaturan,
            'jumlahHariKerja' => $jumlahHariKerja,
            'totalKehadiran' => $totalKehadiran,
            'totalTerlambat' => $totalTerlambat,
            'totalIzin' => $totalIzin,
            'totalAlpa' => $totalAlpa,
            'informasiTerbaru' => $informasiTerbaru,
        ]);
    }

    /**
     * Hitung jumlah hari Senin-Jumat di antara 2 tanggal (buat total hari kerja sebulan).
     */
    private function hitungHariKerja($tanggalMulai, $tanggalAkhir)
    {
        $jumlah = 0;
        $tanggalSekarang = Carbon::parse($tanggalMulai);
        $tanggalSelesai = Carbon::parse($tanggalAkhir);

        while ($tanggalSekarang->lte($tanggalSelesai)) {
            // isWeekday() = Senin sampai Jumat
            if ($tanggalSekarang->isWeekday()) {
                $jumlah = $jumlah + 1;
            }
            $tanggalSekarang->addDay();
        }

        return $jumlah;
    }
}
