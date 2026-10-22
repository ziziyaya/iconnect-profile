<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Akun User - ICONNET</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
  /* Satuan sidebar: sama dengan beranda-admin.html & verifikasi-user.html (frame desain 1110 x 790).
     Di layar kecil (<= 900px) otomatis 1px supaya drawer mobile tidak mengecil. */
  --u: 1px;
  --sidebar-w: calc(var(--u) * 196);
  --sidebar-w-collapsed: 76px;

  --bg: #f9f8fe;
  --white: #ffffff;
  --text: #111111;
  --muted: #555555;
  --cyan: #00b4d0;
  --cyan-soft: #e1f7fd;
  --filter-active: #02B6D1;
  --navy: #1b2574;
  --table-head: #03045e;
  --danger: #d23739;

  --radius: 14px;
  --radius-sm: 8px;
  --radius-pill: 999px;
  --ctrl-h: 32px;
  --row-min: 38px;
  --shadow-card: 0 1px 3px rgba(30, 30, 70, .16), 0 2px 6px rgba(30, 30, 70, .06);
}
@media (min-width: 901px) {
  :root { --u: max(min(100vw / 1110, 100vh / 790), 0.6px); }
}

* { margin: 0; padding: 0; box-sizing: border-box; }

html, body {
  height: 100%;
  font-family: 'Poppins', sans-serif;
  background: var(--bg);
  color: var(--text);
  -webkit-font-smoothing: antialiased;
}

button, input, select, textarea { font-family: inherit; }

.icon {
  display: block;
  flex-shrink: 0;
  fill: none;
  stroke: currentColor;
  stroke-width: 1.6;
  stroke-linecap: round;
  stroke-linejoin: round;
}

/* =========================================================
   LAYOUT (LAPTOP = TANPA SCROLL HALAMAN)
   ========================================================= */
.app {
  display: flex;
  height: 100vh;
  height: 100dvh;
  overflow: hidden;
}

/* ---------------- SIDEBAR (sama persis dengan Beranda Admin) ---------------- */
.sidebar {
  position: relative;
  width: var(--sidebar-w);
  padding: calc(var(--u) * 24) calc(var(--u) * 17) calc(var(--u) * 44);
  background: var(--white);
  border-radius: 0 calc(var(--u) * 28) calc(var(--u) * 28) 0;
  box-shadow: 2px 0 6px rgba(0, 0, 0, .14);
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
  z-index: 20;
  transition: width .25s ease;
}

.sidebar-logo {
  height: calc(var(--u) * 123 + 1px);
  padding-bottom: calc(var(--u) * 19);
  border-bottom: 1px solid #ECEDF2;
  display: flex;
  align-items: center;
  justify-content: center;
}
.sidebar-logo img { display: block; height: calc(var(--u) * 104); width: calc(var(--u) * 104); max-width: 100%; object-fit: contain; }

.collapse-btn {
  position: absolute;
  top: calc(var(--u) * 53);
  right: calc(var(--u) * -9);
  width: calc(var(--u) * 18);
  height: calc(var(--u) * 18);
  border: none;
  border-radius: 50%;
  background: #02B6D1;
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 25;
  box-shadow: 0 1px 3px rgba(0, 0, 0, .1), 0 1px 2px rgba(0, 0, 0, .06);
}
.collapse-btn .icon { width: calc(var(--u) * 9); height: calc(var(--u) * 9); stroke-width: 3; transition: transform .25s; }

.nav { margin-top: calc(var(--u) * 6); display: flex; flex-direction: column; gap: calc(var(--u) * 12); }

