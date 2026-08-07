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
      <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
      <a href="{{ route('home') }}#keunggulan">Kenapa Kami</a>
      <a href="{{ route('langganan') }}" class="{{ request()->routeIs('langganan') ? 'active' : '' }}">Berlangganan</a>

      @auth
        <details class="profile-menu">
          <summary><x-avatar :user="auth()->user()" :size="36" /></summary>
          <div class="profile-menu-panel">
            <div class="profile-menu-name">{{ auth()->user()->name }}</div>
            @if (auth()->user()->role == 'karyawan')
              <a href="{{ route('absen.index') }}">🕒 Absen</a>
              <a href="{{ route('absen.riwayat') }}">📋 Riwayat Absen</a>
            @endif
            @if (auth()->user()->role == 'admin')
              <a href="{{ route('staff.persetujuan.index') }}">🛠️ Panel Admin</a>
              <a href="{{ route('absen.index') }}">🕒 Absen Saya</a>
            @endif
            @if (auth()->user()->role == 'superadmin')
              <a href="{{ route('admin.banners.index') }}">🛠️ Panel Superadmin</a>
              <a href="{{ route('absen.index') }}">🕒 Absen Saya</a>
            @endif
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">🚪 Logout</button>
            </form>
          </div>
        </details>
      @else
        <a href="{{ route('login') }}" class="btn btn-ghost" style="padding:10px 18px;">Login Karyawan</a>
      @endauth
    </nav>
    <button class="nav-toggle" aria-label="Buka menu">☰</button>
  </div>
</header>

<main>
  @yield('content')
</main>

<footer>
  <div class="container">
    <span>{{ $pengaturanGlobal->nama_perusahaan }} — {{ $pengaturanGlobal->tagline }}</span>
    <span>{{ $pengaturanGlobal->kota }}</span>
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
