<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Presensi - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <style>
    #sidebar, #content { transition: width .25s ease, margin-left .25s ease; }
    .sb-div { display: none; }

    /* ===== Umum (mobile first) ===== */
    button { font-family: inherit; }

    .rw-date { position: relative; }
    .rw-date::-webkit-calendar-picker-indicator { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    .rw-date::-webkit-date-and-time-value { text-align: left; }
    select.rw-in, .rw-date { -webkit-appearance: none; appearance: none; }

    /* Badge status */
    .st-b { display: inline-flex; align-items: center; justify-content: center; height: 24px; padding: 0 12px; border-radius: 6px; font-size: 11px; font-weight: 500; white-space: nowrap; }
    .st-hadir { background: #B8FFB4; color: #1B8F36; }
    .st-izin { background: #BBE9FB; color: #0A7FA8; }
    .st-sakit { background: #FFDFA9; color: #D9780A; }
    .st-terlambat { background: #FED5B9; color: #E0560F; }
    .st-lain { background: #E5E7EB; color: #374151; }

    /* Tab */
    .rw-tabbar { display: flex; gap: 6px; background: #F8F8FD; border-radius: 10px; padding: 6px; }
    .rw-tab { flex: 1 1 0; height: 34px; border-radius: 8px; font-size: 12px; font-weight: 500; color: #000; background: transparent; transition: background .15s, color .15s; cursor: pointer; }
    .rw-tab:hover:not(.on) { background: #EEEEF8; }
    .rw-tab.on { background: #00B4D8; color: #fff; cursor: default; }

    /* Pagination */
    .pg-b { display: inline-flex; align-items: center; justify-content: center; gap: 4px; height: 28px; min-width: 28px; padding: 0 10px; border: 1px solid #E3E3E3; border-radius: 7px; background: #fff; font-size: 11px; font-weight: 500; color: #000; cursor: pointer; transition: background .15s; }
    .pg-b:hover:not(:disabled):not(.on) { background: #F3F4F6; }
    .pg-b.on { background: #4FC9E4; border-color: #4FC9E4; color: #fff; cursor: default; }
    .pg-b:disabled { opacity: .45; cursor: default; }
    .pg-pill { border-radius: 999px; padding: 0 12px; }
    .pg-dots { display: inline-flex; align-items: center; padding: 0 2px; font-size: 11px; color: #6B7280; }

    /* Popup detail (dasar) */
    .dm-photos { display: flex; justify-content: center; gap: 12px; }
    .dm-pc { flex: 0 1 calc(50% - 6px); min-width: 0; border: 1px solid #E5E7EB; border-radius: 12px; padding: 8px; background: #fff; box-shadow: 0 2px 6px rgba(0,0,0,.08); }
    .dm-pc:only-child { flex-basis: 100%; }
    .dm-pc:only-child .dm-pimg, .dm-pc:only-child .dm-none { aspect-ratio: 16 / 10; }
    .dm-pt { text-align: center; font-size: 12px; font-weight: 500; margin-bottom: 6px; }
    .dm-pimg { display: block; width: 100%; aspect-ratio: 4 / 3; object-fit: cover; border-radius: 8px; background: #E5E7EB; }
    .dm-none { display: flex; align-items: center; justify-content: center; width: 100%; aspect-ratio: 4 / 3; border-radius: 8px; background: #F3F4F6; font-size: 11px; color: #6B7280; }
    .dm-photos.dm-col { display: block; }
    .dm-sec { border: 1px solid #E5E7EB; border-radius: 12px; padding: 10px 12px 12px; margin-bottom: 12px; background: #fff; text-align: left; }
    .dm-sec-t { font-size: 12.5px; font-weight: 500; margin-bottom: 8px; }
    .dm-file { display: flex; align-items: center; gap: 10px; width: 100%; padding: 8px 10px; border-radius: 10px; background: #fff; box-shadow: 0 1px 4px rgba(0,0,0,.12); text-align: left; font-size: 12.5px; cursor: pointer; transition: background .15s; }
    .dm-file:hover { background: #F5F9FF; }
    .dm-file .fn { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .dm-docic { display: inline-flex; align-items: center; justify-content: center; flex: none; width: 32px; height: 32px; border-radius: 8px; background: #DCE9FF; }
    .dm-docic svg { width: 18px; height: 18px; }
    .dm-ta { min-height: 64px; padding: 8px 10px; border-radius: 8px; background: #F7F7F7; font-size: 12.5px; color: #333; white-space: pre-wrap; word-break: break-word; }
    .dm-tbl { margin-top: 14px; border: 1px solid #E5E7EB; border-radius: 10px; overflow: hidden; }
    .dm-r { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 10px 14px; border-bottom: 1px solid #E5E7EB; font-size: 12.5px; }
    .dm-r:last-child { border-bottom: 0; }
    .dm-r > span:first-child { font-weight: 500; flex: none; }
    .dm-r > span:last-child { text-align: right; }

    /* ===== MOBILE (<900px) ===== */
    @media (max-width: 899px) {
      .hdr-t { font-size: 15px !important; line-height: 1.3; }
      .hdr-s { font-size: 11px !important; }
      .rw-main { padding: 12px 14px 24px !important; gap: 12px !important; }
      .rw-fcard { padding: 12px !important; border-radius: 12px !important; }
      .rw-ft { font-size: 12.5px !important; }
      .rw-ftop > div > svg { width: 16px; height: 16px; }
      .rw-lb { font-size: 11px !important; }
      .rw-wr { margin-top: 4px !important; }
      .rw-in { height: 34px !important; min-height: 34px; font-size: 11.5px !important; padding-left: 10px !important; padding-right: 32px !important; border-radius: 6px !important; display: block; line-height: 32px; }
      .rw-ico { right: 10px !important; width: 15px !important; height: 15px !important; }
      .rw-tab { height: 32px; font-size: 11.5px; }
      #rowsM button[data-view] { border-radius: 6px !important; background: #F3F4F6 !important; }
      .st-b { border-radius: 5px; }
      #mnav .h-16 { height: 56px; }
      .pg-b { height: 26px; min-width: 26px; padding: 0 8px; font-size: 10.5px; }
      .pg-pill { padding: 0 10px; }
      .dm-card { max-width: 340px !important; border-radius: 16px !important; }
      .dm-head { padding: 10px 14px !important; }
      .dm-t { font-size: 13.5px !important; }
      .dm-body { padding: 12px 14px 14px !important; }
      .dm-btn { width: 84px !important; height: 32px !important; font-size: 12.5px !important; }
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
      body .sb-row { height: calc(var(--su) * 104); }
      body .logo-img { height: calc(var(--su) * 104); width: calc(var(--su) * 104); object-fit: contain; }
      body .sb-div { display: block; height: 1px; width: calc(var(--su) * 125); margin: calc(var(--su) * 6) auto 0; background: #E8EAF0; }
      body.collapsed .sb-div { display: none; }
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

      body .hdr { height: calc(var(--u) * 87); padding: calc(var(--u) * 6) calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body .hdr-t { font-size: calc(var(--u) * 18); line-height: 1.25; font-weight: 600; color: #03045E; }
      body .hdr-s { font-size: calc(var(--u) * 12.5); line-height: 1.4; margin-top: calc(var(--u) * 4); color: #000; }

      body #content { overflow-x: hidden; overflow-y: hidden; }
      body .rw-main { display: flex; flex-direction: column; height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 22) calc(var(--u) * 41) calc(var(--u) * 20); gap: calc(var(--u) * 16); }

      /* Kartu filter */
      body .rw-fcard { position: relative; flex: none; padding: calc(var(--u) * 14) calc(var(--u) * 20) calc(var(--u) * 15) calc(var(--u) * 26); border-radius: calc(var(--u) * 13); box-shadow: 0 calc(var(--u) * 3) calc(var(--u) * 12) rgba(0,0,0,.22); }
      body .rw-ftop { height: calc(var(--u) * 26); margin-bottom: calc(var(--u) * 10); gap: calc(var(--u) * 12); }
      body .rw-ftop .rw-fic { width: calc(var(--u) * 26); height: calc(var(--u) * 26); }
      body .rw-ft { font-size: calc(var(--u) * 16); line-height: calc(var(--u) * 24); font-weight: 500; }
      body .rw-fg { margin-top: 0; column-gap: calc(var(--u) * 31); row-gap: calc(var(--u) * 12); }
      body .rw-lb { font-size: calc(var(--u) * 13.5); line-height: calc(var(--u) * 20); font-weight: 500; }
      body .rw-wr { margin-top: calc(var(--u) * 3); }
      body .rw-in { height: calc(var(--u) * 35); font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 6); padding-left: calc(var(--u) * 12); padding-right: calc(var(--u) * 38); }
      body .rw-ico { right: calc(var(--u) * 13); width: calc(var(--u) * 16); height: calc(var(--u) * 16); }

      /* Kartu tab */
      body .rw-tabcard { flex: none; padding: calc(var(--u) * 7) calc(var(--u) * 12); border-radius: calc(var(--u) * 13); box-shadow: 0 calc(var(--u) * 3) calc(var(--u) * 12) rgba(0,0,0,.22); }
      body .rw-tabbar { gap: calc(var(--u) * 6); border-radius: calc(var(--u) * 9); padding: calc(var(--u) * 5); }
      body .rw-tab { height: calc(var(--u) * 30); font-size: calc(var(--u) * 12.5); border-radius: calc(var(--u) * 7); }

      /* Kartu tabel */
      body .rw-tcard { flex: 1 1 0; min-height: 0; border-radius: calc(var(--u) * 13); box-shadow: 0 calc(var(--u) * 3) calc(var(--u) * 12) rgba(0,0,0,.22); }
      body .rw-twrap { position: relative; flex: 1 1 0; min-height: 0; overflow-y: auto; scrollbar-width: none; }
      body .rw-twrap::-webkit-scrollbar { display: none; }
      body .rw-tbl thead { background: #03045E; position: sticky; top: 0; z-index: 1; }
      body .rw-tbl th { height: calc(var(--u) * 37); font-size: calc(var(--u) * 12); font-weight: 500; color: #fff; text-align: center; padding: 0; }
      body .rw-tbl td { height: calc(var(--u) * 50); font-size: calc(var(--u) * 11.5); text-align: center; padding: 0 calc(var(--u) * 8); border-bottom: 1px solid #E9E9E9; }
      body .rw-thumb { width: calc(var(--u) * 54); height: calc(var(--u) * 30); border-radius: calc(var(--u) * 6); }
      body .rw-tbl .st-b { width: calc(var(--u) * 99); height: calc(var(--u) * 26); font-size: calc(var(--u) * 11.5); border-radius: calc(var(--u) * 5); padding: 0; }
      body .rw-lihat { width: calc(var(--u) * 100); height: calc(var(--u) * 27); gap: calc(var(--u) * 7); font-size: calc(var(--u) * 11.5); border-radius: calc(var(--u) * 5); background: #F3F4F6; }
      body .rw-lihat svg { width: calc(var(--u) * 16); height: calc(var(--u) * 16); }
      body .rw-tbl tbody tr:last-child td { border-bottom-color: transparent; }
      body .rw-empty { font-size: calc(var(--u) * 14); }
      body .rw-pgbar { height: calc(var(--u) * 38); padding: 0 calc(var(--u) * 12); gap: calc(var(--u) * 9); border-top: 1px solid #E9E9E9; }
      body .rw-pgbar .pg-b { height: calc(var(--u) * 22); min-width: calc(var(--u) * 24); padding: 0 calc(var(--u) * 10); font-size: calc(var(--u) * 10.5); border-radius: calc(var(--u) * 6); gap: calc(var(--u) * 4); }
      body .rw-pgbar .pg-pill { border-radius: 999px; padding: 0 calc(var(--u) * 14); }
      body .rw-pgbar .pg-b svg { width: calc(var(--u) * 9); height: calc(var(--u) * 9); }
      body .rw-pgbar .pg-dots { font-size: calc(var(--u) * 10.5); }

      /* Popup detail */
      body #dModal { padding: 0 0 0 var(--sbw); background: rgba(0,0,0,.16); }
      body .dm-card { width: calc(var(--u) * 456); max-width: none; max-height: none; overflow: hidden; border-radius: calc(var(--u) * 22); }
      body .dm-head { height: calc(var(--u) * 53); padding: 0 calc(var(--u) * 18); gap: calc(var(--u) * 12); }
      body .dm-ic { width: calc(var(--u) * 34); height: calc(var(--u) * 34); border-radius: calc(var(--u) * 7); }
      body .dm-ic svg { width: calc(var(--u) * 20); height: calc(var(--u) * 20); }
      body .dm-t { font-size: calc(var(--u) * 15); line-height: calc(var(--u) * 22); font-weight: 600; }
      body .dm-body { padding: calc(var(--u) * 18) calc(var(--u) * 20) calc(var(--u) * 16); }
      body .dm-photos { gap: calc(var(--u) * 20); }
      body .dm-pc { flex-basis: calc(50% - var(--u) * 10); border-radius: calc(var(--u) * 12); padding: calc(var(--u) * 9); }
      body .dm-pc:only-child { flex-basis: 100%; }
      body .dm-pt { font-size: calc(var(--u) * 12.5); margin-bottom: calc(var(--u) * 6); }
      body .dm-pimg, body .dm-none { border-radius: calc(var(--u) * 8); }
      body .dm-none { font-size: calc(var(--u) * 11.5); }
      body .dm-tbl { margin-top: calc(var(--u) * 16); border-radius: calc(var(--u) * 10); }
      body .dm-sec { border-radius: calc(var(--u) * 12); padding: calc(var(--u) * 10) calc(var(--u) * 12) calc(var(--u) * 12); margin-bottom: calc(var(--u) * 12); }
      body .dm-sec-t { font-size: calc(var(--u) * 13); margin-bottom: calc(var(--u) * 8); }
      body .dm-file { gap: calc(var(--u) * 10); padding: calc(var(--u) * 8) calc(var(--u) * 10); font-size: calc(var(--u) * 13); border-radius: calc(var(--u) * 10); }
      body .dm-docic { width: calc(var(--u) * 32); height: calc(var(--u) * 32); border-radius: calc(var(--u) * 8); }
      body .dm-docic svg { width: calc(var(--u) * 18); height: calc(var(--u) * 18); }
      body .dm-ta { min-height: calc(var(--u) * 66); font-size: calc(var(--u) * 13); border-radius: calc(var(--u) * 8); padding: calc(var(--u) * 8) calc(var(--u) * 10); }
      body .dm-r { padding: calc(var(--u) * 11) calc(var(--u) * 14); font-size: calc(var(--u) * 13); }
      body .dm-foot { padding: calc(var(--u) * 12) 0 calc(var(--u) * 14); }
      body .dm-btn { width: calc(var(--u) * 100); height: calc(var(--u) * 34); font-size: calc(var(--u) * 14); border-radius: calc(var(--u) * 8); }
      body .rw-st-in { height: calc(var(--u) * 22); min-width: calc(var(--u) * 80); font-size: calc(var(--u) * 12); border-radius: calc(var(--u) * 6); }
    }
  </style>
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/panel.config.js -->
  <link rel="stylesheet" href="{{ asset('css/panel.css') }}" />
</head>

<body class="bg-[#F9F8FE] font-sans text-black antialiased">
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
        <img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" class="block h-12 w-auto" />
      </a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false" class="flex h-10 w-10 items-center justify-center rounded-lg text-[#03045E] transition hover:bg-slate-100">
        <svg id="icoBurger" class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        <svg id="icoClose" class="hidden h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
      </button>
    </div>
    <div id="mmenu" class="absolute inset-x-0 top-full hidden rounded-b-[24px] border-t border-slate-100 bg-white px-4 pb-4 pt-3 shadow-[0_12px_20px_rgba(0,0,0,0.15)]">
      <div class="flex flex-col gap-1.5">
        <a href="{{ url('beranda') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg>Beranda</a>
        <a href="{{ url('absensi') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg>Absensi</a>
        <a href="{{ url('riwayat') }}" class="flex h-11 items-center gap-3 rounded-xl bg-[#E1FAFF] px-3.5 text-[13px] font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg>Riwayat</a>
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
      <a href="{{ url('beranda') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="3" width="7.500" height="7.500" rx="2"/><rect x="3" y="13.500" width="7.500" height="7.500" rx="2"/><rect x="13.500" y="13.500" width="7.500" height="7.500" rx="2"/></svg><span class="sb-label">Beranda</span></a>
      <a href="{{ url('absensi') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V6a2 2 0 012-2h2M16 4h2a2 2 0 012 2v2M20 16v2a2 2 0 01-2 2h-2M8 20H6a2 2 0 01-2-2v-2"/><circle cx="12" cy="10" r="2.800"/><path d="M6.800 18c.6-2.400 2.600-3.800 5.200-3.800s4.600 1.400 5.200 3.800"/></svg><span class="sb-label">Presensi</span></a>
      <a href="{{ url('riwayat') }}" class="sb-item flex items-center gap-3 rounded-xl bg-[#DFF7FC] px-3.5 py-2.5 text-xs font-medium text-ink"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg><span class="sb-label">Riwayat</span></a>
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
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Riwayat Presensi</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Berikut adalah catatan kehadiran Anda.</p>
    </header>

    <main class="rw-main flex flex-col gap-4 px-4 pb-8 pt-4 sm:px-6">

      <!-- ===== Filter ===== -->
      <section class="rw-fcard rounded-2xl bg-white p-4 shadow-[0_3px_12px_rgba(0,0,0,0.18)]">
        <div class="rw-ftop flex items-center gap-2.5">
          <img src="data:image/png;base64,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" alt="" aria-hidden="true" class="rw-fic h-[24px] w-[24px] flex-none rounded-full" />
          <h2 class="rw-ft truncate text-sm font-medium sm:text-base">Filter Data Riwayat Presensi</h2>
        </div>

        <div class="rw-fg mt-3 grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
          <div id="wTgl">
            <label for="fTgl" class="rw-lb block text-xs font-medium">Tanggal</label>
            <div class="rw-wr relative mt-1.5">
              <input id="fTgl" type="date" class="rw-in rw-date h-10 w-full rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.500" y="5" width="17" height="15.500" rx="2.500"/><path d="M3.500 10h17M8 3v4M16 3v4"/></svg>
            </div>
          </div>
          <div id="wMulai" class="hidden">
            <label for="fMulai" class="rw-lb block text-xs font-medium">Tanggal Mulai</label>
            <div class="rw-wr relative mt-1.5">
              <input id="fMulai" type="date" class="rw-in rw-date h-10 w-full rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.500" y="5" width="17" height="15.500" rx="2.500"/><path d="M3.500 10h17M8 3v4M16 3v4"/></svg>
            </div>
          </div>
          <div id="wSelesai" class="hidden">
            <label for="fSelesai" class="rw-lb block text-xs font-medium">Tanggal Selesai</label>
            <div class="rw-wr relative mt-1.5">
              <input id="fSelesai" type="date" class="rw-in rw-date h-10 w-full rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20" />
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3.500" y="5" width="17" height="15.500" rx="2.500"/><path d="M3.500 10h17M8 3v4M16 3v4"/></svg>
            </div>
          </div>
          <div id="wWaktu">
            <label for="fWaktu" class="rw-lb block text-xs font-medium">Waktu Presensi</label>
            <div class="rw-wr relative mt-1.5">
              <select id="fWaktu" class="rw-in h-10 w-full cursor-pointer rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20">
                <option value="">Semua Waktu</option>
                <option value="masuk">Jam Masuk</option>
                <option value="pulang">Jam Pulang</option>
              </select>
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </div>
          <div class="sm:col-span-2">
            <label id="lStatus" for="fStatus" class="rw-lb block text-xs font-medium">Status Kehadiran</label>
            <div class="rw-wr relative mt-1.5">
              <select id="fStatus" class="rw-in h-10 w-full cursor-pointer rounded-lg border border-[#CDCDCD] bg-white pl-3 pr-10 text-xs outline-none focus:border-[#4A9FF5] focus:ring-2 focus:ring-[#4A9FF5]/20"></select>
              <svg class="rw-ico pointer-events-none absolute right-3 top-1/2 h-[18px] w-[18px] -translate-y-1/2 text-slate-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
            </div>
          </div>
        </div>
      </section>

      <!-- ===== Tab ===== -->
      <section class="rw-tabcard rounded-2xl bg-white p-2.5 shadow-[0_3px_12px_rgba(0,0,0,0.18)]">
        <div class="rw-tabbar" role="tablist">
          <button type="button" role="tab" class="rw-tab on" data-tab="presensi" aria-selected="true">Data Presensi</button>
          <button type="button" role="tab" class="rw-tab" data-tab="izin" aria-selected="false">Data Izin / Sakit</button>
        </div>
      </section>

      <!-- ===== Tabel (desktop / laptop) ===== -->
      <section class="rw-tcard hidden flex-col overflow-hidden rounded-2xl bg-white shadow-[0_3px_12px_rgba(0,0,0,0.18)] lg:flex">
        <div class="rw-twrap">
          <table class="rw-tbl w-full table-fixed border-collapse">
            <colgroup id="colsD"></colgroup>
            <thead><tr id="headD"></tr></thead>
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

  <!-- ===================== POPUP DETAIL DATA ===================== -->
  <div id="dModal" class="fixed inset-0 z-[80] hidden items-center justify-center bg-black/40 px-4 lg:z-40">
    <div class="dm-card max-h-[92vh] w-full max-w-[340px] overflow-y-auto rounded-2xl bg-white shadow-[0_10px_30px_rgba(0,0,0,0.3)]" role="dialog" aria-modal="true" aria-labelledby="dmT">
      <div class="dm-head flex items-center gap-3 bg-[#0A2441] px-4 py-3">
        <span class="dm-ic flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-[#D9D9D9]">
          <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="#1a1a1a" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
        </span>
        <h3 id="dmT" class="dm-t text-[15px] font-semibold text-white">Detail Data</h3>
      </div>
      <div class="dm-body px-4 pb-4 pt-4">
        <div id="dPhotos" class="dm-photos"></div>
        <div id="dInfo" class="dm-tbl"></div>
      </div>
      <div class="dm-foot flex justify-center border-t border-[#E5E7EB] py-3">
        <button id="dClose" type="button" class="dm-btn h-9 w-24 rounded-lg bg-[#EDEDED] text-[13px] font-medium text-black shadow-[0_3px_5px_rgba(0,0,0,0.2)] transition hover:bg-[#E2E2E2] active:scale-[.98]">Tutup</button>
      </div>
    </div>
  </div>

  <script>
    /* =====================================================================
       Data dibaca dari localStorage (dicocokkan lewat email di 'iconnet_session').
       Bentuk data: array of { email?, tanggal, jamMasuk, jamPulang, fotoMasuk, fotoPulang,
                               status, keterangan?, bukti? }
       - status Hadir / Terlambat  -> tab "Data Presensi"
       - status Izin / Sakit       -> tab "Data Izin / Sakit"
       ===================================================================== */
    const TZ = 'Asia/Makassar';
    const PER_PAGE = 10;
    const SHOW_DEMO_IF_EMPTY = false;  // false = data contoh dimatikan, hanya data asli yang tampil

    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const esc = s => String(s == null ? '' : s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
    const session = read('iconnet_session', null) || {};

    const REC_KEYS = ['iconnet_presensi', 'iconnet_riwayat', 'iconnet_absensi', 'iconnet_attendance', 'presensi', 'riwayat'];
    const FIELD = {
      tgl:    ['tanggal', 'date', 'tgl'],
      masuk:  ['jamMasuk', 'jam_masuk', 'masuk', 'checkIn', 'waktuMasuk'],
      pulang: ['jamPulang', 'jam_pulang', 'pulang', 'checkOut', 'waktuPulang'],
      fm:     ['fotoMasuk', 'foto_masuk', 'photoIn', 'fotoIn'],
      fp:     ['fotoPulang', 'foto_pulang', 'photoOut', 'fotoOut'],
      status: ['status', 'statusKehadiran', 'kehadiran'],
      ket:    ['keterangan', 'alasan', 'catatan', 'note'],
      bukti:  ['bukti', 'lampiran', 'fotoBukti', 'foto_bukti', 'file'],
      bname:  ['buktiNama', 'namaBukti', 'namaFile', 'fileName'],
      mulai:  ['tanggalMulai', 'tgl_mulai', 'mulai', 'start'],
      selesai:['tanggalSelesai', 'tgl_selesai', 'selesai', 'end']
    };
    const pick = (o, ks) => { for (const k of ks) { if (o && o[k] != null && o[k] !== '') return o[k]; } return ''; };

    /* ---------- Util ---------- */
    function parseDate(v) {
      if (!v) return '';
      const t = String(v).trim();
      if (/^\d{4}-\d{2}-\d{2}$/.test(t)) return t;
      let m = t.match(/^(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})$/);
      if (m) return m[3] + '-' + m[2].padStart(2, '0') + '-' + m[1].padStart(2, '0');
      const d = new Date(t);
      if (isNaN(d)) return '';
      return new Intl.DateTimeFormat('en-CA', { timeZone: TZ, year: 'numeric', month: '2-digit', day: '2-digit' }).format(d);
    }
    const fmtDate = iso => { const m = /^(\d{4})-(\d{2})-(\d{2})$/.exec(iso || ''); return m ? m[3] + '-' + m[2] + '-' + m[1] : '-'; };
    function fmtTime(v) {
      if (!v) return '-';
      const m = String(v).trim().match(/^(\d{1,2})[:.](\d{2})/);
      return m ? m[1].padStart(2, '0') + '.' + m[2] : String(v);
    }
    function normStatus(v) {
      const l = String(v || '').trim().toLowerCase();
      if (['hadir', 'present'].includes(l)) return { key: 'hadir', label: 'Hadir' };
      if (['izin', 'permit'].includes(l)) return { key: 'izin', label: 'Izin' };
      if (['sakit', 'sick'].includes(l)) return { key: 'sakit', label: 'Sakit' };
      if (['terlambat', 'telat', 'late'].includes(l)) return { key: 'terlambat', label: 'Terlambat' };
      return { key: 'lain', label: l ? l.charAt(0).toUpperCase() + l.slice(1) : '-' };
    }
    const badge = (k, l, extra) => '<span class="st-b st-' + k + (extra ? ' ' + extra : '') + '">' + esc(l) + '</span>';

    /* ---------- Foto contoh ---------- */
    const PH = (() => {
      const cols = ['#C8956D', '#E0B48F', '#A9745A', '#F0CBA8', '#8C5A45', '#D7A27B', '#B98263'];
      const tops = ['#E8E8E8', '#2B2B35', '#9B2C2C', '#F3E3E3', '#3F3F4A', '#C0392B', '#222'];
      let s = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 140 90"><defs><linearGradient id="g" x1="0" y1="0" x2="0" y2="1"><stop offset="0" stop-color="#4A4A5C"/><stop offset="1" stop-color="#1D1D28"/></linearGradient></defs><rect width="140" height="90" fill="url(#g)"/><rect x="25" y="6" width="90" height="16" fill="#F5F5F5"/>';
      for (let i = 0; i < 7; i++) {
        const x = 14 + i * 18, y = 40 + (i % 2) * 5;
        s += '<circle cx="' + x + '" cy="' + y + '" r="6.500" fill="' + cols[i] + '"/><rect x="' + (x - 8) + '" y="' + (y + 7) + '" width="16" height="' + (90 - y) + '" rx="6" fill="' + tops[i] + '"/>';
      }
      return 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(s + '</svg>');
    })();

    /* ---------- Muat data ---------- */
    function loadRecords() {
      const email = String(session.email || '').toLowerCase();
      for (const key of REC_KEYS) {
        let raw = read(key, null);
        if (raw && !Array.isArray(raw) && typeof raw === 'object') raw = raw[session.email] || raw[email] || null;
        if (!Array.isArray(raw) || !raw.length) continue;
        const list = raw.filter(r => r && typeof r === 'object' && (!r.email || String(r.email).toLowerCase() === email));
        if (list.length) return list;
      }
      return [];
    }
    function rangeDays(a, b) {
      const out = []; let d = new Date(a + 'T00:00:00Z'); const end = new Date((b || a) + 'T00:00:00Z');
      for (let i = 0; i < 366 && d <= end; i++) { out.push(d.toISOString().slice(0, 10)); d = new Date(d.getTime() + 86400000); }
      return out;
    }
    // Pengajuan izin / sakit dari halaman Presensi (key 'iconnet_leave')
    function loadLeaves() {
      const email = String(session.email || '').toLowerCase();
      const raw = read('iconnet_leave', []);
      if (!Array.isArray(raw)) return [];
      return raw.filter(r => r && typeof r === 'object' && (!r.email || String(r.email).toLowerCase() === email));
    }
    const DEMO_PDF = 'data:application/pdf;base64,' + btoa('%PDF-1.1\n1 0 obj<</Type/Catalog/Pages 2 0 R>>endobj\n2 0 obj<</Type/Pages/Kids[3 0 R]/Count 1>>endobj\n3 0 obj<</Type/Page/Parent 2 0 R/MediaBox[0 0 300 150]/Contents 4 0 R/Resources<</Font<</F1 5 0 R>>>>>>endobj\n4 0 obj<</Length 48>>stream\nBT /F1 14 Tf 20 80 Td (Contoh Surat Izin) Tj ET\nendstream endobj\n5 0 obj<</Type/Font/Subtype/Type1/BaseFont/Helvetica>>endobj\ntrailer<</Root 1 0 R/Size 6>>\n%%EOF');
    const DEMO = [
      ['2026-09-09', '07:50', '17:02', 'Hadir'], ['2026-09-09', '07:45', '17:02', 'Hadir'],
      ['2026-09-09', '07:55', '17:02', 'Terlambat'], ['2026-09-08', '07:48', '17:05', 'Hadir'],
      ['2026-09-07', '07:42', '17:00', 'Hadir'], ['2026-09-04', '08:10', '17:03', 'Terlambat'],
      ['2026-09-03', '07:52', '', 'Hadir'], ['2026-09-02', '07:40', '17:01', 'Hadir']
    ].map(d => ({ tanggal: d[0], jamMasuk: d[1], jamPulang: d[2], status: d[3] }))
    .concat([
      { tanggalMulai: '2026-09-09', tanggalSelesai: '2026-09-09', status: 'Izin', keterangan: 'Ada urusan mendadak & tidak bisa di tunda.', bukti: PH, buktiNama: 'Bukti_Chat.jpg' },
      { tanggalMulai: '2026-09-09', tanggalSelesai: '2026-09-09', status: 'Sakit', keterangan: 'Demam dan flu, istirahat sesuai anjuran dokter.', bukti: DEMO_PDF, buktiNama: 'Surat_Dokter.pdf' },
      { tanggalMulai: '2026-09-02', tanggalSelesai: '2026-09-03', status: 'Izin', keterangan: 'Mengurus dokumen keluarga', bukti: PH, buktiNama: 'Bukti_Chat.png' },
      { tanggalMulai: '2026-08-26', tanggalSelesai: '2026-08-28', status: 'Sakit', keterangan: 'Sakit kepala', bukti: DEMO_PDF, buktiNama: 'Surat_Dokter.pdf' },
      { tanggalMulai: '2026-08-19', tanggalSelesai: '2026-08-19', status: 'Izin', keterangan: 'Keperluan keluarga', bukti: PH, buktiNama: 'Bukti_Chat.jpeg' },
      { tanggalMulai: '2026-08-10', tanggalSelesai: '2026-08-11', status: 'Sakit', keterangan: 'Flu berat', bukti: DEMO_PDF, buktiNama: 'Surat_Izin.pdf' }
    ]);

    function buildAll() {
      const leaves = loadLeaves();
      const covered = new Set();
      leaves.forEach(l => { const a = parseDate(pick(l, FIELD.mulai)); if (a) rangeDays(a, parseDate(pick(l, FIELD.selesai)) || a).forEach(d => covered.add(d)); });
      // baris izin/sakit di data presensi hanya dipakai bila belum tercakup pengajuan izin
      let src = loadRecords().filter(r => { const k = normStatus(pick(r, FIELD.status)).key; return !(k === 'izin' || k === 'sakit') || !covered.has(parseDate(pick(r, FIELD.tgl))); }).concat(leaves);
      const demo = !src.length && SHOW_DEMO_IF_EMPTY;
      if (demo) src = DEMO;
      return src.map(r => {
        const st = normStatus(pick(r, FIELD.status));
        const masuk = pick(r, FIELD.masuk), pulang = pick(r, FIELD.pulang);
        const mRaw = parseDate(pick(r, FIELD.mulai));
        const tgl = parseDate(pick(r, FIELD.tgl)) || mRaw;
        const mulai = mRaw || tgl;
        const selesai = parseDate(pick(r, FIELD.selesai)) || mulai;
        return {
          tgl, mulai, selesai,
          masuk, pulang,
          fm: pick(r, FIELD.fm) || (demo && masuk ? PH : ''),
          fp: pick(r, FIELD.fp) || (demo && pulang ? PH : ''),
          ket: pick(r, FIELD.ket),
          bukti: pick(r, FIELD.bukti), bname: pick(r, FIELD.bname),
          sk: st.key, sl: st.label
        };
      }).sort((a, b) => (a.tgl < b.tgl ? 1 : a.tgl > b.tgl ? -1 : 0));
    }
    const ALL = buildAll();
    const isIzin = r => r.sk === 'izin' || r.sk === 'sakit';
    const DATA = { presensi: ALL.filter(r => !isIzin(r)), izin: ALL.filter(isIzin) };

    let tab = 'presensi', view = [], page = 1;

    /* ---------- Bukti izin (gambar / PDF) ---------- */
    const isPdf = r => { const b = String(r.bukti || ''); return /^data:application\/pdf/i.test(b) || /\.pdf($|\?)/i.test(b) || /\.pdf$/i.test(r.bname || ''); };
    function fileName(r) {
      if (r.bname) return r.bname;
      const b = String(r.bukti || '');
      const m = /^data:([^;,]+)/.exec(b);
      if (m) { const ext = m[1].split('/')[1].split('+')[0].replace('jpeg', 'jpg'); return 'Bukti.' + ext; }
      return b.split('/').pop().split('?')[0] || 'Bukti';
    }
    const DOC_SVG = '<svg viewBox="0 0 24 24" fill="none" stroke="#2563EB" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 3H8a2 2 0 00-2 2v14a2 2 0 002 2h8a2 2 0 002-2V8z"/><path d="M14 3v5h4M9 13h6M9 17h4"/></svg>';
    const docIcon = '<span class="dm-docic">' + DOC_SVG + '</span>';
    function buktiThumb(r, cls) {
      if (!r.bukti) return '<span class="text-slate-400">-</span>';
      return isPdf(r) ? docIcon : '<img src="' + esc(r.bukti) + '" alt="Bukti" class="' + cls + '" />';
    }
    function openBukti(r) {
      if (!r || !r.bukti) return;
      let url = String(r.bukti);
      const m = /^data:([^,]*?)(;base64)?,(.*)$/s.exec(url);
      if (m) {
        try {
          const bin = m[2] ? atob(m[3]) : decodeURIComponent(m[3]);
          const arr = new Uint8Array(bin.length);
          for (let i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
          url = URL.createObjectURL(new Blob([arr], { type: m[1] || 'application/octet-stream' }));
        } catch (e) {}
      }
      window.open(url, '_blank', 'noopener');
    }

    const imgT = (src, alt, cls) => src ? '<img src="' + esc(src) + '" alt="' + alt + '" class="' + cls + '" />' : '<span class="text-slate-400">-</span>';

    /* ---------- Konfigurasi tab ---------- */
    const COLS = {
      presensi: { w: [14.7, 14.3, 13.1, 13.5, 14, 14.3, 16.1], h: ['Tanggal', 'Jam masuk', 'Foto masuk', 'Jam Pulang', 'Foto pulang', 'Status', 'Aksi'] },
      izin:     { w: [16, 16, 20, 14, 17, 17], h: ['Tanggal Mulai', 'Tanggal Selesai', 'Alasan Izin', 'Foto Bukti', 'Status Izin', 'Aksi'] }
    };
    const STATUS_OPT = {
      presensi: [['', 'Semua Status Kehadiran'], ['hadir', 'Hadir'], ['terlambat', 'Terlambat']],
      izin:     [['', 'Semua Status Izin'], ['izin', 'Izin'], ['sakit', 'Sakit']]
    };

    function colsFor() {
      if (tab === 'izin') return COLS.izin;
      const w = $('fWaktu').value;
      if (w === 'masuk') return { w: [20, 18, 18, 22, 22], h: ['Tanggal', 'Jam masuk', 'Foto masuk', 'Status', 'Aksi'] };
      if (w === 'pulang') return { w: [20, 18, 18, 22, 22], h: ['Tanggal', 'Jam Pulang', 'Foto pulang', 'Status', 'Aksi'] };
      return COLS.presensi;
    }
    function setCols() {
      const c = colsFor();
      $('colsD').innerHTML = c.w.map(w => '<col style="width:' + w + '%">').join('');
      $('headD').innerHTML = c.h.map(h => '<th>' + h + '</th>').join('');
    }
    function setTab(t) {
      tab = t;
      document.querySelectorAll('.rw-tab').forEach(b => {
        const on = b.dataset.tab === t;
        b.classList.toggle('on', on);
        b.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      const pr = t === 'presensi';
      $('wTgl').classList.toggle('hidden', !pr);
      $('wWaktu').classList.toggle('hidden', !pr);
      $('wMulai').classList.toggle('hidden', pr);
      $('wSelesai').classList.toggle('hidden', pr);
      $('lStatus').textContent = pr ? 'Status Kehadiran' : 'Status Izin';
      $('fTgl').value = ''; $('fMulai').value = ''; $('fSelesai').value = '';
      $('fWaktu').value = '';
      $('fStatus').innerHTML = STATUS_OPT[t].map(o => '<option value="' + o[0] + '">' + o[1] + '</option>').join('');
      setCols();
      applyFilter();
    }

    /* ---------- Filter ---------- */
    function applyFilter() {
      setCols();
      const tg = $('fTgl').value, w = $('fWaktu').value, s = $('fStatus').value;
      const a = $('fMulai').value, b = $('fSelesai').value;
      if (tab === 'izin') {
        // tampilkan izin/sakit yang rentang tanggalnya beririsan dengan rentang filter
        view = DATA.izin.filter(r =>
          (!s || r.sk === s) &&
          (!a || r.selesai >= a) &&
          (!b || r.mulai <= b));
      } else {
        view = DATA.presensi.filter(r =>
          (!tg || r.tgl === tg) &&
          (!s || r.sk === s) &&
          (!w || (w === 'masuk' ? !!r.masuk : !!r.pulang)));
      }
      closeDetail();
      page = 1; render();
    }
    ['fTgl', 'fWaktu', 'fStatus', 'fMulai', 'fSelesai'].forEach(id => $(id).addEventListener('change', applyFilter));
    document.querySelectorAll('.rw-tab').forEach(b => b.addEventListener('click', () => { if (b.dataset.tab !== tab) setTab(b.dataset.tab); }));

    /* ---------- Render ---------- */
    const EYE = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4 flex-none"><path d="M2 12s3.600-7 10-7 10 7 10 7-3.600 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
    const btnD = i => '<button type="button" data-view="' + i + '" class="rw-lihat mx-auto inline-flex items-center justify-center rounded-md bg-[#F3F4F6] font-medium text-black shadow-[0_2px_4px_rgba(0,0,0,0.22)] transition hover:bg-[#E3E3E3] active:scale-[.98]">' + EYE + 'Lihat</button>';

    function rowD(r, i) {
      if (tab === 'izin') {
        return '<tr>' +
          '<td>' + fmtDate(r.mulai) + '</td>' +
          '<td>' + fmtDate(r.selesai) + '</td>' +
          '<td class="truncate" title="' + esc(r.ket) + '">' + esc(r.ket || '-') + '</td>' +
          '<td>' + buktiThumb(r, 'rw-thumb mx-auto object-cover') + '</td>' +
          '<td>' + badge(r.sk, r.sl) + '</td>' +
          '<td>' + btnD(i) + '</td></tr>';
      }
      const w = $('fWaktu').value;   // '' = semua, 'masuk', 'pulang'
      const cm = '<td>' + fmtTime(r.masuk) + '</td><td>' + imgT(r.fm, 'Foto masuk', 'rw-thumb mx-auto object-cover') + '</td>';
      const cp = '<td>' + fmtTime(r.pulang) + '</td><td>' + imgT(r.fp, 'Foto pulang', 'rw-thumb mx-auto object-cover') + '</td>';
      return '<tr><td>' + fmtDate(r.tgl) + '</td>' + (w !== 'pulang' ? cm : '') + (w !== 'masuk' ? cp : '') +
        '<td>' + badge(r.sk, r.sl) + '</td><td>' + btnD(i) + '</td></tr>';
    }
    function cardM(r, i) {
      const dt = tab === 'izin' ? (r.mulai === r.selesai ? fmtDate(r.mulai) : fmtDate(r.mulai) + ' s/d ' + fmtDate(r.selesai)) : fmtDate(r.tgl);
      const head = '<div class="flex items-center justify-between gap-2"><span class="text-[13px] font-semibold">' + dt + '</span>' + badge(r.sk, r.sl) + '</div>';
      let mid;
      if (tab === 'izin') {
        mid = '<div class="mt-2.5"><p class="text-[11px] text-slate-500">Alasan Izin</p><p class="text-[12px] font-medium">' + esc(r.ket || '-') + '</p>' +
          (r.bukti ? '<p class="mt-2 text-[11px] text-slate-500">Foto Bukti</p><div class="mt-1 flex h-12 w-24 items-center justify-center overflow-hidden rounded-md bg-slate-100 text-xs">' + buktiThumb(r, 'h-full w-full object-cover') + '</div>' : '') + '</div>';
      } else {
        const wf = $('fWaktu').value;
        mid = '<div class="mt-2.5 grid ' + (wf ? 'grid-cols-1' : 'grid-cols-2') + ' gap-3">' +
          (wf === 'pulang' ? '' : '<div><p class="text-[11px] text-slate-500">Jam masuk</p><p class="text-[12px] font-medium">' + fmtTime(r.masuk) + '</p><div class="mt-1.5 flex h-12 items-center justify-center overflow-hidden rounded-md bg-slate-100 text-xs">' + imgT(r.fm, 'Foto masuk', 'h-full w-full object-cover') + '</div></div>') +
          (wf === 'masuk' ? '' : '<div><p class="text-[11px] text-slate-500">Jam pulang</p><p class="text-[12px] font-medium">' + fmtTime(r.pulang) + '</p><div class="mt-1.5 flex h-12 items-center justify-center overflow-hidden rounded-md bg-slate-100 text-xs">' + imgT(r.fp, 'Foto pulang', 'h-full w-full object-cover') + '</div></div>') + '</div>';
      }
      return '<div class="rounded-xl bg-white p-3 shadow-[0_3px_12px_rgba(0,0,0,0.12)]">' + head + mid +
        '<button type="button" data-view="' + i + '" class="mt-3 flex h-9 w-full items-center justify-center gap-2 rounded-lg bg-[#EFEFEF] text-xs font-semibold shadow-[0_2px_4px_rgba(0,0,0,0.2)] transition hover:bg-[#E3E3E3] active:scale-[.99]">' + EYE + 'Lihat</button></div>';
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
      h += '<button type="button" class="pg-b pg-pill" data-p="next"' + (page >= pages ? ' disabled' : '') + '>Selanjutnya' + CH_R + '</button>';
      return h;
    }

    function render() {
      const total = view.length, pages = Math.max(1, Math.ceil(total / PER_PAGE));
      page = Math.min(Math.max(1, page), pages);
      const start = (page - 1) * PER_PAGE, slice = view.slice(start, start + PER_PAGE);
      $('rowsD').innerHTML = slice.map((r, i) => rowD(r, start + i)).join('');
      $('rowsM').innerHTML = slice.map((r, i) => cardM(r, start + i)).join('');
      const emptyMsg = tab === 'izin'
        ? (DATA.izin.length ? 'Tidak ada data izin / sakit yang sesuai filter.' : 'Belum ada data izin / sakit.')
        : (DATA.presensi.length ? 'Tidak ada data presensi yang sesuai filter.' : 'Belum ada data presensi. Silakan lakukan presensi terlebih dahulu.');
      $('emptyD').textContent = emptyMsg; $('emptyM').textContent = emptyMsg;
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

    /* ---------- Popup detail ---------- */
    const dm = $('dModal');
    let curR = null;
    const photoCard = (title, src) =>
      '<div class="dm-pc"><p class="dm-pt">' + esc(title) + '</p>' +
      (src ? '<img class="dm-pimg" src="' + esc(src) + '" alt="' + esc(title) + '" />' : '<div class="dm-none">Tidak ada foto</div>') + '</div>';
    const infoRow = (l, v) => '<div class="dm-r"><span>' + l + '</span><span>' + v + '</span></div>';

    function openDetail(i) {
      const r = view[i]; if (!r) return;
      curR = r;
      let cards = '', rows = tab === 'presensi' ? infoRow('Tanggal', fmtDate(r.tgl)) : '';

      if (tab === 'presensi') {
        const w = $('fWaktu').value;           // '' = semua waktu, 'masuk', 'pulang'
        const showM = w !== 'pulang' && (r.masuk || r.fm);
        const showP = w !== 'masuk' && (r.pulang || r.fp);
        if (showM) cards += photoCard('Jam Masuk (' + fmtTime(r.masuk) + ')', r.fm);
        if (showP) cards += photoCard('Jam Pulang (' + fmtTime(r.pulang) + ')', r.fp);
        rows += infoRow('Waktu Presensi', w === 'masuk' ? 'Jam Masuk' : w === 'pulang' ? 'Jam Pulang' : 'Semua Waktu');
        rows += infoRow('Status', badge(r.sk, r.sl, 'rw-st-in'));
      } else {
        const fileRow = r.bukti
          ? '<button type="button" class="dm-file" data-openfile title="Buka file">' + docIcon + '<span class="fn">' + esc(fileName(r)) + '</span></button>'
          : '<p class="text-xs text-slate-500">Tidak ada bukti.</p>';
        cards = '<div class="dm-sec"><p class="dm-sec-t">Foto Bukti Chat / Surat Izin</p>' + fileRow + '</div>' +
                '<div class="dm-sec"><p class="dm-sec-t">Alasan Izin</p><div class="dm-ta">' + esc(r.ket || '-') + '</div></div>';
        rows += infoRow('Tanggal Mulai', fmtDate(r.mulai));
        rows += infoRow('Tanggal Selesai', fmtDate(r.selesai));
        rows += infoRow('Status', badge(r.sk, r.sl, 'rw-st-in'));
      }

      $('dPhotos').classList.toggle('dm-col', tab === 'izin');
      $('dPhotos').innerHTML = cards;
      $('dPhotos').classList.toggle('hidden', !cards);
      $('dInfo').innerHTML = rows;
      $('dInfo').style.marginTop = cards ? '' : '0';
      dm.classList.remove('hidden'); dm.classList.add('flex');
    }
    function closeDetail() { dm.classList.add('hidden'); dm.classList.remove('flex'); }
    document.addEventListener('click', e => {
      const b = e.target.closest('[data-view]');
      if (b) openDetail(parseInt(b.dataset.view, 10));
      if (e.target.closest('[data-openfile]')) openBukti(curR);
    });
    $('dClose').addEventListener('click', closeDetail);
    dm.addEventListener('click', e => { if (e.target === dm) closeDetail(); });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && !dm.classList.contains('hidden')) closeDetail(); });

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
    window.matchMedia('(min-width:900px)').addEventListener('change', () => setMenu(false));

    function logout() {
      if (!confirm('Yakin ingin keluar dari akun?')) return;
      ICONNET_API.logout();   // logout di server, lalu ke halaman login
    }
    $('logoutBtn').addEventListener('click', logout);
    $('logoutBtnM').addEventListener('click', logout);

    /* ---------- Mulai ---------- */
    setTab('presensi');
  </script>
</body>
</html>
