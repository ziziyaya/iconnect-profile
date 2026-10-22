<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\KeunggulanController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PrestasiController as AdminPrestasiController;
use App\Http\Controllers\Admin\TestimoniController;
use App\Http\Controllers\Iconnet\HalamanController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Staff\IzinPersetujuanController;
use App\Http\Controllers\Staff\PersetujuanController;
use App\Http\Controllers\Staff\RekapAbsensiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CATATAN INTEGRASI FRONTEND ICONNET
|--------------------------------------------------------------------------
| Tampilan website & aplikasi presensi sekarang memakai desain frontend ICONNET
| (resources/views/iconnet). Route lama TETAP ada dengan nama yang sama:
| - Halaman lama yang digantikan desain baru (beranda, paket, saran, dashboard, absen,
|   izin, profil) diarahkan (redirect) ke halaman barunya.
| - Proses lama (POST/PUT absen, izin, profil) dan panel lama /staff & /admin tetap
|   berjalan seperti sebelumnya, untuk fitur yang belum ada di desain baru
|   (persetujuan izin, keunggulan, prestasi, informasi, pengaturan lain).
*/

// ================= HALAMAN PUBLIK LAMA -> halaman baru =================
Route::get('/paket', fn () => redirect('/paket-harga'))->name('paket');
Route::get('/saran-kritik', fn () => redirect('/hubungi-kami'))->name('saran');

// ================= Halaman setelah login (route lama) =================
Route::middleware('auth')->group(function () {
    // Beranda lama -> beranda baru sesuai role
    Route::get('/dashboard', [HalamanController::class, 'dashboard'])->name('dashboard');

    Route::get('/absen', fn () => redirect('/absensi'))->name('absen.index');
    Route::post('/absen/masuk', [AbsensiController::class, 'masuk'])->name('absen.masuk');
    Route::post('/absen/pulang', [AbsensiController::class, 'pulang'])->name('absen.pulang');
    Route::get('/absen/riwayat', fn () => redirect('/riwayat'))->name('absen.riwayat');

    Route::get('/izin', fn () => redirect('/absensi'))->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

    // GET /profil = halaman profil baru (didefinisikan di bawah, nama route tetap profil.index)
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// ================= STAFF: admin + superadmin (panel lama: approval karyawan, izin, rekap absensi) =================
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::put('persetujuan/{id}/approve', [PersetujuanController::class, 'approve'])->name('persetujuan.approve');
    Route::put('persetujuan/{id}/tolak', [PersetujuanController::class, 'tolak'])->name('persetujuan.tolak');

    Route::get('izin', [IzinPersetujuanController::class, 'index'])->name('izin.index');
    Route::put('izin/{id}/approve', [IzinPersetujuanController::class, 'approve'])->name('izin.approve');
    Route::put('izin/{id}/tolak', [IzinPersetujuanController::class, 'tolak'])->name('izin.tolak');

    Route::get('rekap', [RekapAbsensiController::class, 'index'])->name('rekap.index');
});

// ================= SUPERADMIN: kelola konten situs (panel lama) =================
Route::middleware(['auth', 'superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('banners', BannerController::class)->except('show');
    Route::resource('keunggulans', KeunggulanController::class)->except('show');
    Route::resource('pakets', AdminPaketController::class)->except('show');
    Route::resource('testimonis', TestimoniController::class)->except('show');
    Route::resource('prestasis', AdminPrestasiController::class)->except('show');
    Route::resource('informasis', InformasiController::class)->except('show');
    Route::get('pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
    Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
});

// ================= Login / Register bawaan Laravel Breeze =================
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

// ================= FRONTEND ICONNET =================
// Didefinisikan setelah auth.php supaya GET /login, /forgot-password, /reset-password/{token}
// memakai halaman baru (nama route tetap: login, password.request, password.reset).
require __DIR__.'/iconnet.php';
