<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profile SuperAdmin - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    #toast { transition: opacity .3s ease, transform .3s ease; }
    .sb-div { display: none; }

    /* Submenu Kelola Tampilan */
    .sb-sub { display: none; flex-direction: column; gap: 4px; padding-left: 38px; }
    .sb-sub.open { display: flex; }
    .sb-sub a { display: flex; align-items: center; height: 34px; border-radius: 8px; padding: 0 12px; font-size: 12px; color: #475569; transition: background .15s; }
    .sb-sub a:hover { background: #F1F5F9; }
    .chev { transition: transform .2s; }
    .chev.open { transform: rotate(180deg); }


    /* ===== Umum (mobile first) ===== */
    button { font-family: inherit; }
    .pf-box { min-height: 56px; }
    /* Mobile: kartu profil di tengah area konten (vertikal) */
    @media (max-width: 899px) {
      body #content { display: flex; flex-direction: column; min-height: calc(100vh - 64px); min-height: calc(100dvh - 64px); }
      body .main-c { flex: 1; justify-content: center; padding-top: 16px; padding-bottom: 16px; }
    }
    /* ===== DESKTOP / LAPTOP (>=900px) =====
       Frame desain laptop 1440x1024: kartu profil = 951x629 px pada ukuran itu.
       Angka di bawah ditulis dalam satuan --u (1 --u = 1px pada frame 1110x790);
       --u = 1.2939 di frame 1440x1024, sehingga kartu 735x486 --u menjadi 951x629 px.
       --u mengecil otomatis mengikuti lebar/tinggi layar, sehingga semua konten
       selalu muat 1 layar (tanpa scroll). */
    @media (min-width: 900px) {
      :root { --u: max(min(100vw / 1110, 100vh / 680), 0.6px); --su: max(min(100vw / 1110, 100vh / 790), 0.6px); --sbw: calc(var(--su) * 198); }
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

      /* Konten */
      #content { margin-left: var(--sbw); height: 100vh; overflow-y: auto; scrollbar-width: none; }
      #content::-webkit-scrollbar { display: none; }

      /* Header: putih, melebar penuh sampai sidebar */
      body .hdr { height: calc(var(--u) * 87); padding: 0 calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body .hdr-t { font-size: calc(var(--u) * 19); line-height: 1.25; font-weight: 600; color: #03045E; }
      body .hdr-s { font-size: calc(var(--u) * 13); line-height: 1.4; margin-top: calc(var(--u) * 2); color: #000; }


      /* ---- khusus Profil: disesuaikan dengan desain (frame 1110x790) ---- */
      body #content { overflow-x: hidden; overflow-y: auto; }
      body .main-c { padding: 0; align-items: center; justify-content: center; min-height: calc(100vh - var(--u) * 87); gap: 0; }

      /* Kartu profil 735x486 */
      body .pcard { width: min(calc((100vw - var(--sbw)) * 0.81), calc(var(--u) * 680)); max-width: none; height: auto; margin: 0 auto; border-radius: calc(var(--u) * 25); box-shadow: 0 calc(var(--u) * 4) calc(var(--u) * 14) rgba(0,0,0,.22); }
      body .pf-ban { height: calc(var(--u) * 94.5); padding: 0 calc(var(--u) * 23); gap: calc(var(--u) * 9); }
      body .pf-av { width: calc(var(--u) * 55); height: calc(var(--u) * 55); }
      body .pf-n { font-size: calc(var(--u) * 20); line-height: calc(var(--u) * 26); }
      body .pf-bd { margin-top: calc(var(--u) * 5); gap: calc(var(--u) * 7); flex-wrap: nowrap; }
      body .pf-b { height: calc(var(--u) * 22); padding: 0 calc(var(--u) * 12); font-size: calc(var(--u) * 11.5); line-height: 1; white-space: nowrap; }
      body .pf-body { padding: 0 calc(var(--u) * 31) calc(var(--u) * 25); }
      body .pf-h { margin-top: calc(var(--u) * 15.5); font-size: calc(var(--u) * 18.5); line-height: calc(var(--u) * 26); }
      body .pf-grid { margin-top: calc(var(--u) * 17); grid-template-columns: 1fr; row-gap: calc(var(--u) * 12.5); }
      body .pf-box { position: relative; height: calc(var(--u) * 63.5); min-height: 0; align-items: center; padding: 0 calc(var(--u) * 26); gap: calc(var(--u) * 12); border-radius: calc(var(--u) * 17); }
      body .pf-ic { width: calc(var(--u) * 19); height: calc(var(--u) * 19); align-self: flex-start; margin-top: calc(var(--u) * 12); }
      body .pf-l { font-size: calc(var(--u) * 13); line-height: calc(var(--u) * 16); }
      body .pf-v { font-size: calc(var(--u) * 15); line-height: calc(var(--u) * 19); margin-top: calc(var(--u) * 3); }
      body .pf-box > div { align-self: center; }
      body .pf-eye { position: absolute; right: calc(var(--u) * 17); top: 50%; transform: translateY(-50%); width: calc(var(--u) * 26); height: calc(var(--u) * 26); margin: 0; }
      body .pf-eye svg { width: calc(var(--u) * 18); height: calc(var(--u) * 18); }
      body .pf-act { margin-top: calc(var(--u) * 26); }
      body .pf-btn { width: 100%; max-width: none; height: calc(var(--u) * 40); font-size: calc(var(--u) * 15.5); border-radius: calc(var(--u) * 10); }

      /* Popup ubah password 505x492 (berpusat di area konten, sidebar tidak ikut redup) */
      body #pwModal { padding-left: var(--sbw); background: rgba(0,0,0,.16); }
      body .pw-card { width: calc(var(--u) * 505); max-width: none; max-height: none; height: calc(var(--u) * 492); padding: 0 calc(var(--u) * 23); border-radius: calc(var(--u) * 14); display: flex; flex-direction: column; overflow: hidden; }
      body .pw-head { margin: 0 calc(var(--u) * -9); padding-top: calc(var(--u) * 10); gap: calc(var(--u) * 9); }
      body .pw-ic { width: calc(var(--u) * 45); height: calc(var(--u) * 45); }
      body .pw-ic svg { width: calc(var(--u) * 20); height: calc(var(--u) * 20); }
      body .pw-t { font-size: calc(var(--u) * 19); line-height: calc(var(--u) * 24); margin-top: calc(var(--u) * 2); }
      body .pw-s { font-size: calc(var(--u) * 12.5); line-height: calc(var(--u) * 18); margin-top: calc(var(--u) * 4); font-weight: 500; color: #333; }
      body .pw-hr { margin: calc(var(--u) * 10) calc(var(--u) * -5) 0; }
      body .pw-f { margin-top: calc(var(--u) * 25); }
      body .pw-hr + .pw-f { margin-top: calc(var(--u) * 23); }
      body .pw-l { font-size: calc(var(--u) * 17.5); line-height: calc(var(--u) * 20); margin: 0; }
      body .pw-w { margin-top: calc(var(--u) * 3.6); }
      body .pw-in { height: calc(var(--u) * 45.5); font-size: calc(var(--u) * 13); border-radius: calc(var(--u) * 7); padding-left: calc(var(--u) * 8); padding-right: calc(var(--u) * 46); }
      body .pw-e { right: calc(var(--u) * 6); width: calc(var(--u) * 32); height: calc(var(--u) * 32); }
      body .pw-e svg { width: calc(var(--u) * 20); height: calc(var(--u) * 20); }
      body .pw-err { margin-top: calc(var(--u) * 9); min-height: calc(var(--u) * 15); font-size: calc(var(--u) * 11); line-height: calc(var(--u) * 15); }
      body .pw-acts { margin-top: calc(var(--u) * 20); grid-template-columns: calc(var(--u) * 150) calc(var(--u) * 150); gap: calc(var(--u) * 32); justify-content: center; }
      body .pw-acts button { height: calc(var(--u) * 41); font-size: calc(var(--u) * 15); border-radius: calc(var(--u) * 8); }
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/panel.config.js -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
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
      <a href="{{ url('beranda-superadmin') }}" class="block">
        <img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="block h-12 w-auto" />
      </a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-[#03045E] transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden max-h-[80vh] overflow-y-auto rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>Beranda</a>
        <a href="{{ url('riwayat-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>Riwayat Presensi</a>
        <a href="{{ url('rekap-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg>Rekap Presensi</a>
        <button id="kelolaBtnM" type="button" class="flex h-11 w-full items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.800 2.800 4 5.800 4 9s-1.200 6.200-4 9c-2.800-2.800-4-5.800-4-9s1.200-6.200 4-9z"/></svg><span class="flex-1 text-left">Kelola Tampilan</span><svg id="chevM" class="chev h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.500" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg></button>
        <div id="subM" class="sb-sub">
          <a href="{{ url('kelola-beranda') }}">Beranda</a>
          <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
          <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
          <a href="{{ url('kelola-hubungi-kami') }}">Hubungi Kami</a>
        </div>
    <a href="{{ url('profil-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#E1FAFF] px-3.5 text-[13px] font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>Profile</a>
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
  <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 hidden flex-col rounded-r-[28px] bg-white px-3 pb-5 pt-6 shadow-[2px_0_14px_rgba(0,0,0,0.12)] lg:flex">
    <div class="sb-row relative flex h-12 items-center justify-center px-2">
      <a href="{{ url('beranda-superadmin') }}" class="sb-label block"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONIN" class="logo-img block h-9 w-auto" /></a>
      <button id="toggleBtn" type="button" aria-label="Ciutkan sidebar" class="absolute -right-[22px] top-1/2 flex h-[22px] w-[22px] -translate-y-1/2 items-center justify-center rounded-full bg-cyan2 shadow">
        <svg class="h-3 w-3 transition-transform" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
      </button>
    </div>
    <div class="sb-div"></div>

    <nav class="sb-nav mt-8 flex flex-col gap-2">
      <a href="{{ url('beranda-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100">
        <svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="2"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="2"/></svg>
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
      <a href="{{ url('profil-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs bg-[#DFF7FC] font-medium text-ink">
        <svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.2 18.5c1.2-2.2 3.2-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>
        <span class="sb-label">Profile</span>
      </a>
    </nav>

    <button id="logoutBtn" type="button" class="sb-item mt-auto flex items-center justify-center gap-2.5 rounded-xl bg-[#D93A3F] px-4 text-xs font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.25)] transition hover:brightness-110">
      <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.5 8.5L20.5 12l-5 3.5v-2.2H9v-2.6h6.5V8.5z"/></svg>
      <span class="sb-label">Log Out</span>
    </button>
  </aside>

  <!-- ===================== KONTEN ===================== -->
  <div id="content" class="min-h-screen lg:min-h-0">
    <header class="hdr z-30 bg-white px-4 py-3.5 shadow-sm sm:px-6 lg:sticky lg:top-0 lg:flex lg:flex-col lg:justify-center lg:py-0 lg:shadow-none">
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Profile SuperAdmin</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Super Admin mengelola konten yang tampil di portal publik website ICONNET</p>
    </header>

    <main class="main-c flex flex-col px-4 pb-8 pt-4 sm:px-6">
      <section class="pcard mx-auto w-full max-w-[760px] overflow-hidden rounded-2xl bg-white shadow-[0_3px_12px_rgba(0,0,0,0.18)]">

        <div class="pf-ban flex items-center gap-3 bg-gradient-to-r from-[#1C5EA6] to-[#0A2441] px-4 py-4">
          <span class="pf-av flex h-11 w-11 flex-none items-center justify-center overflow-hidden rounded-full bg-white"><svg class="h-full w-full" viewBox="0 0 48 48"><rect width="48" height="48" fill="#fff"/><circle cx="24" cy="14.500" r="6.600" fill="#7F7F7F"/><path d="M10.700 36.800C10.700 30.200 16 26.500 24 26.500s13.300 3.700 13.300 10.300c0 .5-.4.800-.9.800H11.600c-.5 0-.9-.3-.9-.8z" fill="#7F7F7F"/></svg></span>
          <div class="min-w-0">
            <h2 id="pfName" class="pf-n truncate text-[15px] font-semibold leading-snug text-white">SuperAdmin</h2>
            <div class="pf-bd mt-1 flex flex-wrap gap-1.5">
              <span class="pf-b inline-flex items-center rounded-full border border-[#3FB75A] bg-[#E4F9E8] px-2.5 py-0.5 text-[9px] font-medium text-[#1B8F36]">Akun Aktif</span>
            </div>
          </div>
        </div>

        <div class="pf-body px-4 pb-5 pt-4">
          <h3 class="pf-h text-[15px] font-semibold">Informasi Akun</h3>
          <div class="pf-grid mt-3 grid grid-cols-1 gap-2.5 sm:gap-3">
          <div class="pf-box flex items-start gap-2.5 rounded-xl border border-[#C9CED8] bg-[#F5F6FA] px-3.5 py-2.5">
            <svg class="pf-ic h-4 w-4 flex-none" viewBox="0 0 24 24" fill="none" stroke="#0B0B5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.500 7.500l8.500 6 8.500-6"/></svg>
            <div class="min-w-0 flex-1">
              <p class="pf-l text-[10.5px] font-semibold text-[#4A4A55]">Email</p>
              <p id="vEmail" class="pf-v mt-0.5 break-words text-[13px] text-black">-</p>
            </div>
          </div>
          <div class="pf-box flex items-start gap-2.5 rounded-xl border border-[#C9CED8] bg-[#F5F6FA] px-3.5 py-2.5">
            <svg class="pf-ic h-4 w-4 flex-none" viewBox="0 0 24 24" fill="none" stroke="#0B0B5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" ><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 018 0v3"/></svg>
            <div class="min-w-0 flex-1">
              <p class="pf-l text-[10.5px] font-semibold text-[#4A4A55]">Password</p>
              <p id="vPw" class="pf-v mt-0.5 break-words text-[13px] text-black">-</p>
            </div>
            <button id="eyeBtn" type="button" aria-label="Tampilkan password" class="pf-eye -mr-1 flex h-8 w-8 flex-none items-center justify-center self-center text-slate-800">
              <svg id="eyeHide" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path d="M4 4l16 16"/></svg><svg id="eyeShow" class="hidden h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          </div>
          <div class="pf-act mt-4 flex justify-center">
            <button id="btnPw" type="button" class="pf-btn h-11 w-full max-w-[494px] rounded-xl bg-[#F2F2F2] text-[13px] font-semibold text-black shadow-[0_3px_5px_rgba(0,0,0,0.25)] transition hover:bg-[#EAEAEA] active:scale-[.99]">Ubah password</button>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- ===================== POPUP UBAH PASSWORD ===================== -->
  <div id="pwModal" class="fixed inset-0 z-[80] flex hidden items-center justify-center bg-black/40 px-4 lg:z-40">
    <form id="pwForm" novalidate class="pw-card relative max-h-[92vh] w-full max-w-[400px] overflow-y-auto rounded-2xl bg-white px-5 pb-5 pt-5 shadow-[0_10px_30px_rgba(0,0,0,0.3)]" role="dialog" aria-modal="true" aria-labelledby="pwT">
      <div class="pw-head flex items-start gap-3">
        <span class="pw-ic flex h-10 w-10 flex-none items-center justify-center rounded-full bg-[#D5F1FD]">
          <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="#3A9BE8" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V8a4 4 0 018 0v3"/></svg>
        </span>
        <div class="min-w-0">
          <h3 id="pwT" class="pw-t text-base font-semibold">Ubah Password</h3>
          <p class="pw-s mt-0.5 text-[11px] leading-relaxed text-slate-700">Password harus minimal 8 karakter, mengandung angka,<br class="hidden lg:block"> serta tidak boleh mengandung spasi atau pola umum.</p>
        </div>
      </div>
      <div class="pw-hr mt-3 h-px bg-slate-200"></div>
        <div class="pw-f mt-3">
          <label for="pwOld" class="pw-l block text-xs font-medium">Password Saat Ini</label>
          <div class="pw-w relative mt-1.5">
            <input id="pwOld" type="password" autocomplete="current-password" placeholder="Masukkan kata sandi lama" class="pw-in h-10 w-full rounded-lg border border-[#BFC3CC] bg-white pl-3 pr-11 text-xs outline-none placeholder:text-slate-500 focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
          <button type="button" data-eye="pwOld" aria-label="Tampilkan password" class="pw-e absolute right-1.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center text-slate-800">
            <svg class="eo h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg><svg class="es hidden h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path d="M4 4l16 16"/></svg>
          </button>
          </div>
        </div>
        <div class="pw-f mt-3">
          <label for="pwNew" class="pw-l block text-xs font-medium">Password Baru</label>
          <div class="pw-w relative mt-1.5">
            <input id="pwNew" type="password" autocomplete="new-password" placeholder="Minimal 8 karakter" class="pw-in h-10 w-full rounded-lg border border-[#BFC3CC] bg-white pl-3 pr-11 text-xs outline-none placeholder:text-slate-500 focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
          <button type="button" data-eye="pwNew" aria-label="Tampilkan password" class="pw-e absolute right-1.5 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center text-slate-800">
            <svg class="eo h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg><svg class="es hidden h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path d="M4 4l16 16"/></svg>
          </button>
          </div>
        </div>
        <div class="pw-f mt-3">
          <label for="pwConf" class="pw-l block text-xs font-medium">Konfirmasi Password Baru</label>
          <div class="pw-w relative mt-1.5">
            <input id="pwConf" type="password" autocomplete="new-password" placeholder="Ketik ulang kata sandi baru" class="pw-in h-10 w-full rounded-lg border border-[#BFC3CC] bg-white pl-3 pr-3 text-xs outline-none placeholder:text-slate-500 focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
          </div>
        </div>
      <p id="pwErr" class="pw-err mt-2 min-h-[16px] text-[11px] font-medium leading-snug text-[#D93A3F]" role="alert"></p>
      <div class="pw-acts mt-3 grid grid-cols-2 gap-3">
        <button id="pwCancel" type="button" class="h-11 rounded-xl bg-[#E8E8E8] text-[13px] font-semibold text-black shadow-[0_3px_5px_rgba(0,0,0,0.2)] transition hover:bg-[#DEDEDE] active:scale-[.99]">Batal</button>
        <button id="pwSave" type="submit" class="h-11 rounded-xl bg-[#4A9FF5] text-[13px] font-semibold text-white shadow-[0_3px_5px_rgba(0,0,0,0.2)] transition hover:brightness-105 active:scale-[.99]">Simpan</button>
      </div>
    </form>
  </div>

  <script>
    /* =====================================================================
       Akun SUPERADMIN = akun yang dipakai untuk login (localStorage 'iconnet_users',
       sama dengan login.html & lupa password), dicocokkan lewat email di 'iconnet_session'.
       Dengan begitu email yang tampil sama dengan email login, dan password yang
       diubah di sini langsung berlaku saat login berikutnya.
       'iconnet_superadmins' (data profil lama) tetap dibaca sebagai cadangan bila akun tidak
       ada di 'iconnet_users'. Tidak ada lagi akun contoh yang dibuat otomatis
       dan tidak ada fallback ke akun lain, supaya profil selalu milik akun yang login.
       Ganti dengan data dari backend pada versi produksi (jangan simpan password di browser).
       ===================================================================== */
    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const session = read('iconnet_session', null) || {};

    const ACCOUNT_KEYS = ['iconnet_users', 'iconnet_superadmins'];
    function findUser() {
      const email = String(session.email || '').toLowerCase();
      if (!email) return null;
      for (const key of ACCOUNT_KEYS) {
        const raw = read(key, null);
        if (!Array.isArray(raw)) continue;
        const user = raw.find(u => u && String(u.email || '').toLowerCase() === email);
        if (user) return { key, raw, user };
      }
      return null;
    }
    const pick = (o, ...ks) => { for (const k of ks) { if (o && o[k] != null && o[k] !== '') return o[k]; } return ''; };
    const FIELD = {
      nama: ['nama', 'name', 'namaLengkap', 'fullName', 'fullname'],
      jk:   ['jenisKelamin', 'jenis_kelamin', 'gender', 'jk'],
      wa:   ['whatsapp', 'noWhatsapp', 'noWa', 'no_wa', 'wa', 'phone', 'telepon', 'noHp', 'hp']
    };
    const looksHash = v => /^[a-f0-9]{64}$/i.test(String(v || ''));

    function fmtGender(v) {
      const t = String(v || '').trim(), l = t.toLowerCase();
      if (!t) return '-';
      if (['l', 'lk', 'male', 'laki-laki', 'laki laki', 'pria'].includes(l)) return 'Laki-laki';
      if (['p', 'pr', 'female', 'perempuan', 'wanita'].includes(l)) return 'Perempuan';
      return t;
    }
    /* ---------- Tampilkan data ---------- */
    let pwShown = false;
    function render() {
      const f = findUser(), u = f ? f.user : {};
      $('pfName').textContent = pick(u, ...FIELD.nama) || session.nama || 'SuperAdmin';
      $('vEmail').textContent = u.email || session.email || '-';
      const pw = u.password, canReveal = !!pw && !looksHash(pw);
      $('eyeBtn').classList.toggle('hidden', !canReveal);
      if (!canReveal) pwShown = false;
      $('vPw').textContent = pwShown && canReveal ? pw : '********';
      $('eyeHide').classList.toggle('hidden', pwShown);
      $('eyeShow').classList.toggle('hidden', !pwShown);
      $('eyeBtn').setAttribute('aria-label', pwShown ? 'Sembunyikan password' : 'Tampilkan password');
    }
    $('eyeBtn').addEventListener('click', () => { pwShown = !pwShown; render(); });
    render();

    /* ---------- Toast ---------- */
    function showToast(msg) {
      const t = $('toast'); $('toastText').textContent = msg;
      t.classList.remove('opacity-0', '-translate-y-4');
      clearTimeout(window._tt);
      window._tt = setTimeout(() => t.classList.add('opacity-0', '-translate-y-4'), 3000);
    }

    /* ---------- Popup ubah password ---------- */
    const modal = $('pwModal');
    const setErr = m => { $('pwErr').textContent = m || ''; };
    function setEye(btn, visible) {
      btn.querySelector('.eo').classList.toggle('hidden', visible);
      btn.querySelector('.es').classList.toggle('hidden', !visible);
      btn.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
    }
    function openModal() {
      $('pwForm').reset(); setErr('');
      ['pwOld', 'pwNew', 'pwConf'].forEach(id => { $(id).type = 'password'; });
      document.querySelectorAll('[data-eye]').forEach(b => setEye(b, false));
      modal.classList.remove('hidden'); $('pwOld').focus();
    }
    function closeModal() { modal.classList.add('hidden'); }
    $('btnPw').addEventListener('click', openModal);
    $('pwCancel').addEventListener('click', closeModal);
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal(); });
    document.querySelectorAll('[data-eye]').forEach(b => b.addEventListener('click', () => {
      const inp = $(b.dataset.eye), show = inp.type === 'password';
      inp.type = show ? 'text' : 'password'; setEye(b, show);
    }));

    const COMMON = ['password', 'passw0rd', 'qwerty', 'iloveyou', 'admin', 'welcome', 'letmein', 'abc123', 'katasandi', 'sandi', 'rahasia', 'iconnet', 'telkom'];
    function hasSequence(p) {
      const s = p.toLowerCase();
      for (let i = 0; i + 3 < s.length; i++) {
        const a = s.charCodeAt(i), b = s.charCodeAt(i + 1), c = s.charCodeAt(i + 2), d = s.charCodeAt(i + 3);
        if ((b - a === 1 && c - b === 1 && d - c === 1) || (a - b === 1 && b - c === 1 && c - d === 1)) return true;
        if (a === b && b === c && c === d) return true;
      }
      return false;
    }
    function checkNew(nw, old) {
      if (nw.length < 8) return 'Password baru minimal 8 karakter.';
      if (/\s/.test(nw)) return 'Password tidak boleh mengandung spasi.';
      if (!/\d/.test(nw)) return 'Password harus mengandung angka.';
      const l = nw.toLowerCase();
      if (COMMON.some(w => l.includes(w)) || hasSequence(nw)) return 'Password terlalu umum. Hindari urutan atau kata yang mudah ditebak.';
      if (nw === old) return 'Password baru tidak boleh sama dengan password lama.';
      return '';
    }

    $('pwForm').addEventListener('submit', async e => {
      e.preventDefault(); setErr('');
      const old = $('pwOld').value, nw = $('pwNew').value, cf = $('pwConf').value;
      if (!old) return setErr('Masukkan password saat ini.');
      const bad = checkNew(nw, old); if (bad) return setErr(bad);
      if (nw !== cf) return setErr('Konfirmasi password tidak sama.');

      // Password dicek & disimpan (di-hash) di server Laravel
      const btn = $('pwForm').querySelector('[type="submit"]');
      if (btn) btn.disabled = true;
      try {
        await ICONNET_API.request('PUT', 'api/v1/profil/password', { current_password: old, password: nw, password_confirmation: cf });
      } catch (err) {
        if (btn) btn.disabled = false;
        return setErr(err.message);
      }
      if (btn) btn.disabled = false;
      closeModal(); render(); showToast('Kata sandi berhasil diubah');
    });

    /* ---------- Sidebar (desktop) & hamburger (mobile) ---------- */
    $('toggleBtn').addEventListener('click', () => {
      const c = document.body.classList.toggle('collapsed');
      localStorage.setItem('iconnet_sidebar', c ? '1' : '0');
    });
    $('kelolaBtn').addEventListener('click', () => {
      if (document.body.classList.contains('collapsed')) { document.body.classList.remove('collapsed'); localStorage.setItem('iconnet_sidebar', '0'); }
      $('subD').classList.toggle('open'); $('chevD').classList.toggle('open');
    });
    $('kelolaBtnM').addEventListener('click', () => {
      $('subM').classList.toggle('open'); $('chevM').classList.toggle('open');
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
    window.matchMedia('(min-width:900px)').addEventListener('change', () => setMenu(false));

    function logout() {
      if (!confirm('Yakin ingin keluar dari akun?')) return;
      ICONNET_API.logout();   // logout di server, lalu ke halaman login
    }
    $('logoutBtn').addEventListener('click', logout);
    $('logoutBtnM').addEventListener('click', logout);
  </script>
</body>
</html>
