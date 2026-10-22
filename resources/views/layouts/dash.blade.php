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

<div class="dash-shell-v2">
  <aside class="dash-sidebar-v2">
    <div class="dash-sidebar-brand">
      <div class="dash-sidebar-logo">{{ strtolower($namaPerusahaan) }}</div>
      <div class="dash-sidebar-tagline">Semua Makin Mudah</div>
    </div>

    <nav class="dash-nav-v2">
      <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Beranda</a>
      <a href="{{ route('absen.index') }}" class="{{ request()->routeIs('absen.index') || request()->routeIs('absen.masuk') || request()->routeIs('absen.pulang') ? 'active' : '' }}">📷 Absensi</a>
      <a href="{{ route('absen.riwayat') }}" class="{{ request()->routeIs('absen.riwayat') ? 'active' : '' }}">📅 Riwayat</a>
      <a href="{{ route('izin.index') }}" class="{{ request()->routeIs('izin.*') ? 'active' : '' }}">📝 Izin</a>
      <a href="{{ route('profil.index') }}" class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">👤 Profil</a>

      @if ($userLogin->isStaff())
        <div class="dash-nav-divider">Menu Staff</div>
        <a href="{{ route('staff.persetujuan.index') }}" class="{{ request()->routeIs('staff.persetujuan.*') ? 'active' : '' }}">✅ Persetujuan Karyawan</a>
        <a href="{{ route('staff.izin.index') }}" class="{{ request()->routeIs('staff.izin.*') ? 'active' : '' }}">📝 Persetujuan Izin</a>
        <a href="{{ route('staff.rekap.index') }}" class="{{ request()->routeIs('staff.rekap.*') ? 'active' : '' }}">📊 Rekap Absensi</a>
      @endif

      @if ($userLogin->isSuperadmin())
        <div class="dash-nav-divider">Kelola Situs</div>
        <a href="{{ route('admin.banners.index') }}" class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">🖼️ Banner Beranda</a>
        <a href="{{ route('admin.keunggulans.index') }}" class="{{ request()->routeIs('admin.keunggulans.*') ? 'active' : '' }}">⭐ Kenapa Pilih Kami</a>
        <a href="{{ route('admin.testimonis.index') }}" class="{{ request()->routeIs('admin.testimonis.*') ? 'active' : '' }}">📸 Keseruan Bersama</a>
        <a href="{{ route('admin.prestasis.index') }}" class="{{ request()->routeIs('admin.prestasis.*') ? 'active' : '' }}">🏆 Prestasi</a>
        <a href="{{ route('admin.informasis.index') }}" class="{{ request()->routeIs('admin.informasis.*') ? 'active' : '' }}">📢 Informasi Terbaru</a>
        <a href="{{ route('admin.pakets.index') }}" class="{{ request()->routeIs('admin.pakets.*') ? 'active' : '' }}">📦 Paket Layanan</a>
        <a href="{{ route('admin.pengaturan.edit') }}" class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">⚙️ Pengaturan Situs</a>
      @endif
    </nav>

    <div class="dash-nav-v2" style="margin-top:auto; border-top:1px solid var(--border); padding-top:12px;">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="dash-logout-v2">↪️ Logout</button>
      </form>
    </div>

    <div class="dash-sidebar-illustration"></div>
  </aside>

  <div class="dash-body-v2">
    <div class="dash-topbar-v2">
      <h1>@yield('title', 'Dashboard')</h1>

      <div class="dash-topbar-right">
        <div class="dash-bell">
          🔔
          <span class="dash-bell-dot"></span>
        </div>

        <details class="profile-menu">
          <summary style="display:flex; align-items:center; gap:10px; cursor:pointer;">
            <x-avatar :user="$userLogin" :size="40" />
            <div style="text-align:left;">
              <div style="font-weight:700; font-size:0.9rem; color:var(--navy);">{{ $userLogin->name }}</div>
              <div style="font-size:0.78rem; color:var(--text-muted);">{{ ucfirst($userLogin->role) }}</div>
            </div>
            <span style="color:var(--text-muted);">⌄</span>
          </summary>
          <div class="profile-menu-panel">
            <a href="{{ route('profil.index') }}">👤 Profil Saya</a>
            <a href="{{ route('home') }}">🌐 Ke Website</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">🚪 Logout</button>
            </form>
          </div>
        </details>
      </div>
    </div>

    <div class="dash-content-v2">
      @if (session('status'))
        <div class="admin-alert">{{ session('status') }}</div>
      @endif

      @yield('content')
    </div>
  </div>
</div>

<script src="{{ asset('assets/script.js') }}"></script>
@yield('script')
</body>
</html>
