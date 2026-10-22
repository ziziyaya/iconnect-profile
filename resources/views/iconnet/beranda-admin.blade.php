<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda Admin - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    #toast { transition: opacity .3s ease, transform .3s ease; }

    /* Garis tipis pada kartu (sesuai desain) */
    .stat, .info, .prog { border: 1px solid #E3E6EC; }

    /* ===== DESKTOP / LAPTOP (>=1024px) =====
       Frame desain 1110 x 790.
       calc(var(--u) * N) = N px pada frame. --u mengecil/membesar otomatis
       mengikuti lebar/tinggi layar, jadi konten selalu muat 1 layar (tanpa scroll).
       Semua angka diukur dari gambar desain (1006 x 715) x 1.105 */
    @media (min-width: 1024px) {
      :root { --u: max(min(100vw / 1110, 100vh / 790), 0.6px); --sbw: calc(var(--u) * 196); }
      .collapsed { --sbw: 76px; }
      html, body { overflow: hidden; }

      /* Strip putih di belakang header */
      body .hdr-bg { position: fixed; top: 0; left: 0; right: 0; z-index: 0; height: calc(var(--u) * 88); background: #FFFFFF; }

      /* ---- Sidebar ---- */
      #sidebar { width: var(--sbw); padding: calc(var(--u) * 24) calc(var(--u) * 17) calc(var(--u) * 44); border-radius: 0 calc(var(--u) * 28) calc(var(--u) * 28) 0; box-shadow: 2px 0 6px rgba(0,0,0,0.14); }
      .collapsed #sidebar { padding-left: 12px; padding-right: 12px; }
      .collapsed .sb-label { display: none; }
      .collapsed .sb-item { justify-content: center; padding-left: 0 !important; padding-right: 0 !important; }
      .collapsed #toggleBtn svg { transform: rotate(180deg); }

      /* Area logo (logo diisi sendiri lewat images/logo-iconin.png) */
      body .sb-row { height: calc(var(--u) * 104); }
      body .logo-img { height: calc(var(--u) * 104); width: calc(var(--u) * 104); max-width: 100%; object-fit: contain; }
      body .sb-div { display: block; height: 1px; margin: calc(var(--u) * 19) 0 0; background: #ECEDF2; }
      .collapsed .sb-div { display: none; }

      /* Tombol ciut: tepat di tepi kanan sidebar */
      body #toggleBtn { position: absolute; top: calc(var(--u) * 53); right: calc(var(--u) * -9); width: calc(var(--u) * 18); height: calc(var(--u) * 18); }
      body #toggleBtn svg { width: calc(var(--u) * 9); height: calc(var(--u) * 9); }

      /* Menu */
      body .sb-nav { margin-top: calc(var(--u) * 6); gap: calc(var(--u) * 12); }
      body .sb-item { height: calc(var(--u) * 43); padding: 0 calc(var(--u) * 17); gap: calc(var(--u) * 14); font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 11); }
      body .sb-item svg { width: calc(var(--u) * 17); height: calc(var(--u) * 17); }

      /* Log Out: ikon + teks rata kiri */
      body #logoutBtn { height: calc(var(--u) * 44); padding: 0 calc(var(--u) * 17); gap: calc(var(--u) * 16); font-size: calc(var(--u) * 14); border-radius: calc(var(--u) * 11); justify-content: flex-start; }
      body #logoutBtn svg { width: calc(var(--u) * 20); height: calc(var(--u) * 20); }
      body.collapsed #logoutBtn { justify-content: center; }

      /* ---- Konten: tidak bisa di-scroll ---- */
      #content { margin-left: var(--sbw); height: 100vh; overflow: hidden; }

      body .hdr { height: calc(var(--u) * 88); padding: 0 calc(var(--u) * 40) 0 calc(var(--u) * 41); background-color: #FFFFFF; box-shadow: none; }
      body .hdr-t { font-size: calc(var(--u) * 19); line-height: 1.25; font-weight: 600; color: #000; }
      body .hdr-s { font-size: calc(var(--u) * 13); line-height: 1.4; margin-top: calc(var(--u) * 3); color: #000; }

      body .main-c { padding: calc(var(--u) * 34) calc(var(--u) * 39) 0 calc(var(--u) * 41); gap: 0; }

      /* Banner: tinggi 129 */
      body .ban { height: calc(var(--u) * 129); padding: 0 calc(var(--u) * 28); border-radius: calc(var(--u) * 13); display: flex; flex-direction: column; justify-content: center; }
      body .ban-t { font-size: calc(var(--u) * 27); line-height: 1.25; }
      body .ban-s { font-size: calc(var(--u) * 15.5); line-height: 1.45; margin-top: calc(var(--u) * 5); max-width: none; }

      /* Kartu statistik: tinggi 120, jarak antar kartu 18 */
      body .main-c > .stats { margin-top: calc(var(--u) * 35); }
      body .stats { gap: calc(var(--u) * 18); }
      body .stat { height: calc(var(--u) * 120); padding: calc(var(--u) * 10) calc(var(--u) * 15) 0; border-radius: calc(var(--u) * 10); display: block; position: relative; }
      body .stat-l { font-size: calc(var(--u) * 15); line-height: calc(var(--u) * 18); font-weight: 500; color: #000; }
      body .stat-n { font-size: calc(var(--u) * 25.5); line-height: calc(var(--u) * 30); margin-top: calc(var(--u) * 18); font-weight: 500; color: #000 !important; }
      body .stat-s { font-size: calc(var(--u) * 11.5); line-height: calc(var(--u) * 16); margin-top: calc(var(--u) * 14); font-weight: 400; color: #6B6B6B !important; }
      body .stat-i { position: absolute; top: calc(var(--u) * 41); right: calc(var(--u) * 19); width: calc(var(--u) * 36); height: calc(var(--u) * 36); border-radius: calc(var(--u) * 11); }
      body .stat-i svg { width: calc(var(--u) * 20); height: calc(var(--u) * 20); }

      /* Kartu info: tinggi 109 */
      body .main-c > .info { margin-top: calc(var(--u) * 35); }
      body .info { height: calc(var(--u) * 109); padding: calc(var(--u) * 19) calc(var(--u) * 16) 0 calc(var(--u) * 23); gap: calc(var(--u) * 11); border-radius: calc(var(--u) * 10); align-items: flex-start; }
      body .info-i { width: calc(var(--u) * 19); height: calc(var(--u) * 19); margin-top: calc(var(--u) * 2); }
      body .info-t { font-size: calc(var(--u) * 15); line-height: calc(var(--u) * 22); }
      body .info-p { font-size: calc(var(--u) * 14); line-height: calc(var(--u) * 21); margin-top: calc(var(--u) * 8); max-width: none; }

      /* Progress: tinggi 161 */
      body .main-c > .prog { margin-top: calc(var(--u) * 32); }
      body .prog { height: calc(var(--u) * 161); padding: calc(var(--u) * 19) calc(var(--u) * 34) 0; border-radius: calc(var(--u) * 10); }
      body .prog-t { font-size: calc(var(--u) * 15.5); line-height: calc(var(--u) * 22); }
      body .prog-s { font-size: calc(var(--u) * 11); line-height: calc(var(--u) * 16); margin-top: calc(var(--u) * 2); }
      body .bar { height: calc(var(--u) * 20); margin-top: calc(var(--u) * 23); border-radius: calc(var(--u) * 4); }
      body .lg-row { margin-top: calc(var(--u) * 21); gap: calc(var(--u) * 31); }
      body .lg-item { gap: calc(var(--u) * 7); }
      body .lg-dot { width: calc(var(--u) * 18.5); height: calc(var(--u) * 18.5); }
      body .lg-t { font-size: calc(var(--u) * 12); line-height: calc(var(--u) * 18); }
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/dashboard.config.js -->
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
</head>

<body class="bg-[#F9F8FE] font-sans text-black antialiased">
  <script>
    // Guard: wajib login dan khusus role admin. Belum login -> halaman login;
    // role lain -> beranda sesuai role-nya (role kosong dianggap 'user', sama seperti login.html).
    (function () {
      let s = null;
      s = ICONNET_API.read('iconnet_session', null);   // sesi dari server (Laravel)
      if (!s || !s.email) { location.replace('{{ url('login') }}'); return; }
      const role = String(s.role || 'user').toLowerCase().replace(/[\s_]/g, '');
      if (role !== 'admin') { location.replace(role === 'superadmin' ? '{{ url('beranda-superadmin') }}' : role === 'admin' ? '{{ url('beranda-admin') }}' : '{{ url('beranda') }}'); return; }
      if (localStorage.getItem('iconnet_sidebar') === '1') document.body.classList.add('collapsed');
    })();
  </script>

  <!-- ===================== TOAST LOGIN BERHASIL ===================== -->
  <div id="toast" class="pointer-events-none fixed left-1/2 top-4 z-[70] -translate-x-1/2 -translate-y-4 opacity-0 lg:left-auto lg:right-6 lg:translate-x-0" role="status" aria-live="polite">
    <div class="flex items-center gap-2.5 rounded-xl border border-green-200 bg-white px-4 py-2.5 shadow-[0_6px_20px_rgba(0,0,0,0.18)]">
      <span class="flex h-6 w-6 items-center justify-center rounded-full bg-green-500">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.500l4.500 4.500L19 7.500"/></svg>
      </span>
      <span id="toastText" class="text-xs font-medium sm:text-sm">Login Berhasil</span>
    </div>
  </div>

  <!-- ===================== NAVBAR MOBILE ===================== -->
  <nav id="mnav" class="sticky top-0 z-50 lg:hidden">
    <div class="flex h-16 items-center justify-between bg-white px-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
      <a href="{{ url('beranda-admin') }}" class="block">
        <img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="block h-12 w-auto" />
      </a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-[#03045E] transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda-admin') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#E1FAFF] px-3.5 text-[13px] font-medium text-[#1C1F20]">
          <svg class="h-[18px] w-[18px] flex-none text-[#1A1D6E]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>Beranda
        </a>
        <a href="{{ url('verifikasi-user') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-[#4B4B4B] transition hover:bg-slate-100">
          <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20.5c.5-3.6 3-5.8 6.5-5.8 1.6 0 3 .4 4.1 1.2"/><path d="M14.5 19.2l2 2 4-4.5"/></svg>Verifikasi User
        </a>
        <a href="{{ url('akun-user') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-[#4B4B4B] transition hover:bg-slate-100">
          <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.500"/><path d="M2.500 20c.4-3.600 3-5.800 6.500-5.800s6.100 2.200 6.500 5.800"/><path d="M15.500 4.700a3.500 3.500 0 010 6.600M18 14.600c2 .8 3.300 2.600 3.500 5.400"/></svg>Akun User
        </a>
        <a href="{{ url('profil-admin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-[#4B4B4B] transition hover:bg-slate-100">
          <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>Profil
        </a>
      </div>
      <div class="my-3 h-px bg-[#ECEDF2]"></div>
      <button id="logoutBtnM" type="button" class="flex h-11 w-full items-center justify-center gap-2.5 rounded-xl bg-[#D23739] px-4 text-[13px] font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.2)] transition hover:brightness-110">
        <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.500 8.500L20.500 12l-5 3.500v-2.200H9v-2.600h6.500V8.500z"/></svg>
        Log Out
      </button>
    </div>
  </nav>

  <!-- ===================== STRIP PUTIH HEADER (desktop) ===================== -->
  <div class="hdr-bg hidden lg:block"></div>

  <!-- ===================== SIDEBAR (desktop) ===================== -->
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 hidden flex-col rounded-r-[28px] bg-white lg:flex">
    <!-- Logo: isi sendiri di images/logo-iconin.png -->
    <div class="sb-row flex items-center justify-center">
      <a href="{{ url('beranda-admin') }}" class="sb-label block"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="logo-img block h-9 w-auto" /></a>
    </div>
    <button id="toggleBtn" type="button" aria-label="Ciutkan sidebar" class="absolute flex items-center justify-center rounded-full bg-cyan2 shadow">
      <svg class="transition-transform" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
    </button>
    <div class="sb-div"></div>

    <nav class="sb-nav flex flex-col">
      <!-- Beranda (aktif) -->
      <a href="{{ url('beranda-admin') }}" class="sb-item flex items-center rounded-xl bg-[#E1FAFF] text-xs font-medium text-[#1C1F20]">
        <svg class="flex-none text-[#1A1D6E]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>
        <span class="sb-label">Beranda</span>
      </a>
      <!-- Verifikasi User -->
      <a href="{{ url('verifikasi-user') }}" class="sb-item flex items-center rounded-xl text-xs text-[#4B4B4B] transition hover:bg-slate-100">
        <svg class="flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20.5c.5-3.6 3-5.8 6.5-5.8 1.6 0 3 .4 4.1 1.2"/><path d="M14.5 19.2l2 2 4-4.5"/></svg>
        <span class="sb-label">Verifikasi User</span>
      </a>
      <!-- Akun User -->
      <a href="{{ url('akun-user') }}" class="sb-item flex items-center rounded-xl text-xs text-[#4B4B4B] transition hover:bg-slate-100">
        <svg class="flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.500"/><path d="M2.500 20c.4-3.600 3-5.800 6.500-5.800s6.100 2.200 6.500 5.800"/><path d="M15.500 4.700a3.500 3.500 0 010 6.600M18 14.600c2 .8 3.300 2.600 3.500 5.400"/></svg>
        <span class="sb-label">Akun User</span>
      </a>
      <!-- Profile -->
      <a href="{{ url('profil-admin') }}" class="sb-item flex items-center rounded-xl text-xs text-[#4B4B4B] transition hover:bg-slate-100">
        <svg class="flex-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>
        <span class="sb-label">Profil</span>
      </a>
    </nav>

    <button id="logoutBtn" type="button" class="sb-item mt-auto flex items-center rounded-xl bg-[#D23739] text-xs font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.25)] transition hover:brightness-110">
      <svg class="flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.500 8.500L20.500 12l-5 3.500v-2.200H9v-2.600h6.500V8.500z"/></svg>
      <span class="sb-label">Log Out</span>
    </button>
  </aside>

  <!-- ===================== KONTEN ===================== -->
  <div id="content" class="min-h-screen lg:min-h-0">
    <header class="hdr z-30 bg-white px-4 py-3.5 shadow-sm sm:px-6 lg:sticky lg:top-0 lg:flex lg:flex-col lg:justify-center lg:py-0 lg:shadow-none">
      <h1 class="hdr-t text-lg font-semibold text-black">Beranda</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Ringkasan aktivitas dan data sistem.</p>
    </header>

    <main class="main-c flex flex-col gap-4 px-4 pb-8 pt-4 sm:gap-5 sm:px-6">

      <!-- Banner -->
      <section class="ban rounded-xl bg-[linear-gradient(90deg,#050730_0%,#035F81_51%,#01B4CF_100%)] px-5 py-5 text-white shadow-[0_3px_6px_rgba(0,0,0,0.22)] sm:px-7 sm:py-6">
        <h2 class="ban-t text-base font-semibold leading-snug sm:text-xl">Selamat Datang, <span id="adminName">Admin</span></h2>
        <p class="ban-s mt-1.5 text-[11px] leading-relaxed sm:mt-2 sm:text-sm">Periksa dan verifikasi akun pengguna yang telah terdaftar untuk memastikan keakuratan data.</p>
      </section>

      <!-- Statistik -->
      <section class="stats grid grid-cols-1 gap-3 sm:grid-cols-3 sm:gap-4">
        <!-- Menunggu Verifikasi -->
        <article class="stat relative rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_4px_rgba(0,0,0,0.12)] sm:px-4 sm:py-4">
          <h3 class="stat-l text-xs font-normal text-[#333] sm:text-[13px]">Menunggu Verifikasi</h3>
          <p id="statWait" class="stat-n mt-1 text-xl font-medium leading-none text-black sm:text-2xl">5</p>
          <p class="stat-s mt-2 text-[10px] font-medium text-[#D9941F] sm:text-[11px]">Perlu diperiksa untuk aktif absen</p>
          <span class="stat-i absolute right-3.5 top-3 flex h-7 w-7 items-center justify-center rounded-lg bg-[#FCE6C2]">
            <svg class="h-4 w-4 text-[#B8741A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.200 2"/></svg>
          </span>
        </article>

        <!-- Status Disetujui -->
        <article class="stat relative rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_4px_rgba(0,0,0,0.12)] sm:px-4 sm:py-4">
          <h3 class="stat-l text-xs font-normal text-[#333] sm:text-[13px]">Status Disetujui</h3>
          <p id="statOk" class="stat-n mt-1 text-xl font-medium leading-none text-[#2FA84F] sm:text-2xl">5</p>
          <p class="stat-s mt-2 text-[10px] font-medium text-[#2FA84F] sm:text-[11px]">Bisa akses &amp; dan kehadiran PKL</p>
          <span class="stat-i absolute right-3.5 top-3 flex h-7 w-7 items-center justify-center rounded-lg bg-[#DBFFD9]">
            <svg class="h-4 w-4 text-[#1E9A35]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M7.800 12.300l2.800 2.800 5.600-5.800"/></svg>
          </span>
        </article>

        <!-- Akun Ditolak -->
        <article class="stat relative rounded-xl bg-white px-3.5 py-3 shadow-[0_2px_4px_rgba(0,0,0,0.12)] sm:px-4 sm:py-4">
          <h3 class="stat-l text-xs font-normal text-[#333] sm:text-[13px]">Akun Ditolak</h3>
          <p id="statNo" class="stat-n mt-1 text-xl font-medium leading-none text-[#E03A3A] sm:text-2xl">5</p>
          <p class="stat-s mt-2 text-[10px] font-medium text-[#E03A3A] sm:text-[11px]">Tidak dapat login ke aplikasi absensi</p>
          <span class="stat-i absolute right-3.5 top-3 flex h-7 w-7 items-center justify-center rounded-lg bg-[#F1BBBF]">
            <svg class="h-4 w-4 text-[#C93035]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M9 9l6 6M15 9l-6 6"/></svg>
          </span>
        </article>
      </section>

      <!-- Info verifikasi -->
      <section class="info flex items-start gap-3 rounded-xl bg-white px-4 py-3.5 shadow-[0_2px_4px_rgba(0,0,0,0.12)] sm:gap-4 sm:px-5 sm:py-4">
        <svg class="info-i mt-0.5 h-4 w-4 flex-none text-[#1A1D6E] sm:h-5 sm:w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg>
        <div>
          <h3 class="info-t text-xs font-semibold sm:text-sm">Verifikasi Pendaftaran Peserta PKL</h3>
          <p class="info-p mt-1 text-[10px] leading-relaxed text-[#222] sm:text-xs">Silakan periksa kelengkapan data siswa, surat pengantar dari sekolah, dan periode magang yang diajukan<br class="hidden lg:block"> untuk memberikan persetujuan atau penolakan akun.</p>
        </div>
      </section>

      <!-- Progress -->
      <section class="prog rounded-xl bg-white px-4 py-4 shadow-[0_2px_4px_rgba(0,0,0,0.12)] sm:px-6">
        <h3 class="prog-t text-xs font-medium sm:text-sm">Progress Pemeriksaan Akun</h3>
        <p class="prog-s text-[10px] text-[#222]">Status Akun Terverifikasi</p>

        <div class="bar mt-3 flex h-3.5 overflow-hidden rounded-[4px]">
          <div id="barOk"   class="h-full bg-[#0BAC00]" style="width:48.7%"></div>
          <div id="barWait" class="h-full bg-[#FFB741]" style="width:49.4%"></div>
          <div id="barNo"   class="h-full bg-[#FF2B2B]" style="width:1.9%"></div>
        </div>

        <div class="lg-row mt-3 flex flex-wrap gap-x-5 gap-y-1.5">
          <div class="lg-item flex items-center gap-2"><span class="lg-dot h-3.5 w-3.5 rounded-full bg-[#0BAC00]"></span><span class="lg-t text-[10px] font-medium sm:text-[11px]">Disetujui</span></div>
          <div class="lg-item flex items-center gap-2"><span class="lg-dot h-3.5 w-3.5 rounded-full bg-[#FFB741]"></span><span class="lg-t text-[10px] font-medium sm:text-[11px]">Menunggu</span></div>
          <div class="lg-item flex items-center gap-2"><span class="lg-dot h-3.5 w-3.5 rounded-full bg-[#FF2B2B]"></span><span class="lg-t text-[10px] font-medium sm:text-[11px]">Ditolak</span></div>
        </div>
      </section>
    </main>
  </div>

  <script src="{{ asset('js/iconnet-data.js') }}"></script>
  <script>
    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)

    /* =====================================================================
       DATA STATISTIK: dihitung dari data yang sama dengan halaman Verifikasi User
       (iconnet-data.js -> ICONNET.counts()). Kartu ringkasan & progress bar
       otomatis berubah saat ada sign up baru, akun disetujui / ditolak, atau akun dihapus.
       ===================================================================== */
    function renderStats() {
      const c = ICONNET.counts();
      $('statWait').textContent = c.menunggu;
      $('statOk').textContent = c.disetujui;
      $('statNo').textContent = c.ditolak;
      const t = c.total;
      $('barOk').style.width   = (t ? c.disetujui / t * 100 : 0) + '%';
      $('barWait').style.width = (t ? c.menunggu  / t * 100 : 0) + '%';
      $('barNo').style.width   = (t ? c.ditolak   / t * 100 : 0) + '%';
    }
    /* Nama admin diambil dari akun login (localStorage 'iconnet_users'; cadangan 'iconnet_admins')
       yang cocok dengan email di 'iconnet_session', sama seperti profil-admin.html. */
    function renderAdminName() {
      const s = read('iconnet_session', null) || {}, email = String(s.email || '').toLowerCase();
      let u = null;
      for (const key of ['iconnet_users', 'iconnet_admins']) {
        const list = read(key, null);
        u = Array.isArray(list) ? list.find(a => a && String(a.email || '').toLowerCase() === email) : null;
        if (u) break;
      }
      const nama = (u && (u.nama || u.name || u.namaLengkap || u.fullName || u.fullname)) || s.nama;
      if (nama) $('adminName').textContent = nama;
    }
    renderAdminName();
    window.addEventListener('storage', renderAdminName);
    window.addEventListener('pageshow', renderAdminName);

    // Cek dulu: bila iconnet-data.js gagal dimuat, sisa script (toast, sidebar, menu, logout) tetap jalan
    if (typeof ICONNET !== 'undefined') {
      renderStats();
      ICONNET.onChange(renderStats);
    } else {
      console.error('iconnet-data.js belum dimuat: statistik tidak dapat dihitung.');
    }

    /* Toast "Login Berhasil" (sekali tampil, hilang otomatis).
       Di halaman login, setelah login sukses:
         sessionStorage.setItem('iconnet_toast', 'Login Berhasil');
       Untuk testing cepat: buka beranda-admin.html?login=success */
    (function () {
      let msg = sessionStorage.getItem('iconnet_toast');
      if (!msg && new URLSearchParams(location.search).get('login') === 'success') msg = 'Login Berhasil';
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
