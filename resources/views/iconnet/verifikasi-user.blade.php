<!DOCTYPE html>
<html lang="id">
<head>
  @include('iconnet.partials.server')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi User - ICONNET</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root {
  /* Satuan sidebar: sama dengan beranda-admin.html (frame desain 1110 x 790).
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

/* Area logo 47 + jarak 19 sebelum garis pemisah */
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

/* ---------------- KARTU FILTER ---------------- */
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

.filters { display: flex; gap: 22px; margin-top: 15px; flex-wrap: wrap; }
.f-btn {
  height: var(--ctrl-h);
  border: 1px solid #dcdce5;
  border-radius: var(--radius-sm);
  background: var(--white);
  color: #333;
  font-size: 11.5px;
  font-weight: 500;
  line-height: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  padding: 0 16px;
  cursor: pointer;
  white-space: nowrap;
  box-shadow: 0 1px 3px rgba(0, 0, 0, .22);
  transition: background .15s, color .15s, border-color .15s;
}
.f-btn .icon { width: 14px; height: 14px; stroke-width: 1.5; }
.f-btn:hover { border-color: var(--filter-active); }
.f-btn.active { background: var(--filter-active); border-color: var(--filter-active); color: #fff; }

/* ---------------- PENCARIAN ---------------- */
.search-row { display: grid; grid-template-columns: 1fr 1fr; gap: 36px; flex-shrink: 0; }
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

/* Normal: Nama | Email | Telepon | Sekolah | Status | Aksi */
.cols-6 .t-head, .cols-6 .t-row {
  grid-template-columns: 150fr 130fr 104fr 90fr 140fr 134fr 110fr;
  padding: 0 13px 0 30px;
}
/* Filter "Ditolak": Nama | Email | Telepon | Sekolah | Alasan | Status | Aksi */
.cols-7 .t-head, .cols-7 .t-row {
  grid-template-columns: 118fr 116fr 98fr 84fr 140fr 114fr 100fr 101fr;
  padding: 0 4px 0 14px;
}

.t-head {
  height: 36px;
  background: var(--table-head);
  color: #fff;
  font-size: 12px;
  font-weight: 500;
  flex-shrink: 0;
}
.t-head .center, .t-row .center { text-align: center; justify-self: center; }
@media (min-width: 901px) {
  /* Semua kolom center dengan lebar sama rata; kolom Status & Aksi diberi lebar minimum supaya badge/tombol tidak mengecil */
  .cols-6 .t-head, .cols-6 .t-row {
    grid-template-columns: repeat(5, minmax(0, 1fr)) minmax(140px, 1fr) minmax(104px, 1fr);
    padding: 0 16px;
  }
  .cols-7 .t-head, .cols-7 .t-row {
    grid-template-columns: repeat(6, minmax(0, 1fr)) minmax(140px, 1fr) minmax(104px, 1fr);
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
/* Baris ke-10 (terakhir) tanpa garis sendiri: garis penutupnya sudah dari batas pagination, jadi tidak dobel */
.t-row:nth-child(10) { border-bottom: none; }
.t-row > div { min-width: 0; padding-right: 8px; }
.t-row .c-reason { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.t-row .c-status, .t-row .c-aksi { padding-right: 0; display: flex; justify-content: center; }

.pill {
  display: inline-flex; align-items: center; justify-content: center;
  height: 24px; width: 132px; max-width: 100%;
  border-radius: var(--radius-pill);
  padding: 0 8px;
  font-size: 10.5px; font-weight: 500;
  white-space: nowrap;
}
.pill.menunggu  { background: #fce6c2; color: #92400e; }
.pill.disetujui { background: #bdfbbd; color: #1f8a2f; }
.pill.ditolak   { background: #f6c5c9; color: #8f1117; }

/* Tombol Lihat */
.btn-lihat {
  display: inline-flex; align-items: center; justify-content: center;
  gap: 7px;
  height: 24px; width: 94px; max-width: 100%;
  border: 1px solid #e6e8ea; border-radius: var(--radius-sm);
  background: #f3f4f6; color: #000;
  font-size: 11px; font-weight: 500;
  text-decoration: none; white-space: nowrap;
  cursor: pointer;
  box-shadow: 0 2px 3px rgba(0, 0, 0, .18);
  transition: background .15s;
}
.btn-lihat:hover { background: #e9ebee; }
.btn-lihat .icon { width: 14px; height: 14px; stroke-width: 2; }

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
  .filters { margin-top: 10px; }
  .f-btn { height: 30px; }
  .field { height: 30px; }
}
@media (min-width: 901px) and (max-height: 620px) {
  :root { --row-min: 32px; }
  .topbar { height: 58px; }
  .content { padding-top: 10px; padding-bottom: 12px; gap: 10px; }
  .filter-card { height: 80px; padding-top: 8px; }
  .filter-card h2 { font-size: 16px; line-height: 22px; }
  .filters { margin-top: 8px; }
  .f-btn { height: 28px; font-size: 11px; }
  .field { height: 28px; }
  .t-head { height: 30px; }
  .pager { height: 32px; }
  .pill { height: 22px; font-size: 10px; }
  .btn-lihat { height: 22px; font-size: 10.5px; }
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
  .filters { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
  .f-btn { font-size: 11px; height: 32px; padding: 0 14px; gap: 9px; }
  .f-btn .icon { width: 14px; height: 14px; }

  .search-row { grid-template-columns: 1fr; gap: 10px; }
  .field { height: 34px; }
  .field.search input, .field.select select { font-size: 11px; }

  .table-card { flex: none; border-radius: 12px; }
  .t-head { display: none; }
  .t-body { display: block; overflow: visible; }

  .t-row, .cols-6 .t-row, .cols-7 .t-row {
    grid-template-columns: 1fr auto;
    grid-template-areas:
      "nama status"
      "email email"
      "telp telp"
      "jk jk"
      "school school"
      "reason reason"
      "aksi aksi";
    row-gap: 3px; column-gap: 10px;
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
  .c-reason { grid-area: reason; color: #8f1117; font-size: 10.5px; white-space: normal !important; }
  .c-reason::before { content: 'Alasan: '; font-weight: 500; }
  .t-row .c-status { grid-area: status; justify-content: flex-end; }
  .t-row .c-aksi { grid-area: aksi; justify-content: flex-start; margin-top: 6px; }
  .pill, .cols-7 .pill { width: auto; padding: 0 12px; height: 28px; font-size: 10px; }
  .btn-lihat, .cols-7 .btn-lihat { width: 100px; height: 28px; font-size: 11px; gap: 7px; }
  .cols-7 .btn-lihat .icon { width: 14px; height: 14px; }

  .pager { height: auto; padding: 10px; justify-content: center; flex-wrap: wrap; }
}

@media (max-width: 380px) {
  .topbar p { display: none; }
}
@media (min-width: 901px) {
  .backdrop { display: none !important; }
}

/* =========================================================
   POP-UP PERIKSA DATA
   ========================================================= */
.modal-ov {
  position: fixed; inset: 0; z-index: 100;
  background: rgba(0, 0, 0, .4);
  display: flex; align-items: center; justify-content: center;
  padding: 16px;
}
.modal-ov[hidden] { display: none; }
.modal {
  width: min(100%, 500px);
  max-height: calc(100dvh - 32px);
  overflow-y: auto;
  background: var(--white);
  border-radius: 32px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, .25);
  padding: 22px 20px 22px;
}
.m-head { display: flex; align-items: center; gap: 14px; padding: 0 4px; margin-bottom: 18px; }
.m-back {
  width: 30px; height: 30px; border: none; background: none; cursor: pointer;
  color: #111; border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
}
.m-back:hover { background: #f1f2f6; }
.m-back .icon { width: 24px; height: 24px; stroke-width: 1.5; }
.m-head h2 { font-size: 18px; font-weight: 500; line-height: 26px; }

.m-profile {
  display: flex; align-items: center; gap: 14px;
  padding: 14px 22px;
  background: #f6f6fd; border: 1px solid #cfcfdc; border-radius: 20px;
  margin-bottom: 16px;
}
.m-avatar {
  width: 52px; height: 52px; border-radius: 50%; background: var(--white);
  color: #8a8a8a; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
}
.m-avatar .icon { width: 36px; height: 36px; }
.m-name { font-size: 15px; font-weight: 600; line-height: 22px; margin-bottom: 4px; }
.m-profile .pill { width: auto; padding: 0 14px; }

.m-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px 24px; margin-bottom: 20px; }
.m-info {
  display: grid; grid-template-columns: 18px 1fr; column-gap: 12px; align-items: start;
  padding: 10px 14px; min-height: 56px;
  background: #f6f6fd; border: 1px solid #cfcfdc; border-radius: var(--radius-sm);
}
.m-info .icon { width: 17px; height: 17px; color: var(--navy); stroke-width: 1.8; margin-top: 1px; }
.m-info-l { font-size: 12px; font-weight: 600; line-height: 18px; }
.m-info-v { font-size: 12px; line-height: 18px; word-break: break-word; }

.m-actions { display: flex; justify-content: center; gap: 24px; flex-wrap: wrap; }
.m-btn {
  flex: 0 1 176px; min-width: 130px; height: 30px; padding: 0 20px;
  border: none; border-radius: var(--radius-pill);
  color: #fff; font-size: 11px; font-weight: 500;
  display: inline-flex; align-items: center; justify-content: center;
  cursor: pointer; box-shadow: 0 2px 4px rgba(0, 0, 0, .25);
  transition: filter .15s;
}
.m-btn:hover { filter: brightness(1.08); }
.m-btn.blue { background: #1c5fa7; }
.m-btn.red  { background: #d23739; }
.m-btn.gray { background: #ececec; color: #555; font-size: 13px; flex: 0 0 auto; min-width: 92px; box-shadow: 0 2px 3px rgba(0, 0, 0, .18); }

.m-note {
  background: #f8f8f8; border: 1px solid #ececec; border-radius: 14px;
  padding: 12px 12px 14px; margin-bottom: 18px;
}
.m-note label { display: block; font-size: 12px; font-weight: 600; margin-bottom: 8px; }
.m-note label small { font-size: 10px; font-weight: 400; color: #d23739; margin-left: 4px; }
.m-note textarea {
  display: block; width: 100%; height: 88px; resize: none; outline: none;
  background: var(--white); border: 1px solid #dcdce5; border-radius: 10px;
  padding: 10px 12px; font-size: 11.5px; color: var(--text);
}
.m-note textarea::placeholder { color: #aaa; opacity: 1; }
.m-note textarea:focus { border-color: var(--filter-active); }
.m-err { display: none; color: #d23739; font-size: 10.5px; margin-top: 6px; }
.m-note.has-err .m-err { display: block; }
.m-note.has-err textarea { border-color: #d23739; }

.m-result {
  display: flex; flex-direction: column; align-items: center; gap: 4px; text-align: center;
  padding: 18px 16px; border-radius: 12px; margin-bottom: 18px; font-size: 11px; line-height: 17px;
}
.m-result strong { font-weight: 600; }
.m-result.ok { background: #ddfadd; border: 1px solid #bdecbd; color: #1f8a2f; }
.m-result.no { background: #fdecee; border: 1px solid #f3c3c8; color: #8f1117; }
.m-check {
  width: 28px; height: 28px; border-radius: 50%; margin-bottom: 4px;
  background: #1f8a2f; color: #fff;
  display: flex; align-items: center; justify-content: center;
}
.m-result.no .m-check { background: #c4262c; }
.m-check .icon { width: 15px; height: 15px; stroke-width: 3; }
.m-result .m-reason { word-break: break-word; }
.m-foot { display: flex; justify-content: center; }

@media (max-width: 480px) {
  .modal { border-radius: 24px; padding: 18px 14px 18px; }
  .m-grid { grid-template-columns: 1fr; gap: 10px; }
  .m-profile { padding: 12px 16px; }
}

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
    <symbol id="i-clock" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="9"/>
      <path d="M12 6.8V12l3.4 2.2"/>
    </symbol>
    <symbol id="i-check" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="9"/>
      <path d="M8 12.4l2.9 2.9L16.2 9.6"/>
    </symbol>
    <symbol id="i-x" viewBox="0 0 24 24">
      <circle cx="12" cy="12" r="9"/>
      <path d="M9 9l6 6M15 9l-6 6"/>
    </symbol>
    <symbol id="i-group" viewBox="0 0 24 24">
      <circle cx="12" cy="7" r="2.6"/>
      <path d="M7.5 16.5c.7-2.3 2.2-3.4 4.5-3.4s3.8 1.1 4.5 3.4"/>
      <circle cx="4.8" cy="9.2" r="2"/>
      <path d="M1.5 17c.4-1.8 1.4-2.7 3.2-2.9"/>
      <circle cx="19.2" cy="9.2" r="2"/>
      <path d="M22.5 17c-.4-1.8-1.4-2.7-3.2-2.9"/>
    </symbol>
    <symbol id="i-search" viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="6.8"/>
      <path d="M16.2 16.2L20.5 20.5"/>
    </symbol>
    <symbol id="i-chevron-down" viewBox="0 0 24 24">
      <path d="M5.5 9l6.5 6.5L18.5 9"/>
    </symbol>
    <symbol id="i-eye" viewBox="0 0 24 24">
      <path d="M2 12s3.6-6.5 10-6.5S22 12 22 12s-3.6 6.5-10 6.5S2 12 2 12z"/>
      <circle cx="12" cy="12" r="3"/>
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
    <symbol id="i-arrow-left" viewBox="0 0 24 24">
      <path d="M19.5 12h-15M10.5 6l-6 6 6 6"/>
    </symbol>
    <symbol id="i-mail" viewBox="0 0 24 24">
      <rect x="3" y="5" width="18" height="14" rx="2.5"/>
      <path d="M3.5 7.5L12 13.5l8.5-6"/>
    </symbol>
    <symbol id="i-building" viewBox="0 0 24 24">
      <rect x="4" y="3" width="11" height="18" rx="1.5"/>
      <path d="M15 9h4a1 1 0 011 1v11h-5M7.5 7.5h4M7.5 11h4M7.5 14.5h4M9 21v-3"/>
    </symbol>
    <symbol id="i-idcard" viewBox="0 0 24 24">
      <rect x="2.5" y="5" width="19" height="14" rx="2.5"/>
      <circle cx="8.5" cy="11" r="1.8"/>
      <path d="M5.8 16c.4-1.5 1.5-2.2 2.7-2.2s2.3.7 2.7 2.2M14 10h4.5M14 13.5h4.5"/>
    </symbol>
    <symbol id="i-phone" viewBox="0 0 24 24">
      <path d="M6.6 3.5h2.7l1.5 4-2 1.4a11 11 0 005.3 5.3l1.4-2 4 1.5v2.7a2 2 0 01-2.2 2A15.5 15.5 0 014.6 5.7a2 2 0 012-2.2z"/>
    </symbol>
    <symbol id="i-person-fill" viewBox="0 0 24 24">
      <circle cx="12" cy="8.5" r="4.2" fill="currentColor" stroke="none"/>
      <path d="M3.5 21c.6-4.6 4-7 8.5-7s7.9 2.4 8.5 7z" fill="currentColor" stroke="none"/>
    </symbol>
    <symbol id="i-tick" viewBox="0 0 24 24">
      <path d="M5.5 12.5l4.5 4.5 8.5-9.5"/>
    </symbol>
    <symbol id="i-cross" viewBox="0 0 24 24">
      <path d="M6.5 6.5l11 11M17.5 6.5l-11 11"/>
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
      <a href="{{ url('verifikasi-user') }}" class="mnav-item active"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20.5c.5-3.6 3-5.8 6.5-5.8 1.6 0 3 .4 4.1 1.2"/><path d="M14.5 19.2l2 2 4-4.5"/></svg>Verifikasi User</a>
      <a href="{{ url('akun-user') }}" class="mnav-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.4-3.6 3-5.8 6.5-5.8s6.1 2.2 6.5 5.8"/><path d="M15.5 4.7a3.5 3.5 0 010 6.6M18 14.6c2 .8 3.3 2.6 3.5 5.4"/></svg>Akun User</a>
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
      <a href="{{ url('verifikasi-user') }}" class="nav-item active">
        <svg class="icon"><use href="#i-scan"/></svg>
        <span>Verifikasi User</span>
      </a>
      <a href="{{ url('akun-user') }}" class="nav-item">
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
        <h1>Verifikasi User</h1>
        <p>Kelola dan verifikasi akun pengguna baru.</p>
      </div>
    </header>

    <main class="content">

      <!-- Filter status -->
      <section class="filter-card">
        <h2>Daftar User</h2>
        <div class="filters" id="filters">
          <button class="f-btn f-menunggu" data-status="menunggu">
            <svg class="icon"><use href="#i-clock"/></svg><span>Menunggu Verifikasi</span>
          </button>
          <button class="f-btn f-disetujui" data-status="disetujui">
            <svg class="icon"><use href="#i-check"/></svg><span>Disetujui</span>
          </button>
          <button class="f-btn f-ditolak" data-status="ditolak">
            <svg class="icon"><use href="#i-x"/></svg><span>Ditolak</span>
          </button>
          <button class="f-btn f-semua" data-status="semua">
            <svg class="icon"><use href="#i-group"/></svg><span>Semua peserta</span>
          </button>
        </div>
      </section>

      <!-- Pencarian -->
      <section class="search-row">
        <label class="field search">
          <svg class="icon f-icon"><use href="#i-search"/></svg>
          <input type="text" id="searchInput" placeholder="Cari nama atau email" autocomplete="off">
        </label>
        <label class="field select">
          <select id="schoolSelect"><option value="">Nama Sekolah / Institusi</option></select>
          <svg class="icon f-icon"><use href="#i-chevron-down"/></svg>
        </label>
      </section>

      <!-- Tabel -->
      <section class="table-card cols-6" id="tableCard">
        <div class="t-head" id="tHead"></div>
        <div class="t-body" id="tBody"></div>
        <div class="pager" id="pager"></div>
      </section>

    </main>
  </div>
</div>

<!-- POP-UP PERIKSA DATA -->
<div class="modal-ov" id="modal" hidden>
  <div class="modal" role="dialog" aria-modal="true" aria-labelledby="mTitle">
    <div class="m-head">
      <button class="m-back" id="mBack" aria-label="Kembali">
        <svg class="icon"><use href="#i-arrow-left"/></svg>
      </button>
      <h2 id="mTitle">Periksa Data</h2>
    </div>
    <div id="mBody"></div>
  </div>
</div>

<script src="{{ asset('js/iconnet-data.js') }}"></script>
<script>
/* =========================================================
   DATA: diambil dari iconnet-data.js (sumber data bersama).
   Akun yang baru sign up otomatis muncul di sini dengan status 'menunggu'.
   status: 'menunggu' | 'disetujui' | 'ditolak'
   ========================================================= */
const PAGE_SIZE = 10;   // jumlah baris per halaman (di CSS .t-body juga repeat(10, ...))

let peserta = ICONNET.getAll();

const STATUS_LABEL = { menunggu: 'Menunggu Verifikasi', disetujui: 'Disetujui', ditolak: 'Tolak' };

/* =========================================================
   STATE
   ========================================================= */
const state = { status: null, q: '', school: '', page: 1 };

const $ = id => document.getElementById(id);
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

/* Dropdown sekolah dari data */
function fillSchools() {
  const sel = $('schoolSelect');
  const keep = sel.value;
  sel.innerHTML = '<option value="">Nama Sekolah / Institusi</option>';
  [...new Set(peserta.map(p => p.sekolah).filter(Boolean))].sort().forEach(s => {
    const o = document.createElement('option');
    o.value = s; o.textContent = s;
    sel.appendChild(o);
  });
  sel.value = [...sel.options].some(o => o.value === keep) ? keep : '';
  state.school = sel.value;
}
fillSchools();

/* Filter awal dari URL, contoh: verifikasi-user.html?status=ditolak */
const initial = new URLSearchParams(location.search).get('status');
if (['menunggu', 'disetujui', 'ditolak', 'semua'].includes(initial)) state.status = initial;

/* =========================================================
   RENDER
   ========================================================= */
function getFiltered() {
  const q = state.q.trim().toLowerCase();
  return peserta.filter(p => {
    if (state.status && state.status !== 'semua' && p.status !== state.status) return false;
    if (state.school && p.sekolah !== state.school) return false;
    if (q && !(String(p.nama ?? '').toLowerCase().includes(q) || String(p.email ?? '').toLowerCase().includes(q))) return false;
    return true;
  });
}

function render() {
  const list = getFiltered();
  const showReason = state.status === 'ditolak';
  const totalPages = Math.max(1, Math.ceil(list.length / PAGE_SIZE));
  if (state.page > totalPages) state.page = totalPages;
  const rows = list.slice((state.page - 1) * PAGE_SIZE, state.page * PAGE_SIZE);

  /* tombol filter aktif */
  document.querySelectorAll('.f-btn').forEach(b =>
    b.classList.toggle('active', b.dataset.status === state.status));

  /* header tabel */
  const card = $('tableCard');
  card.classList.toggle('cols-7', showReason);
  card.classList.toggle('cols-6', !showReason);
  $('tHead').innerHTML = showReason
    ? `<div>Nama</div><div>Email</div><div>Telepon</div><div>Jenis Kelamin</div><div>Asal Sekolah</div><div>Alasan penolakan</div><div class="center">Status</div><div class="center">Aksi</div>`
    : `<div>Nama</div><div>Email</div><div>Telepon</div><div>Jenis Kelamin</div><div>Sekolah / Institusi</div><div class="center">Status</div><div class="center">Aksi</div>`;

  /* baris */
  $('tBody').innerHTML = rows.length
    ? rows.map(p => `
      <div class="t-row">
        <div class="c-nama">${esc(p.nama)}</div>
        <div class="c-email">${esc(p.email)}</div>
        <div class="c-telp">${esc(p.telepon)}</div>
        <div class="c-jk">${esc(p.jk)}</div>
        <div class="c-school">${esc(p.sekolah)}</div>
        ${showReason ? `<div class="c-reason" title="${esc(p.alasan)}">${esc(p.alasan)}</div>` : ''}
        <div class="c-status"><span class="pill ${p.status}">${STATUS_LABEL[p.status]}</span></div>
        <div class="c-aksi">
          <a class="btn-lihat" href="#" data-id="${esc(p.id)}">
            <svg class="icon"><use href="#i-eye"/></svg> Lihat
          </a>
        </div>
      </div>`).join('')
    : `<div class="empty">Data peserta tidak ditemukan.</div>`;

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
$('filters').addEventListener('click', e => {
  const btn = e.target.closest('.f-btn');
  if (!btn) return;
  state.status = state.status === btn.dataset.status ? null : btn.dataset.status; // klik lagi = batal filter
  state.page = 1;
  render();
});

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

/* Sidebar (status ciut dibagi dengan halaman Beranda lewat localStorage 'iconnet_sidebar') */
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
   POP-UP PERIKSA DATA
   step: 'detail' (lihat data / setujui / tolak) | 'tolak' (form alasan)
   ========================================================= */
const modal = $('modal'), mBody = $('mBody');
let cur = null, step = 'detail', lastTrigger = null;

const infoCard = (icon, label, val) => `
  <div class="m-info">
    <svg class="icon"><use href="#${icon}"/></svg>
    <div><div class="m-info-l">${label}</div><div class="m-info-v">${esc(val || '-')}</div></div>
  </div>`;

function renderModal() {
  const p = cur;
  let foot = '';

  if (step === 'tolak') {
    foot = `
      <div class="m-note" id="mNote">
        <label for="mReason">Catatan Penolakan <small>*(Wajib diisi)</small></label>
        <textarea id="mReason" maxlength="300" placeholder="Tuliskan penolakan secara jelas"></textarea>
        <div class="m-err">Alasan penolakan wajib diisi.</div>
      </div>
      <div class="m-foot"><button class="m-btn red" data-act="kirim">Kirim Penolakan</button></div>`;
  } else if (p.status === 'menunggu') {
    foot = `
      <div class="m-actions">
        <button class="m-btn blue" data-act="setuju">Setujui Akun</button>
        <button class="m-btn red" data-act="tolak">Tolak Akun</button>
      </div>`;
  } else if (p.status === 'disetujui') {
    foot = `
      <div class="m-result ok">
        <span class="m-check"><svg class="icon"><use href="#i-tick"/></svg></span>
        <strong>Akun Peserta Berhasil Disetujui</strong>
        <span>Peserta telah terverifikasi resmi dan dapat melakukan aktivitas presensi</span>
      </div>
      <div class="m-foot"><button class="m-btn gray" data-act="tutup">Tutup</button></div>`;
  } else {
    foot = `
      <div class="m-result no">
        <span class="m-check"><svg class="icon"><use href="#i-cross"/></svg></span>
        <strong>Akun Peserta Ditolak</strong>
        <span class="m-reason">Alasan: ${esc(p.alasan || '-')}</span>
      </div>
      <div class="m-foot"><button class="m-btn gray" data-act="tutup">Tutup</button></div>`;
  }

  mBody.innerHTML = `
    <div class="m-profile">
      <div class="m-avatar"><svg class="icon"><use href="#i-person-fill"/></svg></div>
      <div>
        <div class="m-name">${esc(p.nama)}</div>
        <span class="pill ${p.status}">${STATUS_LABEL[p.status]}</span>
      </div>
    </div>
    <div class="m-grid">
      ${infoCard('i-mail', 'Email', p.email)}
      ${infoCard('i-building', 'Nama Sekolah', p.sekolah)}
      ${infoCard('i-idcard', 'Jenis Kelamin', p.jk)}
      ${infoCard('i-phone', 'Telepon', p.telepon)}
    </div>
    ${foot}`;

  if (step === 'tolak') $('mReason').focus();
}

function openModal(id, trigger) {
  cur = peserta.find(x => x.id === id);
  if (!cur) return;
  step = 'detail';
  lastTrigger = trigger || null;
  renderModal();
  modal.hidden = false;
  $('mBack').focus();
}
function closeModal() {
  modal.hidden = true;
  cur = null;
  if (lastTrigger) lastTrigger.focus();
}

$('tBody').addEventListener('click', e => {
  const a = e.target.closest('.btn-lihat');
  if (!a) return;
  e.preventDefault();
  openModal(a.dataset.id, a);
});

mBody.addEventListener('click', e => {
  const btn = e.target.closest('[data-act]');
  if (!btn || !cur) return;
  const act = btn.dataset.act;

  if (act === 'setuju') {
    cur.status = 'disetujui';
    cur.alasan = undefined;
    ICONNET.saveDecision(cur.email, 'disetujui', '');   // -> pindah ke Akun User & update Beranda
    renderModal();
    render();
  } else if (act === 'tolak') {
    step = 'tolak';
    renderModal();
  } else if (act === 'kirim') {
    const ta = $('mReason');
    const val = ta.value.trim();
    if (!val) {
      $('mNote').classList.add('has-err');
      ta.focus();
      return;
    }
    cur.status = 'ditolak';
    cur.alasan = val;
    ICONNET.saveDecision(cur.email, 'ditolak', val);    // -> update Beranda
    closeModal();
    render();
  } else if (act === 'tutup') {
    closeModal();
  }
});

mBody.addEventListener('input', e => {
  if (e.target.id === 'mReason' && e.target.value.trim()) $('mNote').classList.remove('has-err');
});

$('mBack').addEventListener('click', () => {
  if (step === 'tolak') { step = 'detail'; renderModal(); }
  else closeModal();
});
modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
document.addEventListener('keydown', e => { if (e.key === 'Escape' && !modal.hidden) closeModal(); });

/* Muat ulang data bila berubah (sign up baru, tab lain, dll.) */
function refreshData() {
  peserta = ICONNET.getAll();
  if (cur) cur = peserta.find(x => x.id === cur.id) || cur;
  fillSchools();
  render();
}
ICONNET.onChange(refreshData);

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
