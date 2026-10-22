<?php

namespace App\Http\Controllers\Iconnet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/** Ubah password dari halaman profil (user, admin, superadmin). */
class ProfilController extends Controller
{
    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'not_regex:/\s/', 'regex:/\d/'],
        ], [
            'current_password.required' => 'Masukkan password saat ini.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.not_regex' => 'Password tidak boleh mengandung spasi.',
            'password.regex' => 'Password harus mengandung angka.',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Password saat ini salah.'], 422);
        }
        if ($request->current_password === $request->password) {
            return response()->json(['message' => 'Password baru tidak boleh sama dengan password lama.'], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Kata sandi berhasil diubah']);
    }
}
