<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Rekap Absensi - ICONNET (Superadmin)</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- ExcelJS: dipakai untuk export Excel dengan format (warna, border, lebar kolom, dll) -->
  <script src="{{ asset('vendor/exceljs/exceljs.min.js') }}"></script>
  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    .sb-div { display: none; }
    button { font-family: inherit; }

    .rw-date { position: relative; }
    .rw-date::-webkit-calendar-picker-indicator { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .rw-date::-webkit-date-and-time-value { text-align: left; }
    select.rw-in, .rw-date { -webkit-appearance: none; appearance: none; }

    /* Submenu Kelola Tampilan */
    .sb-sub { display: none; flex-direction: column; gap: 4px; padding-left: 38px; }
    .sb-sub.open { display: flex; }
    .sb-sub a { display: flex; align-items: center; height: 34px; border-radius: 8px; padding: 0 12px; font-size: 12px; color: #475569; transition: background .15s; }
    .sb-sub a:hover { background: #F1F5F9; }
    .chev { transition: transform .2s; }
    .chev.open { transform: rotate(180deg); }

    /* Tombol Export */
    .btn-export { display: inline-flex; align-items: center; justify-content: center; gap: 10px; height: 38px; padding: 0 22px; border-radius: 10px; background: #107C41; color: #fff; font-size: 14px; font-weight: 600; letter-spacing: .1px; box-shadow: 0 4px 8px rgba(0,0,0,.28); transition: filter .15s, transform .1s; cursor: pointer; }
    .btn-export svg { width: 22px; height: 22px; flex: none; }
    .btn-export:hover:not(:disabled) { filter: brightness(1.1); }
    .btn-export:active:not(:disabled) { transform: scale(.98); }
    .btn-export:disabled { opacity: .6; cursor: default; }

    /* Tabel rekap */
    .rk-num { font-variant-numeric: tabular-nums; }
    .rk-z { color: #9CA3AF; }

    /* Pagination */
    .pg-b { display: inline-flex; align-items: center; justify-content: center; gap: 4px; height: 28px; min-width: 28px; padding: 0 10px; border: 1px solid #E3E3E3; border-radius: 7px; background: #fff; font-size: 11px; font-weight: 500; color: #000; cursor: pointer; transition: background .15s; }
    .pg-b:hover:not(:disabled):not(.on) { background: #F3F4F6; }
    .pg-b.on { background: #4FC9E4; border-color: #4FC9E4; color: #fff; cursor: default; }
    .pg-b:disabled { opacity: .45; cursor: default; }
    .pg-pill { border-radius: 999px; padding: 0 12px; }
    .pg-dots { display: inline-flex; align-items: center; padding: 0 2px; font-size: 11px; color: #6B7280; }

    /* Toast */
    #toast { position: fixed; left: 50%; bottom: 28px; z-index: 100; transform: translate(-50%, 20px); opacity: 0; pointer-events: none; max-width: 90vw; padding: 10px 18px; border-radius: 10px; background: #111827; color: #fff; font-size: 12.5px; box-shadow: 0 6px 18px rgba(0,0,0,.3); transition: opacity .2s, transform .2s; }
    #toast.show { opacity: 1; transform: translate(-50%, 0); }

    /* ===== MOBILE (<900px) ===== */
    @media (max-width: 899px) {
      .hdr-t { font-size: 15px !important; line-height: 1.3; }
      .hdr-s { font-size: 11px !important; }
      .rw-main { padding: 12px 14px 24px !important; gap: 12px !important; }
      .rw-fcard { padding: 12px !important; border-radius: 12px !important; }
      .rw-ft { font-size: 12.5px !important; }
      .rw-lb { font-size: 11px !important; }
      .rw-wr { margin-top: 4px !important; }
      .rw-in { height: 34px !important; min-height: 34px; font-size: 11.5px !important; padding-left: 10px !important; padding-right: 32px !important; border-radius: 6px !important; display: block; line-height: 32px; }
      .rw-ico { right: 10px !important; width: 15px !important; height: 15px !important; }
      #mnav .h-16 { height: 56px; }
      .pg-b { height: 26px; min-width: 26px; padding: 0 8px; font-size: 10.5px; }
      .pg-pill { padding: 0 10px; }
      .btn-export { height: 34px; padding: 0 16px; gap: 8px; font-size: 12.5px; border-radius: 9px; }
      .btn-export svg { width: 19px; height: 19px; }
    }

    /* ===== DESKTOP / LAPTOP (>=900px): skala otomatis agar muat 1 layar ===== */
    @media (min-width: 900px) {
      :root { --u: clamp(0.6px, min(100vw / 1110, 100vh / 805), 1px); --su: max(min(100vw / 1110, 100vh / 790), 0.6px); --sbw: calc(var(--su) * 198); }
      .collapsed { --sbw: 76px; }
      html, body { overflow: hidden; }

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

      body .hdr { height: calc(var(--u) * 87); padding: calc(var(--u) * 6) calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body .hdr-t { font-size: calc(var(--u) * 18); line-height: 1.25; font-weight: 600; color: #03045E; }
      body .hdr-s { font-size: calc(var(--u) * 12.5); line-height: 1.4; margin-top: calc(var(--u) * 4); color: #000; }

      body #content { overflow-x: hidden; overflow-y: hidden; }
      body .rw-main { display: flex; flex-direction: column; height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 20) calc(var(--u) * 41) calc(var(--u) * 20); gap: calc(var(--u) * 16); }

      /* Kartu filter */
      body .rw-fcard { position: relative; flex: none; padding: calc(var(--u) * 12) calc(var(--u) * 24) calc(var(--u) * 14) calc(var(--u) * 24); border-radius: calc(var(--u) * 13); box-shadow: 0 calc(var(--u) * 3) calc(var(--u) * 12) rgba(0,0,0,.22); }
      body .rw-ftop { height: calc(var(--u) * 34); margin-bottom: calc(var(--u) * 4); gap: calc(var(--u) * 12); }
      body .rw-ftop .rw-fic { width: calc(var(--u) * 26); height: calc(var(--u) * 26); }
      body .rw-ft { font-size: calc(var(--u) * 16); line-height: calc(var(--u) * 24); font-weight: 500; }
      body .rw-fg { margin-top: 0; column-gap: calc(var(--u) * 28); row-gap: calc(var(--u) * 10); }
      body .rw-lb { font-size: calc(var(--u) * 13.5); line-height: calc(var(--u) * 20); font-weight: 500; }
      body .rw-wr { margin-top: calc(var(--u) * 3); }
      body .rw-in { height: calc(var(--u) * 35); font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 6); padding-left: calc(var(--u) * 12); padding-right: calc(var(--u) * 38); }
      body .rw-ico { right: calc(var(--u) * 13); width: calc(var(--u) * 16); height: calc(var(--u) * 16); }
      body .btn-export { height: calc(var(--u) * 36); padding: 0 calc(var(--u) * 24); gap: calc(var(--u) * 11); font-size: calc(var(--u) * 14); border-radius: calc(var(--u) * 10); }
      body .btn-export svg { width: calc(var(--u) * 22); height: calc(var(--u) * 22); }

      /* Kartu tabel: persis 10 baris per halaman */
      body .rw-tcard { flex: 1 1 0; min-height: 0; border-radius: calc(var(--u) * 13); box-shadow: 0 calc(var(--u) * 3) calc(var(--u) * 12) rgba(0,0,0,.22); }
      body .rw-twrap { position: relative; flex: 1 1 0; min-height: 0; overflow: hidden; }
      body .rw-tbl thead { background: #03045E; }
      body .rw-tbl th { height: calc(var(--u) * 36); font-size: calc(var(--u) * 12); font-weight: 500; color: #fff; text-align: center; padding: 0 calc(var(--u) * 8); }
      body .rw-tbl td { height: calc(var(--u) * 37); font-size: calc(var(--u) * 11.5); vertical-align: middle; text-align: center; padding: 0 calc(var(--u) * 10); border-bottom: 1px solid #ECECEC; }
      body .rw-tbl td.al { text-align: center; padding-left: calc(var(--u) * 14); padding-right: calc(var(--u) * 14); }
      body .rw-tbl tbody tr:nth-child(even) td { background: #FAFAFE; }
      body .rw-tbl tbody tr:last-child td { border-bottom-color: transparent; }
      body .rw-empty { font-size: calc(var(--u) * 14); }
      body .rw-pgbar { height: calc(var(--u) * 38); padding: 0 calc(var(--u) * 14); gap: calc(var(--u) * 9); border-top: 1px solid #E9E9E9; }
      body .rw-pgbar .pg-b { height: calc(var(--u) * 22); min-width: calc(var(--u) * 24); padding: 0 calc(var(--u) * 10); font-size: calc(var(--u) * 10.5); border-radius: calc(var(--u) * 6); gap: calc(var(--u) * 4); }
      body .rw-pgbar .pg-pill { border-radius: 999px; padding: 0 calc(var(--u) * 14); }
      body .rw-pgbar .pg-b svg { width: calc(var(--u) * 9); height: calc(var(--u) * 9); }
      body .rw-pgbar .pg-dots { font-size: calc(var(--u) * 10.5); }
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/panel.config.js -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
</head>

<body class="bg-[#F9F8FE] font-sans text-black antialiased">
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
      <a href="{{ url('beranda-superadmin') }}" class="block"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="block h-12 w-auto" /></a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-[#03045E] transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden max-h-[80vh] overflow-y-auto rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>Beranda</a>
        <a href="{{ url('riwayat-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>Riwayat Presensi</a>
        <a href="{{ url('rekap-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#E1FAFF] px-3.5 text-[13px] font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg>Rekap Presensi</a>
        <button id="kelolaBtnM" type="button" class="flex h-11 w-full items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.800 2.800 4 5.800 4 9s-1.200 6.200-4 9c-2.800-2.800-4-5.800-4-9s1.200-6.200 4-9z"/></svg><span class="flex-1 text-left">Kelola Tampilan</span><svg id="chevM" class="chev h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.500" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg></button>
        <div id="subM" class="sb-sub">
          <a href="{{ url('kelola-beranda') }}">Beranda</a>
          <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
          <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
          <a href="{{ url('kelola-hubungi-kami') }}">Hubungi Kami</a>
        </div>
        <a href="{{ url('profil-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>Profile</a>
      </div>
      <div class="my-3 h-px bg-[#E8EAF0]"></div>
      <button id="logoutBtnM" type="button" class="flex h-11 w-full items-center justify-center gap-2.5 rounded-xl bg-[#D93A3F] px-4 text-[13px] font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.2)] transition hover:brightness-110">
        <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.500 8.500L20.500 12l-5 3.500v-2.200H9v-2.600h6.500V8.500z"/></svg>
        Log Out
      </button>
    </div>
  </nav>

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
      <a href="{{ url('rekap-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs bg-[#DFF7FC] font-medium text-ink">
        <svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H8a2 2 0 00-2 2v14a2 2 0 002 2h8a2 2 0 002-2V8z"/><path d="M14 3v5h4M9 13h6M9 17h4"/></svg>
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
  <div id="content" class="min-h-screen lg:min-h-0">
    <header class="hdr z-30 bg-white px-4 py-3.5 shadow-sm sm:px-6 lg:sticky lg:top-0 lg:flex lg:flex-col lg:justify-center lg:py-0 lg:shadow-none">
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Rekap Absensi</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Ringkasan data kehadiran seluruh peserta magang berdasarkan periode.</p>
    </header>

    <main class="rw-main flex flex-col gap-4 px-4 pb-8 pt-4 sm:px-6">

      <!-- ===== Filter ===== -->
      <section class="rw-fcard rounded-2xl bg-white p-4 shadow-[0_3px_12px_rgba(0,0,0,0.18)]">
        <div class="rw-ftop flex items-center justify-between gap-2.5">
          <div class="flex min-w-0 items-center gap-2.5">
            <span class="rw-fic flex h-[24px] w-[24px] flex-none items-center justify-center rounded-full bg-[#E8E8E8]">
              <svg class="h-[13px] w-[13px]" viewBox="0 0 24 24" fill="none" stroke="#3C4858" stroke-width="2.200" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4.500 5h15l-5 6.500v6L9.500 19v-7.500z"/></svg>
            </span>
            <h2 class="rw-ft truncate text-sm font-medium sm:text-base">Filter Data Riwayat Presensi</h2>
          </div>
          <button id="btnExport" type="button" class="btn-export flex-none">
            <!-- Ikon Excel (putih) -->
            <svg viewBox="0 0 32 32" fill="none" aria-hidden="true"><path d="M14 5h12.500A1.500 1.500 0 0128 6.500v19a1.500 1.500 0 01-1.500 1.500H14" stroke="#fff" stroke-width="1.800" stroke-linecap="round" stroke-linejoin="round"/><path d="M18 11h10M18 16h10M18 21h10M22.500 5v22" stroke="#fff" stroke-width="1.800"/><path d="M3 7.500L15.500 4.500v23L3 24.500z" fill="#fff"/><path d="M6.800 12.200l5.400 7.600M12.200 12.200l-5.400 7.600" stroke="#107C41" stroke-width="2.200" stroke-linecap="round"/></svg>
            <span id="btnExportTxt">Export</span>
          </button>
        </div>

        <div class="rw-fg mt-3 grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
          <div>
            <label for="fMulai" class="rw-lb block text-xs font-medium">Tanggal Mulai</label>
            <div class="rw-wr relative mt-1.5">
              <input id="fMulai" type="date" class="rw-in rw-date h-10 w-full rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.500" y="5" width="17" height="15.500" rx="2.500"/><path d="M3.500 10h17M8 3v4M16 3v4"/></svg>
            </div>
          </div>
          <div>
            <label for="fSelesai" class="rw-lb block text-xs font-medium">Tanggal Selesai</label>
            <div class="rw-wr relative mt-1.5">
              <input id="fSelesai" type="date" class="rw-in rw-date h-10 w-full rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.500" y="5" width="17" height="15.500" rx="2.500"/><path d="M3.500 10h17M8 3v4M16 3v4"/></svg>
            </div>
          </div>
          <div>
            <label for="fNama" class="rw-lb block text-xs font-medium">Nama</label>
            <div class="rw-wr relative mt-1.5">
              <select id="fNama" class="rw-in h-10 w-full cursor-pointer rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20"></select>
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </div>
          <div>
            <label for="fSekolah" class="rw-lb block text-xs font-medium">Sekolah / Institusi</label>
            <div class="rw-wr relative mt-1.5">
              <select id="fSekolah" class="rw-in h-10 w-full cursor-pointer rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20"></select>
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== Tabel (desktop / laptop) ===== -->
      <section class="rw-tcard hidden flex-col overflow-hidden rounded-2xl bg-white shadow-[0_3px_12px_rgba(0,0,0,0.18)] lg:flex">
        <div class="rw-twrap">
          <table class="rw-tbl w-full table-fixed border-collapse">
            <colgroup>
              <col style="width:24%"><col style="width:28%"><col style="width:12%"><col style="width:14%"><col style="width:11%"><col style="width:11%">
            </colgroup>
            <thead>
              <tr><th>Nama</th><th>Sekolah / Institusi</th><th>Total Hadir</th><th>Total Terlambat</th><th>Total Izin</th><th>Total Sakit</th></tr>
            </thead>
            <tbody id="rowsD"></tbody>
          </table>
          <div id="emptyD" class="rw-empty absolute inset-x-0 top-[40%] hidden text-center text-sm text-slate-500">Tidak ada data.</div>
        </div>
        <div id="pgD" class="rw-pgbar flex flex-none items-center justify-end"></div>
      </section>

      <!-- ===== Daftar kartu (mobile) ===== -->
      <section class="lg:hidden">
        <div id="rowsM" class="flex flex-col gap-3"></div>
        <div id="emptyM" class="hidden rounded-xl bg-white py-10 text-center text-xs text-slate-500 shadow-[0_3px_12px_rgba(0,0,0,0.12)]">Tidak ada data.</div>
        <div id="pgM" class="mt-4 flex flex-wrap items-center justify-center gap-1.5"></div>
      </section>
    </main>
  </div>

  <div id="toast" role="status" aria-live="polite"></div>

  <script>
    /* =====================================================================
       REKAP PRESENSI - SUPERADMIN
       Sumber data (localStorage), sama seperti halaman riwayat:
         - Presensi : 'iconnet_presensi' | 'iconnet_riwayat' | ...
         - Izin     : 'iconnet_leave'
         - Peserta  : 'iconnet_users' (opsional; peserta tanpa presensi tetap tampil bernilai 0)
       ===================================================================== */
    const TZ = 'Asia/Makassar';
    const PER_PAGE = 10;               // tabel hanya menampilkan 10 baris per halaman
    const ADMIN_ROLES = ['superadmin', 'super_admin', 'super admin', 'admin'];

    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const esc = s => String(s == null ? '' : s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    const REC_KEYS = ['iconnet_presensi', 'iconnet_riwayat', 'iconnet_absensi', 'iconnet_attendance', 'presensi', 'riwayat'];
    const USER_KEYS = ['iconnet_users', 'iconnet_user', 'iconnet_peserta', 'users'];
    const FIELD = {
      tgl:    ['tanggal', 'date', 'tgl'],
      status: ['status', 'statusKehadiran', 'kehadiran'],
      mulai:  ['tanggalMulai', 'tgl_mulai', 'mulai', 'start'],
      selesai:['tanggalSelesai', 'tgl_selesai', 'selesai', 'end'],
      nama:   ['nama', 'name', 'namaLengkap', 'fullName', 'nama_lengkap'],
      sekolah:['sekolah', 'institusi', 'asalSekolah', 'school', 'sekolahInstitusi', 'asal_sekolah']
    };
    const pick = (o, ks) => { for (const k of ks) { if (o && o[k] != null && o[k] !== '') return o[k]; } return ''; };
    const emailOf = r => String(r.email || '').toLowerCase();

    /* ---------- Util tanggal ---------- */
    const todayISO = () => new Intl.DateTimeFormat('en-CA', { timeZone: TZ, year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date());
    function parseDate(v) {
      if (!v) return '';
      const t = String(v).trim();
      if (/^\d{4}-\d{2}-\d{2}$/.test(t)) return t;
      const m = t.match(/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/);
      if (m) return m[3] + '-' + m[2].padStart(2, '0') + '-' + m[1].padStart(2, '0');
      const d = new Date(t);
      if (isNaN(d)) return '';
      return new Intl.DateTimeFormat('en-CA', { timeZone: TZ, year: 'numeric', month: '2-digit', day: '2-digit' }).format(d);
    }
    const fmtDate = iso => { const m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(iso || ''); return m ? m[3] + '-' + m[2] + '-' + m[1] : '-'; };
    function rangeDays(a, b) {
      const out = []; let d = new Date(a + 'T00:00:00Z'); const end = new Date((b || a) + 'T00:00:00Z');
      for (let i = 0; i < 366 && d <= end; i++) { out.push(d.toISOString().slice(0, 10)); d = new Date(d.getTime() + 86400000); }
      return out;
    }
    function normStatus(v) {
      const l = String(v || '').trim().toLowerCase();
      if (['hadir', 'present'].includes(l)) return 'hadir';
      if (['izin', 'permit'].includes(l)) return 'izin';
      if (['sakit', 'sick'].includes(l)) return 'sakit';
      if (['terlambat', 'telat', 'late'].includes(l)) return 'terlambat';
      return '';
    }

    /* ---------- Muat data ---------- */
    function flatten(raw) {
      if (Array.isArray(raw)) return raw.filter(r => r && typeof r === 'object');
      if (raw && typeof raw === 'object') {
        const out = [];
        Object.entries(raw).forEach(([k, v]) => { if (Array.isArray(v)) v.forEach(r => { if (r && typeof r === 'object') out.push(Object.assign({ email: r.email || k }, r)); }); });
        return out;
      }
      return [];
    }
    function loadUsers() {
      const list = [];
      for (const key of USER_KEYS) {
        const raw = read(key, null);
        if (!raw) continue;
        const arr = Array.isArray(raw) ? raw : (typeof raw === 'object' ? Object.entries(raw).map(([k, v]) => (v && typeof v === 'object') ? Object.assign({ email: v.email || k }, v) : null).filter(Boolean) : []);
        arr.forEach(u => { if (!ADMIN_ROLES.includes(String(u.role || '').toLowerCase())) list.push(u); });
      }
      return list;
    }
    function loadRecords() {
      const out = [], seen = new Set();
      for (const key of REC_KEYS) flatten(read(key, null)).forEach(r => { const s = JSON.stringify(r); if (!seen.has(s)) { seen.add(s); out.push(r); } });
      return out;
    }
    const loadLeaves = () => flatten(read('iconnet_leave', []));

    const USERS = loadUsers(), RECS = loadRecords(), LEAVES = loadLeaves();
    const userByEmail = {};
    USERS.forEach(u => { const e = emailOf(u); if (e) userByEmail[e] = u; });

    // identitas peserta (nama, sekolah) dari record / daftar user
    function identity(r) {
      const em = emailOf(r), u = userByEmail[em] || {};
      const nama = pick(r, FIELD.nama) || pick(u, FIELD.nama) || (em ? em.split('@')[0] : 'Tanpa nama');
      const sekolah = pick(r, FIELD.sekolah) || pick(u, FIELD.sekolah) || '-';
      return { key: em || nama.toLowerCase(), nama, sekolah };
    }

    // Semua peserta yang dikenal (untuk dropdown & agar peserta tanpa data tetap tampil 0)
    const PEOPLE = new Map();
    function ensure(id) { if (!PEOPLE.has(id.key)) PEOPLE.set(id.key, { nama: id.nama, sekolah: id.sekolah }); return id.key; }
    USERS.forEach(u => ensure(identity(u)));
    RECS.forEach(r => ensure(identity(r)));
    LEAVES.forEach(r => ensure(identity(r)));

    /* ---------- Agregasi sesuai filter ---------- */
    function aggregate() {
      const from = $('fMulai').value, to = $('fSelesai').value;
      const nm = $('fNama').value, sc = $('fSekolah').value;
      const inRange = d => d && (!from || d >= from) && (!to || d <= to);

      const acc = new Map();
      PEOPLE.forEach((p, k) => acc.set(k, { nama: p.nama, sekolah: p.sekolah, hadir: 0, terlambat: 0, izin: 0, sakit: 0 }));

      // tanggal yang sudah tercakup pengajuan izin (hindari hitung ganda)
      const covered = new Set();
      LEAVES.forEach(l => {
        const a = parseDate(pick(l, FIELD.mulai)); if (!a) return;
        const id = identity(l).key;
        rangeDays(a, parseDate(pick(l, FIELD.selesai)) || a).forEach(d => covered.add(id + '|' + d));
      });

      RECS.forEach(r => {
        const st = normStatus(pick(r, FIELD.status)), d = parseDate(pick(r, FIELD.tgl)), id = identity(r).key;
        if (!st || !acc.has(id) || !inRange(d)) return;
        if ((st === 'izin' || st === 'sakit') && covered.has(id + '|' + d)) return;
        acc.get(id)[st]++;
      });
      LEAVES.forEach(l => {
        const st = normStatus(pick(l, FIELD.status)), a = parseDate(pick(l, FIELD.mulai)), id = identity(l).key;
        if ((st !== 'izin' && st !== 'sakit') || !a || !acc.has(id)) return;
        rangeDays(a, parseDate(pick(l, FIELD.selesai)) || a).forEach(d => { if (inRange(d)) acc.get(id)[st]++; });
      });

      return [...acc.values()]
        .filter(r => (!nm || r.nama === nm) && (!sc || r.sekolah === sc))
        .sort((a, b) => a.nama.localeCompare(b.nama, 'id'));
    }

    /* ---------- State & filter ---------- */
    let view = [], page = 1;

    function fillSelects() {
      const names = [...new Set([...PEOPLE.values()].map(p => p.nama))].sort((a, b) => a.localeCompare(b, 'id'));
      const schools = [...new Set([...PEOPLE.values()].map(p => p.sekolah).filter(s => s && s !== '-'))].sort((a, b) => a.localeCompare(b, 'id'));
      $('fNama').innerHTML = '<option value="">Semua nama</option>' + names.map(n => '<option value="' + esc(n) + '">' + esc(n) + '</option>').join('');
      $('fSekolah').innerHTML = '<option value="">Semua sekolah / institusi</option>' + schools.map(n => '<option value="' + esc(n) + '">' + esc(n) + '</option>').join('');
    }

    function applyFilter(e) {
      let a = $('fMulai').value, b = $('fSelesai').value;
      // rentang tidak valid -> samakan sisi lain dengan yang baru diubah
      if (a && b && a > b) {
        if (e && e.target && e.target.id === 'fSelesai') $('fMulai').value = b; else $('fSelesai').value = a;
        toast('Rentang tanggal disesuaikan: tanggal mulai tidak boleh melewati tanggal selesai.');
      }
      $('fSelesai').min = $('fMulai').value || '';
      $('fMulai').max = $('fSelesai').value || '';
      view = aggregate();
      page = 1; render();
    }
    ['fMulai', 'fSelesai', 'fNama', 'fSekolah'].forEach(id => $(id).addEventListener('change', applyFilter));

    /* ---------- Render ---------- */
    const num = n => '<span class="rk-num ' + (n === 0 ? 'rk-z' : 'font-medium') + '">' + n + '</span>';
    function rowD(r) {
      return '<tr><td class="al truncate font-medium" title="' + esc(r.nama) + '">' + esc(r.nama) + '</td>' +
        '<td class="truncate" title="' + esc(r.sekolah) + '">' + esc(r.sekolah) + '</td>' +
        '<td>' + num(r.hadir) + '</td><td>' + num(r.terlambat) + '</td><td>' + num(r.izin) + '</td><td>' + num(r.sakit) + '</td></tr>';
    }
    function cardM(r) {
      const cell = (l, n, c) => '<div class="rounded-lg bg-[#F8F8FD] px-1 py-2 text-center"><p class="text-[10px] text-slate-500">' + l + '</p><p class="rk-num text-[15px] font-semibold ' + (n === 0 ? 'rk-z' : c) + '">' + n + '</p></div>';
      return '<div class="rounded-xl bg-white p-3 shadow-[0_3px_12px_rgba(0,0,0,0.12)]">' +
        '<p class="text-[13px] font-semibold text-[#03045E]">' + esc(r.nama) + '</p><p class="text-[11px] text-slate-500">' + esc(r.sekolah) + '</p>' +
        '<div class="mt-2.5 grid grid-cols-4 gap-2">' + cell('Hadir', r.hadir, 'text-[#1B8F36]') + cell('Terlambat', r.terlambat, 'text-[#E0560F]') + cell('Izin', r.izin, 'text-[#0A7FA8]') + cell('Sakit', r.sakit, 'text-[#D9780A]') + '</div></div>';
    }

    const CH_L = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.500" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5"><path d="M15 6l-6 6 6 6"/></svg>';
    const CH_R = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.500" stroke-linecap="round" stroke-linejoin="round" class="h-2.5 w-2.5"><path d="M9 6l6 6-6 6"/></svg>';
    function pagerHTML(pages) {
      let h = '<button type="button" class="pg-b pg-pill" data-p="prev"' + (page <= 1 ? ' disabled' : '') + '>' + CH_L + 'Sebelumnya</button>';
      const nums = [];
      for (let p = 1; p <= pages; p++) { if (p === 1 || p === pages || Math.abs(p - page) <= 1) nums.push(p); }
      let last = 0;
      nums.forEach(p => {
        if (p - last > 1) h += '<span class="pg-dots">…</span>';
        h += '<button type="button" class="pg-b' + (p === page ? ' on' : '') + '" data-p="' + p + '">' + p + '</button>';
        last = p;
      });
      return h + '<button type="button" class="pg-b pg-pill" data-p="next"' + (page >= pages ? ' disabled' : '') + '>Selanjutnya' + CH_R + '</button>';
    }
    function render() {
      const total = view.length, pages = Math.max(1, Math.ceil(total / PER_PAGE));
      page = Math.min(Math.max(1, page), pages);
      const slice = view.slice((page - 1) * PER_PAGE, page * PER_PAGE);
      $('rowsD').innerHTML = slice.map(rowD).join('');
      $('rowsM').innerHTML = slice.map(cardM).join('');
      const msg = PEOPLE.size ? 'Tidak ada data rekap yang sesuai filter.' : 'Belum ada data peserta / presensi.';
      $('emptyD').textContent = msg; $('emptyM').textContent = msg;
      $('emptyD').classList.toggle('hidden', total > 0);
      $('emptyM').classList.toggle('hidden', total > 0);
      $('rowsM').classList.toggle('hidden', total === 0);
      const pg = total ? pagerHTML(pages) : '';
      $('pgD').innerHTML = pg; $('pgM').innerHTML = pg;
    }
    function onPager(e) {
      const b = e.target.closest('[data-p]'); if (!b || b.disabled) return;
      const v = b.dataset.p;
      page = v === 'prev' ? page - 1 : v === 'next' ? page + 1 : parseInt(v, 10);
      render();
    }
    $('pgD').addEventListener('click', onPager);
    $('pgM').addEventListener('click', onPager);

    /* ---------- Toast ---------- */
    let tt;
    function toast(msg) {
      const t = $('toast'); t.textContent = msg; t.classList.add('show');
      clearTimeout(tt); tt = setTimeout(() => t.classList.remove('show'), 3200);
    }

    /* ---------- Export Excel (rapi: judul, info filter, header berwarna, border, zebra, total) ---------- */
    async function exportExcel() {
      if (typeof ExcelJS === 'undefined') { toast('Library Excel belum termuat. Periksa koneksi internet lalu muat ulang halaman.'); return; }
      if (!view.length) { toast('Tidak ada data untuk diekspor.'); return; }

      const btn = $('btnExport'); btn.disabled = true; $('btnExportTxt').textContent = 'Memproses…';
      try {
        const from = $('fMulai').value, to = $('fSelesai').value;
        const nm = $('fNama').value, sc = $('fSekolah').value;
        const periode = (from ? fmtDate(from) : 'Awal') + '  s/d  ' + (to ? fmtDate(to) : 'Sekarang');
        const stamp = new Intl.DateTimeFormat('id-ID', { timeZone: TZ, day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: false }).format(new Date()).replace(/\./g, ':') + ' WITA';

        const NAVY = 'FF03045E', LIGHT = 'FFF4F7FB', LINE = 'FFD5DBE6', TOTAL = 'FFDFF7FC';
        const wb = new ExcelJS.Workbook();
        wb.creator = 'ICONNET'; wb.created = new Date();
        const ws = wb.addWorksheet('Rekap Presensi', {
          views: [{ state: 'frozen', ySplit: 7, showGridLines: false }],
          pageSetup: { paperSize: 9, orientation: 'landscape', fitToPage: true, fitToWidth: 1, fitToHeight: 0, horizontalCentered: true, margins: { left: .5, right: .5, top: .6, bottom: .6, header: .3, footer: .3 } }
        });
        ws.columns = [{ width: 6 }, { width: 32 }, { width: 38 }, { width: 14 }, { width: 17 }, { width: 12 }, { width: 12 }];
        const LAST = 'G';
        const border = { top: { style: 'thin', color: { argb: LINE } }, left: { style: 'thin', color: { argb: LINE } }, bottom: { style: 'thin', color: { argb: LINE } }, right: { style: 'thin', color: { argb: LINE } } };

        // Judul & info
        ws.mergeCells('A1:' + LAST + '1');
        Object.assign(ws.getCell('A1'), { value: 'REKAP ABSENSI PESERTA MAGANG' });
        ws.getCell('A1').font = { name: 'Calibri', size: 18, bold: true, color: { argb: NAVY } };
        ws.getCell('A1').alignment = { horizontal: 'center', vertical: 'middle' };
        ws.getRow(1).height = 32;

        ws.mergeCells('A2:' + LAST + '2');
        ws.getCell('A2').value = 'ICONNET  •  Ringkasan data kehadiran berdasarkan periode';
        ws.getCell('A2').font = { name: 'Calibri', size: 11, italic: true, color: { argb: 'FF6B7280' } };
        ws.getCell('A2').alignment = { horizontal: 'center', vertical: 'middle' };
        ws.getRow(2).height = 20;

        const info = [['Periode', periode], ['Filter', 'Nama: ' + (nm || 'Semua') + '   |   Sekolah / Institusi: ' + (sc || 'Semua')], ['Diekspor pada', stamp]];
        info.forEach((it, i) => {
          const r = 3 + i;
          ws.mergeCells('A' + r + ':B' + r);
          ws.mergeCells('C' + r + ':' + LAST + r);
          ws.getCell('A' + r).value = it[0];
          ws.getCell('A' + r).font = { name: 'Calibri', size: 11, bold: true, color: { argb: NAVY } };
          ws.getCell('A' + r).alignment = { horizontal: 'left', vertical: 'middle', indent: 1 };
          ws.getCell('C' + r).value = ': ' + it[1];
          ws.getCell('C' + r).font = { name: 'Calibri', size: 11, color: { argb: 'FF111827' } };
          ws.getCell('C' + r).alignment = { horizontal: 'left', vertical: 'middle' };
          ws.getRow(r).height = 19;
        });
        ws.getRow(6).height = 8;

        // Header tabel (baris 7)
        const head = ws.getRow(7);
        head.values = ['No', 'Nama', 'Sekolah / Institusi', 'Total Hadir', 'Total Terlambat', 'Total Izin', 'Total Sakit'];
        head.height = 28;
        head.eachCell(c => {
          c.font = { name: 'Calibri', size: 11, bold: true, color: { argb: 'FFFFFFFF' } };
          c.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: NAVY } };
          c.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
          c.border = border;
        });

        // Data
        const tot = { hadir: 0, terlambat: 0, izin: 0, sakit: 0 };
        view.forEach((r, i) => {
          const row = ws.addRow([i + 1, r.nama, r.sekolah, r.hadir, r.terlambat, r.izin, r.sakit]);
          row.height = 22;
          tot.hadir += r.hadir; tot.terlambat += r.terlambat; tot.izin += r.izin; tot.sakit += r.sakit;
          row.eachCell({ includeEmpty: true }, (c, col) => {
            c.font = { name: 'Calibri', size: 11, color: { argb: 'FF111827' } };
            c.border = border;
            c.alignment = { vertical: 'middle', horizontal: col === 2 || col === 3 ? 'left' : 'center', indent: col === 2 || col === 3 ? 1 : 0 };
            if (i % 2 === 1) c.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: LIGHT } };
            if (col >= 4) c.numFmt = '0';
          });
          const colors = { 4: 'FF1B8F36', 5: 'FFE0560F', 6: 'FF0A7FA8', 7: 'FFD9780A' };
          [4, 5, 6, 7].forEach(col => { const c = row.getCell(col); c.font = { name: 'Calibri', size: 11, bold: c.value > 0, color: { argb: c.value > 0 ? colors[col] : 'FF9CA3AF' } }; });
        });

        // Baris total
        const tr = ws.addRow(['TOTAL', '', '', tot.hadir, tot.terlambat, tot.izin, tot.sakit]);
        ws.mergeCells('A' + tr.number + ':C' + tr.number);
        tr.height = 24;
        tr.eachCell({ includeEmpty: true }, (c, col) => {
          c.font = { name: 'Calibri', size: 11, bold: true, color: { argb: NAVY } };
          c.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: TOTAL } };
          c.border = Object.assign({}, border, { top: { style: 'medium', color: { argb: NAVY } } });
          c.alignment = { vertical: 'middle', horizontal: 'center' };
          if (col >= 4) c.numFmt = '0';
        });
        ws.getCell('A' + tr.number).alignment = { vertical: 'middle', horizontal: 'right', indent: 1 };

        // Catatan jumlah peserta + autofilter + judul kolom saat cetak
        const note = ws.addRow([]); ws.mergeCells('A' + (tr.number + 2) + ':' + LAST + (tr.number + 2));
        ws.getCell('A' + (tr.number + 2)).value = 'Jumlah peserta: ' + view.length + ' orang';
        ws.getCell('A' + (tr.number + 2)).font = { name: 'Calibri', size: 10, italic: true, color: { argb: 'FF6B7280' } };
        ws.autoFilter = { from: 'A7', to: LAST + (tr.number - 1) };
        ws.pageSetup.printTitlesRow = '7:7';
        ws.headerFooter.oddFooter = '&LICONNET - Rekap Presensi&RHalaman &P dari &N';

        const buf = await wb.xlsx.writeBuffer();
        const blob = new Blob([buf], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
        const fname = 'Rekap_Presensi_' + (from || 'awal') + '_sd_' + (to || todayISO()) + '.xlsx';
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a'); a.href = url; a.download = fname;
        document.body.appendChild(a); a.click(); a.remove();
        setTimeout(() => URL.revokeObjectURL(url), 2000);
        toast('Berhasil mengekspor ' + view.length + ' data ke Excel.');
      } catch (err) {
        console.error(err);
        toast('Gagal mengekspor data. Silakan coba lagi.');
      } finally {
        btn.disabled = false; $('btnExportTxt').textContent = 'Export';
      }
    }
    $('btnExport').addEventListener('click', exportExcel);

    /* ---------- Sidebar, submenu & hamburger ---------- */
    $('toggleBtn').addEventListener('click', () => {
      const c = document.body.classList.toggle('collapsed');
      localStorage.setItem('iconnet_sidebar', c ? '1' : '0');
    });
    $('kelolaBtn').addEventListener('click', () => {
      if (document.body.classList.contains('collapsed')) { document.body.classList.remove('collapsed'); localStorage.setItem('iconnet_sidebar', '0'); }
      $('subD').classList.toggle('open'); $('chevD').classList.toggle('open');
    });
    $('kelolaBtnM').addEventListener('click', () => { $('subM').classList.toggle('open'); $('chevM').classList.toggle('open'); });
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

    /* ---------- Mulai: default periode = awal bulan ini s/d hari ini ---------- */
    fillSelects();
    (function () {
      const t = todayISO();
      $('fMulai').value = t.slice(0, 8) + '01';
      $('fSelesai').value = t;
      applyFilter();
    })();
  </script>
</body>
</html>
