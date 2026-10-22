<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    #toast { transition: opacity .3s ease, transform .3s ease; }
    .sb-div { display: none; }

    /* ===== DESKTOP / LAPTOP (>=1024px) =====
       Frame desain referensi 1110x790. calc(var(--u) * 1) = 1px pada frame desain.
       --u mengecil otomatis mengikuti lebar/tinggi layar, sehingga semua konten
       selalu muat 1 layar (tanpa scroll). */
    @media (min-width: 1024px) {
      :root { --u: max(min(100vw / 1110, 100vh / 790), 0.6px); --su: max(min(100vw / 1110, 100vh / 790), 0.6px); --sbw: calc(var(--su) * 198); }
      .collapsed { --sbw: 76px; }
      html, body { overflow: hidden; }

      /* Strip putih di belakang sidebar -> header tidak terlihat terpotong di sudut sidebar */
      body .hdr-bg { position: fixed; top: 0; left: 0; right: 0; z-index: 0; height: calc(var(--u) * 87); background: #FFFFFF; }

      /* Sidebar */
      #sidebar { width: var(--sbw); padding: calc(var(--su) * 36) calc(var(--su) * 17) calc(var(--su) * 48); border-radius: 0 calc(var(--su) * 28) calc(var(--su) * 28) 0; }
      .collapsed .sb-label { display: none; }
      .collapsed .sb-item { justify-content: center; padding-left: 0 !important; padding-right: 0 !important; }
      .collapsed #toggleBtn svg { transform: rotate(180deg); }
      .collapsed .sb-div { display: none !important; }
      body .sb-row { height: calc(var(--su) * 104); }
      body .logo-img { height: calc(var(--su) * 104); width: calc(var(--su) * 104); object-fit: contain; }
      body .sb-div { display: block; height: 1px; width: calc(var(--su) * 125); margin: calc(var(--su) * 6) auto 0; background: #E8EAF0; }
      body #toggleBtn { width: calc(var(--su) * 17); height: calc(var(--su) * 17); right: calc(var(--su) * -25.5); }
      body #toggleBtn svg { width: calc(var(--su) * 9); height: calc(var(--su) * 9); }
      body .sb-nav { margin-top: calc(var(--su) * 12); gap: calc(var(--su) * 12); }
      body .sb-item { height: calc(var(--su) * 44); padding: 0 calc(var(--su) * 17); gap: calc(var(--su) * 12); font-size: calc(var(--su) * 11.5); border-radius: calc(var(--su) * 9); }
      body .sb-item svg { width: calc(var(--su) * 18); height: calc(var(--su) * 18); }
      body #logoutBtn { height: calc(var(--su) * 44); font-size: calc(var(--su) * 13); gap: calc(var(--su) * 12); border-radius: calc(var(--su) * 10); }
      body #logoutBtn svg { width: calc(var(--su) * 22); height: calc(var(--su) * 22); }

      /* Konten */
      #content { margin-left: var(--sbw); height: 100vh; overflow-y: auto; scrollbar-width: none; }
      #content::-webkit-scrollbar { display: none; }

      /* Header: putih, melebar penuh sampai sidebar */
      body .hdr { height: calc(var(--u) * 87); padding: 0 calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body .hdr-t { font-size: calc(var(--u) * 19); line-height: 1.25; font-weight: 600; color: #03045E; }
      body .hdr-s { font-size: calc(var(--u) * 13); line-height: 1.4; margin-top: calc(var(--u) * 2); color: #000; }

      body .main-c { padding: calc(var(--u) * 31) calc(var(--u) * 38) calc(var(--u) * 40) calc(var(--u) * 40); gap: 0; }

      /* Banner 834x128 */
      body .ban { height: calc(var(--u) * 128); padding: 0 calc(var(--u) * 30); border-radius: calc(var(--u) * 8); display: flex; flex-direction: column; justify-content: center; }
      body .ban-t { font-size: calc(var(--u) * 26); line-height: 1.25; }
      body .ban-s { font-size: calc(var(--u) * 14); line-height: 1.45; margin-top: calc(var(--u) * 8); max-width: none; }

      /* Kartu statistik 194x97 */
      body .main-c > .stats { margin-top: calc(var(--u) * 34); }
      body .stats { gap: calc(var(--u) * 19); }
      body .stat { height: calc(var(--u) * 97); padding: 0 calc(var(--u) * 12) 0 calc(var(--u) * 11); border-radius: calc(var(--u) * 8); align-items: center; }
      body .stat > div:first-child { align-self: flex-start; padding-top: calc(var(--u) * 5); }
      body .stat-l { font-size: calc(var(--u) * 15); line-height: calc(var(--u) * 20); }
      body .stat-n { font-size: calc(var(--u) * 17); line-height: calc(var(--u) * 20); margin-top: calc(var(--u) * 15); }
      body .stat-s { font-size: calc(var(--u) * 10); line-height: calc(var(--u) * 14); margin-top: calc(var(--u) * 9); }
      body .stat-i { width: calc(var(--u) * 48); height: calc(var(--u) * 48); border-radius: calc(var(--u) * 9); }
      body .stat-i svg { width: calc(var(--u) * 22); height: calc(var(--u) * 22); }

      /* Panel status presensi 833x217 */
      body .main-c > .panel { margin-top: calc(var(--u) * 37); }
      body .panel { border-radius: calc(var(--u) * 8); margin-left: calc(var(--u) * -4); margin-right: calc(var(--u) * 4); }
      body .panel-h { height: calc(var(--u) * 41); padding: 0 calc(var(--u) * 13); gap: calc(var(--u) * 8); flex-wrap: nowrap; }
      body .panel-h svg { width: calc(var(--u) * 16); height: calc(var(--u) * 16); }
      body .panel-t { font-size: calc(var(--u) * 12); }
      body .panel-d { font-size: calc(var(--u) * 10); }
      body .pgrid { grid-template-columns: 1fr 1fr; padding: calc(var(--u) * 19) calc(var(--u) * 38) calc(var(--u) * 24); column-gap: calc(var(--u) * 43); row-gap: 0; }
      body .pcard { height: calc(var(--u) * 133); padding: calc(var(--u) * 13) calc(var(--u) * 8) 0; border-radius: calc(var(--u) * 4); display: flex; flex-direction: column; }
      body .pc-top { padding: 0 calc(var(--u) * 8); flex: 1; }
      body .pc-l { font-size: calc(var(--u) * 11); line-height: calc(var(--u) * 16); letter-spacing: .02em; }
      body .pc-t { font-size: calc(var(--u) * 16); line-height: calc(var(--u) * 24); margin-top: calc(var(--u) * 25); }
      body .pc-i { width: calc(var(--u) * 48); height: calc(var(--u) * 48); border-radius: calc(var(--u) * 9); margin-top: calc(var(--u) * 2); }
      body .pc-i svg { width: calc(var(--u) * 22); height: calc(var(--u) * 22); }
      body .pc-s { font-size: calc(var(--u) * 10); margin: 0; padding: 0; height: calc(var(--u) * 30); line-height: calc(var(--u) * 30); }

      /* Ketentuan presensi 834x73 */
      body .main-c > .ket { margin-top: calc(var(--u) * 38); }
      body .ket { height: calc(var(--u) * 73); padding: 0 calc(var(--u) * 24); gap: calc(var(--u) * 28); border-radius: calc(var(--u) * 6); align-items: center; margin-left: calc(var(--u) * -4); margin-right: calc(var(--u) * 4); }
      body .ket-i { width: calc(var(--u) * 20); height: calc(var(--u) * 20); margin-top: 0; }
      body .ket-t { font-size: calc(var(--u) * 14); line-height: 1.3; }
      body .ket-p { font-size: calc(var(--u) * 11); line-height: 1.7; margin-top: calc(var(--u) * 2); }
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/dashboard.config.js -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
</head>

<body class="bg-[#F7F7FD] font-sans text-black antialiased">
  <script>
    // Guard: wajib login dan khusus role peserta (user). Belum login -> halaman login;
    // role lain -> beranda sesuai role-nya (role kosong dianggap 'user', sama seperti login.html).
    (function () {
      let s = null;
      s = ICONNET_API.read('iconnet_session', null);   // sesi dari server (Laravel)
      if (!s || !s.email) { location.replace('{{ url('login') }}'); return; }
      const role = String(s.role || 'user').toLowerCase().replace(/[\s_]/g, '');
      if (role !== 'user') { location.replace(role === 'superadmin' ? '{{ url('beranda-superadmin') }}' : role === 'admin' ? '{{ url('beranda-admin') }}' : '{{ url('beranda') }}'); return; }
      if (localStorage.getItem('iconnet_sidebar') === '1') document.body.classList.add('collapsed');
    })();
  </script>

  <!-- ===================== TOAST ===================== -->
  <div id="toast" class="pointer-events-none fixed left-1/2 top-4 z-[70] -translate-x-1/2 -translate-y-4 opacity-0 lg:left-auto lg:right-6 lg:translate-x-0" role="status" aria-live="polite">
    <div class="flex items-center gap-2.5 rounded-xl border border-green-200 bg-white px-4 py-2.5 shadow-[0_6px_20px_rgba(0,0,0,0.18)]">
      <span class="flex h-6 w-6 items-center justify-center rounded-full bg-green-500">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.500l4.500 4.500L19 7.500"/></svg>
      </span>
      <span id="toastText" class="text-xs font-medium sm:text-sm">Login Berhasil</span>
    </div>
  </div>

  <!-- ===================== NAVBAR MOBILE (hamburger menu) ===================== -->
  <nav id="mnav" class="sticky top-0 z-50 lg:hidden">
    <div class="flex h-16 items-center justify-between bg-white px-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
      <a href="{{ url('beranda') }}" class="block">
        <img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="block h-12 w-auto" />
      </a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-[#03045E] transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 text-[13px] font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>Beranda</a>
        <a href="{{ url('absensi') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg>Presensi</a>
        <a href="{{ url('riwayat') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg>Riwayat</a>
        <a href="{{ url('profil') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>Profil</a>
      </div>
      <div class="my-3 h-px bg-[#E8EAF0]"></div>
      <button id="logoutBtnM" type="button" class="flex h-11 w-full items-center justify-center gap-2.5 rounded-xl bg-[#D93A3F] px-4 text-[13px] font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.2)] transition hover:brightness-110">
        <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.500 8.500L20.500 12l-5 3.500v-2.200H9v-2.600h6.500V8.500z"/></svg>
        Log Out
      </button>
    </div>
  </nav>

  <!-- ===================== STRIP PUTIH HEADER (desktop) ===================== -->
  <div class="hdr-bg hidden lg:block"></div>

  <!-- ===================== SIDEBAR (desktop) ===================== -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 hidden flex-col rounded-r-[28px] bg-white px-3 pb-5 pt-6 shadow-[2px_0_14px_rgba(0,0,0,0.12)] lg:flex">
    <div class="sb-row relative flex h-12 items-center justify-center px-2">
      <a href="{{ url('beranda') }}" class="sb-label block"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="logo-img block h-9 w-auto" /></a>
      <button id="toggleBtn" type="button" aria-label="Ciutkan sidebar" class="absolute -right-[22px] top-1/2 flex h-[22px] w-[22px] -translate-y-1/2 items-center justify-center rounded-full bg-cyan2 shadow">
        <svg class="h-3 w-3 transition-transform" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
      </button>
    </div>
    <div class="sb-div"></div>

    <nav class="sb-nav mt-8 flex flex-col gap-2">
      <a href="{{ url('beranda') }}" class="sb-item flex items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 py-2.5 text-xs font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg><span class="sb-label">Beranda</span></a>
      <a href="{{ url('absensi') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg><span class="sb-label">Presensi</span></a>
      <a href="{{ url('riwayat') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg><span class="sb-label">Riwayat</span></a>
      <a href="{{ url('profil') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg><span class="sb-label">Profil</span></a>
    </nav>

    <button id="logoutBtn" type="button" class="sb-item mt-auto flex h-11 items-center justify-center gap-2.5 rounded-xl bg-[#D93A3F] px-4 text-xs font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.25)] transition hover:brightness-110">
      <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.500 8.500L20.500 12l-5 3.500v-2.200H9v-2.600h6.500V8.500z"/></svg>
      <span class="sb-label">Log Out</span>
    </button>
  </aside>

  <!-- ===================== KONTEN ===================== -->
  <div id="content" class="min-h-screen lg:min-h-0">
    <header class="hdr z-30 bg-white px-4 py-3.5 shadow-sm sm:px-6 lg:sticky lg:top-0 lg:flex lg:flex-col lg:justify-center lg:py-0 lg:shadow-none">
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Beranda</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Pantau kehadiran harian dan kelola data presensi magangmu di sini.</p>
    </header>

    <main class="main-c flex flex-col gap-4 px-4 pb-8 pt-4 sm:gap-5 sm:px-6">

      <section class="ban rounded-xl bg-gradient-to-r from-[#05052E] to-[#02B6D1] px-5 py-5 text-white shadow-[0_4px_10px_rgba(0,0,0,0.2)] sm:px-7 sm:py-6">
        <h2 class="ban-t text-base font-semibold leading-snug sm:text-xl">Selamat Datang, <span id="userName">Pengguna</span></h2>
        <p class="ban-s mt-1.5 max-w-[640px] text-[11px] leading-relaxed sm:mt-2 sm:text-sm">Pastikan kamu mencatat kehadiran harian melalui presensi selfie sesuai jadwal kerja yang berlaku.</p>
      </section>

      <section class="stats grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
        <article class="stat flex items-center justify-between rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_8px_rgba(0,0,0,0.15)] sm:px-4 sm:py-4">
          <div>
            <h3 class="stat-l text-xs font-semibold sm:text-sm">Hadir</h3>
            <p id="statHadir" class="stat-n mt-1 text-lg font-medium leading-none sm:text-xl">0</p>
            <p class="stat-s mt-1.5 text-[9px] text-slate-500 sm:text-[10px]">Bulan Ini</p>
          </div>
          <span class="stat-i flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-[#DBFBD7] sm:h-12 sm:w-12"><svg class="h-5 w-5 text-[#22A33A] sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M7.800 12.300l2.800 2.800 5.600-5.800"/></svg></span>
        </article>
        <article class="stat flex items-center justify-between rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_8px_rgba(0,0,0,0.15)] sm:px-4 sm:py-4">
          <div>
            <h3 class="stat-l text-xs font-semibold sm:text-sm">Terlambat</h3>
            <p id="statTerlambat" class="stat-n mt-1 text-lg font-medium leading-none sm:text-xl">0</p>
            <p class="stat-s mt-1.5 text-[9px] text-slate-500 sm:text-[10px]">Bulan Ini</p>
          </div>
          <span class="stat-i flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-[#FFD9C2] sm:h-12 sm:w-12"><svg class="h-5 w-5 text-[#F26B1D] sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="13" r="7.500"/><path d="M12 9v4.200l2.500 1.600M4 6.500l3-3M20 6.500l-3-3"/></svg></span>
        </article>
        <article class="stat flex items-center justify-between rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_8px_rgba(0,0,0,0.15)] sm:px-4 sm:py-4">
          <div>
            <h3 class="stat-l text-xs font-semibold sm:text-sm">Izin</h3>
            <p id="statIzin" class="stat-n mt-1 text-lg font-medium leading-none sm:text-xl">0</p>
            <p class="stat-s mt-1.5 text-[9px] text-slate-500 sm:text-[10px]">Bulan Ini</p>
          </div>
          <span class="stat-i flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-[#D4F1FB] sm:h-12 sm:w-12"><svg class="h-5 w-5 text-[#1B8FC4] sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="2.500"/><path d="M8.500 8h7M8.500 12h7M8.500 16h4.500"/></svg></span>
        </article>
        <article class="stat flex items-center justify-between rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_8px_rgba(0,0,0,0.15)] sm:px-4 sm:py-4">
          <div>
            <h3 class="stat-l text-xs font-semibold sm:text-sm">Sakit</h3>
            <p id="statSakit" class="stat-n mt-1 text-lg font-medium leading-none sm:text-xl">0</p>
            <p class="stat-s mt-1.5 text-[9px] text-slate-500 sm:text-[10px]">Bulan Ini</p>
          </div>
          <span class="stat-i flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-[#FFE6BE] sm:h-12 sm:w-12"><svg class="h-5 w-5 text-[#F59A0C] sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 14.800V5a2 2 0 10-4 0v9.800a4 4 0 104 0z"/><path d="M12 9v7.500"/></svg></span>
        </article>
      </section>

      <section class="panel overflow-hidden rounded-xl bg-white shadow-[0_2px_8px_rgba(0,0,0,0.15)]">
        <div class="panel-h flex flex-wrap items-center gap-x-2 gap-y-0.5 border-b border-slate-200 px-4 py-3 sm:px-5">
          <svg class="h-4 w-4 flex-none text-[#1D62A8] sm:h-[18px] sm:w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4.500" width="18" height="16.500" rx="2.500"/><path d="M3 10h18M8 2.500v4M16 2.500v4"/></svg>
          <h3 class="panel-t text-xs font-semibold sm:text-sm">Status Presensi Hari Ini</h3>
          <span class="panel-d text-[10px] text-slate-600 sm:text-[11px]">• <time id="todayLabel"></time></span>
        </div>
        <div class="pgrid grid gap-3 px-4 py-4 sm:grid-cols-2 sm:gap-6 sm:px-6 sm:py-6">
          <div id="cardMasuk" class="pcard rounded-lg border px-4 pb-0 pt-3.5 shadow-[0_1px_4px_rgba(0,0,0,0.1)] sm:px-5 sm:pt-4">
            <div class="pc-top flex items-start justify-between gap-3">
              <div class="min-w-0">
                <p class="pc-l text-[10px] font-semibold uppercase tracking-wide text-slate-600 sm:text-[11px]">Presensi Masuk</p>
                <p id="masukTime" class="pc-t mt-3 text-base font-medium sm:mt-5 sm:text-lg">--:--:-- WITA</p>
              </div>
              <span id="masukIcon" class="pc-i flex h-9 w-9 flex-none items-center justify-center rounded-lg sm:h-10 sm:w-10"></span>
            </div>
            <p class="pc-s mt-3 border-t border-slate-300/70 py-2 text-[9px] text-slate-700 sm:mt-4 sm:text-[10px]">Jadwal Masuk 08.00 WITA</p>
          </div>
          <div id="cardPulang" class="pcard rounded-lg border px-4 pb-0 pt-3.5 shadow-[0_1px_4px_rgba(0,0,0,0.1)] sm:px-5 sm:pt-4">
            <div class="pc-top flex items-start justify-between gap-3">
              <div class="min-w-0">
                <p class="pc-l text-[10px] font-semibold uppercase tracking-wide text-slate-600 sm:text-[11px]">Presensi Pulang</p>
                <p id="pulangTime" class="pc-t mt-3 text-base font-medium sm:mt-5 sm:text-lg">--:--:-- WITA</p>
              </div>
              <span id="pulangIcon" class="pc-i flex h-9 w-9 flex-none items-center justify-center rounded-lg sm:h-10 sm:w-10"></span>
            </div>
            <p class="pc-s mt-3 border-t border-slate-300/70 py-2 text-[9px] text-slate-700 sm:mt-4 sm:text-[10px]">Jadwal Pulang 17.00 WITA</p>
          </div>
        </div>
      </section>

      <section class="ket flex items-start gap-3 rounded-xl border border-slate-300 bg-[#FBF5F0] px-4 py-3.5 shadow-[0_2px_6px_rgba(0,0,0,0.12)] sm:gap-4 sm:px-5 sm:py-4">
        <svg class="ket-i mt-0.5 h-4 w-4 flex-none text-[#EA8A12] sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"><circle cx="12" cy="12" r="9"/><path d="M12 11v5.500"/><circle cx="12" cy="7.800" r=".7" fill="currentColor"/></svg>
        <div>
          <h3 class="ket-t text-xs font-semibold sm:text-sm">Ketentuan Presensi</h3>
          <p class="ket-p mt-1 text-[10px] leading-relaxed text-slate-700 sm:text-xs">Aktifkan akses kamera perangkatmu. Ambil foto di tempat yang terang dengan posisi wajah terlihat jelas tanpa terhalang kacamata hitam atau penutup wajah.</p>
        </div>
      </section>
    </main>
  </div>

  <script>
    /* =====================================================================
       KONTRAK DATA (dipakai bersama menu Presensi & Riwayat)
       - localStorage 'iconnet_session'    : { email, nama }
       - localStorage 'iconnet_attendance' : array of
           { email, date: 'YYYY-MM-DD' (zona WITA), masuk: 'HH:mm:ss' | null,
             pulang: 'HH:mm:ss' | null, status: 'hadir' | 'terlambat' | 'izin' | 'sakit' }
         Halaman Presensi cukup menyimpan/mengubah record hari ini lalu memanggil:
           window.dispatchEvent(new Event('iconnet:attendance-updated'))
         (tab lain otomatis lewat event 'storage'). Beranda akan ikut berubah.
       ===================================================================== */
    const TZ = 'Asia/Makassar';
    const JAM_MASUK = ICONNET_API.jamMasuk;   // jam masuk standar dari pengaturan server
    const svg = (c, d) => '<svg class="h-5 w-5 ' + c + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + d + '</svg>';
    const ICO = {
      check: svg('text-[#22A33A]', '<circle cx="12" cy="12" r="9"/><path d="M7.800 12.300l2.800 2.800 5.600-5.800"/>'),
      clock: svg('text-[#1D62A8]', '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.200 2"/>'),
      late:  svg('text-[#F26B1D]', '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.200 2"/>'),
      doc:   svg('text-[#1B8FC4]', '<rect x="5" y="3" width="14" height="18" rx="2.500"/><path d="M8.500 8h7M8.500 12h7M8.500 16h4.500"/>'),
      temp:  svg('text-[#F59A0C]', '<path d="M14 14.800V5a2 2 0 10-4 0v9.800a4 4 0 104 0z"/><path d="M12 9v7.500"/>')
    };
    const CARD = 'pcard rounded-lg border px-4 pb-0 pt-3.5 shadow-[0_1px_4px_rgba(0,0,0,0.1)] sm:px-5 sm:pt-4 ';
    const ICON = 'pc-i flex h-9 w-9 flex-none items-center justify-center rounded-lg sm:h-10 sm:w-10 ';
    const TONE = {
      done:    { card: 'border-[#CDEFDD] bg-[#F4FCF8]', icon: 'bg-[#DBFBD7]' },
      late:    { card: 'border-[#FFD9C2] bg-[#FFF8F3]', icon: 'bg-[#FFD9C2]' },
      izin:    { card: 'border-slate-200 bg-white',     icon: 'bg-[#D4F1FB]' },
      sakit:   { card: 'border-slate-200 bg-white',     icon: 'bg-[#FFE6BE]' },
      pending: { card: 'border-slate-200 bg-white',     icon: 'bg-[#E4E9F0]' }
    };

    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const todayKey = () => new Intl.DateTimeFormat('en-CA', { timeZone: TZ }).format(new Date()); // YYYY-MM-DD
    const session = read('iconnet_session', null);
    const $ = id => document.getElementById(id);

    function statusOf(r) {
      if (r.status) return r.status;
      if (!r.masuk) return null;
      return r.masuk > JAM_MASUK ? 'terlambat' : 'hadir';
    }
    function paint(cardId, iconId, timeId, tone, icon, text) {
      $(cardId).className = CARD + TONE[tone].card;
      $(iconId).className = ICON + TONE[tone].icon;
      $(iconId).innerHTML = icon;
      $(timeId).textContent = text;
    }

    function render() {
      const email = session && session.email;
      const all = read('iconnet_attendance', []).filter(r => r.email === email);
      const today = todayKey();
      const month = today.slice(0, 7);

      // Statistik bulan ini
      const cnt = { hadir: 0, terlambat: 0, izin: 0, sakit: 0 };
      all.filter(r => r.date && r.date.startsWith(month)).forEach(r => { const s = statusOf(r); if (s in cnt) cnt[s]++; });
      $('statHadir').textContent = cnt.hadir;
      $('statTerlambat').textContent = cnt.terlambat;
      $('statIzin').textContent = cnt.izin;
      $('statSakit').textContent = cnt.sakit;

      // Status hari ini
      const rec = all.find(r => r.date === today);
      const st = rec ? statusOf(rec) : null;

      if (rec && rec.masuk)            paint('cardMasuk', 'masukIcon', 'masukTime', st === 'terlambat' ? 'late' : 'done', st === 'terlambat' ? ICO.late : ICO.check, rec.masuk + ' WITA');
      else if (st === 'izin')          paint('cardMasuk', 'masukIcon', 'masukTime', 'izin', ICO.doc, 'Izin');
      else if (st === 'sakit')         paint('cardMasuk', 'masukIcon', 'masukTime', 'sakit', ICO.temp, 'Sakit');
      else                             paint('cardMasuk', 'masukIcon', 'masukTime', 'pending', ICO.clock, '--:--:-- WITA');

      if (rec && rec.pulang)           paint('cardPulang', 'pulangIcon', 'pulangTime', 'done', ICO.check, rec.pulang + ' WITA');
      else                             paint('cardPulang', 'pulangIcon', 'pulangTime', 'pending', ICO.clock, '--:--:-- WITA');
    }

    // Nama & tanggal
    $('userName').textContent = (session && session.nama) || 'Pengguna';
    const dateEl = $('todayLabel');
    dateEl.textContent = new Intl.DateTimeFormat('id-ID', { timeZone: TZ, weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).format(new Date());
    dateEl.dateTime = todayKey();

    render();
    window.addEventListener('storage', render);                       // perubahan dari tab lain
    window.addEventListener('iconnet:attendance-updated', render);    // perubahan di tab ini
    window.addEventListener('pageshow', render);                      // kembali dari halaman Presensi (back/forward)
    document.addEventListener('visibilitychange', () => { if (!document.hidden) render(); });
    window.addEventListener('focus', render);

    // Toast "Login Berhasil" (sekali tampil, hilang otomatis)
    (function () {
      const msg = sessionStorage.getItem('iconnet_toast');
      if (!msg) return;
      sessionStorage.removeItem('iconnet_toast');
      const toast = $('toast');
      $('toastText').textContent = msg;
      requestAnimationFrame(() => { toast.classList.remove('opacity-0', '-translate-y-4'); });
      setTimeout(() => { toast.classList.add('opacity-0', '-translate-y-4'); }, 3000);
    })();

    // Sidebar (desktop): ciutkan / lebarkan
    $('toggleBtn').addEventListener('click', () => {
      const c = document.body.classList.toggle('collapsed');
      localStorage.setItem('iconnet_sidebar', c ? '1' : '0');
    });

    // Hamburger menu (mobile)
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

    // Logout (desktop & mobile)
    function logout() {
      if (!confirm('Yakin ingin keluar dari akun?')) return;
      ICONNET_API.logout();   // logout di server, lalu ke halaman login
    }
    $('logoutBtn').addEventListener('click', logout);
    $('logoutBtnM').addEventListener('click', logout);
  </script>
</body>
</html>
