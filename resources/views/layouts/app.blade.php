@php
    $pengaturanGlobal = $pengaturan ?? \App\Models\Pengaturan::instance();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>@yield('title', $pengaturanGlobal->nama_perusahaan)</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/style.css') }}">
</head>
<body>

<header class="navbar">
  <div class="container">
    <a href="{{ route('home') }}" class="brand">
      <span class="dot-signal"></span>
      <span>{{ $pengaturanGlobal->nama_perusahaan }}</span>
    </a>
    <nav class="nav-links">
      <a href="{{ route('home') }}" class="pill {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('tentang') }}" class="pill {{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang Kami</a>
      <a href="{{ route('paket') }}" class="pill {{ request()->routeIs('paket') ? 'active' : '' }}">Paket &amp; Harga</a>
      <a href="{{ route('saran') }}" class="pill {{ request()->routeIs('saran') ? 'active' : '' }}">Saran &amp; Kritik</a>

      @auth
        <a href="{{ auth()->user()->role == 'karyawan' ? route('dashboard') : (auth()->user()->role == 'admin' ? route('staff.persetujuan.index') : route('admin.banners.index')) }}" class="btn btn-primary" style="padding:9px 20px;">
          🏠 Dashboard
        </a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn" style="padding:9px 20px; background:var(--danger); color:#fff;">Logout</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="btn btn-primary" style="padding:9px 22px;">Login</a>
      @endauth
    </nav>
    <button class="nav-toggle" aria-label="Buka menu">☰</button>
  </div>
</header>

@auth
  <div class="subnav">
    <div class="container subnav-inner">
      @if (auth()->user()->role == 'karyawan')
        <a href="{{ route('dashboard') }}" class="subnav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Beranda Saya</a>
        <a href="{{ route('absen.index') }}" class="subnav-pill {{ request()->routeIs('absen.index') ? 'active' : '' }}">📷 Absensi</a>
        <a href="{{ route('absen.riwayat') }}" class="subnav-pill {{ request()->routeIs('absen.riwayat') ? 'active' : '' }}">📅 Riwayat</a>
        <a href="{{ route('izin.index') }}" class="subnav-pill {{ request()->routeIs('izin.*') ? 'active' : '' }}">📝 Izin</a>
        <a href="{{ route('profil.index') }}" class="subnav-pill {{ request()->routeIs('profil.*') ? 'active' : '' }}">👤 Profil</a>
      @endif
      @if (auth()->user()->role == 'admin')
        <a href="{{ route('dashboard') }}" class="subnav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Beranda Saya</a>
        <a href="{{ route('staff.persetujuan.index') }}" class="subnav-pill {{ request()->routeIs('staff.persetujuan.*') ? 'active' : '' }}">✅ Persetujuan Karyawan</a>
        <a href="{{ route('staff.izin.index') }}" class="subnav-pill {{ request()->routeIs('staff.izin.*') ? 'active' : '' }}">📝 Persetujuan Izin</a>
        <a href="{{ route('staff.rekap.index') }}" class="subnav-pill {{ request()->routeIs('staff.rekap.*') ? 'active' : '' }}">📊 Rekap Absensi</a>
        <a href="{{ route('absen.index') }}" class="subnav-pill {{ request()->routeIs('absen.index') ? 'active' : '' }}">📷 Absen Saya</a>
      @endif
      @if (auth()->user()->role == 'superadmin')
        <a href="{{ route('dashboard') }}" class="subnav-pill {{ request()->routeIs('dashboard') ? 'active' : '' }}">🏠 Beranda Saya</a>
        <a href="{{ route('admin.banners.index') }}" class="subnav-pill {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">🖼️ Banner</a>
        <a href="{{ route('admin.keunggulans.index') }}" class="subnav-pill {{ request()->routeIs('admin.keunggulans.*') ? 'active' : '' }}">⭐ Keunggulan</a>
        <a href="{{ route('admin.testimonis.index') }}" class="subnav-pill {{ request()->routeIs('admin.testimonis.*') ? 'active' : '' }}">📸 Keseruan</a>
        <a href="{{ route('admin.prestasis.index') }}" class="subnav-pill {{ request()->routeIs('admin.prestasis.*') ? 'active' : '' }}">🏆 Prestasi</a>
        <a href="{{ route('admin.pakets.index') }}" class="subnav-pill {{ request()->routeIs('admin.pakets.*') ? 'active' : '' }}">📦 Paket</a>
        <a href="{{ route('admin.pengaturan.edit') }}" class="subnav-pill {{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">⚙️ Pengaturan</a>
      @endif
    </div>
  </div>
