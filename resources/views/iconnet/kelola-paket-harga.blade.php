<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Paket & Harga - ICONNET</title>

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

    /* ===== Komponen Paket & Harga (mobile dulu, ukuran dikecilkan) ===== */
    #mnav > div:first-child { height: 56px; }
    #mnav img { height: 36px; }
    #mmenu > .flex > a, #mmenu > .flex > button { height: 40px; font-size: 12px; }
    #logoutBtnM { height: 40px; font-size: 12px; }
    header.hdr .hdr-t { font-size: 15px; line-height: 1.3; }
    header.hdr .hdr-s { font-size: 11px; line-height: 1.4; }

    #pkTitle { font-size: 13.5px; line-height: 1.3; font-weight: 500; color: #000; }
    #pkSub { font-size: 11px; line-height: 1.4; color: #000; margin-top: 2px; }
    #btnAdd { height: 34px; padding: 0 14px; font-size: 11.5px; gap: 6px; }
    #btnAdd svg { width: 13px; height: 13px; }

    .f-btn { height: 32px; min-width: 84px; padding: 0 16px; border-radius: 8px; border: 1px solid #E5E7EB; background: #fff; font-size: 11.5px; color: #111; box-shadow: 0 2px 5px rgba(0,0,0,.14); transition: background .15s, color .15s, border-color .15s; }
    .f-btn:hover { background: #F4FBFD; }
    .f-btn.active { background: #02B6D1; border-color: #02B6D1; color: #fff; font-weight: 500; }

    /* ===== Filter kategori (mobile/tablet): 3 tombol sama lebar, rapi ===== */
    @media (max-width: 899px) {
      #filters { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 8px; }
      #filters .f-btn { width: 100%; min-width: 0; padding: 0 6px; height: 34px; font-size: 12px; }
    }

    /* ===== Card paket (mobile: 2 kolom, proporsi mengikuti desain) ===== */
    .pk-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,.2); display: flex; flex-direction: column; border: 1px solid #F0F0F4; min-width: 0; }
    .pk-in { flex: 1; min-height: 0; display: flex; flex-direction: column; padding: 10px 9px 8px; }
    .pk-badges { display: flex; align-items: center; gap: 4px; flex-wrap: nowrap; min-width: 0; }
    .bdg { display: inline-flex; align-items: center; justify-content: center; height: 15px; padding: 0 6px; border-radius: 999px; font-size: 7px; line-height: 1; white-space: nowrap; }
    .bdg-promo { background: #FFFDF5; border: 1px solid #F3D78A; color: #D9A400; }
    .bdg-reg { background: #EAF2FF; border: 1px solid #C6DAFF; color: #2D63D8; }
    .bdg-top { background: #CBA82A; color: #fff; font-weight: 600; letter-spacing: .02em; padding: 0 7px; }
    .pk-price { margin-top: 7px; font-size: 15px; line-height: 1.2; font-weight: 700; color: #03045E; padding-bottom: 7px; border-bottom: 1px solid #ECEDF2; white-space: nowrap; }
    .pk-rows { margin-top: 8px; display: flex; flex-direction: column; gap: 7px; flex: 1; }
    .pk-row { display: grid; grid-template-columns: 4.7em .9em 1fr; font-size: 8.5px; line-height: 1.4; color: #111; }
    .pk-row > span:last-child { min-width: 0; }
    .pk-act { display: flex; justify-content: flex-end; align-items: center; gap: 4px; margin-top: 8px; }
    .pk-act button { display: flex; align-items: center; justify-content: center; width: 22px; height: 22px; border-radius: 6px; transition: background .15s; }
    .pk-act .ed { color: #0891B2; } .pk-act .ed:hover { background: #E0F4F8; }
    .pk-act .dl { color: #E03B3B; } .pk-act .dl:hover { background: #FDECEC; }
    .pk-act svg { width: 15px; height: 15px; }

    /* HP kecil (<=359px) */
    @media (max-width: 359px) {
      .pk-in { padding: 9px 8px 7px; }
      .bdg { font-size: 6.5px; padding: 0 5px; height: 14px; }
      .bdg-top { padding: 0 6px; }
      .pk-price { font-size: 14px; }
      .pk-row { font-size: 8px; }
    }
    /* Tablet (640-899px): 3 kolom */
    @media (min-width: 640px) and (max-width: 899px) {
      .pk-in { padding: 12px 12px 10px; }
      .bdg { height: 17px; font-size: 8px; padding: 0 9px; }
      .bdg-top { padding: 0 10px; }
      .pk-price { font-size: 17px; margin-top: 8px; padding-bottom: 8px; }
      .pk-rows { gap: 8px; margin-top: 10px; }
      .pk-row { font-size: 9.5px; }
      .pk-act button { width: 24px; height: 24px; }
      .pk-act svg { width: 16px; height: 16px; }
    }

    .pg-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; height: 26px; padding: 0 12px; border-radius: 999px; border: 1px solid #E2E4EA; background: #fff; font-size: 10px; color: #444; transition: background .15s; }
    .pg-btn:hover:not(:disabled) { background: #F4F5F9; }
    .pg-btn:disabled { opacity: .45; cursor: default; }
    .pg-num { display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 20px; border-radius: 6px; font-size: 10px; color: #111; background: #fff; }
    .pg-num.active { background: #4FC7DB; color: #fff; }

    /* ===== Pop up tambah / edit / hapus (mobile dulu) ===== */
    .ov { position: fixed; inset: 0; z-index: 80; display: none; align-items: center; justify-content: center; padding: 16px; background: rgba(0,0,0,.4); }
    .ov.open { display: flex; animation: ovIn .15s ease; }
    .ov.open > div { animation: boxIn .18s ease; }
    @keyframes ovIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes boxIn { from { opacity: 0; transform: translateY(8px) scale(.97); } to { opacity: 1; transform: none; } }

    .mbox { width: 100%; max-width: 460px; max-height: 92vh; overflow-y: auto; background: #fff; border-radius: 18px; box-shadow: 0 10px 30px rgba(0,0,0,.25); }
    .m-head { display: flex; align-items: center; height: 46px; padding: 0 18px; background: #02B6D1; border-radius: 18px 18px 0 0; }
    .m-head h3 { color: #fff; font-size: 15px; font-weight: 600; letter-spacing: .01em; }
    .m-body { padding: 14px 18px 4px; }
    .m-grid { display: grid; grid-template-columns: 1fr; column-gap: 18px; }
    @media (min-width: 480px) { .m-grid { grid-template-columns: 1fr 1fr; } }
    .m-lbl { display: block; font-size: 11.5px; font-weight: 500; color: #111; }
    .m-in { display: block; width: 100%; height: 36px; margin-top: 5px; border-radius: 9px; border: 1px solid #D9DCE3; background-color: #fff; padding: 0 12px; font-size: 12px; font-family: inherit; color: #111; outline: none; transition: border-color .15s, box-shadow .15s; }
    .m-in::placeholder { color: #9AA0AC; }
    .m-in:focus { border-color: #4A9FF5; box-shadow: 0 0 0 3px rgba(74,159,245,.2); }
    .m-in.err { border-color: #D93A3F; }
    .m-sel { appearance: none; -webkit-appearance: none; padding-right: 30px; cursor: pointer; background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23222' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'><path d='M6 9l6 6 6-6'/></svg>"); background-repeat: no-repeat; background-position: right 10px center; background-size: 12px; }
    textarea.m-in { height: 64px; padding: 8px 12px; resize: none; line-height: 1.5; }
    .m-err { min-height: 14px; margin-top: 2px; font-size: 10px; line-height: 1.3; font-weight: 500; color: #D93A3F; }
    .m-chk { display: flex; align-items: center; gap: 10px; width: fit-content; font-size: 12px; color: #555; cursor: pointer; user-select: none; }
    .m-chk input { appearance: none; -webkit-appearance: none; display: grid; place-content: center; flex: none; width: 18px; height: 18px; margin: 0; border: 1.5px solid #AEB4BF; border-radius: 6px; background: #fff; cursor: pointer; transition: background .15s, border-color .15s; }
    .m-chk input::after { content: ''; width: 5px; height: 9px; border: solid #fff; border-width: 0 2px 2px 0; transform: rotate(45deg) translate(-1px, -1px); opacity: 0; }
    .m-chk input:checked { background: #02B6D1; border-color: #02B6D1; }
    .m-chk input:checked::after { opacity: 1; }
    .m-chk input:focus-visible { outline: 3px solid rgba(2,182,209,.35); outline-offset: 1px; }
    .m-foot { display: flex; justify-content: center; gap: 14px; margin-top: 10px; padding: 12px 18px 14px; border-top: 1px solid #E8EAF0; }
    .m-btn { height: 36px; width: 104px; border-radius: 10px; font-size: 12.5px; font-weight: 600; box-shadow: 0 3px 5px rgba(0,0,0,.2); transition: background .15s, filter .15s, transform .1s; }
    .m-btn:active { transform: scale(.98); }
    .m-btn-grey { background: #E8E8E8; color: #000; } .m-btn-grey:hover { background: #DEDEDE; }
    .m-btn-blue { background: #4A9FF5; color: #fff; } .m-btn-blue:hover { filter: brightness(1.05); }
    .m-btn-red { background: #D93A3F; color: #fff; } .m-btn-red:hover { filter: brightness(1.08); }

    .dbox { width: 100%; max-width: 320px; padding: 22px 20px 20px; background: #fff; border-radius: 26px; text-align: center; box-shadow: 0 10px 30px rgba(0,0,0,.25); }
    .d-ico { width: 52px; height: 52px; margin: 0 auto; }
    .d-ico svg { display: block; width: 100%; height: 100%; }
    .dbox h3 { margin-top: 14px; font-size: 15px; font-weight: 600; color: #111; }
    .dbox p { margin-top: 4px; font-size: 12px; color: #333; }
    .d-btns { display: flex; justify-content: center; gap: 14px; margin-top: 18px; }

    /* ===== DESKTOP / LAPTOP (>=900px) - skala mengikuti frame referensi ===== */
    @media (min-width: 900px) {
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

      body .hdr { height: calc(var(--u) * 87); padding: 0 calc(var(--u) * 40) 0 calc(var(--u) * 39); background-color: #FFFFFF; box-shadow: none; }
      body header.hdr .hdr-t { font-size: calc(var(--u) * 19); line-height: 1.25; font-weight: 600; color: #03045E; }
      body header.hdr .hdr-s { font-size: calc(var(--u) * 13); line-height: 1.4; margin-top: calc(var(--u) * 2); color: #000; }

      /* Area konten: satu layar penuh, tanpa scroll halaman */
      body .main-c { height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 16) calc(var(--u) * 20) calc(var(--u) * 16) calc(var(--u) * 28); }
      body #pkCard { height: 100%; max-width: none; padding: 0; border-radius: calc(var(--u) * 16); display: flex; flex-direction: column; overflow: hidden; border: 1px solid #DADCE3; box-shadow: 0 1px 4px rgba(0,0,0,.08); }
      body #pkHead { padding: calc(var(--u) * 16) calc(var(--u) * 14) calc(var(--u) * 12); border-bottom: 1px solid #E8EAF0; }
      body #pkTitle { font-size: calc(var(--u) * 15); }
      body #pkSub { font-size: calc(var(--u) * 11.5); margin-top: calc(var(--u) * 4); }
      body #btnAdd { height: calc(var(--u) * 28); padding: 0 calc(var(--u) * 14); font-size: calc(var(--u) * 11); gap: calc(var(--u) * 5); border-radius: calc(var(--u) * 7); }
      body #btnAdd svg { width: calc(var(--u) * 12); height: calc(var(--u) * 12); }

      body #pkBody { flex: 1; min-height: 0; display: flex; flex-direction: column; padding: calc(var(--u) * 14); overflow: hidden; }
      body #filters { gap: calc(var(--u) * 16); }
      body .f-btn { height: calc(var(--u) * 26); width: calc(var(--u) * 98); min-width: 0; padding: 0; border-radius: calc(var(--u) * 7); font-size: calc(var(--u) * 10.5); }

      /* Grid 4 kolom x 2 baris mengisi seluruh area; tiap kartu jadi "container"
         dan semua isinya memakai satuan --k (1% lebar kartu, dibatasi tinggi kartu) */
      body #grid { flex: 1; min-height: 0; margin-top: calc(var(--u) * 14); grid-template-rows: repeat(2, minmax(0, 1fr)); column-gap: calc(var(--u) * 10); row-gap: calc(var(--u) * 20); }
      body .pk-card { container-type: size; --k: min(1cqw, calc(1cqh / 1.02)); height: auto; border-radius: calc(var(--u) * 9); overflow: hidden; }
      body .pk-in { padding: calc(var(--k) * 5.6) calc(var(--k) * 7.5) calc(var(--k) * 5.2); }
      body .pk-badges { gap: calc(var(--k) * 2.6); flex-wrap: nowrap; }
      body .bdg { height: calc(var(--k) * 10.6); padding: 0 calc(var(--k) * 4.2); font-size: calc(var(--k) * 4.9); }
      body .bdg-top { padding: 0 calc(var(--k) * 5.6); }
      body .pk-price { margin-top: calc(var(--k) * 3.6); font-size: calc(var(--k) * 11); padding-bottom: calc(var(--k) * 4.2); }
      body .pk-rows { margin-top: calc(var(--k) * 3.6); gap: calc(var(--k) * 2.2); }
      body .pk-row { grid-template-columns: calc(var(--k) * 28.5) calc(var(--k) * 4) 1fr; font-size: calc(var(--k) * 5.5); line-height: 1.65; }
      body .pk-act { gap: calc(var(--k) * 3.4); margin-top: calc(var(--k) * 2.5); }
      body .pk-act button { width: calc(var(--k) * 8.4); height: calc(var(--k) * 8.4); border-radius: calc(var(--k) * 1.8); }
      body .pk-act svg { width: calc(var(--k) * 6.8); height: calc(var(--k) * 6.8); }

      body #pkFoot { border-top: 1px solid #E8EAF0; padding: calc(var(--u) * 10) calc(var(--u) * 24) calc(var(--u) * 10); }
      body #pkFoot { gap: calc(var(--u) * 10); }
      body .pg-btn { height: calc(var(--u) * 21); padding: 0 calc(var(--u) * 14); gap: calc(var(--u) * 6); font-size: calc(var(--u) * 8); }
      body .pg-btn svg { width: calc(var(--u) * 7); height: calc(var(--u) * 7); }
      body .pg-num { width: calc(var(--u) * 21); height: calc(var(--u) * 17); font-size: calc(var(--u) * 8); border-radius: calc(var(--u) * 5); }
    }

    @media (min-width: 900px) {
      body .mbox { width: calc(var(--u) * 534); max-width: none; max-height: none; overflow: visible; border-radius: calc(var(--u) * 24); }
      body .m-head { height: calc(var(--u) * 49); padding: 0 calc(var(--u) * 20); border-radius: calc(var(--u) * 24) calc(var(--u) * 24) 0 0; }
      body .m-head h3 { font-size: calc(var(--u) * 17); }
      body .m-body { padding: calc(var(--u) * 16) calc(var(--u) * 20) calc(var(--u) * 4); }
      body .m-grid { column-gap: calc(var(--u) * 26); }
      body .m-lbl { font-size: calc(var(--u) * 13); }
      body .m-in { height: calc(var(--u) * 30); margin-top: calc(var(--u) * 5); padding: 0 calc(var(--u) * 12); border-radius: calc(var(--u) * 9); font-size: calc(var(--u) * 11.5); }
      body .m-sel { padding-right: calc(var(--u) * 30); background-position: right calc(var(--u) * 10) center; background-size: calc(var(--u) * 12); }
      body textarea.m-in { height: calc(var(--u) * 56); padding: calc(var(--u) * 8) calc(var(--u) * 12); }
      body .m-err { min-height: calc(var(--u) * 14); margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 10); }
      body .m-chk { gap: calc(var(--u) * 10); font-size: calc(var(--u) * 12.5); }
      body .m-chk input { width: calc(var(--u) * 19); height: calc(var(--u) * 19); border-radius: calc(var(--u) * 6); }
      body .m-foot { gap: calc(var(--u) * 14); margin-top: calc(var(--u) * 8); padding: calc(var(--u) * 10) calc(var(--u) * 20) calc(var(--u) * 12); }
      body .m-btn { height: calc(var(--u) * 30); width: calc(var(--u) * 100); border-radius: calc(var(--u) * 10); font-size: calc(var(--u) * 12.5); }
      body .dbox { width: calc(var(--u) * 346); max-width: none; padding: calc(var(--u) * 24) calc(var(--u) * 20); border-radius: calc(var(--u) * 30); }
      body .d-ico { width: calc(var(--u) * 57); height: calc(var(--u) * 57); }
      body .dbox h3 { margin-top: calc(var(--u) * 16); font-size: calc(var(--u) * 18); }
      body .dbox p { margin-top: calc(var(--u) * 5); font-size: calc(var(--u) * 14); }
      body .d-btns { gap: calc(var(--u) * 18); margin-top: calc(var(--u) * 22); }
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
          <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
          <a href="{{ url('kelola-paket-harga') }}" class="active">Paket &amp; Harga</a>
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
        <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
        <a href="{{ url('kelola-paket-harga') }}" class="active">Paket &amp; Harga</a>
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
      <h1 class="hdr-t text-lg font-semibold text-[#03045E]">Pengelolaan Web Profile ICONNET</h1>
      <p class="hdr-s text-[11px] text-black sm:text-xs">Super Admin mengelola konten yang tampil di portal publik website ICONNET</p>
    </header>

    <main class="main-c px-4 pb-8 pt-4 sm:px-6">
      <section id="pkCard" class="mx-auto w-full max-w-[1100px] rounded-2xl bg-white shadow-[0_3px_14px_rgba(0,0,0,0.12)]">

        <!-- Judul kartu -->
        <div id="pkHead" class="flex items-start justify-between gap-3 border-b border-slate-200 p-4">
          <div class="min-w-0">
            <h2 id="pkTitle">Pengelolaan Bagian: Paket &amp; Harga</h2>
            <p id="pkSub">Kelola daftar paket internet broadband, harga bulanan, kecepatan, dan fitur.</p>
          </div>
          <button id="btnAdd" type="button" class="flex flex-none items-center rounded-lg bg-gradient-to-b from-[#1E9BE0] to-[#0B7FCB] font-medium text-white shadow-[0_3px_6px_rgba(0,0,0,0.2)] transition hover:brightness-110 active:scale-[.98]">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Paket
          </button>
        </div>

        <!-- Isi: filter + grid -->
        <div id="pkBody" class="p-4 pb-2">
          <div id="filters" class="flex flex-wrap items-center gap-2.5" role="tablist" aria-label="Kategori paket">
            <button type="button" data-f="semua" class="f-btn active">Semua</button>
            <button type="button" data-f="promo" class="f-btn">Promo</button>
            <button type="button" data-f="reguler" class="f-btn">Reguler</button>
          </div>

          <div id="grid" class="mt-4 grid grid-cols-2 gap-2.5 sm:grid-cols-3 sm:gap-3 lg:grid-cols-4 lg:content-start"></div>
          <p id="empty" class="hidden py-10 text-center text-xs text-slate-500">Belum ada paket pada kategori ini.</p>
        </div>

        <!-- Pagination -->
        <div id="pkFoot" class="flex flex-wrap items-center justify-center gap-2 border-t border-slate-200 px-4 py-3 lg:justify-end">
          <button id="pgPrev" type="button" class="pg-btn">
            <svg class="h-2 w-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg>Sebelumnya
          </button>
          <div id="pgNums" class="flex items-center gap-1.5"></div>
          <button id="pgNext" type="button" class="pg-btn">
            Selanjutnya<svg class="h-2 w-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </section>
    </main>
  </div>

  <!-- ===================== POP UP TAMBAH / EDIT ===================== -->
  <div id="modal" class="ov" aria-hidden="true">
    <div class="mbox" role="dialog" aria-modal="true" aria-labelledby="mTitle">
      <div class="m-head"><h3 id="mTitle">Tambah Paket Internet Baru</h3></div>
      <form id="mForm" novalidate autocomplete="off">
        <div class="m-body">
          <div class="m-grid">
            <div>
              <label for="mKat" class="m-lbl">Nama Paket</label>
              <select id="mKat" class="m-in m-sel">
                <option value="reguler">Reguler</option>
                <option value="promo">Paket Promo</option>
              </select>
              <p id="eKat" class="m-err"></p>
            </div>
            <div>
              <label for="mMbps" class="m-lbl">Kecepatan (Mbps)</label>
              <select id="mMbps" class="m-in m-sel"></select>
              <p id="eMbps" class="m-err"></p>
            </div>
            <div>
              <label for="mHarga" class="m-lbl">Harga Normal(Rp)</label>
              <input id="mHarga" type="text" inputmode="numeric" placeholder="Rp184.630" class="m-in" />
              <p id="eHarga" class="m-err"></p>
            </div>
            <div>
              <label for="mPromo" class="m-lbl">Harga Promo (Rp)</label>
              <input id="mPromo" type="text" inputmode="numeric" placeholder="Rp166.630" class="m-in" />
              <p id="ePromo" class="m-err"></p>
            </div>
            <div>
              <label for="mKap" class="m-lbl">Kapasitas</label>
              <input id="mKap" type="text" maxlength="40" placeholder="contoh: 1 - 4 Perangkat" class="m-in" />
              <p id="eKap" class="m-err"></p>
            </div>
            <div>
              <label for="mKual" class="m-lbl">Kualitas</label>
              <input id="mKual" type="text" maxlength="60" placeholder="contoh: Lancar Streaming Full HD & Gaming" class="m-in" />
              <p id="eKual" class="m-err"></p>
            </div>
          </div>
          <label class="m-chk"><input id="mTop" type="checkbox" /><span>Tandai Sebagai Paket Terlaris</span></label>
        </div>
        <div class="m-foot">
          <button id="mCancel" type="button" class="m-btn m-btn-grey">Batal</button>
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
       Data paket dari database (tabel pakets). saveData() menyimpan lewat API Laravel
       dan mengembalikan daftar paket terbaru.
       ===================================================================== */
    const PK_KEY = ICONNET.KEY_PAKET;
    const PER_PAGE = 8;
    /* Pilihan kecepatan pada form */
    const SPEED_OPTIONS = [10, 20, 30, 50, 100];
    const priceOf = p => (p.kategori === 'promo' && p.hargaPromo) ? p.hargaPromo : p.hargaNormal;
    // Data awal (isi asli paket-harga.html) & migrasi data lama ada di site-data.js,
    // sehingga admin dan halaman publik membaca data yang sama persis.
    const loadData = () => ICONNET.loadPaket();
    async function saveData(method, path, body) {
      const res = await ICONNET_API.request(method, 'api/v1/kelola/paket' + path, body);
      ICONNET_API.write(PK_KEY, res.list);
      return res.list;
    }

    let data = loadData();
    let filter = 'semua';
    let page = 1;
    let editId = null;

    const rupiah = n => 'Rp ' + Number(n).toLocaleString('id-ID');
    const ICON_EDIT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>';
    const ICON_DEL = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>';

    function filtered() { return filter === 'semua' ? data : data.filter(p => p.kategori === filter); }

    function cardHTML(p) {
      const badge = p.kategori === 'promo' ? '<span class="bdg bdg-promo">Paket Promo</span>' : '<span class="bdg bdg-reg">Reguler</span>';
      const top = p.terlaris ? '<span class="bdg bdg-top">TERLARIS</span>' : '';
      return `
      <article class="pk-card"><div class="pk-in">
        <div class="pk-badges">${badge}${top}</div>
        <div class="pk-price">${rupiah(priceOf(p))}</div>
        <div class="pk-rows">
          <div class="pk-row"><span>Mbps</span><span>:</span><span>${esc(p.mbps)} Mbps</span></div>
          <div class="pk-row"><span>Kapasitas</span><span>:</span><span>${esc(p.kapasitas)}</span></div>
          <div class="pk-row"><span>Kualitas</span><span>:</span><span>${esc(p.kualitas)}</span></div>
        </div>
        <div class="pk-act">
          <button type="button" class="ed" data-act="edit" data-id="${p.id}" aria-label="Edit paket">${ICON_EDIT}</button>
          <button type="button" class="dl" data-act="del" data-id="${p.id}" aria-label="Hapus paket">${ICON_DEL}</button>
        </div>
      </div></article>`;
    }

    function render() {
      const list = filtered();
      const pages = Math.max(1, Math.ceil(list.length / PER_PAGE));
      if (page > pages) page = pages;
      const slice = list.slice((page - 1) * PER_PAGE, page * PER_PAGE);
      $('grid').innerHTML = slice.map(cardHTML).join('');
      $('empty').classList.toggle('hidden', slice.length > 0);

      document.querySelectorAll('.f-btn').forEach(b => b.classList.toggle('active', b.dataset.f === filter));

      let nums = '';
      for (let i = 1; i <= pages; i++) nums += `<button type="button" class="pg-num${i === page ? ' active' : ''}" data-p="${i}">${i}</button>`;
      $('pgNums').innerHTML = nums;
      $('pgPrev').disabled = page <= 1;
      $('pgNext').disabled = page >= pages;
    }

    /* Filter kategori */
    $('filters').addEventListener('click', e => {
      const b = e.target.closest('.f-btn'); if (!b) return;
      filter = b.dataset.f; page = 1; render();
    });

    /* Pagination */
    $('pgNums').addEventListener('click', e => { const b = e.target.closest('[data-p]'); if (b) { page = +b.dataset.p; render(); } });
    $('pgPrev').addEventListener('click', () => { if (page > 1) { page--; render(); } });
    $('pgNext').addEventListener('click', () => { page++; render(); });

    /* ---------- Pop up (buka / tutup) ---------- */
    const modal = $('modal'), delModal = $('delModal');
    function openOv(el) { el.classList.add('open'); el.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; }
    function closeOv(el) {
      el.classList.remove('open'); el.setAttribute('aria-hidden', 'true');
      if (!document.querySelector('.ov.open')) document.body.style.overflow = '';
    }
    const closeModal = () => closeOv(modal);
    const closeDel = () => { closeOv(delModal); delId = null; };

    /* ---------- Edit / hapus dari kartu ---------- */
    let delId = null;
    $('grid').addEventListener('click', e => {
      const b = e.target.closest('[data-act]'); if (!b) return;
      const id = +b.dataset.id;
      if (b.dataset.act === 'edit') openModal(id);
      else { delId = id; openOv(delModal); $('dCancel').focus(); }
    });
    $('dCancel').addEventListener('click', closeDel);
    delModal.addEventListener('click', e => { if (e.target === delModal) closeDel(); });
    $('dOk').addEventListener('click', async () => {
      if (delId === null) return;
      try { data = await saveData('DELETE', '/' + delId); } catch (err) { closeDel(); return showToast(err.message || 'Gagal menghapus data. Coba lagi.'); }
      closeDel(); render(); showToast('Paket berhasil dihapus');
    });

    /* ---------- Pop up tambah / edit ---------- */
    const MF = [['mKat', 'eKat'], ['mMbps', 'eMbps'], ['mHarga', 'eHarga'], ['mPromo', 'ePromo'], ['mKap', 'eKap'], ['mKual', 'eKual']];
    const digits = v => String(v).replace(/\D/g, '').slice(0, 9);
    const fmtIn = n => n ? 'Rp' + Number(n).toLocaleString('id-ID') : '';
    ['mHarga', 'mPromo'].forEach(id => $(id).addEventListener('input', e => { e.target.value = fmtIn(digits(e.target.value)); }));

    function fillSpeeds(extra) {
      const keys = SPEED_OPTIONS.slice();
      if (extra && !keys.includes(+extra)) keys.push(+extra);
      keys.sort((a, b) => a - b);
      $('mMbps').innerHTML = keys.map(k => `<option value="${k}">${k} Mbps</option>`).join('');
    }
    function clearErr() { MF.forEach(([i, e]) => { $(i).classList.remove('err'); $(e).textContent = ''; }); }
    function setErr(i, e, msg) { $(i).classList.add('err'); $(e).textContent = msg; }

    function openModal(id) {
      editId = id || null; clearErr();
      const p = id ? data.find(x => x.id === id) : null;
      fillSpeeds(p && p.mbps);
      $('mTitle').textContent = p ? 'Edit Paket Internet' : 'Tambah Paket Internet Baru';
      $('mKat').value = p ? p.kategori : 'reguler';
      $('mMbps').value = p ? p.mbps : 20;
      $('mHarga').value = p ? fmtIn(p.hargaNormal) : '';
      $('mPromo').value = p && p.hargaPromo ? fmtIn(p.hargaPromo) : '';
      $('mKap').value = p ? p.kapasitas : '';
      $('mKual').value = p ? p.kualitas : '';
      $('mTop').checked = p ? !!p.terlaris : false;
      openOv(modal);
      $('mKat').focus();
    }
    $('btnAdd').addEventListener('click', () => openModal(null));
    $('mCancel').addEventListener('click', closeModal);
    modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', e => {
      if (e.key !== 'Escape') return;
      if (delModal.classList.contains('open')) closeDel();
      else if (modal.classList.contains('open')) closeModal();
    });

    $('mForm').addEventListener('submit', async e => {
      e.preventDefault(); clearErr();
      const kat = $('mKat').value;
      const mbps = +$('mMbps').value;
      const normal = +digits($('mHarga').value);
      const promo = +digits($('mPromo').value);
      const kap = $('mKap').value.trim();
      const kual = $('mKual').value.trim();
      let ok = true;
      if (!mbps) { setErr('mMbps', 'eMbps', 'Pilih kecepatan paket.'); ok = false; }
      if (!normal || normal < 1000) { setErr('mHarga', 'eHarga', 'Harga normal wajib diisi, contoh: Rp184.630.'); ok = false; }
      if (kat === 'promo' && !promo) { setErr('mPromo', 'ePromo', 'Harga promo wajib diisi untuk Paket Promo.'); ok = false; }
      else if (promo && normal && promo >= normal) { setErr('mPromo', 'ePromo', 'Harga promo harus lebih kecil dari harga normal.'); ok = false; }
      if (!kap) { setErr('mKap', 'eKap', 'Kapasitas wajib diisi, contoh: 1 - 4 Perangkat.'); ok = false; }
      if (!kual) { setErr('mKual', 'eKual', 'Kualitas wajib diisi, contoh: Lancar Streaming Full HD & Gaming.'); ok = false; }
      if (!ok) return;

      const item = { kategori: kat, mbps, hargaNormal: normal, hargaPromo: promo || 0, kapasitas: kap, kualitas: kual, terlaris: $('mTop').checked };
      const wasEdit = !!editId;
      try { data = await saveData(wasEdit ? 'PUT' : 'POST', wasEdit ? '/' + editId : '', item); }
      catch (err) { return showToast(err.message || 'Gagal menyimpan data. Coba lagi.'); }
      closeModal(); render();
      showToast(wasEdit ? 'Paket berhasil diperbarui' : 'Paket berhasil ditambahkan');
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
