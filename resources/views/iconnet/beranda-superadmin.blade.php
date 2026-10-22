<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda SuperAdmin - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    button { font-family: inherit; }
    .st-b { display: inline-flex; align-items: center; justify-content: center; height: 26px; min-width: 96px; padding: 0 12px; border-radius: 6px; font-size: 12px; font-weight: 500; white-space: nowrap; }
    .st-hadir { background: #B8FFB4; color: #1B8F36; }
    .st-izin { background: #BBE9FB; color: #0A7FA8; }
    .st-sakit { background: #FFDFA9; color: #D9780A; }
    .st-terlambat { background: #FED5B9; color: #E0560F; }
    .st-lain { background: #E5E7EB; color: #374151; }
    .pg-b { display: inline-flex; align-items: center; justify-content: center; gap: 4px; height: 28px; min-width: 28px; padding: 0 10px; border: 1px solid #E3E3E3; border-radius: 7px; background: #fff; font-size: 11px; font-weight: 500; cursor: pointer; transition: background .15s; }
    .pg-b:hover:not(:disabled):not(.on) { background: #F3F4F6; }
    .pg-b.on { background: #4FC9E4; border-color: #4FC9E4; color: #fff; cursor: default; }
    .pg-b:disabled { opacity: .45; cursor: default; }
    .pg-pill { border-radius: 999px; padding: 0 14px; }
    /* Submenu Kelola Tampilan */
    .sb-sub { display: none; flex-direction: column; gap: 4px; padding-left: 38px; }
    .sb-sub.open { display: flex; }
    .sb-sub a { display: flex; align-items: center; height: 34px; border-radius: 8px; padding: 0 12px; font-size: 12px; color: #475569; transition: background .15s; }
    .sb-sub a:hover { background: #F1F5F9; }
    .chev { transition: transform .2s; }
    .chev.open { transform: rotate(180deg); }
    @media (min-width: 1024px) {
      :root { --su: max(min(100vw / 1110, 100vh / 790), 0.6px); --sbw: calc(var(--su) * 198); }
      .collapsed { --sbw: 76px; }
      #content { margin-left: var(--sbw); }

      /* Sidebar */
      #sidebar { width: var(--sbw); padding: calc(var(--su) * 36) calc(var(--su) * 17) calc(var(--su) * 48); border-radius: 0 calc(var(--su) * 28) calc(var(--su) * 28) 0; }
      .collapsed .sb-label { display: none; }
      .collapsed .sb-item { justify-content: center; padding-left: 0 !important; padding-right: 0 !important; }
      .collapsed #toggleBtn svg { transform: rotate(180deg); }
      .collapsed .sb-div { display: none !important; }
      .collapsed .sb-sub { display: none !important; }
      body .sb-row { height: calc(var(--su) * 104); }
      body .logo-img { height: calc(var(--su) * 104); width: calc(var(--su) * 104); object-fit: contain; }
      body .sb-div { display: block; height: 1px; width: calc(var(--su) * 125); margin: calc(var(--su) * 6) auto 0; background: #E8EAF0; }
      body.collapsed .sb-div { display: none; }
      body #toggleBtn { width: calc(var(--su) * 17); height: calc(var(--su) * 17); right: calc(var(--su) * -25.5); }
      body #toggleBtn svg { width: calc(var(--su) * 9); height: calc(var(--su) * 9); }
      body .sb-nav { margin-top: calc(var(--su) * 12); gap: calc(var(--su) * 12); }
      body .sb-item { height: calc(var(--su) * 44); padding: 0 calc(var(--su) * 17); gap: calc(var(--su) * 12); font-size: calc(var(--su) * 11.5); border-radius: calc(var(--su) * 9); }
      body .sb-item svg { width: calc(var(--su) * 18); height: calc(var(--su) * 18); }
      body .sb-item svg.chev { width: calc(var(--su) * 12); height: calc(var(--su) * 12); }
      body .sb-sub { padding-left: calc(var(--su) * 38); gap: calc(var(--su) * 4); margin-top: calc(var(--su) * -6); }
      body .sb-sub a { height: calc(var(--su) * 32); font-size: calc(var(--su) * 11); border-radius: calc(var(--su) * 8); }
      body #logoutBtn { height: calc(var(--su) * 44); font-size: calc(var(--su) * 13); gap: calc(var(--su) * 12); border-radius: calc(var(--su) * 10); padding: 0 calc(var(--su) * 17); justify-content: flex-start; }
      body #logoutBtn svg { width: calc(var(--su) * 22); height: calc(var(--su) * 22); }
      body.collapsed #logoutBtn { justify-content: center; padding: 0; }
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/superadmin.config.js -->
  <link rel="stylesheet" href="{{ asset('css/superadmin.css') }}" />
</head>

<body class="bg-[#F7F7FD] font-sans text-black antialiased">
  <script>
    // Guard: wajib login dan khusus role superadmin. Belum login -> halaman login;
    // role lain -> beranda sesuai role-nya (role kosong dianggap 'user', sama seperti login.html).
    (function () {
      let s = null;
      s = ICONNET_API.read('iconnet_session', null);   // sesi dari server (Laravel)
      if (!s || !s.email) { location.replace('{{ url('login') }}'); return; }
      const role = String(s.role || 'user').toLowerCase().replace(/[\s_]/g, '');
      if (role !== 'superadmin') { location.replace(role === 'superadmin' ? '{{ url('beranda-superadmin') }}' : role === 'admin' ? '{{ url('beranda-admin') }}' : '{{ url('beranda') }}'); return; }
      if (localStorage.getItem('iconnet_sidebar') === '1') document.body.classList.add('collapsed');
    })();
  </script>

  <!-- ===================== NAVBAR MOBILE ===================== -->
  <nav id="mnav" class="sticky top-0 z-50 lg:hidden">
    <div class="flex h-16 items-center justify-between bg-white px-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
      <a href="{{ url('beranda-superadmin') }}"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONIN" class="block h-12 w-auto" /></a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-navy transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 text-[13px] font-medium text-ink">Beranda</a>
        <a href="{{ url('riwayat-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Riwayat Presensi</a>
        <a href="{{ url('rekap-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Rekap Presensi</a>
        <div class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600">Kelola Tampilan</div>
        <a href="{{ url('kelola-beranda') }}" class="flex h-10 items-center rounded-xl pl-10 pr-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Beranda</a>
        <a href="{{ url('kelola-tentang-kami') }}" class="flex h-10 items-center rounded-xl pl-10 pr-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Tentang Kami</a>
        <a href="{{ url('kelola-paket-harga') }}" class="flex h-10 items-center rounded-xl pl-10 pr-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Paket &amp; Harga</a>
        <a href="{{ url('kelola-hubungi-kami') }}" class="flex h-10 items-center rounded-xl pl-10 pr-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Hubungi Kami</a>
        <a href="{{ url('profil-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 hover:bg-slate-100">Profile</a>
      </div>
      <div class="my-3 h-px bg-[#E8EAF0]"></div>
      <button id="logoutBtnM" type="button" class="flex h-11 w-full items-center justify-center gap-2.5 rounded-xl bg-[#D93A3F] text-[13px] font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.2)] hover:brightness-110">Log Out</button>
    </div>
  </nav>

  <!-- ===================== SIDEBAR (desktop) ===================== -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 hidden flex-col rounded-r-[28px] bg-white px-3 pb-5 pt-6 shadow-[2px_0_14px_rgba(0,0,0,0.12)] lg:flex">
    <div class="sb-row relative flex h-12 items-center justify-center px-2">
      <a href="{{ url('beranda-superadmin') }}" class="sb-label block"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONIN" class="logo-img block h-9 w-auto" /></a>
      <button id="toggleBtn" type="button" aria-label="Ciutkan sidebar" class="absolute -right-[22px] top-1/2 flex h-[22px] w-[22px] -translate-y-1/2 items-center justify-center rounded-full bg-cyan2 shadow">
        <svg class="h-3 w-3 transition-transform" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
      </button>
    </div>
    <div class="sb-div"></div>

    <nav class="sb-nav mt-8 flex flex-col gap-2">
      <a href="{{ url('beranda-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs bg-[#DFF7FC] font-medium text-ink">
        <svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="2"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="2"/></svg>
        <span class="sb-label">Beranda</span>
      </a>
      <a href="{{ url('riwayat-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100">
        <svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.2 2"/></svg>
        <span class="sb-label">Riwayat Presensi</span>
      </a>
      <a href="{{ url('rekap-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100">
        <svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H8a2 2 0 00-2 2v14a2 2 0 002 2h8a2 2 0 002-2V8z"/><path d="M14 3v5h4M9 13h6M9 17h4"/></svg>
        <span class="sb-label">Rekap Presensi</span>
      </a>
      <button id="kelolaBtn" type="button" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100">
        <svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.600 3.8 9S14.500 18.400 12 21c-2.500-2.600-3.800-5.600-3.800-9S9.500 5.600 12 3z"/></svg>
        <span class="sb-label flex-1 text-left">Kelola Tampilan</span>
        <svg id="chevD" class="chev sb-label h-3 w-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
      </button>
      <div id="subD" class="sb-sub">
        <a href="{{ url('kelola-beranda') }}">Beranda</a>
        <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
        <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
        <a href="{{ url('kelola-hubungi-kami') }}">Hubungi Kami</a>
      </div>
      <a href="{{ url('profil-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100">
        <svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.2 18.5c1.2-2.2 3.2-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>
        <span class="sb-label">Profile</span>
      </a>
    </nav>

    <button id="logoutBtn" type="button" class="sb-item mt-auto flex items-center justify-center gap-2.5 rounded-xl bg-[#D93A3F] px-4 text-xs font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.25)] transition hover:brightness-110">
      <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.5 8.5L20.5 12l-5 3.5v-2.2H9v-2.6h6.5V8.5z"/></svg>
      <span class="sb-label">Log Out</span>
    </button>
  </aside>

  <!-- ===================== KONTEN ===================== -->
  <div id="content" class="min-h-screen">
    <header class="sticky top-0 z-30 bg-white px-4 py-4 shadow-sm sm:px-6 lg:px-10 lg:shadow-none">
      <h1 class="text-lg font-semibold text-navy lg:text-[20px]">Beranda</h1>
      <p class="text-[11px] text-black sm:text-xs lg:text-[13px]">Kelola data peserta magang, pantau presensi, dan kelola tampilan di sini.</p>
    </header>

    <main class="flex flex-col gap-5 px-4 pb-10 pt-5 sm:px-6 lg:px-10 lg:pt-7">

      <!-- Banner -->
      <section class="rounded-2xl bg-gradient-to-r from-[#1B5A9C] via-[#12385F] to-[#0A2441] px-6 py-6 text-white shadow-[0_4px_10px_rgba(0,0,0,0.2)] lg:px-8">
        <h2 class="text-xl font-semibold lg:text-[24px]">Selamat Datang, <span id="adminName">SuperAdmin</span>!</h2>
        <p class="mt-1 text-xs leading-relaxed lg:text-[14px]">Pantau seluruh aktivitas kehadiran peserta magang serta kelola tampilan ICONNET.</p>
      </section>

      <!-- Statistik -->
      <section class="grid grid-cols-2 gap-3 lg:grid-cols-4 lg:gap-6">
        <div class="rounded-xl bg-white p-3.5 shadow-[0_2px_8px_rgba(0,0,0,0.2)]">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[13px] font-semibold">Total peserta</p>
              <p id="sTotal" class="mt-1 text-2xl font-medium">0</p>
            </div>
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#B6EDF6]"><svg class="h-5 w-5 text-[#0F86CC]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.2"/><path d="M3 19c.6-3 2.800-4.600 6-4.600s5.400 1.600 6 4.600"/><circle cx="17" cy="9" r="2.4"/><path d="M17 14.200c2.200 0 3.700 1.200 4.200 3.800"/></svg></span>
          </div>
          <p class="mt-1 text-[10px] text-slate-500">Terdaftar di sistem presensi</p>
        </div>
        <div class="rounded-xl bg-white p-3.5 shadow-[0_2px_8px_rgba(0,0,0,0.2)]">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[13px] font-semibold">Hadir</p>
              <p id="sHadir" class="mt-1 text-2xl font-medium">0</p>
            </div>
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#C9F7C5]"><svg class="h-5 w-5 text-[#2E9E3F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M7.800 12.300l2.800 2.800 5.600-5.800"/></svg></span>
          </div>
          <p class="mt-1 text-[10px] text-slate-500">Presensi tepat waktu</p>
        </div>
        <div class="rounded-xl bg-white p-3.5 shadow-[0_2px_8px_rgba(0,0,0,0.2)]">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[13px] font-semibold">Terlambat</p>
              <p id="sLate" class="mt-1 text-2xl font-medium">0</p>
            </div>
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#FFDDBF]"><svg class="h-5 w-5 text-[#E0780A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="13" r="7"/><path d="M12 9.500V13l2.300 1.500M4 6l3-2.500M20 6l-3-2.500"/></svg></span>
          </div>
          <p class="mt-1 text-[10px] text-slate-500">Presensi di atas 08:00 WITA</p>
        </div>
        <div class="rounded-xl bg-white p-3.5 shadow-[0_2px_8px_rgba(0,0,0,0.2)]">
          <div class="flex items-start justify-between">
            <div>
              <p class="text-[13px] font-semibold">Tidak Hadir</p>
              <p id="sAbsent" class="mt-1 text-2xl font-medium">0</p>
            </div>
            <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#FBB6B8]"><svg class="h-5 w-5 text-[#D93A3F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="10" cy="8" r="3.2"/><path d="M3.500 19c.6-3 2.800-4.600 6.500-4.600M15.500 15.500l5 5M20.500 15.500l-5 5"/></svg></span>
          </div>
          <p class="mt-1 text-[10px] text-slate-500">Izin / Sakit</p>
        </div>
      </section>

      <!-- Data Presensi Hari Ini -->
      <section class="rounded-2xl bg-white p-4 shadow-[0_3px_12px_rgba(0,0,0,0.2)] sm:p-5">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
          <h2 class="text-[15px] font-semibold">Data Presensi Hari Ini</h2>
          <p id="todayTxt" class="text-[13px] font-medium"></p>
        </div>

        <div id="list" class="mt-4 flex flex-col gap-4"></div>
        <div id="empty" class="hidden py-12 text-center text-xs text-slate-500">Belum ada peserta yang melakukan presensi hari ini.</div>

        <div id="pg" class="mt-4 flex flex-wrap items-center justify-center gap-1.5 border-t border-[#E9E9E9] pt-3 sm:justify-end"></div>
      </section>
    </main>
  </div>

  <!-- ===================== POPUP DETAIL ===================== -->
  <div id="dModal" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/40 px-4 lg:pl-[var(--sbw)]">
    <div class="max-h-[92vh] w-full max-w-[456px] overflow-y-auto rounded-[22px] bg-white shadow-[0_10px_30px_rgba(0,0,0,0.3)]" role="dialog" aria-modal="true" aria-labelledby="dmT">
      <div class="flex h-[53px] items-center gap-3 bg-[#0A2441] px-4">
        <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-[#D9D9D9]">
          <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
        </span>
        <h3 id="dmT" class="text-[15px] font-semibold text-white">Detail Data</h3>
      </div>
      <div class="px-5 pb-4 pt-4">
        <div class="flex items-center gap-3 rounded-xl border border-slate-200 bg-[#F7F9FD] px-4 py-3">
          <span class="flex h-8 w-8 flex-none items-center justify-center overflow-hidden rounded-full bg-[#9A9A9A]">
            <svg class="h-6 w-6 translate-y-1 text-white" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="8" r="4.500"/><path d="M3.500 22c0-4.700 3.800-7.500 8.500-7.500s8.500 2.800 8.500 7.500z"/></svg>
          </span>
          <div class="min-w-0">
            <p id="dNama" class="truncate text-[14px] font-semibold"></p>
            <p id="dSekolah" class="truncate text-[12px] text-slate-700"></p>
          </div>
        </div>

        <!-- Foto: 1 kartu bila baru absen masuk, 2 kartu bila sudah pulang -->
        <div id="dPhotos" class="mt-4 flex justify-center gap-4"></div>

        <div id="dInfo" class="mt-4 overflow-hidden rounded-[10px] border border-[#E5E7EB]"></div>
      </div>
      <div class="flex justify-center border-t border-[#E5E7EB] py-3">
        <button id="dClose" type="button" class="h-9 w-24 rounded-lg bg-[#EDEDED] text-[14px] font-medium text-black shadow-[0_3px_5px_rgba(0,0,0,0.2)] transition hover:bg-[#E2E2E2] active:scale-[.98]">Tutup</button>
      </div>
    </div>
  </div>

  <script>
    /* =====================================================================
       Sumber data (sama dengan halaman user - Presensi / Beranda):
       - 'iconnet_session'    : { email, nama, role? }
       - 'iconnet_users'      : [{ email, nama, sekolah, role? }]
       - 'iconnet_attendance' : [{ email, date, masuk, pulang, status, fotoMasuk?, fotoPulang? }]
       Setiap user absen -> 'iconnet_attendance' berubah -> halaman ini ikut terbarui
       (event 'storage' antar tab + polling ringan).
       ===================================================================== */
    const TZ = 'Asia/Makassar';
    const PER_PAGE = 5;
    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const esc = s => String(s == null ? '' : s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const session = read('iconnet_session', null) || {};

    const todayKey = () => new Intl.DateTimeFormat('en-CA', { timeZone: TZ }).format(new Date());
    const fmtDate = iso => { const m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(iso || ''); return m ? m[3] + '-' + m[2] + '-' + m[1] : '-'; };
    const fmtFull = t => t ? t + ' WITA' : '-';                                   // 07:42:15 WITA
    const fmtShort = t => { const m = /^(\d{1,2})[:.](\d{2})/.exec(t || ''); return m ? m[1].padStart(2, '0') + '.' + m[2] : '-'; }; // 07.45
    function longDate() {
      const p = Object.fromEntries(new Intl.DateTimeFormat('id-ID', { timeZone: TZ, weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).formatToParts(new Date()).map(x => [x.type, x.value]));
      return p.weekday + ', ' + p.day + ' ' + p.month + ', ' + p.year;
    }

    const STATUS = { hadir: 'Hadir', terlambat: 'Terlambat', izin: 'Izin', sakit: 'Sakit' };
    const badge = (k, extra) => '<span class="st-b st-' + (STATUS[k] ? k : 'lain') + (extra ? ' ' + extra : '') + '">' + esc(STATUS[k] || k || '-') + '</span>';

    /* ---------- Data peserta ---------- */
    const isAdminRole = u => ['superadmin', 'admin'].includes(String(u.role || '').toLowerCase());
    const users = () => (read('iconnet_users', []) || []).filter(u => u && u.email);
    const participants = () => users().filter(u => !isAdminRole(u));
    function userOf(email) {
      const e = String(email || '').toLowerCase();
      return users().find(u => String(u.email).toLowerCase() === e) || { email, nama: email, sekolah: '-' };
    }

    // Baris presensi hari ini (gabungan data user absen + info peserta)
    function todayRows() {
      const d = todayKey();
      const rows = (read('iconnet_attendance', []) || [])
        .filter(r => r && r.date === d && r.email)
        .map(r => {
          const u = userOf(r.email);
          return {
            email: r.email, nama: u.nama || u.name || r.email, sekolah: u.sekolah || '-',
            date: r.date, masuk: r.masuk || '', pulang: r.pulang || '',
            fm: r.fotoMasuk || '', fp: r.fotoPulang || '',
            status: String(r.status || '').toLowerCase()
          };
        });
      // urut: yang terbaru absen di atas
      return rows.sort((a, b) => (b.pulang || b.masuk || '').localeCompare(a.pulang || a.masuk || ''));
    }

    let ROWS = [], view = [], page = 1, filter = '';

    function updateStats() {
      $('sTotal').textContent = participants().length;
      $('sHadir').textContent = ROWS.filter(r => r.status === 'hadir').length;
      $('sLate').textContent = ROWS.filter(r => r.status === 'terlambat').length;
      $('sAbsent').textContent = ROWS.filter(r => r.status === 'izin' || r.status === 'sakit').length;
    }

    function applyFilter() {
      view = ROWS.slice();
      render();
    }

    /* ---------- Render ---------- */
    const AVATAR = '<span class="flex h-7 w-7 flex-none items-center justify-center overflow-hidden rounded-full bg-[#D9D9D9]"><svg class="h-5 w-5 translate-y-0.5 text-[#7A7A7A]" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="8" r="4.500"/><path d="M3.500 22c0-4.700 3.800-7.500 8.500-7.500s8.500 2.800 8.500 7.500z"/></svg></span>';
    const EYE = '<svg class="h-4 w-4 flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';

    function card(r, i) {
      const leave = r.status === 'izin' || r.status === 'sakit';
      const jm = leave ? '-' : fmtFull(r.masuk);
      const jp = leave ? '-' : (r.pulang ? fmtFull(r.pulang) : 'Belum pulang');
      const lok = leave ? '-' : 'Kantor ICONNET';
      const cell = (l, v, cls) => '<div class="text-center"><p class="text-[11px] text-slate-600">' + l + '</p><div class="mt-1.5 text-[13px] font-medium ' + (cls || '') + '">' + v + '</div></div>';
      return '<article class="overflow-hidden rounded-xl bg-white shadow-[0_2px_8px_rgba(0,0,0,0.22)]">' +
        '<div class="flex items-center justify-between gap-3 bg-[#00B4D3] px-4 py-2.5 text-white">' +
          '<div class="flex min-w-0 items-center gap-2.5">' + AVATAR +
            '<div class="min-w-0"><p class="truncate text-[14px] font-semibold leading-tight">' + esc(r.nama) + '</p><p class="truncate text-[11px] leading-tight">' + esc(r.sekolah) + '</p></div></div>' +
          '<button type="button" data-view="' + i + '" class="inline-flex h-7 flex-none items-center justify-center gap-2 rounded-md bg-white px-4 text-[12px] font-medium text-black shadow-[0_2px_4px_rgba(0,0,0,0.2)] transition hover:bg-slate-100 active:scale-[.98]">' + EYE + 'Lihat</button>' +
        '</div>' +
        '<div class="grid grid-cols-2 gap-x-3 gap-y-4 px-4 py-4 sm:grid-cols-4">' +
          cell('Jam Masuk:', jm) + cell('Lokasi:', lok) + cell('Jam Pulang:', jp, !leave && !r.pulang ? 'text-slate-400' : '') +
          cell('Status:', badge(r.status)) +
        '</div></article>';
    }

    const CH_L = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5"><path d="M15 6l-6 6 6 6"/></svg>';
    const CH_R = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5"><path d="M9 6l6 6-6 6"/></svg>';
    function pager(pages) {
      let h = '<button type="button" class="pg-b pg-pill" data-p="prev"' + (page <= 1 ? ' disabled' : '') + '>' + CH_L + 'Sebelumnya</button>';
      let last = 0;
      for (let p = 1; p <= pages; p++) {
        if (!(p === 1 || p === pages || Math.abs(p - page) <= 1)) continue;
        if (p - last > 1) h += '<span class="px-0.5 text-[11px] text-slate-500">…</span>';
        h += '<button type="button" class="pg-b' + (p === page ? ' on' : '') + '" data-p="' + p + '">' + p + '</button>';
        last = p;
      }
      return h + '<button type="button" class="pg-b pg-pill" data-p="next"' + (page >= pages ? ' disabled' : '') + '>Selanjutnya' + CH_R + '</button>';
    }

    function render() {
      const total = view.length, pages = Math.max(1, Math.ceil(total / PER_PAGE));
      page = Math.min(Math.max(1, page), pages);
      const start = (page - 1) * PER_PAGE;
      $('list').innerHTML = view.slice(start, start + PER_PAGE).map((r, i) => card(r, start + i)).join('');
      $('empty').textContent = ROWS.length ? 'Tidak ada data yang sesuai pencarian / filter.' : 'Belum ada peserta yang melakukan presensi hari ini.';
      $('empty').classList.toggle('hidden', total > 0);
      $('pg').innerHTML = total ? pager(pages) : '';
    }
    $('pg').addEventListener('click', e => {
      const b = e.target.closest('[data-p]'); if (!b || b.disabled) return;
      const v = b.dataset.p;
      page = v === 'prev' ? page - 1 : v === 'next' ? page + 1 : parseInt(v, 10);
      render();
    });

    /* ---------- Popup detail ---------- */
    const dm = $('dModal');
    const photoCard = (title, src) =>
      '<div class="min-w-0 flex-1 rounded-xl border border-slate-200 bg-white p-2.5 shadow-[0_2px_6px_rgba(0,0,0,0.08)]' + '">' +
      '<p class="mb-1.5 text-center text-[12.5px] font-medium">' + esc(title) + '</p>' +
      (src ? '<img src="' + esc(src) + '" alt="' + esc(title) + '" class="block aspect-[4/3] w-full rounded-lg bg-slate-200 object-cover" />'
           : '<div class="flex aspect-[4/3] w-full items-center justify-center rounded-lg bg-slate-100 text-[11px] text-slate-500">Tidak ada foto</div>') + '</div>';
    const infoRow = (l, v) => '<div class="flex items-center justify-between gap-3 border-b border-[#E5E7EB] px-4 py-3 text-[13px] last:border-0"><span class="font-medium">' + l + '</span><span class="text-right">' + v + '</span></div>';

    function openDetail(i) {
      const r = view[i]; if (!r) return;
      const leave = r.status === 'izin' || r.status === 'sakit';
      const sudahPulang = !!r.pulang;
      let cards = '';
      if (!leave) {
        cards += photoCard('Jam Masuk (' + fmtShort(r.masuk) + ')', r.fm);
        if (sudahPulang) cards += photoCard('Jam Pulang (' + fmtShort(r.pulang) + ')', r.fp);   // belum pulang -> hanya 1 foto
      }
      $('dNama').textContent = r.nama; $('dSekolah').textContent = r.sekolah;
      $('dPhotos').innerHTML = cards;
      // 1 foto saja -> lebar setengah & di tengah, 2 foto -> berdampingan
      $('dPhotos').classList.toggle('hidden', !cards);
      $('dPhotos').firstElementChild && ($('dPhotos').firstElementChild.style.flex = sudahPulang ? '1 1 0' : '0 1 62%');
      let rows = infoRow('Tanggal', fmtDate(r.date));
      rows += infoRow('Waktu Presensi', leave ? '-' : (sudahPulang ? 'Semua Waktu' : 'Jam Masuk'));
      rows += infoRow('Status', badge(r.status, '!h-[22px] !min-w-[110px]'));
      $('dInfo').innerHTML = rows;
      dm.classList.remove('hidden'); dm.classList.add('flex');
    }
    function closeDetail() { dm.classList.add('hidden'); dm.classList.remove('flex'); }
    $('list').addEventListener('click', e => { const b = e.target.closest('[data-view]'); if (b) openDetail(parseInt(b.dataset.view, 10)); });
    $('dClose').addEventListener('click', closeDetail);
    dm.addEventListener('click', e => { if (e.target === dm) closeDetail(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDetail(); });

    /* ---------- Muat & sinkron data ---------- */
    let lastSig = '';
    function refresh(force) {
      const sig = JSON.stringify(read('iconnet_attendance', [])) + '|' + JSON.stringify(read('iconnet_users', []));
      if (!force && sig === lastSig) return;
      lastSig = sig;
      ROWS = todayRows();
      updateStats();
      applyFilter();
    }
    window.addEventListener('storage', e => { if (!e.key || e.key.startsWith('iconnet_')) refresh(); });
    window.addEventListener('iconnet:attendance-updated', () => refresh());
    // Ambil data presensi terbaru dari server secara berkala (peserta yang baru absen langsung muncul)
    setInterval(() => { if (!document.hidden) ICONNET_API.reload('beranda-superadmin').then(() => refresh()).catch(() => {}); }, 15000);

    /* ---------- Sidebar, menu, logout ---------- */
    $('adminName').textContent = session.nama || session.name || 'SuperAdmin';
    $('todayTxt').textContent = longDate();
    $('toggleBtn').addEventListener('click', () => {
      const c = document.body.classList.toggle('collapsed');
      localStorage.setItem('iconnet_sidebar', c ? '1' : '0');
    });
    $('kelolaBtn').addEventListener('click', () => {
      if (document.body.classList.contains('collapsed')) { document.body.classList.remove('collapsed'); localStorage.setItem('iconnet_sidebar', '0'); }
      $('subD').classList.toggle('open'); $('chevD').classList.toggle('open');
    });
    const mmenu = $('mmenu'), menuBtn = $('menuBtn');
    function setMenu(open) {
      mmenu.classList.toggle('hidden', !open);
      $('icoBurger').classList.toggle('hidden', open);
      $('icoClose').classList.toggle('hidden', !open);
      menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
    menuBtn.addEventListener('click', () => setMenu(mmenu.classList.contains('hidden')));
    document.addEventListener('click', e => { if (!$('mnav').contains(e.target)) setMenu(false); });
    window.matchMedia('(min-width:1024px)').addEventListener('change', () => setMenu(false));
    function logout() {
      if (!confirm('Yakin ingin keluar dari akun?')) return;
      ICONNET_API.logout();   // logout di server, lalu ke halaman login
    }
    $('logoutBtn').addEventListener('click', logout);
    $('logoutBtnM').addEventListener('click', logout);

    refresh(true);
  </script>
</body>
</html>
