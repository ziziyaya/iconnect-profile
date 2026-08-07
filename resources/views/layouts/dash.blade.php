<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title', 'Dashboard')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>
<body>

@php
    $userLogin = auth()->user();
    $namaPerusahaan = \App\Models\Pengaturan::instance()->nama_perusahaan;
@endphp

<div class="dash-shell">
  <aside class="dash-sidebar">
    <a href="{{ route('home') }}" class="brand">
      <span class="dot-signal"></span>
      <span>{{ $namaPerusahaan }}</span>
    </a>

    <nav class="dash-nav">
      <a href="{{ route('absen.index') }}" class="{{ request()->routeIs('absen.*') ? 'active' : '' }}">🕒 Absen Saya</a>

      @if ($userLogin->isStaff())
        <a href="{{ route('staff.persetujuan.index') }}" class="{{ request()->routeIs('staff.persetujuan.*') ? 'active' : '' }}">✅ Persetujuan Karyawan</a>
        <a href="{{ route('staff.rekap.index') }}" class="{{ request()->routeIs('staff.rekap.*') ? 'active' : '' }}">📊 Rekap Absensi</a>
      @endif

      @if ($userLogin->isSuperadmin())
        <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">🖼️ Banner Beranda</a>
        <a href="{{ route('admin.keunggulans.index') }}" class="{{ request()->routeIs('admin.keunggulans.*') ? 'active' : '' }}">⭐ Kenapa Pilih Kami</a>
        <a href="{{ route('admin.pakets.index') }}" class="{{ request()->routeIs('admin.pakets.*') ? 'active' : '' }}">📦 Paket Layanan</a>
        <a href="{{ route('admin.pengaturan.edit') }}" class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">⚙️ Pengaturan Situs</a>
      @endif
    </nav>

    <div class="dash-nav" style="margin-top:auto;">
      <a href="{{ route('home') }}">← Kembali ke Website</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dash-logout">Logout</button>
      </form>
    </div>
  </aside>

  <main class="dash-main">
    <div class="dash-topbar">
      <h1>@yield('title', 'Dashboard')</h1>
      <span class="mono" style="color:var(--text-muted); font-size:0.85rem;">{{ $userLogin->name }} ({{ ucfirst($userLogin->role) }})</span>
    </div>

    @if (session('status'))
      <div class="admin-alert">{{ session('status') }}</div>
    @endif

    @yield('content')
  </main>
</div>

<script src="{{ asset('assets/script.js') }}"></script>
@yield('script')
</body>
</html>
