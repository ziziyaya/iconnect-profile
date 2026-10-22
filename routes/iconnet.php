<?php

use App\Http\Controllers\Iconnet\AuthController;
use App\Http\Controllers\Iconnet\HalamanController;
use App\Http\Controllers\Iconnet\KelolaController;
use App\Http\Controllers\Iconnet\PesertaController;
use App\Http\Controllers\Iconnet\PresensiController;
use App\Http\Controllers\Iconnet\ProfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route halaman & API frontend ICONNET
|--------------------------------------------------------------------------
| Nama halaman = nama file frontend tanpa ".html" (beranda.html -> /beranda).
| Link lama berakhiran .html tetap bisa dibuka (diarahkan ke alamat barunya).
*/

$halaman = [HalamanController::class, 'tampil'];

// ---------- Website publik ----------
Route::get('/', $halaman)->defaults('halaman', 'index')->name('home');
Route::get('/keseruan', $halaman)->defaults('halaman', 'keseruan')->name('iconnet.keseruan');
Route::get('/keseruan-detail', $halaman)->defaults('halaman', 'keseruan-detail')->name('iconnet.keseruan-detail');
Route::get('/tentang-kami', $halaman)->defaults('halaman', 'tentang-kami')->name('tentang');
Route::get('/paket-harga', $halaman)->defaults('halaman', 'paket-harga')->name('iconnet.paket-harga');
Route::get('/hubungi-kami', $halaman)->defaults('halaman', 'hubungi-kami')->name('iconnet.hubungi-kami');

// ---------- Login, sign up, lupa password (hanya untuk tamu) ----------
Route::middleware('guest')->group(function () use ($halaman) {
    Route::get('/login', $halaman)->defaults('halaman', 'login')->name('login');
    Route::get('/signup', $halaman)->defaults('halaman', 'signup')->name('iconnet.signup');
    Route::get('/register', fn () => redirect('/signup'))->name('register');
    Route::get('/forgot-password', $halaman)->defaults('halaman', 'forgot-password')->name('password.request');
    Route::get('/reset-password/{token}', [HalamanController::class, 'resetPassword'])->name('password.reset');
});

// ---------- Peserta magang (role karyawan) ----------
Route::middleware('iconnet.role:user')->group(function () use ($halaman) {
    Route::get('/beranda', $halaman)->defaults('halaman', 'beranda')->name('iconnet.beranda');
    Route::get('/absensi', $halaman)->defaults('halaman', 'absensi')->name('iconnet.absensi');
    Route::get('/riwayat', $halaman)->defaults('halaman', 'riwayat')->name('iconnet.riwayat');
});

// /profil (nama route lama profil.index, dipakai juga menu panel lama): halaman profil sesuai role
Route::get('/profil', [HalamanController::class, 'profil'])->middleware('auth')->name('profil.index');

// ---------- Admin ----------
Route::middleware('iconnet.role:admin')->group(function () use ($halaman) {
    Route::get('/beranda-admin', $halaman)->defaults('halaman', 'beranda-admin')->name('iconnet.beranda-admin');
    Route::get('/verifikasi-user', $halaman)->defaults('halaman', 'verifikasi-user')->name('iconnet.verifikasi-user');
    Route::get('/akun-user', $halaman)->defaults('halaman', 'akun-user')->name('iconnet.akun-user');
    Route::get('/profil-admin', $halaman)->defaults('halaman', 'profil-admin')->name('iconnet.profil-admin');
});

// ---------- Superadmin ----------
Route::middleware('iconnet.role:superadmin')->group(function () use ($halaman) {
    foreach ([
        'beranda-superadmin', 'riwayat-superadmin', 'rekap-superadmin', 'profil-superadmin',
        'kelola-beranda', 'kelola-tentang-kami', 'kelola-paket-harga', 'kelola-hubungi-kami',
    ] as $nama) {
        Route::get('/'.$nama, $halaman)->defaults('halaman', $nama)->name('iconnet.'.$nama);
    }
});

