<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Hubungi Kami - ICONNET</title>

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
    .sb-sub a.active { background: #DFF7FC; color: #0B0B3B; font-weight: 500; }
    .chev { transition: transform .2s; }
    .chev.open { transform: rotate(180deg); }

    button { font-family: inherit; }

    /* ===== Form Hubungi Kami: mode lihat vs mode edit ===== */
    .hk-in { width: 100%; border-radius: 10px; border: 1px solid #D9DCE3; background: #fff; font-size: 12px; color: #000; outline: none; transition: border-color .15s, box-shadow .15s, background .15s; }
    .hk-in:focus { border-color: #4A9FF5; box-shadow: 0 0 0 3px rgba(74,159,245,.2); }
    .hk-in.err { border-color: #D93A3F; }
    #hkForm[data-mode="view"] .hk-in { background: #fff; border-color: #E5E7EB; cursor: default; }
    #hkForm[data-mode="view"] .hk-in:focus { box-shadow: none; border-color: #E5E7EB; }
    #hkForm[data-mode="view"] .hk-in[type="email"] { text-decoration: underline; }
    #hkForm[data-mode="view"] .only-edit { display: none; }
    #hkForm[data-mode="edit"] .only-view { display: none; }
    .hk-lbl { display: block; font-size: 12px; font-weight: 500; color: #111; }
    .hk-err { min-height: 14px; margin-top: 3px; font-size: 10.5px; font-weight: 500; color: #D93A3F; }

    /* ===== Mobile / tablet (<900px): ukuran dikecilkan agar tidak kebesaran ===== */
    #mnav > div:first-child { height: 56px; }
    #mnav img { height: 36px; }
    #mmenu > .flex > a, #mmenu > .flex > button { height: 40px; font-size: 12px; }
    #logoutBtnM { height: 40px; font-size: 12px; }
    header.hdr .hdr-t { font-size: 15px; line-height: 1.3; }
    header.hdr .hdr-s { font-size: 11px; line-height: 1.4; }
    #hkTitle { font-size: 13.5px; line-height: 1.3; }
    #hkTitle + p { font-size: 11px; }
    #btnEdit { height: 32px; padding: 0 14px; gap: 6px; font-size: 11.5px; }
    #btnEdit svg { width: 13px; height: 13px; }
    input.hk-in { height: 40px; padding: 0 14px; font-size: 12px; }
    textarea.hk-in { padding: 10px 14px; font-size: 12px; line-height: 1.5; }
    #hkForm .relative > input.hk-in { padding-left: 40px; }
    #hkForm .relative > span { left: 14px; }
    #hkForm .relative > span svg { width: 16px; height: 16px; }
    #btnCancel, #btnSave { height: 38px; width: 108px; font-size: 12px; border-radius: 10px; }
    #toast span.text-xs { font-size: 12px; }

    /* ===== DESKTOP / LAPTOP (>=900px) - sidebar & header sama persis dengan halaman profil ===== */
    @media (min-width: 900px) {
      /* Skala dasar mengikuti frame Figma 1080 px */
      :root { --u: max(min(100vw / 1080, 100vh / 680), 0.6px); --su: max(min(100vw / 1080, 100vh / 790), 0.6px); --sbw: calc(var(--su) * 198); }
      .collapsed { --sbw: 76px; }
      html, body { overflow: hidden; }

      body .hdr-bg { position: fixed; top: 0; left: 0; right: 0; z-index: 0; height: calc(var(--u) * 87); background: #FFFFFF; }

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

      #content { margin-left: var(--sbw); height: 100vh; overflow: hidden; }
      #content::-webkit-scrollbar { display: none; }

      body .hdr { height: calc(var(--u) * 87); padding: 0 calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body header.hdr .hdr-t { font-size: calc(var(--u) * 19); line-height: 1.25; font-weight: 600; color: #03045E; }
      body header.hdr .hdr-s { font-size: calc(var(--u) * 13); line-height: 1.4; margin-top: calc(var(--u) * 2); color: #000; }

      /* ===== Area konten Hubungi Kami: pas satu layar (tanpa scroll), skala Figma 1080 ===== */
      body .main-c { height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 20) calc(var(--u) * 40); display: flex; align-items: center; justify-content: center; }
      body #hkCard { width: 100%; max-width: none; padding: calc(var(--u) * 20) calc(var(--u) * 26); border-radius: calc(var(--u) * 16); }
      body #hkTitle { font-size: calc(var(--u) * 15); line-height: 1.3; }
      body #hkTitle + p { font-size: calc(var(--u) * 11); margin-top: calc(var(--u) * 2); }
      body #btnEdit { height: calc(var(--u) * 32); padding: 0 calc(var(--u) * 18); gap: calc(var(--u) * 6); font-size: calc(var(--u) * 11); }
      body #btnEdit svg { width: calc(var(--u) * 13); height: calc(var(--u) * 13); }
      body #hkCard > div.h-px { margin-top: calc(var(--u) * 12); }
      body #hkForm { margin-top: calc(var(--u) * 12); }
      body #hkForm .grid { column-gap: calc(var(--u) * 16); row-gap: 0; }
      body #hkForm .hk-lbl { font-size: calc(var(--u) * 12); line-height: 1.3; margin-top: 0; }
      body .hk-in { font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 10); margin-top: calc(var(--u) * 6); }
      body input.hk-in { height: calc(var(--u) * 38); padding: 0 calc(var(--u) * 14); }
      body textarea.hk-in { height: calc(var(--u) * 70); padding: calc(var(--u) * 8) calc(var(--u) * 14); line-height: 1.5; overflow-y: auto; scrollbar-width: none; }
      body textarea.hk-in::-webkit-scrollbar { display: none; }
      body .hk-err { min-height: calc(var(--u) * 14); margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 10); line-height: 1.3; }
      body #hkForm > p.hk-lbl { margin-top: 0; }
      body #hkForm .relative { margin-top: 0; }
      body #hkForm .relative > input.hk-in { padding-left: calc(var(--u) * 40); margin-top: 0; }
      body #hkForm .relative { margin-top: calc(var(--u) * 6); }
      body #hkForm .relative > span { left: calc(var(--u) * 14); }
      body #hkForm .relative > span svg { width: calc(var(--u) * 16); height: calc(var(--u) * 16); }
      body #hkForm .grid.gap-y-3 { row-gap: calc(var(--u) * 0); }
      body #hkForm .only-edit { margin-top: calc(var(--u) * 12); gap: calc(var(--u) * 14); }
      body #btnCancel, body #btnSave { height: calc(var(--u) * 34); width: calc(var(--u) * 108); font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 10); }
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
      <span id="toastText" class="text-xs font-medium sm:text-sm">Berhasil</span>
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
        <button id="kelolaBtnM" type="button" class="flex h-11 w-full items-center gap-3 rounded-xl bg-[#E1FAFF] px-3.5 text-[13px] font-medium text-ink transition"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.800 2.800 4 5.800 4 9s-1.200 6.200-4 9c-2.800-2.800-4-5.800-4-9s1.200-6.200 4-9z"/></svg><span class="flex-1 text-left">Kelola Tampilan</span><svg id="chevM" class="chev open h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.500" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg></button>
        <div id="subM" class="sb-sub open">
          <a href="{{ url('kelola-beranda') }}">Beranda</a>
          <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
          <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
          <a href="{{ url('kelola-hubungi-kami') }}" class="active">Hubungi Kami</a>
        </div>
    <a href="{{ url('profil-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.200 18.500c1.200-2.200 3.200-3.300 5.800-3.300s4.600 1.100 5.800 3.300"/></svg>Profile</a>
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
      <button id="kelolaBtn" type="button" class="sb-item flex items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 py-2.5 text-xs font-medium text-ink transition">
        <svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.600 3.8 9S14.500 18.400 12 21c-2.500-2.600-3.800-5.600-3.800-9S9.500 5.600 12 3z"/></svg>
        <span class="sb-label flex-1 text-left">Kelola Tampilan</span>
        <svg id="chevD" class="chev open sb-label h-3 w-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
      </button>
      <div id="subD" class="sb-sub open">
        <a href="{{ url('kelola-beranda') }}">Beranda</a>
        <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
        <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
        <a href="{{ url('kelola-hubungi-kami') }}" class="active">Hubungi Kami</a>
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
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Pengelolaan Web Profile ICONNET</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Super Admin mengelola konten yang tampil di portal publik website ICONNET</p>
    </header>

    <main class="main-c px-4 pb-8 pt-4 sm:px-6">
      <section id="hkCard" class="mx-auto w-full max-w-[600px] rounded-2xl bg-white p-4 shadow-[0_3px_14px_rgba(0,0,0,0.16)] sm:p-5">

        <!-- Judul kartu -->
        <div class="flex items-start justify-between gap-3">
          <div class="min-w-0">
            <h2 id="hkTitle" class="text-[15px] font-semibold text-black sm:text-base">Pengelolaan Bagian: Hubungi Kami</h2>
            <p class="mt-0.5 text-[11.5px] text-slate-500 sm:text-xs">Kelola alamat kantor perwakilan, call center, WhatsApp, dan media sosial resmi.</p>
          </div>
          <button id="btnEdit" type="button" class="only-view flex h-9 flex-none items-center gap-2 rounded-full bg-[#0891B2] px-5 text-xs font-medium text-white shadow-[0_3px_6px_rgba(0,0,0,0.2)] transition hover:brightness-110 active:scale-[.98]" form="hkForm">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.500 3.500a2.120 2.120 0 013 3L7 19l-4 1 1-4 12.500-12.500z"/></svg>
            Edit
          </button>
        </div>
        <div class="mt-4 h-px bg-slate-200"></div>

        <form id="hkForm" data-mode="view" novalidate autocomplete="off" class="mt-4">

          <!-- Alamat -->
          <div>
            <label for="fAlamat" class="hk-lbl">Alamat Kantor Layanan / Regional</label>
            <textarea id="fAlamat" rows="3" readonly class="hk-in mt-2 resize-none px-4 py-3.5 leading-relaxed"></textarea>
            <p id="eAlamat" class="hk-err"></p>
          </div>

          <!-- Call center & WhatsApp -->
          <div class="mt-1 grid grid-cols-1 gap-x-5 gap-y-1 sm:grid-cols-2">
            <div>
              <label for="fCall" class="hk-lbl">Call Center</label>
              <input id="fCall" type="text" inputmode="tel" readonly class="hk-in mt-2 h-12 px-4" />
              <p id="eCall" class="hk-err"></p>
            </div>
            <div>
              <label for="fWa" class="hk-lbl">Whatsapp</label>
              <input id="fWa" type="text" inputmode="tel" readonly class="hk-in mt-2 h-12 px-4" />
              <p id="eWa" class="hk-err"></p>
            </div>
          </div>

          <!-- Email & jam operasional -->
          <div class="mt-1 grid grid-cols-1 gap-x-5 gap-y-1 sm:grid-cols-2">
            <div>
              <label for="fEmail" class="hk-lbl">Email</label>
              <input id="fEmail" type="email" readonly class="hk-in mt-2 h-12 px-4" />
              <p id="eEmail" class="hk-err"></p>
            </div>
            <div>
              <label for="fJam" class="hk-lbl">Jam Opersional</label>
              <input id="fJam" type="text" readonly class="hk-in mt-2 h-12 px-4" />
              <p id="eJam" class="hk-err"></p>
            </div>
          </div>

          <!-- Media sosial -->
          <p class="hk-lbl mt-1">Media Sosial Resmi</p>
          <div class="mt-2 grid grid-cols-1 gap-x-5 gap-y-3 sm:grid-cols-2">
            <div class="relative">
              <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-black">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.500" cy="6.500" r="1" fill="currentColor" stroke="none"/></svg>
              </span>
              <input id="fIg" type="text" readonly aria-label="Instagram" class="hk-in h-12 pl-11 pr-4" />
            </div>
            <div class="relative">
              <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-black">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.070C24 5.400 18.630 0 12 0S0 5.400 0 12.070C0 18.100 4.390 23.100 10.130 24v-8.440H7.080v-3.490h3.050V9.410c0-3.020 1.800-4.700 4.540-4.700 1.310 0 2.680.24 2.680.24v2.970h-1.510c-1.490 0-1.960.93-1.960 1.890v2.260h3.330l-.53 3.490h-2.800V24C19.620 23.100 24 18.100 24 12.070z"/></svg>
              </span>
              <input id="fFb" type="text" readonly aria-label="Facebook" class="hk-in h-12 pl-11 pr-4" />
            </div>
            <div class="relative">
              <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-black">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M12.525.020c1.310-.02 2.610-.01 3.910-.02.080 1.530.630 3.090 1.750 4.170 1.120 1.110 2.700 1.620 4.240 1.790v4.030c-1.440-.05-2.890-.35-4.200-.97-.57-.26-1.100-.59-1.620-.93-.01 2.920.01 5.840-.02 8.750-.08 1.400-.54 2.790-1.350 3.940-1.310 1.920-3.580 3.170-5.910 3.210-1.430.08-2.860-.31-4.080-1.030-2.020-1.190-3.440-3.370-3.650-5.710-.02-.5-.03-1-.01-1.490.18-1.900 1.120-3.720 2.580-4.960 1.660-1.440 3.980-2.130 6.150-1.720.02 1.480-.04 2.960-.04 4.440-.99-.32-2.150-.23-3.020.37-.63.41-1.110 1.040-1.360 1.750-.21.51-.15 1.070-.14 1.610.24 1.640 1.820 3.020 3.500 2.870 1.120-.01 2.190-.66 2.770-1.610.19-.33.40-.67.41-1.060.10-1.790.06-3.570.07-5.360.01-4.030-.01-8.050.02-12.070z"/></svg>
              </span>
              <input id="fTt" type="text" readonly aria-label="TikTok" class="hk-in h-12 pl-11 pr-4" />
            </div>
            <div class="relative">
              <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-black">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="currentColor"><path d="M23.953 4.570a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.920 4.920 0 00-8.384 4.482C7.690 8.095 4.067 6.130 1.640 3.162a4.822 4.822 0 00-.666 2.475c0 1.710.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.170-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.590z"/></svg>
              </span>
              <input id="fTw" type="text" readonly aria-label="Twitter" class="hk-in h-12 pl-11 pr-4" />
            </div>
          </div>

          <!-- Tombol mode edit -->
          <div class="only-edit mt-6 flex items-center justify-center gap-4">
            <button id="btnCancel" type="button" class="h-10 w-32 rounded-xl bg-[#E8E8E8] text-[13px] font-semibold text-black shadow-[0_3px_5px_rgba(0,0,0,0.2)] transition hover:bg-[#DEDEDE] active:scale-[.99]">Batal</button>
            <button id="btnSave" type="submit" class="h-10 w-32 rounded-xl bg-[#4A9FF5] text-[13px] font-semibold text-white shadow-[0_3px_5px_rgba(0,0,0,0.2)] transition hover:brightness-105 active:scale-[.99]">Simpan</button>
          </div>
        </form>
      </section>
    </main>
  </div>

  <script src="{{ asset('js/site-data.js') }}"></script>
  <script>
    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)

    /* =====================================================================
       Data "Hubungi Kami" dari database (tabel pengaturans: alamat, call_center,
       no_wa_sales, email, jam_operasional, media sosial). saveData() menyimpan lewat API Laravel;
       halaman publik & footer semua halaman membaca data yang sama.
       ===================================================================== */
    const HK_KEY = ICONNET.KEY_HUBUNGI;
    // Data awal (isi asli hubungi-kami.html) ada di site-data.js, sehingga admin dan
    // halaman publik (termasuk footer semua halaman) membaca data yang sama persis.
    const loadData = () => ICONNET.loadHubungi();
    async function saveData(d) {
      const res = await ICONNET_API.request('PUT', 'api/v1/kelola/hubungi', d);
      ICONNET_API.write(HK_KEY, res.data);
      return res.data;
    }

    /* Peta field form <-> data */
    const FIELDS = [
      { id: 'fAlamat', key: 'alamat',     err: 'eAlamat' },
      { id: 'fCall',   key: 'callCenter', err: 'eCall' },
      { id: 'fWa',     key: 'whatsapp',   err: 'eWa' },
      { id: 'fEmail',  key: 'email',      err: 'eEmail' },
      { id: 'fJam',    key: 'jam',        err: 'eJam' },
      { id: 'fIg',     key: 'instagram' },
      { id: 'fFb',     key: 'facebook' },
      { id: 'fTt',     key: 'tiktok' },
      { id: 'fTw',     key: 'twitter' }
    ];
    const form = $('hkForm');
    let saved = loadData();

    function fillForm(d) { FIELDS.forEach(f => { $(f.id).value = d[f.key] || ''; }); clearErrors(); }
    function clearErrors() {
      FIELDS.forEach(f => { $(f.id).classList.remove('err'); if (f.err) $(f.err).textContent = ''; });
    }
    function setMode(mode) {
      form.dataset.mode = mode;
      const editing = mode === 'edit';
      FIELDS.forEach(f => { $(f.id).readOnly = !editing; });
      $('hkTitle').textContent = editing ? 'Edit Pengelolaan Bagian: Hubungi Kami' : 'Pengelolaan Bagian: Hubungi Kami';
      if (editing) $('fAlamat').focus();
    }
    fillForm(saved); setMode('view');

    /* ---------- Edit / Batal / Simpan ---------- */
    $('btnEdit').addEventListener('click', () => setMode('edit'));
    $('btnCancel').addEventListener('click', () => { fillForm(saved); setMode('view'); });

    function setErr(f, msg) { $(f.id).classList.add('err'); if (f.err) $(f.err).textContent = msg; }
    function validate(v) {
      clearErrors();
      let ok = true;
      const byKey = k => FIELDS.find(f => f.key === k);
      if (!v.alamat) { setErr(byKey('alamat'), 'Alamat kantor wajib diisi.'); ok = false; }
      if (!v.callCenter) { setErr(byKey('callCenter'), 'Call center wajib diisi.'); ok = false; }
      else if (!/^[0-9+\-\s()]{3,20}$/.test(v.callCenter)) { setErr(byKey('callCenter'), 'Gunakan angka saja, contoh: 150678.'); ok = false; }
      if (!v.whatsapp) { setErr(byKey('whatsapp'), 'Nomor WhatsApp wajib diisi.'); ok = false; }
      else if (!/^[0-9+\-\s()]{8,20}$/.test(v.whatsapp)) { setErr(byKey('whatsapp'), 'Nomor WhatsApp tidak valid, contoh: 0853-3660-3030.'); ok = false; }
      if (!v.email) { setErr(byKey('email'), 'Email wajib diisi.'); ok = false; }
      else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v.email)) { setErr(byKey('email'), 'Format email tidak valid.'); ok = false; }
      if (!v.jam) { setErr(byKey('jam'), 'Jam operasional wajib diisi.'); ok = false; }
      return ok;
    }

    form.addEventListener('submit', async e => {
      e.preventDefault();
      if (form.dataset.mode !== 'edit') return;
      const v = {};
      FIELDS.forEach(f => { v[f.key] = $(f.id).value.trim(); });
      if (!validate(v)) return;
      try { saved = await saveData(v); }
      catch (err) { return showToast(err.message || 'Gagal menyimpan data. Coba lagi.'); }
      fillForm(saved); setMode('view');
      window.scrollTo({ top: 0, behavior: 'smooth' });
      showToast('Data Hubungi Kami berhasil disimpan');
    });
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && form.dataset.mode === 'edit') $('btnCancel').click();
    });

    /* ---------- Toast ---------- */
    function showToast(msg) {
      const t = $('toast'); $('toastText').textContent = msg;
      t.classList.remove('opacity-0', '-translate-y-4');
      clearTimeout(window._tt);
      window._tt = setTimeout(() => t.classList.add('opacity-0', '-translate-y-4'), 3000);
    }

    /* ---------- Sidebar (desktop) & hamburger (mobile) - sama dengan halaman profil ---------- */
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
