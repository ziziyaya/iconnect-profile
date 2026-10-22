<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Beranda - ICONNET</title>

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
       Skala: semua ukuran konten memakai satuan --u (1u = 1px pada frame 1080 x 745)
       Mobile/tablet: 1u = 1.05px, halaman boleh scroll.
       ===================================================================== */
    :root { --u: 1.05px; }

    /* ---------- Tab ---------- */
    .tabs-card { background: #fff; border-radius: calc(var(--u) * 14); box-shadow: 0 2px 6px rgba(0,0,0,.18); padding: calc(var(--u) * 6.8) calc(var(--u) * 6.5); flex: none; }
    .tabs-in { display: grid; grid-template-columns: 1fr 1fr; background: #F7F7FC; border-radius: calc(var(--u) * 10); padding: calc(var(--u) * 7); }
    .tab { height: calc(var(--u) * 27); border-radius: calc(var(--u) * 8); font-size: calc(var(--u) * 12.5); font-weight: 500; color: #111; background: transparent; transition: background .15s, color .15s; }
    .tab.active { background: #03045E; color: #fff; }
    .tab:not(.active):hover { background: #ECECF6; }

    /* ---------- Kartu utama ---------- */
    .bn-card { display: flex; flex-direction: column; min-height: 0; margin-top: calc(var(--u) * 20); background: #fff; border: 1px solid #DADCE3; border-radius: calc(var(--u) * 14); box-shadow: 0 2px 6px rgba(0,0,0,.12); overflow: hidden; }
    .bn-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; flex: none; padding: calc(var(--u) * 7.6) calc(var(--u) * 20) calc(var(--u) * 13.4) calc(var(--u) * 26); border-bottom: 1px solid #E6E8EE; }
    .bn-title { font-size: calc(var(--u) * 16); line-height: 1.3; font-weight: 500; color: #000; }
    .bn-sub { margin-top: calc(var(--u) * 1); font-size: calc(var(--u) * 13); line-height: 1.4; color: #000; }
    .btn-add { display: inline-flex; align-items: center; justify-content: center; flex: none; gap: calc(var(--u) * 6); width: calc(var(--u) * 119); height: calc(var(--u) * 29); margin-top: calc(var(--u) * 8); border-radius: calc(var(--u) * 9); background: linear-gradient(to bottom, #1E9BE0, #0B7FCB); color: #fff; font-size: calc(var(--u) * 12); font-weight: 500; box-shadow: 0 3px 6px rgba(0,0,0,.2); transition: filter .15s, transform .1s; }
    .btn-add:hover { filter: brightness(1.08); }
    .btn-add:active { transform: scale(.98); }
    .btn-add svg { width: calc(var(--u) * 12); height: calc(var(--u) * 12); }

    .bn-scroll { flex: 1; min-height: 0; overflow-y: auto; scrollbar-width: none; padding: calc(var(--u) * 20) calc(var(--u) * 20) calc(var(--u) * 21) calc(var(--u) * 26); }
    .bn-scroll::-webkit-scrollbar { display: none; }
    .bn-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); column-gap: calc(var(--u) * 36); row-gap: calc(var(--u) * 26); }
    #empty { padding: calc(var(--u) * 40) 0; text-align: center; font-size: calc(var(--u) * 13); color: #64748B; }

    /* ---------- Kartu banner ---------- */
    .bn-item { display: flex; flex-direction: column; min-width: 0; padding: calc(var(--u) * 8); background: #fff; border: 1px solid #D3D6DE; border-radius: calc(var(--u) * 16); box-shadow: 0 1px 4px rgba(0,0,0,.12); }
    .bn-img { position: relative; width: 100%; height: calc(var(--u) * 156); border-radius: calc(var(--u) * 9); overflow: hidden; background: #0A6F80; flex: none; }
    .bn-img img { display: block; width: 100%; height: 100%; object-fit: cover; }
    .bn-ph { display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background: linear-gradient(135deg, #0B8FA6 0%, #064E63 55%, #052F4A 100%); color: rgba(255,255,255,.9); font-size: calc(var(--u) * 20); font-weight: 700; letter-spacing: .08em; }
    .bn-rows { margin-top: calc(var(--u) * 5.4); display: flex; flex-direction: column; gap: calc(var(--u) * 3); font-size: calc(var(--u) * 9); line-height: calc(var(--u) * 14.3); color: #111; }
    .bn-row { display: grid; grid-template-columns: calc(var(--u) * 63) calc(var(--u) * 10) minmax(0, 1fr); }
    .bn-row .v { white-space: pre-wrap; word-break: break-word; }
    .bn-row.tb { margin-top: calc(var(--u) * 1); }
    .bn-act { display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: calc(var(--u) * 11); }
    .bn-act .ic { display: flex; margin-right: calc(var(--u) * -3.5); }
    .ibtn { display: flex; align-items: center; justify-content: center; width: calc(var(--u) * 22.6); height: calc(var(--u) * 22.6); border-radius: calc(var(--u) * 6); transition: background .15s; }
    .ibtn svg { width: calc(var(--u) * 15); height: calc(var(--u) * 15); }
    .ibtn.ed { color: #0891B2; } .ibtn.ed:hover { background: #E0F4F8; }
    .ibtn.dl { color: #E03B3B; } .ibtn.dl:hover { background: #FDECEC; }
    .tgl { position: relative; flex: none; width: calc(var(--u) * 34); height: calc(var(--u) * 18); border-radius: 999px; background: #C5C8D0; transition: background .2s; }
    .tgl::after { content: ''; position: absolute; top: calc(var(--u) * 2.25); left: calc(var(--u) * 2.25); width: calc(var(--u) * 13.5); height: calc(var(--u) * 13.5); border-radius: 50%; background: #fff; transition: transform .2s; }
    .tgl.on { background: #1B7F45; }
    .tgl.on::after { transform: translateX(calc(var(--u) * 16)); }
    .tgl-sp { width: calc(var(--u) * 34); height: calc(var(--u) * 18); }

    /* ---------- Pagination ---------- */
    .bn-foot { display: flex; align-items: center; justify-content: flex-end; flex: none; gap: calc(var(--u) * 11); padding: calc(var(--u) * 7.5) calc(var(--u) * 20); border-top: 1px solid #D5D8DF; }
    .pg-btn { display: inline-flex; align-items: center; justify-content: center; gap: calc(var(--u) * 7); min-width: calc(var(--u) * 106); height: calc(var(--u) * 22); border-radius: 999px; border: 1px solid #E2E4EA; background: #fff; font-size: calc(var(--u) * 9.5); font-weight: 500; color: #111; transition: background .15s; }
    .pg-btn:hover:not(:disabled) { background: #F4F5F9; }
    .pg-btn:disabled { color: #7C818C; font-weight: 400; border-color: #E8EAEF; cursor: default; }
    .pg-btn svg { width: calc(var(--u) * 6.5); height: calc(var(--u) * 6.5); }
    .pg-nums { display: flex; align-items: center; gap: calc(var(--u) * 9); }
    .pg-num { display: inline-flex; align-items: center; justify-content: center; min-width: calc(var(--u) * 24); height: calc(var(--u) * 20); padding: 0 calc(var(--u) * 4); border-radius: calc(var(--u) * 6.5); background: #fff; font-size: calc(var(--u) * 9.5); color: #111; }
    .pg-num.active { background: #4FC7DB; color: #fff; }

    /* ---------- Form tambah / edit (di dalam kartu) ---------- */
    [hidden] { display: none !important; }
    .fm-head { flex: none; padding: calc(var(--u) * 9) calc(var(--u) * 26) calc(var(--u) * 7); border-bottom: 1px solid #E6E8EE; }
    .fm-form { display: flex; flex-direction: column; flex: 1 1 auto; min-height: 0; }
    .fm-body { display: flex; flex-direction: column; flex: 1 1 auto; min-height: 0; gap: calc(var(--u) * 10); overflow-y: auto; scrollbar-width: none; padding: calc(var(--u) * 10) calc(var(--u) * 26) calc(var(--u) * 8); }
    .fm-body::-webkit-scrollbar { display: none; }
    .fm-lbl { display: block; font-size: calc(var(--u) * 13); line-height: 1.35; font-weight: 500; color: #000; }
    .fm-lbl .rq { margin-left: 2px; color: #D93A3F; }
    .fm-lbl .op { margin-left: 5px; font-size: calc(var(--u) * 9.5); font-weight: 400; color: #8A8FA0; }
    .fm-in { display: block; width: 100%; height: calc(var(--u) * 32); margin-top: calc(var(--u) * 4); padding: 0 calc(var(--u) * 11); border-radius: calc(var(--u) * 9); border: 1px solid #D9DCE3; background: #fff; font-family: inherit; font-size: calc(var(--u) * 11); color: #111; outline: none; transition: border-color .15s, box-shadow .15s; }
    .fm-in::placeholder { color: #9AA0AE; }
    .fm-in:focus { border-color: #4A9FF5; box-shadow: 0 0 0 3px rgba(74,159,245,.2); }
    .fm-in.err { border-color: #D93A3F; }
    textarea.fm-in { height: calc(var(--u) * 58); padding: calc(var(--u) * 7) calc(var(--u) * 11); resize: none; line-height: calc(var(--u) * 15); }
    .fm-err { margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 9.5); font-weight: 500; line-height: 1.3; color: #D93A3F; }
    .fm-err:empty { display: none; }
    .fm-row2 { display: flex; gap: calc(var(--u) * 16); }
    .fm-row2 > .fm-f { flex: 1 1 0; min-width: 0; }
    .st-box { display: flex; align-items: center; justify-content: space-between; height: calc(var(--u) * 32); margin-top: calc(var(--u) * 4); padding: 0 calc(var(--u) * 11); border: 1px solid #D9DCE3; border-radius: calc(var(--u) * 9); font-size: calc(var(--u) * 11); color: #111; }

    .jn-grid { display: grid; grid-template-columns: 1fr 1fr; gap: calc(var(--u) * 14); margin-top: calc(var(--u) * 4); }
    .jn { display: block; width: 100%; text-align: left; padding: calc(var(--u) * 5) calc(var(--u) * 5) calc(var(--u) * 6); border-radius: calc(var(--u) * 7); border: 1px solid #D9DCE3; background: #fff; transition: background .15s, border-color .15s; }
    .jn:hover { border-color: #9CC4F0; }
    .jn.on { background: #EEF3FE; border-color: #4A9FF5; }
    .jn-prev { display: flex; align-items: center; justify-content: center; height: calc(var(--u) * 43); border-radius: calc(var(--u) * 6); background: #CDDCF8; }
    .jn-prev svg { width: calc(var(--u) * 22); height: calc(var(--u) * 22); }
    .jn-prev.t { flex-direction: column; align-items: flex-start; justify-content: center; gap: calc(var(--u) * 3); padding-left: calc(var(--u) * 10); }
    .jn-prev.t i { display: block; height: calc(var(--u) * 2.6); border-radius: 99px; background: #4B5F8E; }
    .jn-prev.t i.a { width: 34%; height: calc(var(--u) * 3.4); background: #0B0B3B; }
    .jn-prev.t i.b { width: 58%; }
    .jn-prev.t i.c { width: 30%; height: calc(var(--u) * 5); border-radius: calc(var(--u) * 2); background: #2F6FE4; }
    .jn-t { display: flex; align-items: center; gap: calc(var(--u) * 5); margin-top: calc(var(--u) * 4); font-size: calc(var(--u) * 10.5); font-weight: 500; color: #0B0B3B; }
    .jn-dot { display: flex; flex: none; align-items: center; justify-content: center; width: calc(var(--u) * 10); height: calc(var(--u) * 10); border-radius: 50%; border: 1px solid #9AA0AE; background: #fff; }
    .jn-dot svg { display: none; width: 70%; height: 70%; }
    .jn.on .jn-dot { background: #2F6FE4; border-color: #2F6FE4; }
    .jn.on .jn-dot svg { display: block; }
    .jn p { margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 8); line-height: 1.4; color: #475569; }

    .drop { display: flex; align-items: center; justify-content: center; height: calc(var(--u) * 124); margin-top: calc(var(--u) * 4); border: 1.5px dashed #6B7280; border-radius: calc(var(--u) * 10); background: #fff; cursor: pointer; outline: none; transition: background .15s, border-color .15s; }
    .drop.compact { height: calc(var(--u) * 84); }
    .drop:hover, .drop:focus-visible, .drop.drag { background: #F4FAFE; border-color: #1E9BE0; }
    .drop.err { border-color: #D93A3F; }
    .drop-in { display: flex; flex-direction: column; align-items: center; max-width: 90%; text-align: center; }
    .drop-ic { display: flex; align-items: center; justify-content: center; width: calc(var(--u) * 26); height: calc(var(--u) * 26); margin-bottom: calc(var(--u) * 5); border-radius: 50%; background: #EEF2F7; color: #1E88C8; }
    .drop-ic svg { width: 55%; height: 55%; }
    .drop.compact .drop-ic { width: calc(var(--u) * 15); height: calc(var(--u) * 15); margin-bottom: calc(var(--u) * 2); }
    .drop-t { font-size: calc(var(--u) * 10.5); line-height: 1.4; font-weight: 500; color: #000; overflow-wrap: anywhere; }
    .drop-h { margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 8.5); line-height: 1.3; color: #8A8FA0; }
    .drop-btn { display: inline-flex; align-items: center; justify-content: center; height: calc(var(--u) * 20); margin-top: calc(var(--u) * 6); padding: 0 calc(var(--u) * 18); border: 1px solid #D9DCE3; border-radius: calc(var(--u) * 6); background: #fff; font-size: calc(var(--u) * 9.5); font-weight: 500; color: #111; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
    .drop.compact .drop-btn { height: calc(var(--u) * 18); margin-top: calc(var(--u) * 4); }
    .fm-form .m-foot { flex: none; padding-top: calc(var(--u) * 10); padding-bottom: calc(var(--u) * 10); }
    .sr-only { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); white-space: nowrap; }
    @media (max-width: 639px) {
      .fm-row2 { flex-direction: column; gap: calc(var(--u) * 10); }
      .fm-body { padding-left: 16px; padding-right: 16px; }
      .fm-head { padding-left: 16px; }
    }

    /* ---------- Penyesuaian ukuran form Tambah / Edit agar sama dengan desain ---------- */
    .fm-head { padding-top: calc(var(--u) * 11); padding-bottom: calc(var(--u) * 10); }
    .fm-body { gap: calc(var(--u) * 12); padding-top: calc(var(--u) * 13); padding-bottom: calc(var(--u) * 14); }
    .fm-in { height: calc(var(--u) * 37); }
    textarea.fm-in { height: calc(var(--u) * 69); }
    .st-box { height: calc(var(--u) * 37); }
    .jn { padding: calc(var(--u) * 6) calc(var(--u) * 6) calc(var(--u) * 7); }
    .jn-prev { height: calc(var(--u) * 50); }
    .jn-t { margin-top: calc(var(--u) * 6); }
    .jn p { margin-top: calc(var(--u) * 4); }
    .drop { height: calc(var(--u) * 153); }
    .drop.compact { height: calc(var(--u) * 95); }
    .drop.compact .drop-ic { width: calc(var(--u) * 20); height: calc(var(--u) * 20); margin-bottom: calc(var(--u) * 3); }
    .drop-ic { width: calc(var(--u) * 34); height: calc(var(--u) * 34); margin-bottom: calc(var(--u) * 9); }
    .drop-h { margin-top: calc(var(--u) * 3); }
    .drop-btn { height: calc(var(--u) * 26); margin-top: calc(var(--u) * 14); padding: 0 calc(var(--u) * 30); }
    .drop.compact .drop-btn { height: calc(var(--u) * 15); margin-top: calc(var(--u) * 4); padding: 0 calc(var(--u) * 28); font-size: calc(var(--u) * 8.5); }
    .fm-form .m-foot { padding-top: calc(var(--u) * 9); padding-bottom: calc(var(--u) * 9); }

    /* Mobile / tablet: ukuran tetap nyaman disentuh & dibaca */
    @media (max-width: 899px) {
      .fm-head { padding-top: 14px; padding-bottom: 12px; }
      .fm-head .bn-title { font-size: 16px; }
      .fm-body { gap: 16px; padding-top: 16px; padding-bottom: 16px; }
      .fm-lbl { font-size: 14px; }
      .fm-lbl .op { font-size: 11px; }
      .fm-in { height: 42px; font-size: 14px; margin-top: 6px; }
      textarea.fm-in { height: 92px; }
      .fm-err { font-size: 11px; }
      .st-box { height: 42px; font-size: 13px; margin-top: 6px; }
      .jn-grid { gap: 10px; margin-top: 6px; }
      .jn { padding: 6px 6px 8px; border-radius: 9px; }
      .jn-prev { height: 56px; }
      .jn-prev svg { width: 26px; height: 26px; }
      .jn-t { font-size: 12px; gap: 6px; margin-top: 7px; }
      .jn-dot { width: 12px; height: 12px; }
      .jn p { font-size: 10px; margin-top: 3px; }
      .drop { height: 160px; margin-top: 6px; }
      .drop.compact { height: 130px; }
      .drop-ic { width: 38px; height: 38px; }
      .drop.compact .drop-ic { width: 30px; height: 30px; margin-bottom: 4px; }
      .drop-t { font-size: 13px; }
      .drop-h { font-size: 11px; }
      .drop-btn { height: 30px; font-size: 12px; margin-top: 10px; padding: 0 24px; }
      .drop.compact .drop-btn { height: 28px; margin-top: 6px; padding: 0 24px; font-size: 12px; }
      .fm-form .m-foot { padding: 12px 16px; }
      .fm-form .m-btn { height: 38px; width: 110px; font-size: 14px; border-radius: 11px; }
    }
    @media (max-width: 380px) {
      .jn p { font-size: 9px; }
      .jn-t { font-size: 11px; }
    }

    /* ---------- Pilihan jenis banner: thumbnail tetap + teks di samping (tidak melar di layar lebar) ---------- */
    .jn-grid { gap: calc(var(--u) * 14); }
    .jn { display: flex; align-items: center; gap: calc(var(--u) * 14); padding: calc(var(--u) * 8); border: 1.5px solid #E1E4EC; border-radius: calc(var(--u) * 12); background: #fff; text-align: left; cursor: pointer; transition: background .15s, border-color .15s, box-shadow .15s; }
    .jn:hover { border-color: #9CC4F0; background: #FAFCFF; }
    .jn:focus-visible { outline: none; box-shadow: 0 0 0 3px rgba(74,159,245,.3); }
    .jn.on { border-color: #2F6FE4; background: #F2F6FF; box-shadow: 0 0 0 3px rgba(47,111,228,.12); }
    .jn-prev { flex: none; width: calc(var(--u) * 112); height: calc(var(--u) * 66); border-radius: calc(var(--u) * 8); background: linear-gradient(135deg, #D9E5FB, #BDD1F6); overflow: hidden; }
    .jn-prev svg { width: calc(var(--u) * 26); height: calc(var(--u) * 26); }
    .jn-prev.t { display: flex; flex-direction: column; align-items: flex-start; justify-content: center; gap: calc(var(--u) * 5); padding: 0 calc(var(--u) * 14); }
    .jn-prev.t i { display: block; height: calc(var(--u) * 3.5); border-radius: 99px; background: #4B5F8E; opacity: .85; }
    .jn-prev.t i.a { width: 52%; height: calc(var(--u) * 5); background: #0B0B3B; opacity: 1; }
    .jn-prev.t i.b { width: 82%; }
    .jn-prev.t i.c { width: 36%; height: calc(var(--u) * 9); margin-top: calc(var(--u) * 2); border-radius: calc(var(--u) * 3); background: #2F6FE4; opacity: 1; }
    .jn-info { flex: 1 1 auto; min-width: 0; }
    .jn-t { display: flex; align-items: center; gap: calc(var(--u) * 7); margin: 0; font-size: calc(var(--u) * 12.5); line-height: 1.3; font-weight: 600; color: #0B0B3B; }
    .jn-dot { width: calc(var(--u) * 14); height: calc(var(--u) * 14); border: 1.5px solid #B3B8C6; }
    .jn p { margin-top: calc(var(--u) * 4); font-size: calc(var(--u) * 10.5); line-height: 1.45; color: #5B6478; }
    @media (max-width: 899px) {
      .jn { gap: 12px; padding: 8px; border-radius: 12px; }
      .jn-prev { width: 112px; height: 66px; }
      .jn-prev svg { width: 28px; height: 28px; }
      .jn-t { font-size: 13px; gap: 8px; margin: 0; }
      .jn-dot { width: 15px; height: 15px; }
      .jn p { font-size: 11px; margin-top: 3px; }
    }
    @media (max-width: 639px) {
      .jn-grid { grid-template-columns: 1fr; gap: 10px; }
    }
    @media (max-width: 380px) {
      .jn-prev { width: 92px; height: 60px; }
      .jn-t { font-size: 12.5px; }
      .jn p { font-size: 10.5px; }
    }

    /* ---------- Mode Edit: area foto lebih tinggi (sesuai desain), tanpa pilihan jenis & status ---------- */
    .drop-btn { min-width: calc(var(--u) * 118); }
    .drop.compact .drop-btn { min-width: calc(var(--u) * 120); }
    #dfName { font-size: calc(var(--u) * 11.5); font-weight: 500; line-height: 1.4; }
    #dfSize { font-size: calc(var(--u) * 9); }
    #formCard.is-edit .drop { height: calc(var(--u) * 216); }
    #formCard.is-edit .drop.compact { height: calc(var(--u) * 143); }
    #formCard.is-edit .fm-body { padding-top: calc(var(--u) * 14); }
    @media (max-width: 899px) {
      .drop-btn, .drop.compact .drop-btn { min-width: 120px; }
      #dfName { font-size: 13px; }
      #dfSize { font-size: 11px; }
      #formCard.is-edit .drop { height: 210px; }
      #formCard.is-edit .drop.compact { height: 160px; }
      #formCard.is-edit .fm-body { padding-top: 16px; }
    }

    /* ---------- Kartu data banner: rapi, konsisten, dan membedakan "foto saja" vs "foto + teks" ---------- */
    .bn-item { border-color: #E1E4EC; box-shadow: 0 1px 3px rgba(15,23,42,.08); transition: box-shadow .2s, border-color .2s; }
    .bn-item:hover { border-color: #C9D6EA; box-shadow: 0 6px 16px rgba(15,23,42,.1); }
    .bn-img { border-radius: calc(var(--u) * 10); }
    .bn-chip { position: absolute; top: calc(var(--u) * 8); left: calc(var(--u) * 8); padding: calc(var(--u) * 2.5) calc(var(--u) * 8); border-radius: 999px; background: rgba(255,255,255,.92); color: #03045E; font-size: calc(var(--u) * 8.5); font-weight: 600; line-height: 1.4; box-shadow: 0 1px 3px rgba(0,0,0,.15); backdrop-filter: blur(2px); }
    .bn-row { grid-template-columns: calc(var(--u) * 68) calc(var(--u) * 10) minmax(0, 1fr); }
    .bn-row .v.clamp { display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; line-clamp: 2; overflow: hidden; }
    .bn-row > span:first-child { color: #5B6478; }
    .tgl-wrap { display: flex; align-items: center; gap: calc(var(--u) * 8); min-width: 0; }
    .tgl-lb { font-size: calc(var(--u) * 9.5); font-weight: 500; color: #7C818C; white-space: nowrap; }
    .tgl-lb.on { color: #1B7F45; }
    .ibtn { width: calc(var(--u) * 26); height: calc(var(--u) * 26); border-radius: calc(var(--u) * 7); }
    .ibtn svg { width: calc(var(--u) * 14); height: calc(var(--u) * 14); }
    .bn-act .ic { gap: calc(var(--u) * 4); margin-right: 0; }
    body .bn-act { border-top: 1px solid #EEF0F4; padding-top: calc(var(--u) * 7); margin-top: auto; }
    body .bn-item.only .bn-img { max-height: none; }
    body .bn-item.only .bn-act { margin-top: calc(var(--u) * 8); }
    @media (max-width: 899px) {
      .bn-chip { font-size: 10px; padding: 3px 9px; top: 9px; left: 9px; }
      .tgl-lb { font-size: 11px; }
      .ibtn { width: 32px; height: 32px; }
      .ibtn svg { width: 17px; height: 17px; }
      .bn-act { padding-top: 10px; }
    }

    /* ---------- Tab Foto Kegiatan: daftar satu kolom ---------- */
    .bn-grid.kg { grid-template-columns: minmax(0, 1fr); row-gap: calc(var(--u) * 14); align-content: start; }
    .kg-item { display: flex; align-items: center; gap: calc(var(--u) * 8); min-width: 0; padding: calc(var(--u) * 7) calc(var(--u) * 10) calc(var(--u) * 7) calc(var(--u) * 7); background: #fff; border: 1px solid #D3D6DE; border-radius: calc(var(--u) * 16); box-shadow: 0 1px 4px rgba(0,0,0,.1); transition: box-shadow .2s, border-color .2s; }
    .kg-item:hover { border-color: #C9D6EA; box-shadow: 0 6px 16px rgba(15,23,42,.1); }
    .kg-img { flex: none; width: calc(var(--u) * 74); height: calc(var(--u) * 63); border-radius: calc(var(--u) * 7); overflow: hidden; background: #0A6F80; }
    .kg-img img { display: block; width: 100%; height: 100%; object-fit: cover; }
    .kg-img .bn-ph { font-size: calc(var(--u) * 8.5); }
    .kg-body { flex: 1 1 0; min-width: 0; align-self: flex-start; padding: calc(var(--u) * 4) calc(var(--u) * 6) 0 0; }
    .kg-t { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: calc(var(--u) * 11.5); line-height: 1.4; font-weight: 500; color: #000; }
    .kg-d { margin-top: calc(var(--u) * 2); font-size: calc(var(--u) * 10.3); line-height: calc(var(--u) * 15.5); color: #111; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; line-clamp: 2; overflow: hidden; }
    .kg-act { display: flex; flex: none; align-self: flex-end; gap: calc(var(--u) * 4); }
    @media (min-width: 900px) {
      /* 5 baris data mengisi tinggi kartu; foto mengikuti tinggi baris */
      body .bn-grid.kg { flex: 1 1 auto; align-content: stretch; grid-template-rows: repeat(5, minmax(calc(var(--u) * 66), 1fr)); grid-auto-rows: minmax(calc(var(--u) * 66), 1fr); row-gap: calc(var(--u) * 12); }
      body .kg-item { align-items: stretch; height: auto; }
      body .kg-img { height: auto; align-self: stretch; }
      body .kg-body { padding-top: calc(var(--u) * 3); }
      body .kg-act { padding-bottom: calc(var(--u) * 1); }
    }
    @media (max-width: 899px) {
      .kg-item { padding: 10px; gap: 12px; border-radius: 14px; }
      .kg-img { width: 92px; height: 76px; border-radius: 9px; }
      .kg-img .bn-ph { font-size: 10px; }
      .kg-body { padding-top: 2px; }
      .kg-t { font-size: 14px; }
      .kg-d { font-size: 12px; line-height: 1.5; -webkit-line-clamp: 3; line-clamp: 3; }
    }
    @media (max-width: 639px) {
      .kg-item { flex-wrap: wrap; }
      .kg-body { flex: 1 1 0; }
      .kg-act { width: 100%; justify-content: flex-end; padding-top: 6px; border-top: 1px solid #EEF0F4; }
    }

    /* ---------- Form Tambah / Edit Kegiatan: Foto, Judul, Deskripsi tersusun ke bawah ---------- */
    #formCard.is-kg .fm-head { padding-top: calc(var(--u) * 13); padding-bottom: calc(var(--u) * 12); }
    #formCard.is-kg .fm-body { gap: calc(var(--u) * 20); padding-top: calc(var(--u) * 16); padding-bottom: calc(var(--u) * 24); }
    #formCard.is-kg #fText { flex-direction: column; gap: calc(var(--u) * 20); }
    #formCard.is-kg #fText > .fm-f { flex: none; width: 100%; }
    #formCard.is-kg .drop { height: calc(var(--u) * 124); }
    #formCard.is-kg.is-edit .drop { height: calc(var(--u) * 130); }
    #formCard.is-kg .fm-lbl .op { display: none; }
    #formCard.is-kg .m-foot { padding-top: calc(var(--u) * 12); padding-bottom: calc(var(--u) * 12); }
    @media (max-width: 899px) {
      #formCard.is-kg .fm-head { padding-top: 14px; padding-bottom: 12px; }
      #formCard.is-kg .fm-body { gap: 18px; padding-top: 16px; padding-bottom: 18px; }
      #formCard.is-kg #fText { gap: 18px; }
      #formCard.is-kg .drop { height: 160px; }
      #formCard.is-kg.is-edit .drop { height: 170px; }
      #formCard.is-kg .m-foot { padding: 12px 16px; }
    }

    /* Desktop: kartu form setinggi isinya (tidak melar sampai bawah), seperti desain */
    @media (min-width: 900px) {
      body #formCard { flex: 0 1 auto; }
    }

    /* ---------- Pop up ---------- */
    .ov { position: fixed; inset: 0; z-index: 80; display: none; align-items: center; justify-content: center; padding: 16px; background: rgba(0,0,0,.12); }
    .ov.open { display: flex; animation: ovIn .15s ease; }
    .ov.open > div { animation: boxIn .18s ease; }
    @keyframes ovIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes boxIn { from { opacity: 0; transform: translateY(8px) scale(.97); } to { opacity: 1; transform: none; } }

    .mbox { width: min(calc(var(--u) * 470), calc(100vw - 32px)); background: #fff; border-radius: calc(var(--u) * 24); box-shadow: 0 6px 22px rgba(0,0,0,.2); }
    @media (max-width: 899px) { .mbox { max-height: 94vh; overflow-y: auto; } }
    .m-head { display: flex; align-items: center; height: calc(var(--u) * 50); padding: 0 calc(var(--u) * 19); background: #02B6D1; border-radius: calc(var(--u) * 24) calc(var(--u) * 24) 0 0; }
    .m-head h3 { color: #fff; font-size: calc(var(--u) * 18); font-weight: 600; }
    .m-body { padding: calc(var(--u) * 12.5) calc(var(--u) * 18) calc(var(--u) * 12) calc(var(--u) * 17); }
    .m-f { position: relative; margin-bottom: calc(var(--u) * 14); }
    .m-lbl { display: block; font-size: calc(var(--u) * 14); line-height: 1.4; font-weight: 500; color: #000; }
    .m-in { display: block; width: 100%; height: calc(var(--u) * 35); margin-top: calc(var(--u) * 5); padding: 0 calc(var(--u) * 11); border-radius: calc(var(--u) * 11); border: 1px solid #D9DCE3; background: #fff; font-size: calc(var(--u) * 12); font-family: inherit; color: #111; outline: none; transition: border-color .15s, box-shadow .15s; }
    .m-in:focus { border-color: #4A9FF5; box-shadow: 0 0 0 3px rgba(74,159,245,.2); }
    .m-in.err { border-color: #D93A3F; }
    textarea.m-in { height: calc(var(--u) * 84); padding: calc(var(--u) * 8) calc(var(--u) * 11); resize: none; line-height: calc(var(--u) * 19); }
    .m-file { padding: 0; display: flex; align-items: center; }
    .m-file input { width: 100%; padding: 0 calc(var(--u) * 8); font-size: calc(var(--u) * 11); font-family: inherit; color: #333; }
    .m-prev { display: none; margin-top: calc(var(--u) * 8); height: calc(var(--u) * 96); border-radius: calc(var(--u) * 10); overflow: hidden; border: 1px solid #E3E5EB; }
    .m-prev.show { display: block; }
    .m-prev img { display: block; width: 100%; height: 100%; object-fit: cover; }
    .m-err { position: absolute; left: 2px; top: 100%; margin-top: 1px; font-size: calc(var(--u) * 9.5); font-weight: 500; line-height: 1.3; color: #D93A3F; white-space: nowrap; }
    .m-foot { display: flex; justify-content: center; gap: calc(var(--u) * 12); padding: calc(var(--u) * 13) calc(var(--u) * 20) calc(var(--u) * 10); border-top: 1px solid #E5E7EB; }
    .m-btn { height: calc(var(--u) * 30); width: calc(var(--u) * 98); border-radius: calc(var(--u) * 11); font-size: calc(var(--u) * 15); font-weight: 500; box-shadow: 0 3px 5px rgba(0,0,0,.2); transition: background .15s, filter .15s, transform .1s; }
    .m-btn:active { transform: scale(.98); }
    .m-btn-grey { background: #E8E8E8; color: #000; } .m-btn-grey:hover { background: #DEDEDE; }
    .m-btn-blue { background: #4A9FF5; color: #fff; } .m-btn-blue:hover { filter: brightness(1.05); }
    .m-btn-red { background: #D93A3F; color: #fff; } .m-btn-red:hover { filter: brightness(1.08); }

    .dbox { width: min(calc(var(--u) * 341), calc(100vw - 32px)); padding: calc(var(--u) * 17) calc(var(--u) * 20) calc(var(--u) * 24); background: #fff; border-radius: calc(var(--u) * 30); text-align: center; box-shadow: 0 6px 22px rgba(0,0,0,.2); }
    .d-ico { width: calc(var(--u) * 49); height: calc(var(--u) * 49); margin: 0 auto; }
    .d-ico svg { display: block; width: 100%; height: 100%; }
    .dbox h3 { margin-top: calc(var(--u) * 19); font-size: calc(var(--u) * 18); line-height: 1.3; font-weight: 500; color: #000; }
    .dbox p { margin-top: calc(var(--u) * 3); font-size: calc(var(--u) * 14); line-height: 1.4; color: #333; }
    .d-btns { display: flex; justify-content: center; gap: calc(var(--u) * 44); margin-top: calc(var(--u) * 36); }
    .d-btns .m-btn { width: calc(var(--u) * 95); height: calc(var(--u) * 33); }

    /* ---------- Mobile / tablet (<900px) ---------- */
    @media (max-width: 899px) {
      .main-c { padding: 16px 16px 32px; }
      .bn-scroll { padding: 18px 16px; }
      .bn-head { padding-left: 16px; padding-right: 16px; }
    }
    @media (max-width: 639px) {
      .bn-grid { grid-template-columns: 1fr; }
      .bn-foot { flex-wrap: wrap; justify-content: center; }
    }

    /* ===== DESKTOP / LAPTOP (>=900px) - sama dengan halaman lain ===== */
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

      /* Halaman tidak di-scroll: hanya daftar banner di dalam kartu yang bisa digulir bila datanya banyak */
      body .main-c { display: flex; flex-direction: column; height: calc(100vh - var(--u) * 87); padding: calc(var(--u) * 20) calc(var(--u) * 41) calc(var(--u) * 24) calc(var(--u) * 34); overflow: hidden; }
      body .bn-card { flex: 1 1 auto; }

      /* Mode ringkas: 2 baris kartu (4 data) muat dalam satu layar tanpa scroll */
      body .main-c { padding-top: calc(var(--u) * 14); padding-bottom: calc(var(--su) * 48); } /* dasar kartu sejajar dasar tombol Log Out (padding bawah sidebar = 48 su) */
      body .bn-card { margin-top: calc(var(--u) * 12); }
      body .bn-head { padding-top: calc(var(--u) * 6); padding-bottom: calc(var(--u) * 9); }
      body .btn-add { margin-top: calc(var(--u) * 4); }
      body .bn-scroll { padding-top: calc(var(--u) * 12); padding-bottom: calc(var(--u) * 12); }
      body .bn-grid { row-gap: calc(var(--u) * 12); }
      body .bn-item { padding: calc(var(--u) * 7); border-radius: calc(var(--u) * 14); }
      body .bn-scroll { display: flex; flex-direction: column; }
      body .bn-grid { flex: 1 1 auto; grid-template-rows: repeat(2, minmax(0, 1fr)); }
      body .bn-img { flex: 1 1 auto; height: auto; min-height: calc(var(--u) * 48); max-height: calc(var(--u) * 170); }
      body .bn-rows { margin-top: calc(var(--u) * 4); gap: calc(var(--u) * 2); }
      body .bn-act { padding-top: calc(var(--u) * 6); }
      body .bn-foot { padding-top: calc(var(--u) * 5); padding-bottom: calc(var(--u) * 5); }

      /* overlay pop up: menutup area konten saja (sidebar tetap terang) */
      body .ov { left: var(--sbw); z-index: 40; }
    }

    /* =====================================================================
       FIX DESKTOP (>=900px): form Tambah / Edit harus MUAT tanpa scroll.
       Prinsip: semua bagian form memakai tinggi tetap, KECUALI area upload foto
       yang boleh menyusut otomatis sampai batas minimum bila layar kurang tinggi.
       Scroll di dalam form hanya tersisa sebagai pengaman di layar mobile / tablet.
       ===================================================================== */
    @media (min-width: 900px) {
      body #formCard { flex: 0 1 auto; min-height: 0; }
      body #formCard .fm-form { flex: 1 1 auto; min-height: 0; }

      /* Rapatkan sedikit jarak vertikal agar total tinggi form lebih hemat */
      body #formCard .fm-head { padding-top: calc(var(--u) * 10); padding-bottom: calc(var(--u) * 9); }
      body #formCard .fm-body { flex: 1 1 auto; min-height: 0; gap: calc(var(--u) * 10); padding-top: calc(var(--u) * 11); padding-bottom: calc(var(--u) * 11); }
      body #formCard.is-kg .fm-body { gap: calc(var(--u) * 16); padding-top: calc(var(--u) * 14); padding-bottom: calc(var(--u) * 16); }
      body #formCard.is-kg #fText { gap: calc(var(--u) * 16); }
      body #formCard .m-foot { padding-top: calc(var(--u) * 8); padding-bottom: calc(var(--u) * 8); }
      body #formCard .jn { padding: calc(var(--u) * 6) calc(var(--u) * 8); }
      body #formCard .jn-prev { height: calc(var(--u) * 58); }
      body #formCard textarea.fm-in { height: calc(var(--u) * 62); }

      /* Bagian foto = satu-satunya bagian yang fleksibel */
      body #formCard #fFoto { display: flex; flex-direction: column; flex: 0 1 auto; }
      body #formCard #fFoto .fm-lbl,
      body #formCard #fFoto .fm-err { flex: none; }
      body #formCard #fFoto .drop { flex: 1 1 auto; min-height: calc(var(--u) * 112); }
      body #formCard #fFoto .drop.compact { min-height: calc(var(--u) * 60); }

      /* Pada kotak upload ringkas, petunjuk format digabung ke satu baris dengan judul */
      body #formCard .drop.compact #dropEmpty .drop-h { display: none; }
      body #formCard .drop.compact #dropEmpty .drop-t::after { content: ' \00B7  PNG, JPG hingga 10MB'; font-weight: 400; font-size: calc(var(--u) * 8.5); color: #8A8FA0; }
    }

    /* =====================================================================
       FIX DESKTOP (>=900px): DAFTAR banner / kegiatan = ukuran kartu TETAP,
       selalu 2 baris (banner) / 5 baris (kegiatan), TANPA scroll.
       Data lebih banyak -> pindah halaman lewat pagination.
       Penyebab sebelumnya: kartu "foto saja" tidak punya blok teks sehingga gambar
       melar penuh, dan foto asli ikut mendorong tinggi kartu -> muncul scroll.
       ===================================================================== */
    .v.clamp1 { display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; line-clamp: 1; overflow: hidden; }
    @media (min-width: 900px) {
      body .bn-scroll { overflow: hidden; }
      body .bn-grid { flex: 1 1 0; min-height: 0; grid-template-rows: repeat(2, minmax(0, 1fr)); grid-auto-rows: minmax(0, 1fr); }
      body .bn-grid.kg { grid-template-rows: repeat(5, minmax(0, 1fr)); grid-auto-rows: minmax(0, 1fr); }

      body .bn-item { min-height: 0; overflow: hidden; }
      /* Foto mengisi sisa tinggi kartu; ukuran asli file tidak ikut menentukan tinggi */
      body .bn-item .bn-img, body .bn-item.only .bn-img { flex: 1 1 0; height: auto; min-height: 0; max-height: none; }
      body .bn-img img { position: absolute; inset: 0; }
      /* Blok teks tinggi tetap -> semua kartu (foto saja / foto + teks) punya tinggi foto yang sama */
      body .bn-item .bn-rows { flex: none; height: calc(var(--u) * 64); overflow: hidden; margin-top: calc(var(--u) * 5); }
      body .bn-act { flex: none; }

      body .kg-item { min-height: 0; overflow: hidden; }
      body .kg-img { position: relative; }
      body .kg-img img { position: absolute; inset: 0; }
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
          <a href="{{ url('kelola-beranda') }}" class="active">Beranda</a>
          <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
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
        <a href="{{ url('kelola-beranda') }}" class="active">Beranda</a>
        <a href="{{ url('kelola-tentang-kami') }}">Tentang Kami</a>
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
      <h1 id="hdrT" class="hdr-t text-lg font-semibold text-[#03045E]">Kelola Tampilan Beranda</h1>
      <p id="hdrS" class="hdr-s text-[11px] text-black sm:text-xs">Kelola konten yang tampil di halaman utama website</p>
    </header>

    <main class="main-c">
      <!-- Tab -->
      <div class="tabs-card">
        <div id="tabs" class="tabs-in" role="tablist" aria-label="Kelola Beranda">
          <button type="button" role="tab" data-t="banner" class="tab active">Kelola Banner</button>
          <button type="button" role="tab" data-t="kegiatan" class="tab">Kelola Foto Kegiatan</button>
        </div>
      </div>

      <!-- Kartu utama -->
      <section id="listCard" class="bn-card">
        <div class="bn-head">
          <div class="min-w-0">
            <h2 id="bnTitle" class="bn-title"></h2>
            <p id="bnSub" class="bn-sub"></p>
          </div>
          <button id="btnAdd" type="button" class="btn-add">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>Tambah Data
          </button>
        </div>

        <div class="bn-scroll">
          <div id="grid" class="bn-grid"></div>
          <p id="empty" class="hidden">Belum ada data.</p>
        </div>

        <div class="bn-foot">
          <button id="pgPrev" type="button" class="pg-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg>Sebelumnya
          </button>
          <div id="pgNums" class="pg-nums"></div>
          <button id="pgNext" type="button" class="pg-btn">
            Selanjutnya<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg>
          </button>
        </div>
      </section>

      <!-- Form tambah / edit (menggantikan daftar di dalam kartu) -->
      <section id="formCard" class="bn-card" hidden>
        <div class="fm-head"><h2 id="fmTitle" class="bn-title">Tambah Banner</h2></div>
        <form id="fmForm" class="fm-form" novalidate autocomplete="off">
          <div class="fm-body">

            <div id="fJenis">
              <span class="fm-lbl" id="lblJenis">Pilih Jenis Banner</span>
              <div class="jn-grid" role="radiogroup" aria-labelledby="lblJenis">
                <button type="button" role="radio" class="jn on" data-j="foto" aria-checked="true">
                  <div class="jn-prev"><svg viewBox="0 0 24 24" fill="#fff"><circle cx="16.5" cy="7.5" r="2.6"/><path d="M2.5 20l6.3-8.6a1 1 0 011.6 0l3 4.1 2-2.6a1 1 0 011.6 0L22 20z"/></svg></div>
                  <div class="jn-info">
                    <div class="jn-t"><span class="jn-dot"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></span>Foto iklan saja</div>
                    <p>Hanya gambar, tanpa teks dan tombol.</p>
                  </div>
                </button>
                <button type="button" role="radio" class="jn" data-j="lengkap" aria-checked="false">
                  <div class="jn-prev t"><i class="a"></i><i class="b"></i><i class="b" style="width:50%"></i><i class="c"></i></div>
                  <div class="jn-info">
                    <div class="jn-t"><span class="jn-dot"><svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12.5l4.5 4.5L19 7.5"/></svg></span>Foto + teks + tombol</div>
                    <p>Gambar dengan judul, deskripsi, dan tombol.</p>
                  </div>
                </button>
              </div>
            </div>

            <div id="fFoto">
              <span class="fm-lbl"><span id="lblFotoT">Foto Banner</span><span class="rq" aria-hidden="true">*</span></span>
              <div id="drop" class="drop" role="button" tabindex="0" aria-label="Unggah foto">
                <input id="fmFile" type="file" accept="image/png,image/jpeg,image/webp" class="sr-only" tabindex="-1" />
                <div id="dropEmpty" class="drop-in">
                  <span class="drop-ic"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 16V5M7.5 9.5L12 5l4.5 4.5M5 19h14"/></svg></span>
                  <span class="drop-t">Klik untuk mengunggah</span>
                  <span class="drop-h">PNG, JPG hingga 10MB</span>
                  <span class="drop-btn">Pilih File</span>
                </div>
                <div id="dropFile" class="drop-in" hidden>
                  <span class="drop-t" id="dfName"></span>
                  <span class="drop-h" id="dfSize"></span>
                  <span class="drop-btn">Ganti File</span>
                </div>
              </div>
              <p id="eFoto" class="fm-err"></p>
            </div>

            <div id="fText" class="fm-row2">
              <div class="fm-f">
                <label for="fmJudul" class="fm-lbl">Judul<span class="rq" aria-hidden="true">*</span></label>
                <input id="fmJudul" type="text" maxlength="120" class="fm-in" placeholder="Ketik judul banner..." />
                <p id="eJudul" class="fm-err"></p>
              </div>
              <div class="fm-f">
                <label for="fmDesk" class="fm-lbl">Deskripsi<span class="op">(opsional)</span></label>
                <textarea id="fmDesk" maxlength="300" class="fm-in" placeholder="Ketik deskripsi banner..."></textarea>
              </div>
            </div>

            <div id="fBottom" class="fm-row2">
              <div id="fStatus" class="fm-f">
                <span class="fm-lbl" id="lblStatus">Status Banner</span>
                <div class="st-box">
                  <span>Banner ditampilkan di website</span>
                  <button id="fmTgl" type="button" class="tgl on" role="switch" aria-checked="true" aria-labelledby="lblStatus"></button>
                </div>
              </div>
              <div id="fTombol" class="fm-f">
                <label for="fmTombol" class="fm-lbl">Teks Tombol<span class="op">(opsional)</span></label>
                <input id="fmTombol" type="text" maxlength="40" class="fm-in" placeholder="Contoh: Pelajari Layanan Kami" />
              </div>
            </div>

          </div>
          <div class="m-foot">
            <button id="fmCancel" type="button" class="m-btn m-btn-grey">Batal</button>
            <button type="submit" class="m-btn m-btn-blue">Simpan</button>
          </div>
        </form>
      </section>
    </main>
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
       Data dari database: banner (tabel banners) & foto kegiatan (tabel testimonis).
       loadData() membaca data dari server, saveData() menyimpan lewat API Laravel.
       Foto baru dikirim sebagai data URL (otomatis dikecilkan) dan disimpan sebagai file di server.
       ===================================================================== */
    let PER_PAGE = 4; // diatur per tab (cfg.per): Banner 4 (2 baris x 2 kolom), Foto Kegiatan 5 baris
    // Data awal & kunci penyimpanan datang dari site-data.js, sehingga index / keseruan / keseruan-detail
    // membaca data yang sama persis dengan yang dikelola di halaman ini.
    const TABS = {
      banner: {
        key: ICONNET.KEY_BANNER, hasBtn: true, per: 4, add: 'Tambah Banner', edit: 'Edit Banner',
        title: 'Pengelolaan Bagian: Banner Beranda',
        hdrT: 'Kelola Tampilan Beranda', hdrS: 'Kelola konten yang tampil di halaman utama website',
        sub: 'Kelola banner iklan yang tampil di halaman utama website.',
        load: () => ICONNET.loadBanners()
      },
      kegiatan: {
        key: ICONNET.KEY_KEGIATAN, hasBtn: false, per: 5, add: 'Tambah Kegiatan', edit: 'Edit Kegiatan',
        title: 'Kelola foto kegiatan yang di tampilkan di website',
        sub: 'Kelola foto kegiatan dan keseruan ICONNET yang tampil di halaman utama.',
        hdrT: 'Kelola Tampilan Keseruan', hdrS: 'Perbarui Informasi Keseruan Yang Ditampilkan di Website.',
        load: () => ICONNET.loadKegiatan()
      }
    };
    // Tanggal lokal (YYYY-MM-DD) untuk data baru; data baru tampil paling depan di beranda.
    const tglLokal = ICONNET.todayLocal;
    const store = {};
    const loadData = t => TABS[t].load();
    // Simpan ke database lewat API. Server mengembalikan daftar terbaru (foto sudah berupa URL file).
    const API_PATH = { banner: 'api/v1/kelola/banner', kegiatan: 'api/v1/kelola/kegiatan' };
    async function saveData(t, method, path, body) {
      const res = await ICONNET_API.request(method, API_PATH[t] + path, body);
      ICONNET_API.write(TABS[t].key, res.list);
      return res.list;
    }
    Object.keys(TABS).forEach(t => { store[t] = loadData(t); });

    let tab = 'banner', page = 1, editId = null, delId = null, curFoto = '';

    const ICON_EDIT = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 013 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>';
    const ICON_DEL = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 011-1h6a1 1 0 011 1v2"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>';

    function cardHTML(p) {
      const cfg = TABS[tab];
      const fotoOnly = cfg.hasBtn && p.jenis === 'foto';
      const alt = fotoOnly ? 'Foto banner' : p.judul;
      const img = p.foto ? `<img src="${esc(p.foto)}" alt="${esc(alt)}" />` : '<div class="bn-ph">ICONNET</div>';
      const chip = cfg.hasBtn ? `<span class="bn-chip">${fotoOnly ? 'Foto saja' : 'Foto + teks'}</span>` : '';
      const tbRow = (cfg.hasBtn && p.teksTombol) ? `<div class="bn-row tb"><span>Teks Tombol</span><span>:</span><span class="v clamp1">${esc(p.teksTombol)}</span></div>` : '';
      const tgl = cfg.hasBtn
        ? `<div class="tgl-wrap"><button type="button" class="tgl${p.aktif ? ' on' : ''}" role="switch" aria-checked="${p.aktif ? 'true' : 'false'}" aria-label="Tampilkan banner" data-act="tgl" data-id="${p.id}"></button><span class="tgl-lb${p.aktif ? ' on' : ''}">${p.aktif ? 'Ditampilkan' : 'Disembunyikan'}</span></div>`
        : '<span class="tgl-sp"></span>';
      const rows = fotoOnly ? '' : `<div class="bn-rows">
          <div class="bn-row"><span>Judul</span><span>:</span><span class="v clamp1">${esc(p.judul)}</span></div>
          ${p.deskripsi ? `<div class="bn-row"><span>Deskripsi</span><span>:</span><span class="v clamp">${esc(p.deskripsi)}</span></div>` : ''}
          ${tbRow}
        </div>`;
      return `
      <article class="bn-item${fotoOnly ? ' only' : ''}">
        <div class="bn-img">${img}${chip}</div>
        ${rows}
        <div class="bn-act">
          ${tgl}
          <div class="ic">
            <button type="button" class="ibtn ed" data-act="edit" data-id="${p.id}" aria-label="Edit">${ICON_EDIT}</button>
            <button type="button" class="ibtn dl" data-act="del" data-id="${p.id}" aria-label="Hapus">${ICON_DEL}</button>
          </div>
        </div>
      </article>`;
    }

    /* Kartu daftar "Foto Kegiatan": thumbnail kiri, judul + deskripsi, ikon edit / hapus kanan bawah */
    function kegiatanHTML(p) {
      // Foto diisi otomatis dari data (p.foto). Bila belum ada, tampil kotak polos sebagai tempat foto.
      const img = p.foto ? `<img src="${esc(p.foto)}" alt="${esc(p.judul)}" />` : '<div class="bn-ph"></div>';
      return `
      <article class="kg-item">
        <div class="kg-img">${img}</div>
        <div class="kg-body">
          <h3 class="kg-t">${esc(p.judul)}</h3>
          ${p.deskripsi ? `<p class="kg-d">${esc(p.deskripsi)}</p>` : ''}
        </div>
        <div class="kg-act">
          <button type="button" class="ibtn ed" data-act="edit" data-id="${p.id}" aria-label="Edit">${ICON_EDIT}</button>
          <button type="button" class="ibtn dl" data-act="del" data-id="${p.id}" aria-label="Hapus">${ICON_DEL}</button>
        </div>
      </article>`;
    }

    function render() {
      const cfg = TABS[tab], list = store[tab];
      $('hdrT').textContent = cfg.hdrT; $('hdrS').textContent = cfg.hdrS;
      $('grid').className = 'bn-grid' + (tab === 'kegiatan' ? ' kg' : '');
      PER_PAGE = cfg.per;
      const pages = Math.max(1, Math.ceil(list.length / PER_PAGE));
      if (page > pages) page = pages;
      $('bnTitle').textContent = cfg.title;
      $('bnSub').textContent = cfg.sub;
      document.querySelectorAll('.tab').forEach(b => { const on = b.dataset.t === tab; b.classList.toggle('active', on); b.setAttribute('aria-selected', on ? 'true' : 'false'); });

      const slice = list.slice((page - 1) * PER_PAGE, page * PER_PAGE);
      $('grid').innerHTML = slice.map(tab === 'kegiatan' ? kegiatanHTML : cardHTML).join('');
      $('empty').classList.toggle('hidden', slice.length > 0);

      let nums = '';
      for (let i = 1; i <= pages; i++) nums += `<button type="button" class="pg-num${i === page ? ' active' : ''}" data-p="${i}">${i}</button>`;
      $('pgNums').innerHTML = nums;
      $('pgPrev').disabled = page <= 1;
      $('pgNext').disabled = page >= pages;
    }

    /* Tab */
    $('tabs').addEventListener('click', e => {
      const b = e.target.closest('.tab'); if (!b || (b.dataset.t === tab && !inForm)) return;
      tab = b.dataset.t; page = 1; showList();
      document.querySelector('.bn-scroll').scrollTop = 0;
    });

    /* Pagination */
    $('pgNums').addEventListener('click', e => { const b = e.target.closest('[data-p]'); if (b) { page = +b.dataset.p; render(); document.querySelector('.bn-scroll').scrollTop = 0; } });
    $('pgPrev').addEventListener('click', () => { if (page > 1) { page--; render(); document.querySelector('.bn-scroll').scrollTop = 0; } });
    $('pgNext').addEventListener('click', () => { page++; render(); document.querySelector('.bn-scroll').scrollTop = 0; });

    /* ---------- Pop up (buka / tutup) ---------- */
    const delModal = $('delModal');
    function openOv(el) { el.classList.add('open'); el.setAttribute('aria-hidden', 'false'); document.body.style.overflow = 'hidden'; }
    function closeOv(el) {
      el.classList.remove('open'); el.setAttribute('aria-hidden', 'true');
      if (!document.querySelector('.ov.open')) document.body.style.overflow = window.matchMedia('(min-width:900px)').matches ? 'hidden' : '';
    }
    const closeDel = () => { closeOv(delModal); delId = null; };

    /* ---------- Aksi pada kartu ---------- */
    $('grid').addEventListener('click', e => {
      const b = e.target.closest('[data-act]'); if (!b) return;
      const id = +b.dataset.id, act = b.dataset.act;
      if (act === 'edit') openForm(id);
      else if (act === 'del') { delId = id; openOv(delModal); $('dCancel').focus(); }
      else if (act === 'tgl') {
        const t = tab, cur = store[t].find(p => p.id === id); if (!cur) return;
        saveData(t, 'PATCH', '/' + id + '/aktif', { aktif: !cur.aktif })
          .then(list => { store[t] = list; render(); })
          .catch(err => showToast(err.message || 'Gagal menyimpan data. Coba lagi.'));
      }
    });
    $('dCancel').addEventListener('click', closeDel);
    delModal.addEventListener('click', e => { if (e.target === delModal) closeDel(); });
    $('dOk').addEventListener('click', async () => {
      if (delId === null) return;
      const t = tab;
      try { store[t] = await saveData(t, 'DELETE', '/' + delId); }
      catch (err) { closeDel(); return showToast(err.message || 'Gagal menghapus data. Coba lagi.'); }
      closeDel(); render(); showToast('Data berhasil dihapus');
    });

    /* ---------- Form tambah / edit (tampil di dalam kartu) ---------- */
    const listCard = $('listCard'), formCard = $('formCard'), drop = $('drop');
    let inForm = false, jenis = 'foto', curNama = '', curKb = 0, curAktif = true;
    const MAX_BYTES = 10 * 1024 * 1024;

    const fmtKb = kb => kb >= 1024 ? (kb / 1024).toFixed(1).replace('.', ',') + ' MB' : kb + ' KB';
    function clearErr() {
      $('fmJudul').classList.remove('err'); $('eJudul').textContent = '';
      drop.classList.remove('err'); $('eFoto').textContent = '';
    }
    function setFoto(src, nama, kb) {
      curFoto = src || ''; curNama = nama || ''; curKb = kb || 0;
      const has = !!curFoto;
      $('dropEmpty').hidden = has; $('dropFile').hidden = !has;
      const isData = /^data:/.test(curFoto);
      $('dfName').textContent = curNama || (has && !isData ? decodeURIComponent(curFoto.split('/').pop()) : 'Foto banner');
      $('dfSize').textContent = (has && (isData || curKb)) ? fmtKb(curKb || Math.max(1, Math.round(curFoto.length * 0.75 / 1024))) : '';
    }
    function syncTgl() { const t = $('fmTgl'); t.classList.toggle('on', curAktif); t.setAttribute('aria-checked', curAktif ? 'true' : 'false'); }

    /* Tampilkan field sesuai jenis banner & mode (tambah / edit) */
    function applyForm() {
      const cfg = TABS[tab], editing = editId !== null, isBanner = cfg.hasBtn;
      const full = !isBanner || jenis === 'lengkap';          // judul + deskripsi (+ tombol)
      $('fJenis').hidden = !(isBanner && !editing);
      document.querySelectorAll('.jn').forEach(b => { const on = b.dataset.j === jenis; b.classList.toggle('on', on); b.setAttribute('aria-checked', on ? 'true' : 'false'); });
      $('fText').hidden = !full;
      $('fTombol').hidden = !(isBanner && full);
      // Status hanya muncul saat Tambah; saat Edit status diatur lewat toggle di kartu.
      $('fStatus').hidden = !(isBanner && !editing);
      $('fBottom').hidden = $('fTombol').hidden && $('fStatus').hidden;
      formCard.classList.toggle('is-edit', editing);
      formCard.classList.toggle('is-kg', !isBanner);
      $('lblFotoT').textContent = isBanner ? 'Foto Banner' : 'Foto Kegiatan';
      $('fmJudul').placeholder = isBanner ? 'Ketik judul banner...' : 'Ketik judul kegiatan...';
      $('fmDesk').placeholder = isBanner ? 'Ketik deskripsi banner...' : 'Ketik deskripsi kegiatan...';
      drop.classList.toggle('compact', isBanner && full);
      syncTgl();
    }

    function openForm(id) {
      editId = id || null; clearErr();
      const cfg = TABS[tab], p = id ? store[tab].find(x => x.id === id) : null;
      $('fmTitle').textContent = p ? cfg.edit : cfg.add;
      jenis = p ? (p.jenis || 'lengkap') : 'foto';
      curAktif = p ? !!p.aktif : true;
      $('fmJudul').value = p ? p.judul : '';
      $('fmDesk').value = p ? p.deskripsi : '';
      $('fmTombol').value = p ? p.teksTombol : '';
      setFoto(p ? p.foto : '', p ? p.fotoNama : '', p ? p.fotoKb : 0);
      applyForm();
      inForm = true; listCard.hidden = true; formCard.hidden = false;
      document.querySelector('.fm-body').scrollTop = 0;
    }
    function showList() {
      inForm = false; formCard.hidden = true; listCard.hidden = false; render();
    }
    $('btnAdd').addEventListener('click', () => openForm(null));
    $('fmCancel').addEventListener('click', showList);

    document.querySelectorAll('.jn').forEach(b => b.addEventListener('click', () => { jenis = b.dataset.j; clearErr(); applyForm(); }));
    $('fmTgl').addEventListener('click', () => { curAktif = !curAktif; syncTgl(); });

    /* Foto: dikecilkan (maks 900px) sebelum dikirim ke server */
    function fileToData(file) {
      return new Promise((res, rej) => {
        const r = new FileReader();
        r.onload = () => {
          const im = new Image();
          im.onload = () => {
            const s = Math.min(1, 900 / im.width);
            const c = document.createElement('canvas');
            c.width = Math.round(im.width * s); c.height = Math.round(im.height * s);
            const g = c.getContext('2d');
            g.fillStyle = '#fff'; g.fillRect(0, 0, c.width, c.height);
            g.drawImage(im, 0, 0, c.width, c.height);
            res(c.toDataURL('image/jpeg', 0.82));
          };
          im.onerror = rej; im.src = r.result;
        };
        r.onerror = rej; r.readAsDataURL(file);
      });
    }
    async function handleFile(f) {
      drop.classList.remove('err'); $('eFoto').textContent = '';
      if (!f) return;
      if (!/^image\/(png|jpe?g|webp)$/.test(f.type)) { $('eFoto').textContent = 'Format file harus PNG atau JPG.'; return; }
      if (f.size > MAX_BYTES) { $('eFoto').textContent = 'Ukuran file maksimal 10MB.'; return; }
      try { setFoto(await fileToData(f), f.name, Math.max(1, Math.round(f.size / 1024))); }
      catch (err) { $('eFoto').textContent = 'Gagal membaca gambar.'; }
    }
    $('fmFile').addEventListener('change', e => { const f = e.target.files[0]; e.target.value = ''; handleFile(f); });
    drop.addEventListener('click', () => $('fmFile').click());
    drop.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); $('fmFile').click(); } });
    ['dragenter', 'dragover'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); drop.classList.add('drag'); }));
    ['dragleave', 'drop'].forEach(ev => drop.addEventListener(ev, e => { e.preventDefault(); drop.classList.remove('drag'); }));
    drop.addEventListener('drop', e => handleFile(e.dataTransfer.files[0]));

    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && delModal.classList.contains('open')) closeDel();
    });

    $('fmForm').addEventListener('submit', async e => {
      e.preventDefault(); clearErr();
      const cfg = TABS[tab], isBanner = cfg.hasBtn, full = !isBanner || jenis === 'lengkap';
      const judul = $('fmJudul').value.trim(), desk = $('fmDesk').value.trim(), tb = $('fmTombol').value.trim();

      // Wajib: foto, dan judul (kecuali jenis "foto iklan saja"). Sisanya opsional.
      let first = null;
      if (!curFoto) { drop.classList.add('err'); $('eFoto').textContent = 'Foto wajib diunggah.'; first = drop; }
      if (full && !judul) { $('fmJudul').classList.add('err'); $('eJudul').textContent = 'Judul wajib diisi.'; first = first || $('fmJudul'); }
      if (first) {
        // Di desktop halaman tidak boleh bergeser; scroll otomatis hanya untuk mobile / tablet.
        if (!window.matchMedia('(min-width:900px)').matches) first.scrollIntoView({ block: 'nearest' });
        first.focus({ preventScroll: true });
        return;
      }

      const wasEdit = editId !== null;
      const t = tab;
      const item = {
        judul: full ? judul : '', deskripsi: full ? desk : '', teksTombol: (isBanner && full) ? tb : '',
        foto: curFoto   // data URL = foto baru; URL lama = foto tidak diganti
      };
      // Saat edit, status tampil/sembunyi tidak berubah (diatur lewat toggle di kartu).
      if (isBanner) { item.jenis = jenis; if (!wasEdit) item.aktif = curAktif; }
      const btnSave = $('fmForm').querySelector('[type="submit"]');
      if (btnSave) btnSave.disabled = true;
      let next;
      try { next = await saveData(t, wasEdit ? 'PUT' : 'POST', wasEdit ? '/' + editId : '', item); }
      catch (err) { return showToast(err.message || 'Gagal menyimpan data. Foto mungkin terlalu besar.'); }
      finally { if (btnSave) btnSave.disabled = false; }
      store[t] = next;
      // Banner baru ada di bawah (buka halaman terakhir); kegiatan baru tampil paling depan (halaman 1)
      if (!wasEdit) page = t === 'kegiatan' ? 1 : Math.ceil(next.length / PER_PAGE);
      showList();
      showToast(wasEdit ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan');
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
