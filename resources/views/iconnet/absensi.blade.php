<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Presensi - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    #toast { transition: opacity .3s ease, transform .3s ease; }
    .sb-div { display: none; }


    /* ===== Umum (mobile first) ===== */
    .seg-b { color: #000; transition: background-color .15s ease, color .15s ease; }
    .seg-b.on { background: #000050; color: #fff; }
    .mirror { transform: scaleX(-1); }
    .sel { -webkit-appearance: none; appearance: none; padding-right: 34px;
      background: #fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 12px center; }
    input[type="date"] { display: block; max-width: 100%; min-width: 0; }
    .drop.over { background: #F0F9FD; border-color: #0F86CC; }
    button { font-family: inherit; }
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

      /* ---- khusus Presensi: disesuaikan dengan desain (frame 1110x790) ---- */
      body #content { overflow: hidden; }
      body .main-c { height: calc(var(--u) * 703); height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 21) calc(var(--u) * 35) calc(var(--u) * 42) calc(var(--u) * 38); gap: 0; }

      /* Tab bar 840x63 */
      body .tabbar { flex: none; height: calc(var(--u) * 63); padding: 0 calc(var(--u) * 13) 0 calc(var(--u) * 12); border-radius: calc(var(--u) * 8); flex-direction: row; align-items: center; justify-content: space-between; }
      body .seg { width: calc(var(--u) * 354); height: calc(var(--u) * 42); padding: calc(var(--u) * 7) calc(var(--u) * 9); border-radius: calc(var(--u) * 8); }
      body .seg-b { height: 100%; font-size: calc(var(--u) * 13); border-radius: calc(var(--u) * 6); }
      body .jam { font-size: calc(var(--u) * 12); }

      /* Presensi: kartu kamera 546x420 + kartu detail 265x420 */
      body .pwrap { flex: 1 1 0; min-height: 0; margin-top: calc(var(--u) * 20); gap: calc(var(--u) * 24); }
      body .agrid { flex: 1 1 0; min-height: 0; display: grid; grid-template-columns: minmax(0, 1fr) calc(var(--u) * 265); grid-template-rows: minmax(0, 1fr); gap: calc(var(--u) * 31); }
      body .cam-card { padding: calc(var(--u) * 24); border-radius: calc(var(--u) * 9); min-height: 0; }
      body .cam-box { border-radius: calc(var(--u) * 9); }
      body .ph-i, body .pill { display: none; }
      body .ph-m { font-size: calc(var(--u) * 11); max-width: calc(var(--u) * 340); margin-top: 0; }
      body .cam-acts { margin-top: calc(var(--u) * 22); }
      body .cam-acts .row { gap: calc(var(--u) * 30); }
      body .btn-main, body .btn-ghost, body .btn-send { height: calc(var(--u) * 38); font-size: calc(var(--u) * 14); border-radius: calc(var(--u) * 11); }
      body .ov-i svg { width: calc(var(--u) * 52); height: calc(var(--u) * 52); }
      body .ov-t { font-size: calc(var(--u) * 16); margin-top: calc(var(--u) * 10); }
      body .ov-s { font-size: calc(var(--u) * 12); margin-top: calc(var(--u) * 4); }
      body .ov-n { font-size: calc(var(--u) * 36); margin-top: calc(var(--u) * 6); }

      body .det-card { padding: calc(var(--u) * 13) calc(var(--u) * 14); border-radius: calc(var(--u) * 9); min-height: 0; overflow: hidden; }
      body .det-t { font-size: calc(var(--u) * 15); line-height: calc(var(--u) * 20); }
      body .det-list { flex: 1 1 0; min-height: 0; margin-top: calc(var(--u) * 14); gap: calc(var(--u) * 14); }
      body .det-i { flex: none; padding: calc(var(--u) * 11) calc(var(--u) * 13) 0; border-radius: calc(var(--u) * 7); }
      body .det-i:nth-child(1) { height: calc(var(--u) * 98); }
      body .det-i:nth-child(2) { height: calc(var(--u) * 96); }
      body .det-i:nth-child(3) { flex: 1 1 0; min-height: 0; }
      body .det-l { font-size: calc(var(--u) * 12); line-height: calc(var(--u) * 16); gap: calc(var(--u) * 8); }
      body .det-l svg { width: calc(var(--u) * 15); height: calc(var(--u) * 15); }
      body .det-v { font-size: calc(var(--u) * 14); line-height: calc(var(--u) * 18); margin-top: calc(var(--u) * 14); }
      body .det-s { font-size: calc(var(--u) * 12); line-height: calc(var(--u) * 18); margin-top: calc(var(--u) * 14); }
      body .det-i:nth-child(3) .det-s { font-size: calc(var(--u) * 11.5); }

      /* Petunjuk 840x113 */
      body .tips { flex: none; height: calc(var(--u) * 113); padding: calc(var(--u) * 8) calc(var(--u) * 20) 0 calc(var(--u) * 17.5); gap: calc(var(--u) * 13.5); border-radius: calc(var(--u) * 8); align-items: flex-start; }
      body .tips > svg { width: calc(var(--u) * 19); height: calc(var(--u) * 19); margin-top: calc(var(--u) * 3.5); }
      body .tips-t { font-size: calc(var(--u) * 13.5); line-height: calc(var(--u) * 24); font-weight: 500; }
      body .tips-l { font-size: calc(var(--u) * 12.5); line-height: calc(var(--u) * 24); margin-top: 0; padding-left: calc(var(--u) * 16); }

      /* Form izin / sakit (kartu 840x555) */
      body .frm:not(.hidden) { display: flex; }
      body .frm { flex: 1 1 0; min-height: 0; flex-direction: column; margin-top: calc(var(--u) * 22); border-radius: calc(var(--u) * 9); }
      body .frm-h { position: relative; flex: none; height: calc(var(--u) * 63); padding: calc(var(--u) * 11) calc(var(--u) * 26) 0 calc(var(--u) * 28); border-bottom: 0; }
      body .frm-h::after { content: ''; position: absolute; left: calc(var(--u) * 18); right: calc(var(--u) * 18); bottom: 0; height: 1px; background: #E3E5EA; }
      body .frm-t { font-size: calc(var(--u) * 16); line-height: calc(var(--u) * 18); font-weight: 500; gap: calc(var(--u) * 9); }
      body .frm-t svg { width: calc(var(--u) * 16); height: calc(var(--u) * 16); }
      body .frm-s { font-size: calc(var(--u) * 11.5); line-height: calc(var(--u) * 16); margin-top: calc(var(--u) * 7); color: #4A4A4A; }
      body .frm-b { flex: 1 1 0; min-height: 0; display: flex; flex-direction: column; padding: calc(var(--u) * 16) calc(var(--u) * 26) calc(var(--u) * 21); gap: 0; }
      body .frm-b > :nth-child(2) { margin-top: calc(var(--u) * 12); }
      body .frm-b > :nth-child(3) { margin-top: calc(var(--u) * 9); }
      body .frm-b > :nth-child(4) { margin-top: calc(var(--u) * 17.5); flex: 1 1 0; min-height: 0; display: flex; flex-direction: column; }
      body .frm-b > :nth-child(5) { margin-top: calc(var(--u) * 21); flex: none; gap: calc(var(--u) * 6); }
      body .frm-dates { gap: calc(var(--u) * 31); }
      body .lbl { font-size: calc(var(--u) * 13); line-height: calc(var(--u) * 16); margin-bottom: calc(var(--u) * 6); font-weight: 500; }
      body .inp { height: calc(var(--u) * 36); font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 7); padding-left: calc(var(--u) * 14); padding-right: calc(var(--u) * 14); border-color: #CFCFD6; }
      body .sel { padding-right: calc(var(--u) * 34); background-position: right calc(var(--u) * 14) center; background-size: calc(var(--u) * 16); }
      body textarea.inp { height: calc(var(--u) * 65.5); padding-top: calc(var(--u) * 10); padding-bottom: calc(var(--u) * 10); }
      body .drop { flex: 1 1 0; min-height: 0; padding: 0 calc(var(--u) * 12) calc(var(--u) * 8); border-radius: calc(var(--u) * 5); border-color: #3A3A3A; }
      body .drop-ic { width: calc(var(--u) * 27.5); height: calc(var(--u) * 27.5); }
      body .drop-ic svg { width: calc(var(--u) * 14); height: calc(var(--u) * 14); }
      body .drop-t { font-size: calc(var(--u) * 12.5); line-height: calc(var(--u) * 16); margin-top: calc(var(--u) * 6); }
      body .drop-s { font-size: calc(var(--u) * 10.5); line-height: calc(var(--u) * 14); margin-top: calc(var(--u) * 4); }
      body .drop-b { height: calc(var(--u) * 26); width: calc(var(--u) * 132); justify-content: center; padding: 0; font-size: calc(var(--u) * 12); margin-top: calc(var(--u) * 8); border-radius: calc(var(--u) * 6); }
      body .btn-send { max-width: calc(var(--u) * 494); }
      body .err { font-size: calc(var(--u) * 11); line-height: calc(var(--u) * 14); }
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

  <!-- ===================== NAVBAR MOBILE (hamburger menu) ===================== -->
  <nav id="mnav" class="sticky top-0 z-50 lg:hidden">
    <div class="flex h-16 items-center justify-between bg-white px-4 shadow-[0_2px_10px_rgba(0,0,0,0.08)]">
      <a href="{{ url('beranda') }}" class="block">
        <img src="{{ asset('images/logo-iconin.png') }}" alt="ICONIN" class="block h-12 w-auto" />
      </a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-[#03045E] transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>Beranda</a>
        <a href="{{ url('absensi') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 text-[13px] font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg>Presensi</a>
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
      <a href="{{ url('beranda') }}" class="sb-label block"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONIN" class="logo-img block h-9 w-auto" /></a>
      <button id="toggleBtn" type="button" aria-label="Ciutkan sidebar" class="absolute -right-[22px] top-1/2 flex h-[22px] w-[22px] -translate-y-1/2 items-center justify-center rounded-full bg-cyan2 shadow">
        <svg class="h-3 w-3 transition-transform" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M15 6l-6 6 6 6"/></svg>
      </button>
    </div>
    <div class="sb-div"></div>

    <nav class="sb-nav mt-8 flex flex-col gap-2">
      <a href="{{ url('beranda') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg><span class="sb-label">Beranda</span></a>
      <a href="{{ url('absensi') }}" class="sb-item flex items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 py-2.5 text-xs font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg><span class="sb-label">Presensi</span></a>
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
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Presensi</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Silahkan lakukan presensi kehadiran Anda hari ini.</p>
    </header>

    <main class="main-c flex flex-col px-4 pb-8 pt-4 sm:px-6">

      <!-- Tab -->
      <section class="tabbar flex flex-col gap-2.5 rounded-xl bg-white p-2.5 shadow-[0_2px_8px_rgba(0,0,0,0.15)] sm:flex-row sm:items-center sm:justify-between sm:p-3">
        <div class="seg flex rounded-lg bg-[#F5F6FC] p-1 sm:w-[300px]" role="tablist">
          <button id="tabP" type="button" role="tab" aria-selected="true" class="seg-b on h-9 flex-1 rounded-md text-xs font-medium">Presensi</button>
          <button id="tabI" type="button" role="tab" aria-selected="false" class="seg-b h-9 flex-1 rounded-md text-xs font-medium">Pengajuan Izin / Sakit</button>
        </div>
        <p class="jam text-[11px] text-slate-600 sm:text-xs">Jam Operasional: 08.00 - 17.00 WITA</p>
      </section>

      <!-- ===== Panel presensi ===== -->
      <div id="panelP" class="pwrap mt-4 flex flex-col gap-4">
        <div class="agrid flex flex-col gap-4 lg:grid">

          <section class="cam-card flex flex-col rounded-xl bg-white p-3 shadow-[0_2px_8px_rgba(0,0,0,0.15)]">
            <div id="camBox" class="cam-box relative flex aspect-[4/3] w-full items-center justify-center overflow-hidden rounded-lg bg-[#EBEBEB] lg:aspect-auto lg:min-h-0 lg:flex-1">
              <video id="video" class="mirror absolute inset-0 hidden h-full w-full object-cover" autoplay playsinline muted></video>
              <img id="shot" class="absolute inset-0 hidden h-full w-full object-cover" alt="Hasil foto presensi" />
              <div id="ph" class="flex flex-col items-center px-4 text-center">
                <p id="phMsg" class="ph-m mt-2 hidden text-[11px] leading-relaxed text-slate-600"></p>
              </div>
              <span id="phase" class="pill absolute left-2.5 top-2.5 rounded-full bg-white/90 px-3 py-1 text-[10px] font-semibold text-[#03045E] shadow-sm">Presensi Masuk</span>
              <div id="ov" class="absolute inset-0 flex hidden flex-col items-center justify-center bg-[#EBEBEB] px-5 text-center">
                <span id="ovIcon" class="ov-i"></span>
                <p id="ovT" class="ov-t mt-2.5 text-sm font-semibold text-black"></p>
                <p id="ovS" class="ov-s mt-1 whitespace-pre-line text-[11px] leading-relaxed text-slate-600"></p>
                <p id="ovN" class="ov-n mt-1.5 hidden text-3xl font-semibold text-[#03045E]"></p>
              </div>
            </div>

            <p id="waitNote" class="mt-2 hidden text-left text-[11px] text-slate-600"></p>

            <div id="actLive" class="cam-acts mt-3">
              <button id="btnSnap" type="button" class="btn-main h-11 w-full rounded-xl bg-[#00B4D3] text-[13px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.2)] transition hover:brightness-105 active:scale-[.99]">Ambil Foto &amp; Absen</button>
            </div>
            <div id="actShot" class="cam-acts mt-3 hidden">
              <div class="row grid grid-cols-2 gap-3">
                <button id="btnRetake" type="button" class="btn-ghost h-11 rounded-xl bg-[#EDEDED] text-[13px] font-semibold text-black shadow-[0_3px_6px_rgba(0,0,0,0.2)] transition hover:bg-[#E4E4E4] active:scale-[.99]">Ulang</button>
                <button id="btnOk" type="button" class="btn-main h-11 rounded-xl bg-[#00B4D3] text-[13px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.2)] transition hover:brightness-105 active:scale-[.99]">Konfirmasi Presensi</button>
              </div>
            </div>
            <input id="selfie" type="file" accept="image/*" capture="user" class="hidden" />
          </section>

          <aside class="det-card flex flex-col rounded-xl bg-white p-3 shadow-[0_2px_8px_rgba(0,0,0,0.15)]">
            <h3 class="det-t text-center text-[13px] font-semibold">Detail Informasi Presensi</h3>
            <div class="det-list mt-3 flex flex-col gap-2.5">
              <div class="det-i rounded-lg border border-slate-200 bg-[#FAFAFE] px-3 py-2.5">
                <p class="det-l flex items-center gap-2 text-[11px] text-slate-600"><svg class="h-3.5 w-3.5 flex-none" viewBox="0 0 24 24" fill="none" stroke="#0B0B5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.200 2"/></svg>Waktu &amp; Tanggal</p>
                <p id="clock" class="det-v mt-1.5 text-[13px] font-semibold">--:--:-- WITA</p>
                <p id="dateTxt" class="det-s mt-1.5 text-[11px] text-slate-600">&nbsp;</p>
              </div>
              <div class="det-i rounded-lg border border-slate-200 bg-[#FAFAFE] px-3 py-2.5">
                <p class="det-l flex items-center gap-2 text-[11px] text-slate-600"><svg class="h-3.5 w-3.5 flex-none" viewBox="0 0 24 24" fill="#0B0B5C" fill-rule="evenodd"><path d="M2 10h6v11H2zM3.8 12.5v2.4h2.4v-2.4zM3.8 16.5v2.4h2.4v-2.4zM8 3h14v18H8zM10.6 6v2.4H13V6zM16 6v2.4h2.4V6zM10.6 10.5v2.4H13v-2.4zM16 10.5v2.4h2.4v-2.4zM10.6 15v2.4H13V15zM16 15v2.4h2.4V15z"/></svg>Nama Sekolah / Institusi</p>
                <p id="school" class="det-v mt-1.5 text-[13px] font-semibold">-</p>
              </div>
              <div class="det-i rounded-lg border border-slate-200 bg-[#FAFAFE] px-3 py-2.5">
                <p class="det-l flex items-center gap-2 text-[11px] text-slate-600"><svg class="h-3.5 w-3.5 flex-none" viewBox="0 0 24 24" fill="none" stroke="#0B0B5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 21s7-6.100 7-11.500A7 7 0 005 9.500C5 14.900 12 21 12 21z"/><circle cx="12" cy="9.500" r="2.500"/></svg>Lokasi Kantor ICONNET</p>
                <p class="det-v mt-1.5 text-[13px] font-semibold">Kantor ICONNET Banjarbaru</p>
                <p class="det-s mt-1.5 text-[11px] leading-relaxed text-slate-600">Jl. A. Yani 33.5, Loktabat Selatan, Kota Banjarbaru, Kalimantan Selatan 70712</p>
              </div>
            </div>
          </aside>
        </div>

        <section class="tips flex items-start gap-2.5 rounded-xl border border-slate-300 bg-[#FBF5F0] px-4 py-3 shadow-[0_2px_6px_rgba(0,0,0,0.12)]">
          <svg class="mt-0.5 h-4 w-4 flex-none text-[#E0780A]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><circle cx="12" cy="12" r="9.500"/><path d="M12 11v5.500"/><circle cx="12" cy="7.600" r="1.100" fill="currentColor" stroke="none"/></svg>
          <div>
            <h3 class="tips-t text-xs font-semibold">Petunjuk Pengambilan Foto:</h3>
            <ul class="tips-l mt-1 list-disc pl-4 text-[11px] leading-relaxed text-slate-800">
              <li>Posisikan wajah tepat di tengah area foto.</li>
              <li>Pastikan pencahayaan terang serta tidak memakai kacamata hitam atau penutup wajah.</li>
              <li>Waktu dan tanggal presensi akan tercatat secara otomatis oleh sistem.</li>
            </ul>
          </div>
        </section>
      </div>

      <!-- ===== Panel izin / sakit ===== -->
      <section id="panelI" class="frm mt-4 hidden overflow-hidden rounded-xl bg-white shadow-[0_2px_8px_rgba(0,0,0,0.15)]">
        <div class="frm-h border-b border-slate-200 px-4 py-3 sm:px-5">
          <h2 class="frm-t flex items-center gap-2 text-sm font-semibold sm:text-base">
            <svg class="h-4 w-4 flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="3" width="14" height="18" rx="2.500"/><path d="M8.500 8h7M8.500 12h7M8.500 16h4.500"/></svg>
            Formulir Pengajuan Izin / Sakit
          </h2>
          <p class="frm-s mt-1 text-[11px] leading-relaxed text-slate-600 sm:text-xs">Isi data izin, lampirkan bukti chat persetujuan pembimbing atau surat dokter.</p>
        </div>
        <div class="frm-b flex flex-col gap-3.5 px-4 py-4 sm:px-5">
          <div>
            <label for="jenis" class="lbl mb-1.5 block text-xs font-medium">Jenis Izin</label>
            <select id="jenis" class="inp sel h-10 w-full rounded-lg border border-slate-300 px-3 text-xs outline-none focus:border-[#0F86CC] focus:ring-2 focus:ring-[#0F86CC]/20">
              <option value="izin">Izin</option>
              <option value="sakit">Sakit</option>
            </select>
          </div>
          <div class="frm-dates grid grid-cols-2 gap-3 sm:gap-6">
            <div class="min-w-0">
              <label for="tglMulai" class="lbl mb-1.5 block text-xs font-medium">Tanggal Mulai</label>
              <input id="tglMulai" type="date" class="inp h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-xs outline-none focus:border-[#0F86CC] focus:ring-2 focus:ring-[#0F86CC]/20" />
            </div>
            <div class="min-w-0">
              <label for="tglSelesai" class="lbl mb-1.5 block text-xs font-medium">Tanggal Selesai</label>
              <input id="tglSelesai" type="date" class="inp h-10 w-full rounded-lg border border-slate-300 bg-white px-3 text-xs outline-none focus:border-[#0F86CC] focus:ring-2 focus:ring-[#0F86CC]/20" />
            </div>
          </div>
          <div>
            <label for="alasan" class="lbl mb-1.5 block text-xs font-medium">Alasan Izin</label>
            <textarea id="alasan" rows="3" maxlength="300" placeholder="Jelaskan alasan izin Anda..." class="inp block w-full resize-none rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-xs outline-none placeholder:text-slate-400 focus:border-[#0F86CC] focus:ring-2 focus:ring-[#0F86CC]/20"></textarea>
          </div>
          <div>
            <span class="lbl mb-1.5 block text-xs font-medium">Unggah Bukti Chat / Surat Izin</span>
            <div id="drop" role="button" tabindex="0" class="drop flex cursor-pointer flex-col items-center justify-center rounded-lg border border-dashed border-slate-500 px-3 py-4 text-center transition">
              <span id="dropIc" class="drop-ic flex h-8 w-8 items-center justify-center rounded-full bg-slate-100"><svg class="h-4 w-4 text-[#0F86CC]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16V5M7.500 9.500L12 5l4.500 4.500M5 19h14"/></svg></span>
              <p id="dropT" class="drop-t mt-2 text-xs font-semibold">Klik untuk mengunggah</p>
              <p id="dropS" class="drop-s mt-0.5 text-[10px] text-slate-500">PNG, JPG, PDF hingga 10MB</p>
              <span id="dropB" class="drop-b mt-2 inline-flex h-8 items-center rounded-lg border border-slate-200 bg-white px-5 text-xs font-medium shadow-sm">Pilih File</span>
            </div>
            <input id="file" type="file" accept=".png,.jpg,.jpeg,.pdf,image/png,image/jpeg,application/pdf" class="hidden" />
          </div>
          <div class="flex flex-col items-center gap-2">
            <p id="izinErr" class="err hidden text-center text-xs font-medium text-[#D93A3F]" role="alert"></p>
            <button id="btnSend" type="button" class="btn-send h-11 w-full max-w-[430px] rounded-xl bg-[#0F86CC] text-[13px] font-semibold text-white shadow-[0_3px_8px_rgba(0,0,0,0.2)] transition hover:brightness-105 active:scale-[.99]">Kirim Pengajuan Izin</button>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- ===================== POPUP ===================== -->
  <div id="modal" class="fixed inset-0 z-[80] flex hidden items-center justify-center bg-black/45 px-6">
    <div class="relative w-full max-w-[300px] rounded-2xl bg-white px-6 pb-6 pt-7 text-center shadow-[0_10px_30px_rgba(0,0,0,0.25)]" role="dialog" aria-modal="true" aria-labelledby="mTitle">
      <button id="mClose" type="button" aria-label="Tutup" class="absolute right-3 top-3 flex h-7 w-7 items-center justify-center rounded-full text-slate-700 transition hover:bg-slate-100">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
      <svg class="mx-auto h-12 w-12 text-[#3FA34D]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9.500"/><path d="M7.800 12.300l2.800 2.800 5.600-5.800"/></svg>
      <h3 id="mTitle" class="mt-3 text-base font-semibold">Absen Masuk Berhasil</h3>
      <p id="mText" class="mt-1 text-xs text-slate-500">Data presensi Anda telah disimpan.</p>
      <button id="mOk" type="button" class="mt-4 h-10 w-32 rounded-full bg-[#3FA34D] text-[13px] font-semibold text-white shadow-[0_3px_6px_rgba(0,0,0,0.2)] transition hover:brightness-105">Lanjut</button>
    </div>
  </div>

  <script>
    /* =====================================================================
       Kontrak data (sama dengan Beranda)
       - 'iconnet_session'    : { email, nama }
       - 'iconnet_attendance' : [{ email, date, masuk, pulang, status, fotoMasuk?, fotoPulang? }]
       - 'iconnet_leave'      : [{ id, email, jenis, status, start, end, alasan, fileName, createdAt }]
       Setiap perubahan memanggil event 'iconnet:attendance-updated' agar Beranda ikut berubah.
       ===================================================================== */
    const TZ = 'Asia/Makassar';
    const JAM_MASUK = ICONNET_API.jamMasuk;   // jam masuk standar dari pengaturan server
    const WAIT_SEC = 5;
    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const session = read('iconnet_session', null) || {};

    const todayKey = () => new Intl.DateTimeFormat('en-CA', { timeZone: TZ }).format(new Date());
    const nowTime = () => new Intl.DateTimeFormat('en-GB', { timeZone: TZ, hourCycle: 'h23', hour: '2-digit', minute: '2-digit', second: '2-digit' }).format(new Date());
    function dateText() {
      const p = Object.fromEntries(new Intl.DateTimeFormat('id-ID', { timeZone: TZ, weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }).formatToParts(new Date()).map(x => [x.type, x.value]));
      return p.weekday + ', ' + p.day + ' ' + p.month + ', ' + p.year;
    }

    const loadAll = () => read('iconnet_attendance', []);
    // Data presensi & izin terbaru dari server (setelah absen / mengajukan izin)
    function applyServer(res) {
      if (res && Array.isArray(res.attendance)) ICONNET_API.write('iconnet_attendance', res.attendance);
      if (res && Array.isArray(res.leave)) ICONNET_API.write('iconnet_leave', res.leave);
      window.dispatchEvent(new Event('iconnet:attendance-updated'));
    }
    const myToday = () => loadAll().find(r => r.email === session.email && r.date === todayKey());

    /* ---------- Info sekolah & jam ---------- */
    // Nama sekolah diambil dari data sign up (iconnet_users) berdasarkan email yang sedang login
    const me = read('iconnet_users', []).find(u => String(u.email || '').toLowerCase() === String(session.email || '').toLowerCase());
    $('school').textContent = (me && me.sekolah) || session.sekolah || '-';
    function tick() { $('clock').textContent = nowTime() + ' WITA'; $('dateTxt').textContent = dateText(); }
    tick(); setInterval(tick, 1000);

    /* ---------- Popup ---------- */
    let modalCb = null;
    function openModal(title, text, cb) {
      $('mTitle').textContent = title; $('mText').textContent = text; modalCb = cb || null;
      $('modal').classList.remove('hidden'); $('mOk').focus();
    }
    function closeModal() {
      if ($('modal').classList.contains('hidden')) return;
      $('modal').classList.add('hidden');
      const cb = modalCb; modalCb = null; if (cb) cb();
    }
    $('mOk').addEventListener('click', closeModal);
    $('mClose').addEventListener('click', closeModal);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

    /* ---------- Presensi ---------- */
    const video = $('video');
    const svgOv = (c, d) => '<svg class="h-12 w-12 ' + c + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">' + d + '</svg>';
    const OV_ICON = {
      done: svgOv('text-[#3FA34D]', '<circle cx="12" cy="12" r="9.500"/><path d="M7.800 12.300l2.800 2.800 5.600-5.800"/>'),
      wait: svgOv('text-[#1D62A8]', '<circle cx="12" cy="12" r="9.500"/><path d="M12 7v5l3.200 2"/>'),
      izin: svgOv('text-[#1B8FC4]', '<rect x="5" y="3" width="14" height="18" rx="2.500"/><path d="M8.500 8h7M8.500 12h7M8.500 16h4.500"/>')
    };

    let tab = 'presensi', phase = 'masuk', stage = 'live';   // stage: live | shot | saved | wait | done | blocked
    let stream = null, starting = false, camErr = '', shotData = null, thumbData = null, waitTimer = null, waitLeft = 0;

    function renderOv() {
      const r = myToday() || {};
      let ic = '', t = '', s = '', n = '';
      if (stage === 'wait') { ic = OV_ICON.wait; t = 'Absen masuk tercatat'; s = 'Kamera absen pulang akan terbuka dalam'; n = String(waitLeft); }
      else if (stage === 'done') { ic = OV_ICON.done; t = 'Presensi hari ini selesai'; s = 'Masuk ' + (r.masuk || '-') + ' WITA\nPulang ' + (r.pulang || '-') + ' WITA'; }
      else if (stage === 'blocked') { ic = OV_ICON.izin; t = 'Kamu mengajukan ' + (r.status === 'sakit' ? 'sakit' : 'izin') + ' hari ini'; s = 'Presensi tidak perlu dilakukan hari ini.'; }
      $('ovIcon').innerHTML = ic; $('ovT').textContent = t; $('ovS').textContent = s;
      $('ovN').textContent = n; $('ovN').classList.toggle('hidden', !n);
    }

    function ui() {
      const live = stage === 'live';
      const overlay = stage === 'wait' || stage === 'done' || stage === 'blocked';
      $('phase').textContent = phase === 'masuk' ? 'Presensi Masuk' : 'Presensi Pulang';
      $('phase').classList.toggle('hidden', overlay);
      video.classList.toggle('hidden', !(live && stream));
      $('shot').classList.toggle('hidden', !(stage === 'shot' || stage === 'saved'));
      $('ph').classList.toggle('hidden', !(live && !stream));
      $('phMsg').textContent = camErr; $('phMsg').classList.toggle('hidden', !camErr);
      $('ov').classList.toggle('hidden', !overlay);
      if (overlay) renderOv();
      $('waitNote').classList.toggle('hidden', !(stage === 'saved' && waitLeft > 0));
      $('actLive').classList.toggle('hidden', !live);
      $('actShot').classList.toggle('hidden', stage !== 'shot');
      $('btnSnap').textContent = phase === 'masuk' ? 'Ambil Foto & Absen' : 'Ambil Foto & Absen Pulang';
    }

    async function startCamera() {
      if (stream || starting || stage !== 'live' || tab !== 'presensi') return;
      if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        camErr = 'Kamera tidak didukung di browser ini. Tekan tombol untuk memilih foto dari perangkat.'; ui(); return;
      }
      starting = true;
      try {
        const st = await navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user', width: { ideal: 1280 }, height: { ideal: 960 } }, audio: false });
        if (stage !== 'live' || tab !== 'presensi') { st.getTracks().forEach(t => t.stop()); }
        else { stream = st; video.srcObject = st; camErr = ''; video.play().catch(() => {}); }
      } catch (e) {
        camErr = 'Akses kamera ditolak atau tidak tersedia. Tekan tombol untuk memilih foto dari perangkat.';
      }
      starting = false; ui();
    }
    function stopCamera() {
      if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
      video.srcObject = null;
    }

    function grab(src, w, h, mirror) {
      const sc = Math.min(1, 960 / Math.max(w, h)), cw = Math.round(w * sc), ch = Math.round(h * sc);
      const c = document.createElement('canvas'); c.width = cw; c.height = ch;
      const x = c.getContext('2d');
      if (mirror) { x.translate(cw, 0); x.scale(-1, 1); }
      x.drawImage(src, 0, 0, cw, ch);
      shotData = c.toDataURL('image/jpeg', 0.85);
      const tw = 320, th = Math.round(ch * tw / cw);
      const t = document.createElement('canvas'); t.width = tw; t.height = th;
      t.getContext('2d').drawImage(c, 0, 0, tw, th);
      thumbData = t.toDataURL('image/jpeg', 0.6);
      stopCamera(); stage = 'shot'; $('shot').src = shotData; ui();
    }

    $('btnSnap').addEventListener('click', () => {
      if (stream && video.videoWidth) grab(video, video.videoWidth, video.videoHeight, true);
      else if (stream) return;                           // kamera aktif tapi frame belum siap: tunggu, jangan buka pemilih file
      else if (!stream && !camErr) startCamera();
      else $('selfie').click();
    });
    $('selfie').addEventListener('change', e => {
      const f = e.target.files[0]; e.target.value = ''; if (!f) return;
      const img = new Image(), url = URL.createObjectURL(f);
      img.onload = () => { grab(img, img.naturalWidth, img.naturalHeight, false); URL.revokeObjectURL(url); };
      img.src = url;
    });
    $('btnRetake').addEventListener('click', () => { shotData = null; thumbData = null; stage = 'live'; ui(); startCamera(); });

    $('btnOk').addEventListener('click', () => {
      if (!shotData || $('btnOk').disabled) return;
      // Foto & jam presensi disimpan di server (jam memakai waktu server, zona WITA)
      $('btnOk').disabled = true;
      ICONNET_API.request('POST', phase === 'masuk' ? 'api/v1/presensi/masuk' : 'api/v1/presensi/pulang', { foto: shotData })
        .then(res => {
          $('btnOk').disabled = false;
          applyServer(res);
          stage = 'saved'; ui();
          if (phase === 'masuk') openModal('Absen Masuk Berhasil', 'Data presensi Anda telah disimpan.', startWait);
          else openModal('Absen Pulang Berhasil', 'Data presensi Anda telah disimpan.', () => { stage = 'done'; ui(); });
        })
        .catch(err => {
          $('btnOk').disabled = false;
          if (err.data) applyServer(err.data);
          // 409 = status presensi di server berbeda (mis. sudah absen di perangkat lain) -> sesuaikan tampilan
          openModal('Presensi Gagal', err.message, err.status === 409 ? initStage : null);
        });
    });

    function startWait() {
      clearInterval(waitTimer);
      waitLeft = WAIT_SEC;
      const note = () => { $('waitNote').textContent = 'Kamera absen pulang akan terbuka dalam ' + waitLeft + ' detik...'; };
      stage = 'saved'; note(); ui();   // foto absen tetap tampil selama jeda
      waitTimer = setInterval(() => {
        waitLeft--;
        if (waitLeft > 0) { note(); return; }
        clearInterval(waitTimer);
        phase = 'pulang'; stage = 'live'; shotData = null; thumbData = null; ui(); startCamera();
      }, 1000);
    }

    function initStage() {
      clearInterval(waitTimer);
      const r = myToday();
      shotData = null; thumbData = null;
      if (r && (r.status === 'izin' || r.status === 'sakit') && !r.masuk) stage = 'blocked';
      else if (r && r.pulang) stage = 'done';
      else if (r && r.masuk) { phase = 'pulang'; stage = 'live'; }
      else { phase = 'masuk'; stage = 'live'; }
      ui(); if (stage === 'live') startCamera();
    }

    /* ---------- Tab ---------- */
    function setTab(t) {
      tab = t;
      $('panelP').classList.toggle('hidden', t !== 'presensi');
      $('panelI').classList.toggle('hidden', t !== 'izin');
      $('tabP').classList.toggle('on', t === 'presensi'); $('tabP').setAttribute('aria-selected', t === 'presensi');
      $('tabI').classList.toggle('on', t === 'izin');     $('tabI').setAttribute('aria-selected', t === 'izin');
      if (t === 'izin') { stopCamera(); ui(); }
      else if (stage === 'live' || stage === 'blocked' || stage === 'done') initStage();
      else ui();
    }
    $('tabP').addEventListener('click', () => setTab('presensi'));
    $('tabI').addEventListener('click', () => setTab('izin'));

    // Matikan kamera saat halaman disembunyikan
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) stopCamera(); else if (stage === 'live' && tab === 'presensi') startCamera();
    });
    window.addEventListener('pagehide', stopCamera);

    /* ---------- Form izin / sakit ---------- */
    const JENIS = { izin: 'Izin', sakit: 'Sakit' };
    const MAX_FILE = 10 * 1024 * 1024;
    let pickedFile = null;
    const tglMulai = $('tglMulai'), tglSelesai = $('tglSelesai');

    function resetForm() {
      const t = todayKey();
      tglMulai.min = t; tglMulai.value = t; tglSelesai.min = t; tglSelesai.value = t;
      $('jenis').value = 'izin'; $('alasan').value = '';
      setFile(null); showErr('');
    }
    tglMulai.addEventListener('change', () => {
      tglSelesai.min = tglMulai.value || todayKey();
      if (tglSelesai.value < tglMulai.value) tglSelesai.value = tglMulai.value;
    });

    function showErr(m) { $('izinErr').textContent = m; $('izinErr').classList.toggle('hidden', !m); }
    function fmtSize(b) { return b >= 1048576 ? (b / 1048576).toFixed(1) + ' MB' : Math.max(1, Math.round(b / 1024)) + ' KB'; }
    function setFile(f) {
      pickedFile = f;
      $('dropIc').classList.toggle('!hidden', !!f);
      $('dropT').textContent = f ? f.name : 'Klik untuk mengunggah';
      $('dropT').classList.toggle('break-all', !!f);
      $('dropS').textContent = f ? fmtSize(f.size) : 'PNG, JPG, PDF hingga 10MB';
      $('dropB').textContent = f ? 'Ganti File' : 'Pilih File';
    }
    function tryFile(f) {
      if (!f) return;
      const okType = /\.(png|jpe?g|pdf)$/i.test(f.name) || ['image/png', 'image/jpeg', 'application/pdf'].includes(f.type);
      if (!okType) { showErr('Format file harus PNG, JPG, atau PDF.'); return; }
      if (f.size > MAX_FILE) { showErr('Ukuran file maksimal 10MB.'); return; }
      showErr(''); setFile(f);
    }
    $('drop').addEventListener('click', () => $('file').click());
    $('drop').addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); $('file').click(); } });
    $('file').addEventListener('change', e => { tryFile(e.target.files[0]); e.target.value = ''; });
    ['dragenter', 'dragover'].forEach(ev => $('drop').addEventListener(ev, e => { e.preventDefault(); $('drop').classList.add('over'); }));
    ['dragleave', 'drop'].forEach(ev => $('drop').addEventListener(ev, e => { e.preventDefault(); $('drop').classList.remove('over'); }));
    $('drop').addEventListener('drop', e => tryFile(e.dataTransfer.files[0]));

    function dayRange(s, e) {
      const out = []; let d = new Date(s + 'T00:00:00Z'); const end = new Date(e + 'T00:00:00Z');
      while (d <= end) { out.push(d.toISOString().slice(0, 10)); d = new Date(d.getTime() + 86400000); }
      return out;
    }

    $('btnSend').addEventListener('click', async () => {
      const jenis = $('jenis').value, s = tglMulai.value, e = tglSelesai.value, alasan = $('alasan').value.trim();
      if (!s || !e) return showErr('Tanggal mulai dan tanggal selesai wajib diisi.');
      if (e < s) return showErr('Tanggal selesai tidak boleh sebelum tanggal mulai.');
      let days = dayRange(s, e);
      if (days.length > 31) return showErr('Pengajuan maksimal 31 hari.');
      if (alasan.length < 5) return showErr('Jelaskan alasan izin Anda.');
      if (!pickedFile) return showErr('Lampirkan bukti chat atau surat izin.');
      showErr('');

      const status = jenis === 'sakit' ? 'sakit' : 'izin';

      // Pengajuan + file bukti dikirim ke server (tabel izins). Hari kerja dalam rentang tanggal
      // otomatis berstatus izin/sakit, kecuali hari yang sudah absen masuk.
      const fd = new FormData();
      fd.append('jenis', status); fd.append('start', s); fd.append('end', e); fd.append('alasan', alasan);
      fd.append('bukti', pickedFile, pickedFile.name);
      $('btnSend').disabled = true;
      try {
        const res = await ICONNET_API.request('POST', 'api/v1/izin', fd);
        applyServer(res);
      } catch (err) {
        $('btnSend').disabled = false;
        return showErr(err.message);
      }
      $('btnSend').disabled = false;

      openModal('Pengajuan Terkirim', 'Pengajuan ' + (status === 'sakit' ? 'sakit' : 'izin') + ' Anda telah disimpan.', resetForm);
    });

    /* ---------- Sidebar (desktop) & hamburger (mobile) ---------- */
    $('toggleBtn').addEventListener('click', () => {
      const c = document.body.classList.toggle('collapsed');
      localStorage.setItem('iconnet_sidebar', c ? '1' : '0');
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
      stopCamera();
      ICONNET_API.logout();   // logout di server, lalu ke halaman login
    }
    $('logoutBtn').addEventListener('click', logout);
    $('logoutBtnM').addEventListener('click', logout);

    /* ---------- Mulai ---------- */
    resetForm();
    initStage();
  </script>
</body>
</html>
