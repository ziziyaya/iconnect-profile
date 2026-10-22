<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Tentang Kami - ICONNET</title>

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

    /* Navbar mobile */
    #mnav > div:first-child { height: 56px; }
    #mnav img { height: 36px; }
    #mmenu > .flex > a, #mmenu > .flex > button { height: 40px; font-size: 12px; }
    #logoutBtnM { height: 40px; font-size: 12px; }
    header.hdr .hdr-t { font-size: 15px; line-height: 1.3; }
    header.hdr .hdr-s { font-size: 11px; line-height: 1.4; }

    /* =====================================================================
       Skala: semua ukuran konten memakai satuan --u (1u = 1px pada frame 1080 x 775)
       Mobile/tablet: 1u = 1.1px, halaman boleh scroll.
       ===================================================================== */
    :root { --u: 1.05px; }

    /* ---------- Kartu ---------- */
    .card { background: #fff; border: 1px solid #DADCE3; border-radius: calc(var(--u) * 16); box-shadow: 0 2px 7px rgba(0,0,0,.15); }
    .stack { display: flex; flex-direction: column; gap: calc(var(--u) * 12); }

    /* Kartu 1 */
    #c1 { padding: calc(var(--u) * 12) calc(var(--u) * 18) calc(var(--u) * 14); }
    .c-title { font-size: calc(var(--u) * 17.5); line-height: 1.3; font-weight: 500; color: #000; }
    .c-sub { margin-top: calc(var(--u) * 3); font-size: calc(var(--u) * 13); line-height: 1.4; color: #000; }

    /* Kartu 2 */
    #c2 { padding: calc(var(--u) * 10) calc(var(--u) * 18) calc(var(--u) * 10); }
    #aboutText { margin-top: calc(var(--u) * 4); font-size: calc(var(--u) * 13); line-height: calc(var(--u) * 20); color: #000; }
    .c2-line { margin-top: calc(var(--u) * 12); border-top: 1px solid #ECEDF2; }
    .c2-act { margin-top: calc(var(--u) * 8); }

    /* Kartu 3 */
    #c3 { display: flex; flex-direction: column; min-height: 0; padding: 0 calc(var(--u) * 22); }
    #c3Head { display: flex; align-items: center; justify-content: space-between; gap: 12px; padding-top: calc(var(--u) * 16); }
    #c3Head .c-title { line-height: calc(var(--u) * 34); }
    #list { margin-top: calc(var(--u) * 12); padding: 2px 1px calc(var(--u) * 16); display: flex; flex-direction: column; gap: calc(var(--u) * 14); }
    #emptyTl { padding: 28px 0; text-align: center; font-size: calc(var(--u) * 13); color: #64748B; }

    /* Tombol */
    .btn { display: inline-flex; align-items: center; justify-content: center; flex: none; gap: calc(var(--u) * 6); height: calc(var(--u) * 30); border-radius: calc(var(--u) * 15); font-size: calc(var(--u) * 12.5); font-weight: 500; color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.2); transition: filter .15s, transform .1s; }
    .btn:hover { filter: brightness(1.08); }
    .btn:active { transform: scale(.97); }
    .btn svg { width: calc(var(--u) * 15); height: calc(var(--u) * 15); flex: none; }
    .btn-edit { width: calc(var(--u) * 92); background: #0891B2; }
    .btn-del  { width: calc(var(--u) * 98); background: #D93A3F; }
    .btn-add  { width: calc(var(--u) * 136); height: calc(var(--u) * 34); border-radius: calc(var(--u) * 9); font-size: calc(var(--u) * 12.5); gap: calc(var(--u) * 7); background: linear-gradient(to bottom, #1E9BE0, #0B7FCB); }
    .btn-add svg { width: calc(var(--u) * 13); height: calc(var(--u) * 13); }

    /* Item perjalanan */
    .tl-item { display: flex; align-items: center; flex: none; padding: calc(var(--u) * 13) calc(var(--u) * 11) calc(var(--u) * 12) calc(var(--u) * 9); background: #fff; border: 1px solid #E3E5EB; border-radius: calc(var(--u) * 15); box-shadow: 0 1px 3px rgba(0,0,0,.1); }
    .tl-main { display: flex; align-items: flex-start; flex: 1; min-width: 0; }
    .tl-year { flex: none; display: flex; align-items: center; justify-content: center; width: calc(var(--u) * 58); height: calc(var(--u) * 26); margin-top: calc(var(--u) * -3); border-radius: calc(var(--u) * 13); background: #F1F3F8; border: 1px solid #E4E7EE; box-shadow: 0 1px 3px rgba(0,0,0,.15); font-size: calc(var(--u) * 12.5); font-weight: 500; color: #111; }
    .tl-text { flex: 1; min-width: 0; margin-left: calc(var(--u) * 12); margin-right: calc(var(--u) * 16); }
    .tl-t { font-size: calc(var(--u) * 13); line-height: calc(var(--u) * 20); font-weight: 500; color: #000; }
    .tl-d { margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 12.5); line-height: calc(var(--u) * 19.5); color: #000; }
    .tl-act { display: flex; align-items: center; gap: calc(var(--u) * 6); flex: none; }

    /* ---------- Pop up ---------- */
    .ov { position: fixed; inset: 0; z-index: 80; display: none; align-items: center; justify-content: center; padding: 16px; background: rgba(0,0,0,.4); }
    .ov.open { display: flex; animation: ovIn .15s ease; }
    .ov.open > div { animation: boxIn .18s ease; }
    @keyframes ovIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes boxIn { from { opacity: 0; transform: translateY(8px) scale(.97); } to { opacity: 1; transform: none; } }

    .mbox { width: min(calc(var(--u) * 534), calc(100vw - 32px)); max-height: 94vh; overflow-y: auto; background: #fff; border-radius: calc(var(--u) * 24); box-shadow: 0 10px 30px rgba(0,0,0,.25); }
    .m-head { display: flex; align-items: center; height: calc(var(--u) * 49); padding: 0 calc(var(--u) * 20); background: #02B6D1; border-radius: calc(var(--u) * 24) calc(var(--u) * 24) 0 0; }
    .m-head h3 { color: #fff; font-size: calc(var(--u) * 17); font-weight: 600; }
    .m-body { padding: calc(var(--u) * 16) calc(var(--u) * 20) calc(var(--u) * 4); }
    .m-lbl { display: block; font-size: calc(var(--u) * 13); font-weight: 500; color: #111; }
    .m-in { display: block; width: 100%; height: calc(var(--u) * 30); margin-top: calc(var(--u) * 5); padding: 0 calc(var(--u) * 12); border-radius: calc(var(--u) * 9); border: 1px solid #D9DCE3; background: #fff; font-size: calc(var(--u) * 11.5); font-family: inherit; color: #111; outline: none; transition: border-color .15s, box-shadow .15s; }
    .m-in::placeholder { color: #9AA0AC; }
    .m-in:focus { border-color: #4A9FF5; box-shadow: 0 0 0 3px rgba(74,159,245,.2); }
    .m-in.err { border-color: #D93A3F; }
    textarea.m-in { height: calc(var(--u) * 120); padding: calc(var(--u) * 8) calc(var(--u) * 12); resize: none; line-height: 1.6; }
    .m-err { min-height: calc(var(--u) * 14); margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 10); line-height: 1.3; font-weight: 500; color: #D93A3F; }
    .m-foot { display: flex; justify-content: center; gap: calc(var(--u) * 14); margin-top: calc(var(--u) * 8); padding: calc(var(--u) * 10) calc(var(--u) * 20) calc(var(--u) * 12); border-top: 1px solid #E8EAF0; }
    .m-btn { height: calc(var(--u) * 30); width: calc(var(--u) * 100); border-radius: calc(var(--u) * 10); font-size: calc(var(--u) * 12.5); font-weight: 600; box-shadow: 0 3px 5px rgba(0,0,0,.2); transition: background .15s, filter .15s, transform .1s; }
    .m-btn:active { transform: scale(.98); }
    .m-btn-grey { background: #E8E8E8; color: #000; } .m-btn-grey:hover { background: #DEDEDE; }
    .m-btn-blue { background: #4A9FF5; color: #fff; } .m-btn-blue:hover { filter: brightness(1.05); }
    .m-btn-red { background: #D93A3F; color: #fff; } .m-btn-red:hover { filter: brightness(1.08); }

    .dbox { width: min(calc(var(--u) * 346), calc(100vw - 32px)); padding: calc(var(--u) * 24) calc(var(--u) * 20); background: #fff; border-radius: calc(var(--u) * 30); text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,.25); }
    .d-ico { width: calc(var(--u) * 57); height: calc(var(--u) * 57); margin: 0 auto; }
    .d-ico svg { display: block; width: 100%; height: 100%; }
    .dbox h3 { margin-top: calc(var(--u) * 16); font-size: calc(var(--u) * 18); font-weight: 600; color: #111; }
    .dbox p { margin-top: calc(var(--u) * 5); font-size: calc(var(--u) * 14); color: #333; }
    .d-btns { display: flex; justify-content: center; gap: calc(var(--u) * 18); margin-top: calc(var(--u) * 22); }

    /* ---------- Pop up: disesuaikan 1:1 dengan desain (frame 1080) ---------- */
    .ov { background: rgba(0,0,0,.12); }
    .mbox { width: min(calc(var(--u) * 470), calc(100vw - 32px)); max-height: none; overflow: visible; border-radius: calc(var(--u) * 24); box-shadow: 0 6px 22px rgba(0,0,0,.2); }
    @media (max-width: 899px) { .mbox { max-height: 94vh; overflow-y: auto; } }
    .m-head { height: calc(var(--u) * 50); padding: 0 calc(var(--u) * 19); background: #02B6D1; border-radius: calc(var(--u) * 24) calc(var(--u) * 24) 0 0; }
    .m-head h3 { font-size: calc(var(--u) * 18); font-weight: 600; letter-spacing: 0; }
    .m-body { padding: calc(var(--u) * 12.5) calc(var(--u) * 18) calc(var(--u) * 23) calc(var(--u) * 17); }
    #aboutModal .m-body { padding-top: calc(var(--u) * 6); padding-bottom: calc(var(--u) * 26); }
    .m-row2 { display: grid; grid-template-columns: 1fr 1fr; column-gap: calc(var(--u) * 8.5); margin-bottom: calc(var(--u) * 8); }
    .m-f { position: relative; }
    .m-lbl { font-size: calc(var(--u) * 14); line-height: 1.4; font-weight: 500; color: #000; }
    .m-in { height: calc(var(--u) * 35); margin-top: calc(var(--u) * 5); padding: 0 calc(var(--u) * 11); border-radius: calc(var(--u) * 11); border: 1px solid #D9DCE3; font-size: calc(var(--u) * 12); }
    textarea.m-in { height: calc(var(--u) * 106); padding: calc(var(--u) * 8) calc(var(--u) * 11); line-height: calc(var(--u) * 19); }
    #aText { height: calc(var(--u) * 118); font-size: calc(var(--u) * 13); line-height: calc(var(--u) * 20); }
    .m-err { position: absolute; left: 2px; top: 100%; min-height: 0; margin-top: 1px; font-size: calc(var(--u) * 9.5); white-space: nowrap; }
    .m-in-ic { position: relative; }
    .m-in-ic .m-in { padding-right: calc(var(--u) * 36); }
    .m-ic { position: absolute; right: calc(var(--u) * 12); top: 50%; margin-top: calc(var(--u) * 2.5); transform: translateY(-50%); width: calc(var(--u) * 16); height: calc(var(--u) * 16); pointer-events: none; }
    .m-foot { gap: calc(var(--u) * 12); margin-top: 0; padding: calc(var(--u) * 13) calc(var(--u) * 20) calc(var(--u) * 10); border-top: 1px solid #E5E7EB; }
    .m-btn { height: calc(var(--u) * 30); width: calc(var(--u) * 98); border-radius: calc(var(--u) * 11); font-size: calc(var(--u) * 15); font-weight: 500; }

    .dbox { width: min(calc(var(--u) * 341), calc(100vw - 32px)); padding: calc(var(--u) * 17) calc(var(--u) * 20) calc(var(--u) * 24); border-radius: calc(var(--u) * 30); box-shadow: 0 6px 22px rgba(0,0,0,.2); }
    .d-ico { width: calc(var(--u) * 49); height: calc(var(--u) * 49); }
    .dbox h3 { margin-top: calc(var(--u) * 19); font-size: calc(var(--u) * 18); line-height: 1.3; font-weight: 500; color: #000; }
    .dbox p { margin-top: calc(var(--u) * 3); font-size: calc(var(--u) * 14); line-height: 1.4; color: #333; }
    .d-btns { gap: calc(var(--u) * 44); margin-top: calc(var(--u) * 36); }
    .d-btns .m-btn { width: calc(var(--u) * 95); height: calc(var(--u) * 33); }

    /* ---------- Mobile / tablet (<900px) ---------- */
    @media (max-width: 899px) {
      .stack { padding: 16px 16px 32px; }
      #c3 { min-height: 0; }
      .tl-item { flex-wrap: wrap; }
      .tl-main { flex: 1 1 100%; }
      .tl-text { margin-right: 0; }
      .tl-act { width: 100%; justify-content: flex-end; margin-top: 10px; }
      #c3 { padding-bottom: 0; }
    }

    /* ===== DESKTOP / LAPTOP (>=900px) - sama dengan halaman lain, frame desain 1080 x 775 ===== */
    @media (min-width: 900px) {
      :root { --u: max(min(100vw / 1080, 100vh / 745), 0.6px); --su: max(min(100vw / 1080, 100vh / 790), 0.6px); --sbw: calc(var(--su) * 198); }
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

      body .hdr { height: calc(var(--u) * 87); padding: 0 calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body header.hdr .hdr-t { font-size: calc(var(--u) * 19); line-height: 1.25; font-weight: 600; color: #03045E; }
      body header.hdr .hdr-s { font-size: calc(var(--u) * 13); line-height: 1.4; margin-top: calc(var(--u) * 2); color: #000; }

      /* Area konten: satu layar penuh, tanpa scroll halaman */
      body .main-c { height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 18) calc(var(--u) * 38) calc(var(--u) * 18) calc(var(--u) * 30); overflow: hidden; }
      body .stack { height: 100%; padding: 0; }
      body #c1, body #c2 { flex: none; }
      body #c3 { flex: 1; min-height: 0; }
      /* bila data perjalanan banyak, hanya daftar ini yang bisa discroll (scrollbar disembunyikan) */
      body #list { flex: 1; min-height: 0; overflow-y: auto; scrollbar-width: none; }
      body #list::-webkit-scrollbar { display: none; }
      /* overlay pop up: menutup area konten saja (sidebar tetap terang), pop up di tengah area konten */
      body .ov { left: var(--sbw); z-index: 40; }
      /* box item mengisi tinggi yang tersedia (3 item pas satu layar) */
      body .tl-item { flex: 1 1 0; min-height: calc(var(--u) * 84); max-height: calc(var(--u) * 120); }
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
  <div id="toast" class="pointer-events-none fixed left-1/2 top-4 z-[90] -translate-x-1/2 -translate-y-4 opacity-0 lg:left-auto lg:right-6 lg:translate-x-0" role="status" aria-live="polite">
    <div class="flex items-center gap-2.5 rounded-xl border border-green-200 bg-white px-4 py-2.5 shadow-[0_6px_20px_rgba(0,0,0,0.18)]">
      <span class="flex h-6 w-6 items-center justify-center rounded-full bg-green-500">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg>
      </span>
      <span id="toastText" class="text-xs font-medium sm:text-sm">Berhasil</span>
    </div>
  </div>

  <!-- ===================== NAVBAR MOBILE ===================== -->
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
        <a href="{{ url('beranda-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="2"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="2"/></svg>Beranda</a>
        <a href="{{ url('riwayat-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>Riwayat Presensi</a>
        <a href="{{ url('rekap-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="4" width="14" height="17" rx="2"/><path d="M9 4V3h6v1M9 11h6M9 15h6"/></svg>Rekap Presensi</a>
        <button id="kelolaBtnM" type="button" class="flex h-11 w-full items-center gap-3 rounded-xl bg-[#E1FAFF] px-3.5 text-[13px] font-medium text-ink transition"><svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.8 2.8 4 5.8 4 9s-1.2 6.2-4 9c-2.8-2.8-4-5.8-4-9s1.2-6.2 4-9z"/></svg><span class="flex-1 text-left">Kelola Tampilan</span><svg id="chevM" class="chev open h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg></button>
        <div id="subM" class="sb-sub open">
          <a href="{{ url('kelola-beranda') }}">Beranda</a>
          <a href="{{ url('kelola-tentang-kami') }}" class="active">Tentang Kami</a>
          <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
          <a href="{{ url('kelola-hubungi-kami') }}">Hubungi Kami</a>
        </div>
        <a href="{{ url('profil-superadmin') }}" class="flex h-11 items-center gap-3 rounded-xl px-3.5 text-[13px] text-slate-600 transition hover:bg-slate-100"><svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.2 18.5c1.2-2.2 3.2-3.3 5.8-3.3s4.6 1.1 5.8 3.3"/></svg>Profile</a>
      </div>
      <div class="my-3 h-px bg-[#ECEDF2]"></div>
      <button id="logoutBtnM" type="button" class="flex h-11 w-full items-center justify-center gap-2.5 rounded-xl bg-[#D23739] px-4 text-[13px] font-semibold text-white shadow-[0_4px_8px_rgba(0,0,0,0.2)] transition hover:brightness-110">
        <svg class="h-[18px] w-[18px] flex-none" viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.5 8.5L20.5 12l-5 3.5v-2.2H9v-2.6h6.5V8.5z"/></svg>
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
        <svg class="h-[18px] w-[18px] flex-none text-[#1D62A8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.6 3.8 9S14.5 18.4 12 21c-2.5-2.6-3.8-5.6-3.8-9S9.5 5.6 12 3z"/></svg>
        <span class="sb-label flex-1 text-left">Kelola Tampilan</span>
        <svg id="chevD" class="chev open sb-label h-3 w-3 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
      </button>
      <div id="subD" class="sb-sub open">
        <a href="{{ url('kelola-beranda') }}">Beranda</a>
        <a href="{{ url('kelola-tentang-kami') }}" class="active">Tentang Kami</a>
        <a href="{{ url('kelola-paket-harga') }}">Paket &amp; Harga</a>
        <a href="{{ url('kelola-hubungi-kami') }}">Hubungi Kami</a>
      </div>
      <a href="{{ url('profil-superadmin') }}" class="sb-item flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-xs text-slate-600 transition hover:bg-slate-100">
        <svg class="h-[18px] w-[18px] flex-none text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.2 18.5c1.2-2.2 3.2-3.3 5.8-3.3s4.6 1.1 5.8 3.3"/></svg>
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
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Pengelolaan Tentang Kami</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Kelola informasi Tentang ICONNET dan perjalanan ICONNET di website publik.</p>
    </header>

    <main class="main-c">
      <div class="stack">

        <!-- Kartu 1 -->
        <section id="c1" class="card">
          <h2 class="c-title">Pengelolaan Bagian: Paket &amp; Harga</h2>
          <p class="c-sub">Kelola daftar paket internet broadband, harga bulanan, kecepatan, dan fitur.</p>
        </section>

        <!-- Kartu 2: Tentang ICONNET -->
        <section id="c2" class="card">
          <h2 class="c-title">Tentang ICONNET</h2>
          <p id="aboutText"></p>
          <div class="c2-line"></div>
          <div class="c2-act">
            <button id="btnEditAbout" type="button" class="btn btn-edit">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>Edit
            </button>
          </div>
        </section>

        <!-- Kartu 3: Perjalanan ICONNET -->
        <section id="c3" class="card">
          <div id="c3Head">
            <h2 class="c-title">Perjalanan ICONNET</h2>
            <button id="btnAdd" type="button" class="btn btn-add">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>Tambah Data
            </button>
          </div>
          <div id="list"></div>
        </section>

      </div>
    </main>
  </div>

  <!-- ===================== POP UP EDIT TENTANG ICONNET ===================== -->
  <div id="aboutModal" class="ov" aria-hidden="true">
    <div class="mbox" role="dialog" aria-modal="true" aria-labelledby="aTitle">
      <div class="m-head"><h3 id="aTitle">Edit Tentang ICONNET</h3></div>
      <form id="aForm" novalidate autocomplete="off">
        <div class="m-body">
          <div class="m-f">
            <label for="aText" class="m-lbl">Deskripsi</label>
            <textarea id="aText" class="m-in"></textarea>
            <p id="eAText" class="m-err"></p>
          </div>
        </div>
        <div class="m-foot">
          <button id="aCancel" type="button" class="m-btn m-btn-grey">Batal</button>
          <button type="submit" class="m-btn m-btn-blue">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ===================== POP UP TAMBAH / EDIT PERJALANAN ===================== -->
  <div id="tlModal" class="ov" aria-hidden="true">
    <div class="mbox" role="dialog" aria-modal="true" aria-labelledby="tTitle">
      <div class="m-head"><h3 id="tTitle">Tambah Perjalanan ICONNET</h3></div>
      <form id="tForm" novalidate autocomplete="off">
        <div class="m-body">
          <div class="m-row2">
            <div class="m-f">
              <label for="tYear" class="m-lbl">Tahun</label>
              <div class="m-in-ic">
                <input id="tYear" type="text" inputmode="numeric" maxlength="4" class="m-in" />
                <svg class="m-ic" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="16" rx="2.5"/><path d="M3 10h18M8 3v4M16 3v4"/></svg>
              </div>
              <p id="eTYear" class="m-err"></p>
            </div>
            <div class="m-f">
              <label for="tJudul" class="m-lbl">Judul</label>
              <input id="tJudul" type="text" maxlength="60" class="m-in" />
              <p id="eTJudul" class="m-err"></p>
            </div>
          </div>
          <div class="m-f">
            <label for="tDesk" class="m-lbl">Deskripsi</label>
            <textarea id="tDesk" maxlength="220" class="m-in"></textarea>
            <p id="eTDesk" class="m-err"></p>
          </div>
        </div>
        <div class="m-foot">
          <button id="tCancel" type="button" class="m-btn m-btn-grey">Batal</button>
          <button type="submit" class="m-btn m-btn-blue">Simpan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ===================== POP UP KONFIRMASI HAPUS ===================== -->
  <div id="delModal" class="ov" aria-hidden="true">
    <div class="dbox" role="alertdialog" aria-modal="true" aria-labelledby="dTitle" aria-describedby="dDesc">
      <div class="d-ico" aria-hidden="true">
        <svg viewBox="0 0 56 56" fill="none"><circle cx="28" cy="28" r="28" fill="#F8D3D5"/><circle cx="28" cy="28" r="15" stroke="#E03B3B" stroke-width="2.4"/><path d="M28 21v9" stroke="#E03B3B" stroke-width="2.6" stroke-linecap="round"/><circle cx="28" cy="35" r="1.6" fill="#E03B3B"/></svg>
      </div>
      <h3 id="dTitle">Konfirmasi Hapus Data</h3>
      <p id="dDesc">Yakin ingin menghapus data ini?</p>
      <div class="d-btns">
        <button id="dCancel" type="button" class="m-btn m-btn-grey">Batal</button>
        <button id="dOk" type="button" class="m-btn m-btn-red">Hapus</button>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/site-data.js') }}"></script>
  <script>
    const $ = id => document.getElementById(id);
    const read = (k, d) => ICONNET_API.read(k, d);   // data dari database (lihat public/js/iconnet-api.js)
    const esc = s => String(s).replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));

    /* =====================================================================
       Data dari database: teks "Tentang ICONNET" (pengaturans.tentang) &
       timeline perjalanan (tabel perjalanans). saveData() menyimpan lewat API Laravel
       dan mengembalikan data terbaru { about, timeline }.
       ===================================================================== */
    const KEY = ICONNET.KEY_TENTANG;
    // Data awal = isi asli tentang-kami.html (dari site-data.js), jadi admin & halaman publik selalu sama.
    const loadData = () => ICONNET.loadTentang();
    async function saveData(method, path, body) {
      const res = await ICONNET_API.request(method, 'api/v1/kelola/' + path, body);
      ICONNET_API.write(KEY, res.data);
      return res.data;
    }

    let data = loadData();
    let editId = null, delId = null;

    const ICON_EDIT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>';
    const ICON_DEL = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>';

    function itemHTML(t) {
      return `
      <article class="tl-item">
        <div class="tl-main">
          <span class="tl-year">${esc(t.tahun)}</span>
          <div class="tl-text">
            <h3 class="tl-t">${esc(t.judul)}</h3>
            <p class="tl-d">${esc(t.deskripsi)}</p>
          </div>
        </div>
        <div class="tl-act">
          <button type="button" class="btn btn-edit" data-act="edit" data-id="${t.id}">${ICON_EDIT}Edit</button>
          <button type="button" class="btn btn-del" data-act="del" data-id="${t.id}">${ICON_DEL}Hapus</button>
        </div>
      </article>`;
    }

    function render() {
      $('aboutText').textContent = data.about;
      $('list').innerHTML = data.timeline.length
        ? data.timeline.map(itemHTML).join('')
        : '<p id="emptyTl">Belum ada data perjalanan. Klik "Tambah Data" untuk menambahkan.</p>';
    }

    /* ---------- Pop up (buka / tutup) ---------- */
    const aboutModal = $('aboutModal'), tlModal = $('tlModal'), delModal = $('delModal');
    function openOv(el) { el.classList.add('open'); el.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; }
    function closeOv(el) {
      el.classList.remove('open'); el.setAttribute('aria-hidden', 'true');
      if (!document.querySelector('.ov.open') && window.matchMedia('(max-width:899px)').matches) document.body.style.overflow = '';
      else if (!document.querySelector('.ov.open')) document.body.style.overflow = 'hidden';
    }
    const closeAbout = () => closeOv(aboutModal);
    const closeTl = () => closeOv(tlModal);
    const closeDel = () => { closeOv(delModal); delId = null; };
    function setErr(i, e, msg) { $(i).classList.add('err'); $(e).textContent = msg; }
    function clearErr(pairs) { pairs.forEach(([i, e]) => { $(i).classList.remove('err'); $(e).textContent = ''; }); }

    /* ---------- Edit Tentang ICONNET ---------- */
    $('btnEditAbout').addEventListener('click', () => {
      clearErr([['aText', 'eAText']]);
      $('aText').value = data.about;
      openOv(aboutModal); $('aText').focus();
    });
    $('aCancel').addEventListener('click', closeAbout);
    aboutModal.addEventListener('click', e => { if (e.target === aboutModal) closeAbout(); });
    $('aForm').addEventListener('submit', async e => {
      e.preventDefault(); clearErr([['aText', 'eAText']]);
      const v = $('aText').value.trim();
      if (!v) return setErr('aText', 'eAText', 'Deskripsi wajib diisi.');
      let next;
      try { next = await saveData('PUT', 'tentang', { about: v }); } catch (err) { return showToast(err.message || 'Gagal menyimpan data. Coba lagi.'); }
      data = next; closeAbout(); render(); showToast('Tentang ICONNET berhasil diperbarui');
    });

    /* ---------- Tambah / edit perjalanan ---------- */
    const TF = [['tYear', 'eTYear'], ['tJudul', 'eTJudul'], ['tDesk', 'eTDesk']];
    $('tYear').addEventListener('input', e => { e.target.value = e.target.value.replace(/\D/g, '').slice(0, 4); });
    function openTl(id) {
      editId = id || null; clearErr(TF);
      const t = id ? data.timeline.find(x => x.id === id) : null;
      $('tTitle').textContent = t ? 'Edit Perjalanan ICONNET' : 'Tambah Perjalanan ICONNET';
      $('tYear').value = t ? t.tahun : '';
      $('tJudul').value = t ? t.judul : '';
      $('tDesk').value = t ? t.deskripsi : '';
      openOv(tlModal); $('tYear').focus();
    }
    $('btnAdd').addEventListener('click', () => openTl(null));
    $('tCancel').addEventListener('click', closeTl);
    tlModal.addEventListener('click', e => { if (e.target === tlModal) closeTl(); });
    $('tForm').addEventListener('submit', async e => {
      e.preventDefault(); clearErr(TF);
      const tahun = $('tYear').value.trim(), judul = $('tJudul').value.trim(), deskripsi = $('tDesk').value.trim();
      let ok = true;
      if (!/^\d{4}$/.test(tahun)) { setErr('tYear', 'eTYear', 'Tahun wajib diisi 4 digit, contoh: 2021.'); ok = false; }
      if (!judul) { setErr('tJudul', 'eTJudul', 'Judul wajib diisi.'); ok = false; }
      if (!deskripsi) { setErr('tDesk', 'eTDesk', 'Deskripsi wajib diisi.'); ok = false; }
      if (!ok) return;
      const item = { tahun, judul, deskripsi };
      const wasEdit = !!editId;
      let next;
      try { next = await saveData(wasEdit ? 'PUT' : 'POST', wasEdit ? 'perjalanan/' + editId : 'perjalanan', item); }
      catch (err) { return showToast(err.message || 'Gagal menyimpan data. Coba lagi.'); }
      data = next; closeTl(); render();
      showToast(wasEdit ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan');
    });

    /* ---------- Edit / hapus dari daftar ---------- */
    $('list').addEventListener('click', e => {
      const b = e.target.closest('[data-act]'); if (!b) return;
      const id = +b.dataset.id;
      if (b.dataset.act === 'edit') openTl(id);
      else { delId = id; openOv(delModal); $('dCancel').focus(); }
    });
    $('dCancel').addEventListener('click', closeDel);
    delModal.addEventListener('click', e => { if (e.target === delModal) closeDel(); });
    $('dOk').addEventListener('click', async () => {
      if (delId === null) return;
      let next;
      try { next = await saveData('DELETE', 'perjalanan/' + delId); } catch (err) { closeDel(); return showToast(err.message || 'Gagal menghapus data. Coba lagi.'); }
      data = next; closeDel(); render(); showToast('Data berhasil dihapus');
    });

    document.addEventListener('keydown', e => {
      if (e.key !== 'Escape') return;
      if (delModal.classList.contains('open')) closeDel();
      else if (tlModal.classList.contains('open')) closeTl();
      else if (aboutModal.classList.contains('open')) closeAbout();
    });

    /* Toast */
    function showToast(msg) {
      const t = $('toast'); $('toastText').textContent = msg;
      t.classList.remove('opacity-0', '-translate-y-4');
      clearTimeout(window._tt);
      window._tt = setTimeout(() => t.classList.add('opacity-0', '-translate-y-4'), 3000);
    }

    /* Sidebar (desktop) & hamburger (mobile) - sama dengan halaman lain */
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

    render();
  </script>
</body>
</html>
