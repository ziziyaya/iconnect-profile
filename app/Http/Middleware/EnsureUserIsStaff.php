<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsStaff
{
    // Admin dan superadmin dua-duanya boleh masuk (approve karyawan, lihat rekap absen)
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user == null) {
            abort(403, 'Halaman ini khusus admin/superadmin.');
        }

        if ($user->role != 'admin' && $user->role != 'superadmin') {
            abort(403, 'Halaman ini khusus admin/superadmin.');
        }

        return $next($request);
    }
}
