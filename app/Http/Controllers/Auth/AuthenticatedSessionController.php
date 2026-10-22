<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = Auth::user();

        // Karyawan yang belum di-ACC (atau ditolak) tidak boleh login
        if ($user->role == 'karyawan' && $user->status != 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($user->status == 'pending') {
                return back()->withErrors(['email' => 'Akun kamu masih menunggu persetujuan admin.']);
            }

            return back()->withErrors(['email' => 'Akun kamu ditolak. Hubungi admin untuk info lebih lanjut.']);
        }

        $request->session()->regenerate();

        // Semua role (karyawan, admin, superadmin) landing di Beranda dulu.
        // Dari situ mereka bisa pilih menu lain lewat sidebar sesuai hak akses masing-masing.
        return redirect()->route('dashboard');
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
