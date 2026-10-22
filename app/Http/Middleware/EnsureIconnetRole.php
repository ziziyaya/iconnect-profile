<?php

namespace App\Http\Middleware;

use App\Support\IconnetData;
use Closure;
use Illuminate\Http\Request;

/**
 * Akses halaman frontend ICONNET per role (sama dengan guard di halaman frontend):
 *   user (= karyawan), admin, superadmin. Satu halaman hanya untuk satu role.
 * Belum login -> halaman login. Role lain -> beranda sesuai role-nya.
 * Untuk request API (JSON) dibalas 401 / 403.
 */
class EnsureIconnetRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        if ($user === null) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Sesi login berakhir. Silakan login kembali.'], 401);
            }

            return redirect()->guest(route('login'));
        }

        // Akun peserta yang belum / tidak disetujui tidak boleh memakai aplikasi (aturan login lama)
        if ($user->role === 'karyawan' && $user->status !== 'approved') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Akun belum disetujui admin.'], 403);
            }

            return redirect()->route('login');
        }

        if (IconnetData::role($user) !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Anda tidak memiliki akses ke fitur ini.'], 403);
            }

            return redirect(IconnetData::homePath($user));
        }

        return $next($request);
    }
}
