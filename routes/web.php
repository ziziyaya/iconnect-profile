<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\KeunggulanController;
use App\Http\Controllers\Admin\PaketController as AdminPaketController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanggananController;
use App\Http\Controllers\Staff\PersetujuanController;
use App\Http\Controllers\Staff\RekapAbsensiController;
use Illuminate\Support\Facades\Route;

// ================= HALAMAN PUBLIK (belum login) =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/langganan', [LanggananController::class, 'index'])->name('langganan');

// ================= ABSEN (karyawan, admin, superadmin — semua yang login boleh absen sendiri) =================
Route::middleware('auth')->group(function () {
    Route::get('/absen', [AbsensiController::class, 'index'])->name('absen.index');
    Route::post('/absen/masuk', [AbsensiController::class, 'masuk'])->name('absen.masuk');
    Route::post('/absen/pulang', [AbsensiController::class, 'pulang'])->name('absen.pulang');
    Route::get('/absen/riwayat', [AbsensiController::class, 'riwayat'])->name('absen.riwayat');
});

// ================= STAFF: admin + superadmin (approval karyawan & rekap absensi) =================
Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::put('persetujuan/{id}/approve', [PersetujuanController::class, 'approve'])->name('persetujuan.approve');
    Route::put('persetujuan/{id}/tolak', [PersetujuanController::class, 'tolak'])->name('persetujuan.tolak');

    Route::get('rekap', [RekapAbsensiController::class, 'index'])->name('rekap.index');
});

// ================= SUPERADMIN: kelola konten situs =================
Route::middleware(['auth', 'superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('banners', BannerController::class)->except('show');
    Route::resource('keunggulans', KeunggulanController::class)->except('show');
    Route::resource('pakets', AdminPaketController::class)->except('show');
    Route::get('pengaturan', [PengaturanController::class, 'edit'])->name('pengaturan.edit');
    Route::put('pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');
});

// ================= Login / Register bawaan Laravel Breeze =================
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}