@endauth

<main>
  @yield('content')
</main>

<footer class="footer-new">
  <div class="container">
    <div class="footer-grid">
      <div>
        <div class="brand" style="color:#fff; margin-bottom:12px;">
          <span class="dot-signal"></span>
          <span>{{ $pengaturanGlobal->nama_perusahaan }}</span>
        </div>
        <p>{{ $pengaturanGlobal->tagline }}</p>
      </div>

      <div>
        <h4>Menu</h4>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}">› Beranda</a></li>
          <li><a href="{{ route('tentang') }}">› Tentang Kami</a></li>
          <li><a href="{{ route('paket') }}">› Paket &amp; Harga</a></li>
          <li><a href="{{ route('saran') }}">› Saran &amp; Kritik</a></li>
        </ul>
      </div>

      <div>
        <h4>Hubungi Kami</h4>
        <div class="footer-contact-item">📍 {{ $pengaturanGlobal->alamat }}, {{ $pengaturanGlobal->kota }}</div>
        <div class="footer-contact-item">📞 {{ $pengaturanGlobal->no_wa_sales }}</div>
        <div class="footer-contact-item">✉️ {{ $pengaturanGlobal->email }}</div>

        <h4 style="margin-top:18px;">Social Media</h4>
        <div class="footer-social">
          @if ($pengaturanGlobal->instagram)
            <a href="https://instagram.com/{{ $pengaturanGlobal->instagram }}" target="_blank" rel="noopener">📷</a>
          @endif
          @if ($pengaturanGlobal->twitter)
            <a href="https://twitter.com/{{ $pengaturanGlobal->twitter }}" target="_blank" rel="noopener">🐦</a>
          @endif
          @if ($pengaturanGlobal->facebook)
            <a href="https://facebook.com/{{ $pengaturanGlobal->facebook }}" target="_blank" rel="noopener">📘</a>
          @endif
          @if ($pengaturanGlobal->tiktok)
            <a href="https://tiktok.com/@{{ $pengaturanGlobal->tiktok }}" target="_blank" rel="noopener">🎵</a>
          @endif
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      © {{ date('Y') }} {{ $pengaturanGlobal->nama_perusahaan }}. All rights reserved.
    </div>
  </div>
</footer>

<button class="fab" data-open-contact-modal>
  <span class="dot-signal"></span> Hubungi Kami
</button>

<div class="modal-overlay" id="contact-modal">
  <div class="modal-panel">
    <div class="modal-head">
      <h3>Hubungi Kami</h3>
      <button class="modal-close" aria-label="Tutup">✕</button>
    </div>
    @if ($pengaturanGlobal->no_wa_sales)
      <a class="btn btn-whatsapp btn-block" href="https://wa.me/{{ $pengaturanGlobal->no_wa_sales }}" target="_blank" rel="noopener">💬 Chat via WhatsApp</a>
    @endif
    <div class="modal-address">
      📍 {{ $pengaturanGlobal->alamat }}, {{ $pengaturanGlobal->kota }}
    </div>
    @if ($pengaturanGlobal->maps_embed_url)
      <div class="map-frame">
        <iframe src="{{ $pengaturanGlobal->maps_embed_url }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    @endif
  </div>
</div>

<script src="{{ asset('assets/script.js') }}"></script>
@yield('script')
</body>
</html>
