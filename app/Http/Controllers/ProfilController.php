<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        return view('profil', ['user' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
        ]);

        $emailSudahDipakai = User::where('email', $request->email)
            ->where('id', '!=', $user->id)
            ->first();

        if ($emailSudahDipakai != null) {
            return back()->withErrors(['email' => 'Email sudah digunakan akun lain.']);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profil.index')->with('status', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = $request->user();

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profil.index')->with('status', 'Password berhasil diubah.');
    }
}
