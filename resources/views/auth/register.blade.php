<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Daftar — {{ \App\Models\Pengaturan::instance()->nama_perusahaan }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>
<body>

<div class="auth-shell">

  <div class="auth-illustration">
    <div class="glow"></div>
    <a href="{{ route('home') }}" class="brand">
      <span class="dot-signal"></span>
      <span>{{ \App\Models\Pengaturan::instance()->nama_perusahaan }}</span>
    </a>

    <h1>Connect Every Possibility</h1>
    <p>Daftar sebagai karyawan untuk mengakses fitur absensi. Akun kamu perlu di-ACC admin dulu sebelum bisa login.</p>

    <div class="icon-badges">
      <div>
        <div class="ic">⚡</div>
        Koneksi Stabil
      </div>
      <div>
        <div class="ic">📶</div>
        Bandwidth Besar
      </div>
      <div>
        <div class="ic">🎧</div>
        Layanan Responsif
      </div>
    </div>
  </div>

  <div class="auth-form-side">
    <div class="auth-form-box">
      <h2>Registration</h2>
      <p style="margin-bottom:20px;">Enter your details to daftar</p>

      @if ($errors->any())
        <div class="admin-error">
          @foreach ($errors->all() as $pesanError)
            {{ $pesanError }}<br>
          @endforeach
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field">
          <label for="name">Nama</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="field">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="field">
          <label for="password_confirmation">Konfirmasi Password</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
      </form>

      <div class="auth-divider">ATAU</div>

      <button type="button" class="btn-social" disabled title="Belum tersedia">
        🔴 Continue with Google
      </button>
      <button type="button" class="btn-social" disabled title="Belum tersedia">
        ⚫ Continue with Apple
      </button>

      <p style="text-align:center; margin-top:20px; font-size:0.9rem;">
        Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--blue); font-weight:700;">Login</a>
      </p>
    </div>
  </div>

</div>

</body>
</html>
