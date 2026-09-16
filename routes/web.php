<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\KeunggulanController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\PrestasiController as AdminPrestasiController;
use App\Http\Controllers\Admin\TestimoniController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\SaranController;
use App\Http\Controllers\Staff\IzinPersetujuanController;
use App\Http\Controllers\Staff\PersetujuanController;
use App\Http\Controllers\Staff\RekapAbsensiController;
use App\Http\Controllers\TentangController;
use Illuminate\Support\Facades\Route;

// ================= HALAMAN PUBLIK (belum login) =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [TentangController::class, 'index'])->name('tentang');
Route::get('/paket', [PaketController::class, 'index'])->name('paket');
Route::get('/saran-kritik', [SaranController::class, 'index'])->name('saran');

// ================= Halaman setelah login: Beranda karyawan/admin/superadmin =================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/absen', [AbsensiController::class, 'index'])->name('absen.index');
    Route::post('/absen/masuk', [AbsensiController::class, 'masuk'])->name('absen.masuk');
    Route::post('/absen/pulang', [AbsensiController::class, 'pulang'])->name('absen.pulang');
    Route::get('/absen/riwayat', [AbsensiController::class, 'riwayat'])->name('absen.riwayat');

    Route::get('/izin', [IzinController::class, 'index'])->name('izin.index');
    Route::post('/izin', [IzinController::class, 'store'])->name('izin.store');

    Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
    Route::put('/profil/password', [ProfilController::class, 'updatePassword'])->name('profil.password');
});

// ================= STAFF: admin + superadmin (approval karyawan, izin, rekap absensi) =================
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::put('persetujuan/{id}/approve', [PersetujuanController::class, 'approve'])->name('persetujuan.approve');
    Route::put('persetujuan/{id}/tolak', [PersetujuanController::class, 'tolak'])->name('persetujuan.tolak');

    Route::get('izin', [IzinPersetujuanController::class, 'index'])->name('izin.index');
    Route::put('izin/{id}/approve', [IzinPersetujuanController::class, 'approve'])->name('izin.approve');
    Route::put('izin/{id}/tolak', [IzinPersetujuanController::class, 'tolak'])->name('izin.tolak');

    Route::get('rekap', [RekapAbsensiController::class, 'index'])->name('rekap.index');
});

// ================= SUPERADMIN: kelola konten situs =================
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
