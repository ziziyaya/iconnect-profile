<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSuperadmin
{
    // Cuma superadmin yang boleh masuk (kelola banner, keunggulan, pengaturan, paket)
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if ($user == null) {
            abort(403, 'Halaman ini khusus superadmin.');
        }

        if ($user->role != 'superadmin') {
            abort(403, 'Halaman ini khusus superadmin.');
        }

        return $next($request);
    }
}
