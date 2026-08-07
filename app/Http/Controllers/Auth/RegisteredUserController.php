<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        // Akun baru dari form Register SELALU jadi karyawan, status pending
        // (harus di-ACC dulu sama admin sebelum bisa login)
        $user->role = 'karyawan';
        $user->status = 'pending';
        $user->save();

        event(new Registered($user));

        // Sengaja TIDAK langsung login-in user, karena masih pending.
        return redirect()->route('login')->with('status', 'Pendaftaran berhasil! Akun kamu perlu di-ACC admin dulu sebelum bisa login.');
    }
}
