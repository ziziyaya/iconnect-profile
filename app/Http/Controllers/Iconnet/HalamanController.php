<?php

namespace App\Http\Controllers\Iconnet;

use App\Http\Controllers\Controller;
use App\Http\Middleware\EnsureIconnetRole;
use App\Support\IconnetData;
use Illuminate\Http\Request;

/**
 * Menampilkan halaman frontend ICONNET (resources/views/iconnet/*.blade.php).
 * Setiap halaman menerima data asli dari database lewat window.ICONNET_SERVER
 * (lihat App\Support\IconnetData dan public/js/iconnet-api.js).
 */
class HalamanController extends Controller
{
    public function tampil(Request $request, string $halaman)
    {
        return response()
            ->view('iconnet.'.$halaman, [
                'iconnet' => IconnetData::untukHalaman($halaman, $request->user()),
            ])
            // Data halaman bersifat pribadi & selalu terbaru: jangan disimpan di cache browser
            ->header('Cache-Control', 'no-store, private');
    }

    /** Data terbaru untuk halaman yang memperbarui dirinya secara berkala (mis. Beranda Superadmin). */
    public function data(Request $request, string $halaman)
    {
        return response()->json(IconnetData::untukHalaman($halaman, $request->user()));
    }

    /** Link reset password dari email: tampil di halaman Lupa Password (langkah ke-2). */
    public function resetPassword(Request $request, string $token)
    {
        $state = IconnetData::untukHalaman('forgot-password', null);
        $state['reset'] = ['token' => $token, 'email' => (string) $request->query('email', '')];

        return response()->view('iconnet.forgot-password', ['iconnet' => $state])
            ->header('Cache-Control', 'no-store, private');
    }

    /** /profil: peserta -> profil.html, admin -> profil-admin, superadmin -> profil-superadmin. */
    public function profil(Request $request)
    {
        return match (IconnetData::role($request->user())) {
            'admin' => redirect('/profil-admin'),
            'superadmin' => redirect('/profil-superadmin'),
            default => app(EnsureIconnetRole::class)->handle($request, fn ($r) => $this->tampil($r, 'profil'), 'user'),
        };
    }

    /** /dashboard (route lama) -> beranda sesuai role. */
    public function dashboard(Request $request)
    {
        return redirect(IconnetData::homePath($request->user()));
    }
}
