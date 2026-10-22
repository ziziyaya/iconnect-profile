<?php

namespace App\Http\Controllers\Iconnet;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\IconnetData;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

/**
 * Login, sign up, lupa password & logout untuk halaman frontend ICONNET (dipanggil lewat fetch).
 * Aturannya mengikuti controller Breeze yang sudah ada:
 *  - LoginRequest: maksimal 5 percobaan, lalu dikunci sementara.
 *  - AuthenticatedSessionController: karyawan yang belum di-ACC / ditolak tidak boleh login.
 *  - RegisteredUserController: akun baru selalu karyawan berstatus pending.
 */
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->string('email')).'|'.$request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            event(new Lockout($request));
            $detik = RateLimiter::availableIn($throttleKey);

            return response()->json([
                'field' => 'password',
                'message' => 'Terlalu banyak percobaan login. Coba lagi dalam '.$detik.' detik.',
            ], 429);
        }

        $credentials = [
            'email' => Str::lower(trim($request->input('email'))),
            'password' => $request->input('password'),
        ];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey);

            return response()->json(['field' => 'password', 'message' => 'Email atau password salah.'], 422);
        }

        RateLimiter::clear($throttleKey);
        $user = Auth::user();

        // Karyawan yang belum di-ACC (atau ditolak) tidak boleh login
        if ($user->role === 'karyawan' && $user->status !== 'approved') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($user->status === 'pending') {
                return response()->json(['notice' => 'Akun Anda masih menunggu verifikasi admin.'], 403);
            }

            return response()->json([
                'notice' => 'Akun Anda ditolak admin. Alasan: '.($user->alasan_penolakan ?: '-'),
            ], 403);
        }

        $request->session()->regenerate();

        return response()->json([
            'redirect' => IconnetData::homePath($user),
            'session' => IconnetData::session($user),
        ]);
    }

    public function register(Request $request)
    {
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);

        $request->validate([
            'nama' => ['required', 'string', 'min:3', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email'],
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Za-z]/', 'regex:/\d/', Rules\Password::defaults()],
            'telepon' => ['required', 'string', 'max:30'],
            'gender' => ['required', 'in:L,P'],
            'sekolah' => ['required', 'string', 'min:3', 'max:150'],
        ], [
            'email.unique' => 'Email sudah terdaftar. Silakan login.',
            'password.min' => 'Password minimal 8 karakter dan mengandung huruf serta angka.',
            'password.regex' => 'Password minimal 8 karakter dan mengandung huruf serta angka.',
        ]);

        $user = new User();
        $user->name = trim($request->nama);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->telepon = trim($request->telepon);
        $user->jenis_kelamin = $request->gender;
        $user->sekolah = trim($request->sekolah);
        // Akun baru dari Sign Up SELALU karyawan, status pending (harus di-ACC admin dulu)
        $user->role = 'karyawan';
        $user->status = 'pending';
        $user->save();

        event(new Registered($user));

        return response()->json(['ok' => true]);
    }

    /** Langkah 1 lupa password: kirim link reset ke email (fitur reset password Laravel). */
    public function forgot(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $email = Str::lower(trim($request->email));
        if (! User::where('email', $email)->exists()) {
            return response()->json(['field' => 'email', 'message' => 'Email belum terdaftar.'], 422);
        }

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Link reset password telah dikirim ke '.$email.'. Silakan cek email Anda.']);
        }
        if ($status === Password::RESET_THROTTLED) {
            return response()->json(['field' => 'email', 'message' => 'Tunggu sebentar sebelum meminta link reset lagi.'], 429);
        }

        return response()->json(['field' => 'email', 'message' => 'Link reset password gagal dikirim. Coba lagi.'], 422);
    }

    /** Langkah 2 lupa password: simpan password baru memakai token dari email. */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8', 'regex:/[A-Za-z]/', 'regex:/\d/'],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sama.',
            'password.min' => 'Password minimal 8 karakter dan mengandung huruf serta angka.',
            'password.regex' => 'Password minimal 8 karakter dan mengandung huruf serta angka.',
        ]);

        $status = Password::reset(
            [
                'email' => Str::lower(trim($request->email)),
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token' => $request->token,
            ],
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json(['ok' => true]);
        }

        return response()->json([
            'field' => 'password',
            'message' => 'Link reset password tidak valid atau sudah kedaluwarsa. Minta link baru.',
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['redirect' => 'login']);
    }
}
