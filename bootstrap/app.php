<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'superadmin' => \App\Http\Middleware\EnsureUserIsSuperadmin::class,
        'staff' => \App\Http\Middleware\EnsureUserIsStaff::class,
<<<<<<< HEAD
        // Akses halaman frontend ICONNET per role: iconnet.role:user|admin|superadmin
        'iconnet.role' => \App\Http\Middleware\EnsureIconnetRole::class,
    ]);
    // Tamu yang membuka halaman khusus login diarahkan ke /login,
    // user yang sudah login dan membuka /login diarahkan ke beranda sesuai role.
    $middleware->redirectUsersTo(fn ($request) => \App\Support\IconnetData::homePath($request->user()));
=======
    ]);
>>>>>>> 655aefec3182cd2b62b58e4cf428a5fa1f1a26e9
})

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