// ---------- Alamat lama berakhiran .html (mis. bookmark) -> alamat baru ----------
Route::get('/{nama}.html', function (string $nama) {
    return redirect($nama === 'index' ? '/' : '/'.$nama, 301);
})->where('nama', 'index|keseruan|keseruan-detail|tentang-kami|paket-harga|hubungi-kami|login|signup|forgot-password|beranda|absensi|riwayat|profil|beranda-admin|verifikasi-user|akun-user|profil-admin|beranda-superadmin|riwayat-superadmin|rekap-superadmin|profil-superadmin|kelola-beranda|kelola-tentang-kami|kelola-paket-harga|kelola-hubungi-kami');

/*
|--------------------------------------------------------------------------
| API untuk halaman frontend (dipanggil lewat fetch, memakai sesi login + CSRF)
|--------------------------------------------------------------------------
*/
Route::prefix('api/v1')->name('iconnet.api.')->group(function () {
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
    Route::post('auth/register', [AuthController::class, 'register'])->middleware(['guest', 'throttle:10,1'])->name('register');
    Route::post('auth/forgot', [AuthController::class, 'forgot'])->middleware(['guest', 'throttle:6,1'])->name('forgot');
    Route::post('auth/reset', [AuthController::class, 'reset'])->middleware(['guest', 'throttle:6,1'])->name('reset');
    Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('auth')->group(function () {
        Route::put('profil/password', [ProfilController::class, 'password'])->name('profil.password');
    });

    Route::middleware('iconnet.role:user')->group(function () {
        Route::post('presensi/masuk', [PresensiController::class, 'masuk'])->name('presensi.masuk');
        Route::post('presensi/pulang', [PresensiController::class, 'pulang'])->name('presensi.pulang');
        Route::post('izin', [PresensiController::class, 'izin'])->name('izin');
    });

    Route::middleware('iconnet.role:admin')->group(function () {
        Route::post('peserta/verifikasi', [PesertaController::class, 'verifikasi'])->name('peserta.verifikasi');
        Route::post('peserta/hapus', [PesertaController::class, 'hapus'])->name('peserta.hapus');
    });

    Route::middleware('iconnet.role:superadmin')->prefix('kelola')->name('kelola.')->group(function () {
        Route::get('data/{halaman}', [HalamanController::class, 'data'])
            ->where('halaman', 'beranda-superadmin|riwayat-superadmin|rekap-superadmin')->name('data');

        Route::post('banner', [KelolaController::class, 'bannerSimpan'])->name('banner.tambah');
        Route::put('banner/{id}', [KelolaController::class, 'bannerSimpan'])->whereNumber('id')->name('banner.ubah');
        Route::patch('banner/{id}/aktif', [KelolaController::class, 'bannerAktif'])->whereNumber('id')->name('banner.aktif');
        Route::delete('banner/{id}', [KelolaController::class, 'bannerHapus'])->whereNumber('id')->name('banner.hapus');

        Route::post('kegiatan', [KelolaController::class, 'kegiatanSimpan'])->name('kegiatan.tambah');
        Route::put('kegiatan/{id}', [KelolaController::class, 'kegiatanSimpan'])->whereNumber('id')->name('kegiatan.ubah');
        Route::delete('kegiatan/{id}', [KelolaController::class, 'kegiatanHapus'])->whereNumber('id')->name('kegiatan.hapus');

        Route::put('tentang', [KelolaController::class, 'tentangSimpan'])->name('tentang');
        Route::post('perjalanan', [KelolaController::class, 'perjalananSimpan'])->name('perjalanan.tambah');
        Route::put('perjalanan/{id}', [KelolaController::class, 'perjalananSimpan'])->whereNumber('id')->name('perjalanan.ubah');
        Route::delete('perjalanan/{id}', [KelolaController::class, 'perjalananHapus'])->whereNumber('id')->name('perjalanan.hapus');

        Route::post('paket', [KelolaController::class, 'paketSimpan'])->name('paket.tambah');
        Route::put('paket/{id}', [KelolaController::class, 'paketSimpan'])->whereNumber('id')->name('paket.ubah');
        Route::delete('paket/{id}', [KelolaController::class, 'paketHapus'])->whereNumber('id')->name('paket.hapus');

        Route::put('hubungi', [KelolaController::class, 'hubungiSimpan'])->name('hubungi');
    });
});

// File bukti izin (pemilik, admin, superadmin) - dicek di controller
Route::get('izin/{id}/bukti', [PresensiController::class, 'bukti'])->middleware('auth')->whereNumber('id')->name('iconnet.izin.bukti');