.nav-item {
  display: flex;
  align-items: center;
  gap: calc(var(--u) * 14);
  height: calc(var(--u) * 43);
  padding: 0 calc(var(--u) * 17);
  border-radius: calc(var(--u) * 11);
  text-decoration: none;
  color: #4B4B4B;
  font-size: calc(var(--u) * 12);
  font-weight: 400;
  white-space: nowrap;
  overflow: hidden;
  transition: background .2s;
}
.nav-item .icon { width: calc(var(--u) * 17); height: calc(var(--u) * 17); stroke-width: 1.8; }
.nav-item:hover { background: #f1f5f9; }
.nav-item.active { background: #E1FAFF; color: #1C1F20; font-weight: 500; }
.nav-item.active .icon { color: #1A1D6E; }

.logout-wrap { margin-top: auto; }
.logout-btn {
  width: 100%;
  height: calc(var(--u) * 44);
  border: none;
  border-radius: calc(var(--u) * 11);
  background: #D23739;
  color: #fff;
  font-size: calc(var(--u) * 14);
  font-weight: 600;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  gap: calc(var(--u) * 16);
  padding: 0 calc(var(--u) * 17);
  cursor: pointer;
  box-shadow: 0 3px 6px rgba(0, 0, 0, .25);
  white-space: nowrap;
  overflow: hidden;
  transition: filter .15s;
}
.logout-btn:hover { filter: brightness(1.1); }
.logout-btn .icon { width: calc(var(--u) * 20); height: calc(var(--u) * 20); }

/* Sidebar diciutkan (desktop saja) */
@media (min-width: 901px) {
  .app.collapsed .sidebar { width: var(--sidebar-w-collapsed); padding-left: 12px; padding-right: 12px; }
  .app.collapsed .sidebar-logo { height: calc(var(--u) * 104); padding-bottom: 0; border-bottom: none; }
  .app.collapsed .sidebar-logo img { display: none; }
  .app.collapsed .nav-item,
  .app.collapsed .logout-btn { justify-content: center; padding: 0; }
  .app.collapsed .nav-item span,
  .app.collapsed .logout-btn span { display: none; }
  .app.collapsed .collapse-btn .icon { transform: rotate(180deg); }
}

/* ---------------- KONTEN ---------------- */
.main {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
  height: 100%;
}

.topbar {
  background: var(--white);
  padding: 0 38px;
  height: 80px;
  display: flex;
  align-items: center;
  gap: 12px;
  flex-shrink: 0;
}
.menu-toggle {
  display: none;
  width: 36px; height: 36px;
  border: none; background: var(--cyan-soft);
  border-radius: var(--radius-sm); cursor: pointer; color: var(--navy);
  align-items: center; justify-content: center;
}
.menu-toggle .icon { width: 18px; height: 18px; stroke-width: 2; }
.topbar h1 { font-size: 18px; font-weight: 600; line-height: 24px; }
.topbar p  { font-size: 12.5px; font-weight: 400; color: #222; line-height: 18px; }

.content {
  flex: 1;
  min-height: 0;
  padding: 20px 33px 40px 38px;
  display: flex;
  flex-direction: column;
  gap: 18px;
}

/* ---------------- KARTU PENCARIAN ---------------- */
.filter-card {
  background: var(--white);
  border: 1px solid #ebebf3;
  border-radius: var(--radius);
  box-shadow: var(--shadow-card);
  padding: 12px 21px 0;
  height: 104px;
  flex-shrink: 0;
}
.filter-card h2 { font-size: 18px; font-weight: 600; line-height: 26px; }

.search-row { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; margin-top: 15px; }
.field {
  position: relative;
  height: var(--ctrl-h);
  background: var(--white);
  border: 1px solid #dcdce6;
  border-radius: var(--radius-sm);
}
.field .f-icon {
  position: absolute; top: 50%; transform: translateY(-50%);
  color: #444; pointer-events: none;
}
.field.search .f-icon { left: 11px; width: 15px; height: 15px; stroke-width: 1.7; }
.field.search input {
  width: 100%; height: 100%;
  border: none; outline: none; background: transparent;
  padding: 0 12px 0 34px;
  font-size: 11.5px; color: var(--text);
  border-radius: var(--radius-sm);
}
.field input::placeholder { color: #666; opacity: 1; }
.field.select .f-icon { right: 12px; width: 14px; height: 14px; stroke-width: 2; color: #222; }
.field.select select {
  width: 100%; height: 100%;
  border: none; outline: none; background: transparent;
  appearance: none; -webkit-appearance: none;
  padding: 0 34px 0 12px;
  font-size: 11.5px; color: #555;
  border-radius: var(--radius-sm);
  cursor: pointer;
}
.field:focus-within { border-color: var(--filter-active); }

/* ---------------- TABEL ---------------- */
.table-card {
  flex: 1;
  min-height: 0;
  background: var(--white);
  border-radius: var(--radius);
  box-shadow: 0 2px 5px rgba(30, 30, 70, .22);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.t-head, .t-row { display: grid; align-items: center; column-gap: 0; }

/* Nama | Email | Telepon | Jenis Kelamin | Sekolah | Aksi */
.t-head, .t-row {
  grid-template-columns: 150fr 140fr 106fr 90fr 150fr 110fr;
  padding: 0 13px 0 30px;
}

.t-head {
  height: 36px;
  background: var(--table-head);
  color: #fff;
  font-size: 12px;
  font-weight: 500;
  flex-shrink: 0;
}
@media (min-width: 901px) {
  /* Semua kolom center dengan lebar sama rata; kolom Aksi diberi lebar minimum supaya tombol tidak mengecil */
  .t-head, .t-row {
    grid-template-columns: repeat(5, minmax(0, 1fr)) minmax(120px, 1fr);
    padding: 0 16px;
  }
  .t-head > div, .t-row > div { text-align: center; padding-left: 8px; padding-right: 8px; }
}

/* 10 baris per halaman: tinggi baris menyesuaikan layar (maks 56px) supaya halaman tidak perlu di-scroll */
.t-body {
  flex: 1;
  min-height: 0;
  overflow-y: auto;
  display: grid;
  grid-template-rows: repeat(10, minmax(var(--row-min), 56px));
  align-content: start;
}

.t-row {
  min-height: 0;
  border-bottom: 1px solid #ececec;
  font-size: 11.5px;
  color: #000;
}
/* Baris ke-10 (terakhir) tanpa garis sendiri: garis penutupnya sudah dari batas pagination */
.t-row:nth-child(10) { border-bottom: none; }
.t-row > div { min-width: 0; padding-right: 8px; }
.t-row .c-aksi { padding-right: 0; display: flex; justify-content: center; }

/* Tombol Hapus Akun */
.btn-hapus {
  display: inline-flex; align-items: center; justify-content: center;
  gap: 8px;
  height: 26px; width: 108px; max-width: 100%;
  border: none; border-radius: var(--radius-pill);
  background: #d23739; color: #fff;
  font-size: 11.5px; font-weight: 500;
  white-space: nowrap;
  cursor: pointer;
  box-shadow: 0 3px 6px rgba(0, 0, 0, .28);
  transition: filter .15s;
}
.btn-hapus:hover { filter: brightness(1.1); }
.btn-hapus .icon { width: 15px; height: 15px; stroke-width: 2; }

.empty { grid-row: 1 / -1; padding: 48px 16px; text-align: center; font-size: 12px; color: #888; }

/* ---------------- PAGINATION ---------------- */
.pager {
  height: 36px;
  border-top: 1px solid #e0e0e0;
  padding: 0 12px;
  display: flex; align-items: center; justify-content: flex-end; gap: 8px;
  flex-shrink: 0;
}
.pg-nav {
  height: 24px; padding: 0 14px;
  border: 1px solid #cfcfd8; border-radius: var(--radius-pill);
  background: var(--white); color: #222;
  font-size: 10.5px; font-weight: 500;
  display: flex; align-items: center; gap: 8px;
  cursor: pointer; white-space: nowrap;
}
.pg-nav .icon { width: 8px; height: 8px; stroke-width: 2.6; }
.pg-nav:disabled { opacity: .45; cursor: default; }
.pg-num {
  min-width: 24px; height: 24px; padding: 0 4px;
  border: 1px solid #d3d3dc; border-radius: 6px;
  background: var(--white); color: #111;
  font-size: 10.5px; font-weight: 500;
  cursor: pointer;
}
.pg-num.active { background: #4dcae0; border-color: #4dcae0; color: #fff; }

/* =========================================================
   LAPTOP PENDEK (tetap tanpa scroll)
   ========================================================= */
@media (min-width: 901px) and (max-height: 780px) {
  :root { --row-min: 36px; }
  .topbar { height: 68px; }
  .content { padding-top: 14px; padding-bottom: 20px; gap: 12px; }
  .filter-card { height: 92px; padding-top: 10px; }
  .filter-card h2 { font-size: 17px; line-height: 24px; }
  .search-row { margin-top: 10px; }
  .field { height: 30px; }
}
@media (min-width: 901px) and (max-height: 620px) {
  :root { --row-min: 32px; }
  .topbar { height: 58px; }
  .content { padding-top: 10px; padding-bottom: 12px; gap: 10px; }
  .filter-card { height: 80px; padding-top: 8px; }
  .filter-card h2 { font-size: 16px; line-height: 22px; }
  .search-row { margin-top: 8px; }
  .field { height: 28px; }
  .t-head { height: 30px; }
  .pager { height: 32px; }
  .btn-hapus { height: 22px; width: 98px; font-size: 10.5px; gap: 6px; }
  .btn-hapus .icon { width: 13px; height: 13px; }
  .pg-nav, .pg-num { height: 22px; }
}

/* =========================================================
   TABLET & MOBILE
   ========================================================= */
@media (max-width: 900px) {
  .app { height: auto; min-height: 100dvh; overflow: visible; }
  html, body { height: auto; }

  .sidebar {
    position: fixed;
    top: 0; left: 0; bottom: 0;
    width: var(--sidebar-w);
    transform: translateX(-105%);
    transition: transform .28s ease;
  }
  .app.menu-open .sidebar { transform: translateX(0); }
  .collapse-btn { display: none; }

  .backdrop {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0, 0, 0, .35);
    z-index: 15;
  }
  .app.menu-open .backdrop { display: block; }

  .main { height: auto; }
  .topbar { padding: 0 16px; height: 64px; position: sticky; top: 64px; z-index: 10; }
  .menu-toggle { display: none; }
  .topbar h1 { font-size: 15px; line-height: 20px; }
  .topbar p  { font-size: 10.5px; line-height: 14px; }

  .content { padding: 16px; gap: 12px; }

  .filter-card { height: auto; padding: 14px; }
  .filter-card h2 { font-size: 14px; line-height: 20px; }
  .search-row { grid-template-columns: 1fr; gap: 10px; margin-top: 10px; }
  .field { height: 34px; }
  .field.search input, .field.select select { font-size: 11px; }

  .table-card { flex: none; border-radius: 12px; }
  .t-head { display: none; }
  .t-body { display: block; overflow: visible; }

  .t-row {
    grid-template-columns: 1fr;
    grid-template-areas:
      "nama"
      "email"
      "telp"
      "jk"
      "school"
      "aksi";
    row-gap: 3px;
    padding: 12px 14px;
    min-height: 0;
    font-size: 11px;
  }
  .t-row:nth-child(10) { border-bottom: 1px solid #ececec; }
  .t-row > div { padding-right: 0; }
  .c-nama   { grid-area: nama; font-weight: 600; font-size: 12px; }
  .c-email  { grid-area: email; color: #555; font-size: 10.5px; word-break: break-all; }
  .c-telp   { grid-area: telp; color: #555; font-size: 10.5px; }
  .c-jk     { grid-area: jk; color: #555; font-size: 10.5px; }
  .c-school { grid-area: school; color: #555; font-size: 10.5px; }
  .t-row .c-aksi { grid-area: aksi; justify-content: flex-start; margin-top: 6px; }
  .btn-hapus { width: 124px; height: 30px; font-size: 12px; }

  .pager { height: auto; padding: 10px; justify-content: center; flex-wrap: wrap; }
}

@media (max-width: 380px) {
  .topbar p { display: none; }
}
@media (min-width: 901px) {
  .backdrop { display: none !important; }
}

/* =========================================================
   POP-UP KONFIRMASI HAPUS
   ========================================================= */
.modal-ov {
  position: fixed; inset: 0; z-index: 100;
  background: rgba(0, 0, 0, .4);
  display: flex; align-items: center; justify-content: center;
  padding: 16px;
}
.modal-ov[hidden] { display: none; }
.modal {
  width: min(100%, 288px);
  background: var(--white);
  border-radius: 32px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, .25);
  padding: 20px 22px 24px;
  text-align: center;
}
.m-icon {
  width: 48px; height: 48px; border-radius: 50%;
  background: #fbdcdd; color: var(--danger);
  margin: 0 auto 14px;
  display: flex; align-items: center; justify-content: center;
}
.m-icon .icon { width: 28px; height: 28px; stroke-width: 1.8; }
.modal h2 { font-size: 16px; font-weight: 500; line-height: 24px; }
.modal p { font-size: 12px; font-weight: 400; color: #444; line-height: 18px; margin-top: 4px; }
.m-actions { display: flex; justify-content: center; gap: 22px; margin-top: 18px; }
.m-btn {
  width: 84px; height: 28px; border: none; border-radius: var(--radius-pill);
  font-size: 12px; font-weight: 500; cursor: pointer;
  box-shadow: 0 2px 4px rgba(0, 0, 0, .22);
  transition: filter .15s;
}
.m-btn:hover { filter: brightness(.96); }
.m-btn.gray { background: #ececec; color: #444; }
.m-btn.red  { background: var(--danger); color: #fff; }

/* Notifikasi singkat setelah akun dihapus */
.toast {
  position: fixed; left: 50%; bottom: 28px; z-index: 110;
  transform: translate(-50%, 20px);
  background: #333; color: #fff;
  font-size: 12px; font-weight: 500;
  padding: 10px 18px; border-radius: var(--radius-pill);
  box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
  opacity: 0; pointer-events: none;
  transition: opacity .25s, transform .25s;
  max-width: calc(100vw - 32px); text-align: center;
}
.toast.show { opacity: 1; transform: translate(-50%, 0); }

/* ===== NAVBAR MOBILE (hamburger menu) - sama seperti beranda-admin ===== */
.mnav { display: none; }
@media (max-width: 900px) {
  .mnav { display: block; position: sticky; top: 0; z-index: 50; }
  .mnav, .mnav * { box-sizing: border-box; }
  .mnav-bar { display: flex; height: 64px; align-items: center; justify-content: space-between; background: #fff; padding: 0 16px; box-shadow: 0 2px 10px rgba(0,0,0,.08); }
  .mnav-bar img { display: block; height: 48px; width: auto; }
  .mnav-btn { display: flex; width: 40px; height: 40px; align-items: center; justify-content: center; border: none; background: none; border-radius: 8px; color: #03045E; cursor: pointer; transition: background .15s; }
  .mnav-btn:hover { background: #f1f5f9; }
  .mnav-btn svg { width: 28px; height: 28px; }
  .mnav-btn #icoClose { display: none; width: 24px; height: 24px; }
  .mnav-btn.open #icoBurger { display: none; }
  .mnav-btn.open #icoClose { display: block; }
  .mnav-menu { position: absolute; left: 0; right: 0; top: 100%; display: none; background: #fff; border-top: 1px solid #f1f5f9; border-radius: 0 0 24px 24px; padding: 12px 16px 16px; box-shadow: 0 12px 20px rgba(0,0,0,.15); }
  .mnav-menu.open { display: block; }
  .mnav-list { display: flex; flex-direction: column; gap: 6px; }
  .mnav-item { display: flex; height: 44px; align-items: center; gap: 12px; border-radius: 12px; padding: 0 14px; font-size: 13px; color: #4B4B4B; text-decoration: none; transition: background .15s; }
  .mnav-item:hover { background: #f1f5f9; }
  .mnav-item.active { background: #E1FAFF; color: #1C1F20; font-weight: 500; }
  .mnav-item svg { width: 18px; height: 18px; flex: none; }
  .mnav-item.active svg { color: #1A1D6E; }
  .mnav-sep { margin: 12px 0; height: 1px; background: #ECEDF2; }
  .mnav-logout { display: flex; height: 44px; width: 100%; align-items: center; justify-content: center; gap: 10px; border: none; border-radius: 12px; background: #D23739; padding: 0 16px; font-family: inherit; font-size: 13px; font-weight: 600; color: #fff; box-shadow: 0 4px 8px rgba(0,0,0,.2); cursor: pointer; }
  .mnav-logout:hover { filter: brightness(1.1); }
  .mnav-logout svg { width: 18px; height: 18px; flex: none; }
}
</style>
</head>

<body>
<script>
  // Guard: wajib login dan khusus role admin. Belum login -> halaman login;
  // role lain -> beranda sesuai role-nya (role kosong dianggap 'user', sama seperti login.html).
  (function () {
    let s = null;
    s = ICONNET_API.read('iconnet_session', null);   // sesi dari server (Laravel)
    if (!s || !s.email) { location.replace('{{ url('login') }}'); return; }
    const role = String(s.role || 'user').toLowerCase().replace(/[\s_]/g, '');
    if (role !== 'admin') { location.replace(role === 'superadmin' ? '{{ url('beranda-superadmin') }}' : role === 'admin' ? '{{ url('beranda-admin') }}' : '{{ url('beranda') }}'); return; }
  })();
</script>

<!-- ===== SPRITE IKON ===== -->
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <defs>
    <symbol id="i-grid" viewBox="0 0 24 24">
      <rect x="3" y="3" width="7.5" height="7.5" rx="2"/>
      <rect x="13.5" y="3" width="7.5" height="7.5" rx="2"/>
      <rect x="3" y="13.5" width="7.5" height="7.5" rx="2"/>
      <rect x="13.5" y="13.5" width="7.5" height="7.5" rx="2"/>
    </symbol>
    <symbol id="i-scan" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20.5c.5-3.6 3-5.8 6.5-5.8 1.6 0 3 .4 4.1 1.2"/><path d="M14.5 19.2l2 2 4-4.5"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24">
      <circle cx="9" cy="8" r="3.5"/>
      <path d="M2.5 20c.4-3.6 3-5.8 6.5-5.8s6.1 2.2 6.5 5.8"/>
      <path d="M15.5 4.7a3.5 3.5 0 010 6.6M18 14.6c2 .8 3.3 2.6 3.5 5.4"/>
    </symbol>
    <symbol id="i-profile" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="9"/>
      <circle cx="12" cy="10" r="3"/>
      <path d="M6.2 18.5c1.2-2.2 3.2-3.3 5.8-3.3s4.6 1.1 5.8 3.3"/>
    </symbol>
    <symbol id="i-logout" viewBox="0 0 24 24">
      <path fill="#fff" stroke="none" d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
      <path fill="#fff" stroke="none" d="M15.5 8.5L20.5 12l-5 3.5v-2.2H9v-2.6h6.5V8.5z"/>
    </symbol>
    <symbol id="i-search" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="6.8"/>
      <path d="M16.2 16.2L20.5 20.5"/>
    </symbol>
    <symbol id="i-chevron-down" viewBox="0 0 24 24">
      <path d="M5.5 9l6.5 6.5L18.5 9"/>
    </symbol>
    <symbol id="i-chevron" viewBox="0 0 24 24">
      <path d="M15 5.5L8.5 12l6.5 6.5"/>
    </symbol>
    <symbol id="i-chevron-right" viewBox="0 0 24 24">
      <path d="M9 5.5l6.5 6.5L9 18.5"/>
    </symbol>
    <symbol id="i-menu" viewBox="0 0 24 24">
      <path d="M4 7h16M4 12h16M4 17h16"/>
    </symbol>
    <symbol id="i-trash" viewBox="0 0 24 24">
      <path d="M4 7h16M9.5 7V4.8c0-.4.3-.8.8-.8h3.4c.5 0 .8.4.8.8V7M6.2 7l.9 12.2c.1.5.5.8 1 .8h7.8c.5 0 .9-.3 1-.8L17.8 7M10 11v5.5M14 11v5.5"/>
    </symbol>
    <symbol id="i-alert" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="9"/>
      <path d="M12 7.5v5.5"/>
      <circle cx="12" cy="16.5" r=".6" fill="currentColor"/>
    </symbol>
  </defs>
</svg>

<!-- ===================== NAVBAR MOBILE (hamburger menu) ===================== -->
<nav id="mnav" class="mnav">
  <div class="mnav-bar">
    <a href="{{ url('beranda-admin') }}"><img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET" /></a>
    <button id="menuBtn" type="button" class="mnav-btn" aria-label="Buka menu" aria-expanded="false">
      <svg id="icoBurger" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
      <svg id="icoClose" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 5l14 14M19 5L5 19"/></svg>
    </button>
  </div>
  <div id="mmenu" class="mnav-menu">
    <div class="mnav-list">
      <a href="{{ url('beranda-admin') }}" class="mnav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"><rect x="3" y="3" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="2"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="2"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="2"/></svg>Beranda</a>
      <a href="{{ url('verifikasi-user') }}" class="mnav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20.5c.5-3.6 3-5.8 6.5-5.8 1.6 0 3 .4 4.1 1.2"/><path d="M14.5 19.2l2 2 4-4.5"/></svg>Verifikasi User</a>
      <a href="{{ url('akun-user') }}" class="mnav-item active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.4-3.6 3-5.8 6.5-5.8s6.1 2.2 6.5 5.8"/><path d="M15.5 4.7a3.5 3.5 0 010 6.6M18 14.6c2 .8 3.3 2.6 3.5 5.4"/></svg>Akun User</a>
      <a href="{{ url('profil-admin') }}" class="mnav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6.2 18.5c1.2-2.2 3.2-3.3 5.8-3.3s4.6 1.1 5.8 3.3"/></svg>Profil</a>
    </div>
    <div class="mnav-sep"></div>
    <button id="logoutBtnM" type="button" class="mnav-logout"><svg viewBox="0 0 24 24" fill="#fff"><path d="M4 4h9a1 1 0 011 1v3h-2V6H6v12h6v-2h2v3a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/><path d="M15.5 8.5L20.5 12l-5 3.5v-2.2H9v-2.6h6.5V8.5z"/></svg>Log Out</button>
  </div>
</nav>

<div class="app" id="app">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <!-- LOGO: taruh file logomu di images/logo-iconin.png (sama dengan beranda-admin.html) -->
      <img src="{{ asset('images/logo-iconin.png') }}" alt="ICONNET">
    </div>

    <button class="collapse-btn" id="collapseBtn" aria-label="Ciutkan sidebar">
      <svg class="icon"><use href="#i-chevron"/></svg>
    </button>

    <nav class="nav">
      <a href="{{ url('beranda-admin') }}" class="nav-item">
        <svg class="icon"><use href="#i-grid"/></svg>
        <span>Beranda</span>
      </a>
      <a href="{{ url('verifikasi-user') }}" class="nav-item">
        <svg class="icon"><use href="#i-scan"/></svg>
        <span>Verifikasi User</span>
      </a>
      <a href="{{ url('akun-user') }}" class="nav-item active">
        <svg class="icon"><use href="#i-users"/></svg>
        <span>Akun User</span>
      </a>
      <a href="{{ url('profil-admin') }}" class="nav-item">
        <svg class="icon"><use href="#i-profile"/></svg>
        <span>Profil</span>
      </a>
    </nav>

    <div class="logout-wrap">
      <button class="logout-btn" id="logoutBtn">
        <svg class="icon"><use href="#i-logout"/></svg>
        <span>Log Out</span>
      </button>
    </div>
  </aside>

  <div class="backdrop" id="backdrop"></div>

  <!-- KONTEN -->
  <div class="main">
    <header class="topbar">
      <button class="menu-toggle" id="menuToggle" aria-label="Buka menu">
        <svg class="icon"><use href="#i-menu"/></svg>
      </button>
      <div>
        <h1>Akun User</h1>
        <p>Menampilkan daftar akun peserta magang serta menyediakan fitur penghapusan akun.</p>
      </div>
    </header>

    <main class="content">

      <!-- Pencarian -->
      <section class="filter-card">
        <h2>Data Akun</h2>
        <div class="search-row">
          <label class="field search">
            <svg class="icon f-icon"><use href="#i-search"/></svg>
            <input type="text" id="searchInput" placeholder="Cari nama atau email" autocomplete="off">
          </label>
          <label class="field select">
            <select id="schoolSelect"><option value="">Nama Sekolah / Institusi</option></select>
            <svg class="icon f-icon"><use href="#i-chevron-down"/></svg>
          </label>
        </div>
      </section>

      <!-- Tabel -->
      <section class="table-card" id="tableCard">
        <div class="t-head">
          <div>Nama User</div>
          <div>Email</div>
          <div>Telepon</div>
          <div>Jenis Kelamin</div>
          <div>Sekolah / Institusi</div>
          <div>Aksi</div>
        </div>
        <div class="t-body" id="tBody"></div>
        <div class="pager" id="pager"></div>
      </section>

    </main>
  </div>
</div>

<!-- POP-UP KONFIRMASI HAPUS -->
<div class="modal-ov" id="modal" hidden>
  <div class="modal" role="alertdialog" aria-modal="true" aria-labelledby="mTitle" aria-describedby="mDesc">
    <div class="m-icon"><svg class="icon"><use href="#i-alert"/></svg></div>
    <h2 id="mTitle">Konfirmasi Hapus Data</h2>
    <p id="mDesc">Yakin ingin menghapus data ini?</p>
    <div class="m-actions">
      <button class="m-btn gray" id="mCancel">Batal</button>
      <button class="m-btn red" id="mConfirm">Hapus</button>
    </div>
  </div>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script src="{{ asset('js/iconnet-data.js') }}"></script>
<script>
/* =========================================================
   DATA: diambil dari iconnet-data.js (sumber data bersama dengan Verifikasi User).
   Halaman ini hanya menampilkan akun yang sudah DISETUJUI di halaman Verifikasi User.
   ========================================================= */
const PAGE_SIZE = 10;   // jumlah baris per halaman (di CSS .t-body juga repeat(10, ...))

/* Bila iconnet-data.js gagal dimuat, pakai data kosong supaya sidebar, menu & logout tetap berfungsi */
const DATA = typeof ICONNET !== 'undefined' ? ICONNET
  : (console.error('iconnet-data.js belum dimuat: daftar akun tidak dapat ditampilkan.'), { getAll: () => [], onChange() {}, deleteAccount() {} });

let peserta = DATA.getAll();

/* Akun aktif = berstatus disetujui (akun yang dihapus otomatis tidak ada lagi di getAll) */
const isActive = p => p.status === 'disetujui';

/* =========================================================
   STATE
   ========================================================= */
const state = { q: '', school: '', page: 1 };

const $ = id => document.getElementById(id);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

/* Dropdown sekolah dari data */
function fillSchools() {
  const sel = $('schoolSelect');
  const keep = sel.value;
  sel.innerHTML = '<option value="">Nama Sekolah / Institusi</option>';
  [...new Set(peserta.filter(isActive).map(p => p.sekolah).filter(Boolean))].sort().forEach(s => {
    const o = document.createElement('option');
    o.value = s; o.textContent = s;
    sel.appendChild(o);
  });
  sel.value = [...sel.options].some(o => o.value === keep) ? keep : '';
  state.school = sel.value;
}

/* =========================================================
   RENDER
   ========================================================= */
function getFiltered() {
  const q = state.q.trim().toLowerCase();
  return peserta.filter(p => {
    if (!isActive(p)) return false;
    if (state.school && p.sekolah !== state.school) return false;
    if (q && !(String(p.nama ?? '').toLowerCase().includes(q) || String(p.email ?? '').toLowerCase().includes(q))) return false;
    return true;
  });
}

function render() {
  const list = getFiltered();
  const totalPages = Math.max(1, Math.ceil(list.length / PAGE_SIZE));
  if (state.page > totalPages) state.page = totalPages;
  const rows = list.slice((state.page - 1) * PAGE_SIZE, state.page * PAGE_SIZE);

  $('tBody').innerHTML = rows.length
    ? rows.map(p => `
      <div class="t-row">
        <div class="c-nama">${esc(p.nama)}</div>
        <div class="c-email">${esc(p.email)}</div>
        <div class="c-telp">${esc(p.telepon)}</div>
        <div class="c-jk">${esc(p.jk)}</div>
        <div class="c-school">${esc(p.sekolah)}</div>
        <div class="c-aksi">
          <button class="btn-hapus" data-id="${esc(p.id)}">
            <svg class="icon"><use href="#i-trash"/></svg> Hapus Akun
          </button>
        </div>
      </div>`).join('')
    : `<div class="empty">Data akun tidak ditemukan.</div>`;

  /* pagination */
  let nums = '';
  for (let i = 1; i <= totalPages; i++) {
    nums += `<button class="pg-num ${i === state.page ? 'active' : ''}" data-page="${i}">${i}</button>`;
  }
  $('pager').innerHTML = `
    <button class="pg-nav" data-nav="-1" ${state.page === 1 ? 'disabled' : ''}>
      <svg class="icon"><use href="#i-chevron"/></svg> Sebelumnya
    </button>
    ${nums}
    <button class="pg-nav" data-nav="1" ${state.page === totalPages ? 'disabled' : ''}>
      Selanjutnya <svg class="icon"><use href="#i-chevron-right"/></svg>
    </button>`;
}

/* =========================================================
   EVENT
   ========================================================= */
$('searchInput').addEventListener('input', e => { state.q = e.target.value; state.page = 1; render(); });
$('schoolSelect').addEventListener('change', e => { state.school = e.target.value; state.page = 1; render(); });

$('pager').addEventListener('click', e => {
  const num = e.target.closest('.pg-num');
  const nav = e.target.closest('.pg-nav');
  if (num) state.page = Number(num.dataset.page);
  else if (nav && !nav.disabled) state.page += Number(nav.dataset.nav);
  else return;
  render();
});

/* Sidebar (status ciut dibagi dengan halaman lain lewat localStorage 'iconnet_sidebar') */
const app = $('app');
try { if (localStorage.getItem('iconnet_sidebar') === '1') app.classList.add('collapsed'); } catch (e) {}
$('collapseBtn').addEventListener('click', () => {
  const c = app.classList.toggle('collapsed');
  try { localStorage.setItem('iconnet_sidebar', c ? '1' : '0'); } catch (e) {}
});
$('menuToggle').addEventListener('click', () => app.classList.add('menu-open'));
$('backdrop').addEventListener('click', () => app.classList.remove('menu-open'));
$('logoutBtn').addEventListener('click', () => {
  if (!confirm('Yakin ingin keluar dari akun?')) return;
  sessionStorage.removeItem('loginSuccess');
  ICONNET_API.logout();   // logout di server, lalu ke halaman login
});

/* =========================================================
   POP-UP KONFIRMASI HAPUS AKUN
   ========================================================= */
const modal = $('modal');
let target = null, lastTrigger = null, toastTimer = null;

function openConfirm(id, trigger) {
  target = peserta.find(x => String(x.id) === String(id));   // data-id selalu string, id di data bisa angka
  if (!target) return;
  lastTrigger = trigger || null;
  modal.hidden = false;
  $('mCancel').focus();
}
function closeConfirm() {
  modal.hidden = true;
  target = null;
  if (lastTrigger && document.body.contains(lastTrigger)) lastTrigger.focus();
}
function showToast(msg) {
  const t = $('toast');
  t.textContent = msg;
  t.classList.add('show');
  clearTimeout(toastTimer);
  toastTimer = setTimeout(() => t.classList.remove('show'), 2500);
}

$('tBody').addEventListener('click', e => {
  const btn = e.target.closest('.btn-hapus');
  if (!btn) return;
  openConfirm(btn.dataset.id, btn);
});

$('mCancel').addEventListener('click', closeConfirm);
$('mConfirm').addEventListener('click', () => {
  if (!target) return;
  const nama = target.nama;
  /* Ganti dengan panggilan ke backend (DELETE /api/users/:id) bila sudah ada API */
  DATA.deleteAccount(target.email);   // hapus dari semua halaman (Verifikasi User & Beranda ikut berubah)
  lastTrigger = null;
  closeConfirm();
  fillSchools();
  render();
  showToast('Akun ' + nama + ' berhasil dihapus');
});
modal.addEventListener('click', e => { if (e.target === modal) closeConfirm(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.hidden) closeConfirm(); });

/* Muat ulang data bila berubah (disetujui di Verifikasi User, tab lain, dll.) */
function refreshData() {
  peserta = DATA.getAll();
  fillSchools();
  render();
}
DATA.onChange(refreshData);

fillSchools();
render();
</script>
<script>
/* Hamburger menu (mobile) - sama seperti beranda-admin */
(function () {
  var mmenu = document.getElementById('mmenu'), menuBtn = document.getElementById('menuBtn');
  function setMenu(open) {
    mmenu.classList.toggle('open', open);
    menuBtn.classList.toggle('open', open);
    menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
  }
  menuBtn.addEventListener('click', function () { setMenu(!mmenu.classList.contains('open')); });
  document.addEventListener('click', function (e) { if (!document.getElementById('mnav').contains(e.target)) setMenu(false); });
  window.matchMedia('(min-width:901px)').addEventListener('change', function () { setMenu(false); });
  document.getElementById('logoutBtnM').addEventListener('click', function () { document.getElementById('logoutBtn').click(); });
})();
</script>
</body>
</html>
