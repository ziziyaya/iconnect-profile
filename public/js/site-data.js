/* =========================================================================
   site-data.js  -  SATU SUMBER DATA untuk halaman publik & halaman admin
   -------------------------------------------------------------------------
   Dipakai oleh: index.html, keseruan.html, keseruan-detail.html, kelola-beranda.html
   Wajib dimuat SETELAH articles.js:
     <script src="articles.js"></script>
     <script src="site-data.js"></script>

   Alur relasi:
     kelola-beranda.html  --(simpan ke localStorage)-->  index / keseruan / keseruan-detail
       'iconnet_banner'    -> carousel banner di index.html
       'iconnet_kegiatan'  -> kartu "Keseruan Bersama" (index), daftar (keseruan), detail

   VERSI LARAVEL: data dibaca dari database (dikirim server lewat iconnet-api.js,
   key & bentuk data sama dengan key localStorage lama). Perubahan dari halaman
   Kelola disimpan ke database lewat API, jadi semua pengunjung melihat data yang sama.
   Data awal (default*) di bawah hanya dipakai bila halaman dibuka tanpa server.
   ========================================================================= */
(function (global) {
  'use strict';

  var KEY_BANNER = 'iconnet_banner';
  var KEY_KEGIATAN = 'iconnet_kegiatan';
  var KEY_KEGIATAN_VER = 'iconnet_kegiatan_ver';
  var KEY_TENTANG = 'iconnet_tentang_kami';
  var KEY_PAKET = 'iconnet_paket_harga';
  var KEY_HUBUNGI = 'iconnet_hubungi_kami';

  /* ---------- util ---------- */
  function fromServer(key) { return !!(global.ICONNET_API && global.ICONNET_API.has(key)); }
  function read(key, fallback) {
    if (global.ICONNET_API) return global.ICONNET_API.read(key, fallback);
    return fallback;
  }
  function esc(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }
  function todayLocal() {
    var d = new Date();
    return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
  }
  function baseName(path) {
    try { return decodeURIComponent(String(path).split('/').pop()); } catch (e) { return String(path).split('/').pop(); }
  }
  // articles.js memakai `const ARTICLES` (tidak masuk ke window), jadi dibaca lewat nama global langsung.
  function baseArticles() { return (typeof ARTICLES !== 'undefined' && Array.isArray(ARTICLES)) ? ARTICLES : []; }

  /* Format tanggal: pakai helper dari articles.js bila ada, jika tidak pakai cadangan. */
  var BULAN = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  function parseISO(iso) { var m = /^(\d{4})-(\d{2})-(\d{2})/.exec(String(iso || '')); return m ? { y: +m[1], m: +m[2], d: +m[3] } : null; }
  function dateLabel(iso) {            // contoh: 3 Jan, 2026
    if (typeof global.formatDateLabel === 'function') return global.formatDateLabel(iso);
    var p = parseISO(iso); return p ? p.d + ' ' + BULAN[p.m - 1] + ', ' + p.y : '';
  }
  function dateNumeric(iso) {          // contoh: 03-01-2026
    if (typeof global.formatDateNumeric === 'function') return global.formatDateNumeric(iso);
    var p = parseISO(iso); return p ? String(p.d).padStart(2, '0') + '-' + String(p.m).padStart(2, '0') + '-' + p.y : '';
  }

  /* =======================================================================
     BANNER
     ======================================================================= */
  var DESK = 'jaringan 100% Full Fiber Optic terhubung langsung ke infrastruktur ketenagalistrikan andal PLN. kuota tanpa batas, kecepatan simetris, dan jangkauan luas se-indonesia.';
  var JUDUL = 'Solusi Digital & internet Andal Tanpa Batas Dari ICONNET';

  function defaultBanners() {
    return [
      { id: 1, jenis: 'lengkap', judul: JUDUL, deskripsi: DESK, teksTombol: 'Pelajari Layanan Kami', aktif: true, foto: 'images/banners/banner-1.png', fotoNama: 'banner-1.png' },
      { id: 2, jenis: 'foto', judul: '', deskripsi: '', teksTombol: '', aktif: true, foto: 'images/banners/banner-2.jpeg', fotoNama: 'banner-2.jpeg' }
    ];
  }

  /* Semua banner (untuk admin) */
  function loadBanners() {
    if (fromServer(KEY_BANNER)) return read(KEY_BANNER, []);
    var d = read(KEY_BANNER, null);
    if (Array.isArray(d) && !(d.length && d.every(function (x) { return !x.foto; }))) return d;
    return defaultBanners();
  }
  /* Banner yang tampil di website: hanya yang aktif dan punya foto */
  function getBanners() {
    return loadBanners().filter(function (b) { return b && b.aktif && b.foto; });
  }

  /* =======================================================================
     KEGIATAN / KESERUAN
     articles.js = data awal (artikel asli, lengkap dengan isi).
     localStorage 'iconnet_kegiatan' = hasil kelola admin:
       - artikel asli yang dihapus admin  -> tidak tampil lagi
       - artikel asli yang diedit admin   -> judul/deskripsi/foto ikut berubah
       - data baru dari admin             -> tampil paling depan
     ======================================================================= */

  /* Foto & ringkasan resmi untuk 4 kartu di beranda, supaya semua halaman konsisten. */
  var SEED = {
    1: { image: 'images/apresiasi.jpeg', excerpt: 'Sebagai bentuk apresiasi kepada pelanggan yang telah setia menggunakan layanan ICONNET, dilakukan kegiatan kunjungan langsung ke rumah pelanggan. Kegiatan ini menjadi salah satu bentuk perhatian dan penghargaan ICONNET kepada pelanggan yang telah mempercayakan kebutuhan internetnya kepada ICONNET dalam jangka waktu lama.' },
    6: { image: 'images/hut.jpeg', excerpt: 'Kebersamaan menjadi salah satu hal penting dalam menjaga hubungan yang baik antaranggota tim.' },
    3: { image: 'images/cici iconnet.jpeg', excerpt: 'ICONNET terus berupaya membangun hubungan yang baik dengan para pelanggan melalui kegiatan kunjungan.' },
    5: { image: 'images/badminton icon.jpeg', excerpt: 'Selain menjalankan aktivitas pekerjaan, kebersamaan antaranggota tim juga dapat dibangun melalui olahraga.' }
  };
  var HOME_ORDER = [1, 6, 3, 5]; // urutan kartu di beranda (sama seperti sebelumnya)

  function seeded() {
    return baseArticles().map(function (a) {
      var s = SEED[a.id];
      return s ? Object.assign({}, a, { image: s.image, excerpt: s.excerpt }) : a;
    });
  }
  function orderedSeed() {
    var list = seeded(), first = [], rest = list.slice();
    HOME_ORDER.forEach(function (id) {
      var i = rest.findIndex(function (a) { return a.id === id; });
      if (i >= 0) first.push(rest.splice(i, 1)[0]);
    });
    return first.concat(rest);
  }

  /* Data awal untuk admin (kelola-beranda.html) */
  function defaultKegiatan() {
    return orderedSeed().map(function (a) {
      return {
        id: a.id, articleId: a.id, tanggal: a.date, judul: a.title, deskripsi: a.excerpt,
        teksTombol: '', aktif: true, foto: a.image, fotoNama: baseName(a.image)
      };
    });
  }
  function loadKegiatan() {
    if (fromServer(KEY_KEGIATAN)) return read(KEY_KEGIATAN, []);
    var d = read(KEY_KEGIATAN, null);
    if (Array.isArray(d) && !(d.length && d.every(function (x) { return !x.foto; }))) return d;
    return defaultKegiatan();
  }

  /* Artikel final untuk halaman publik (bentuk sama dengan ARTICLES) */
  function getArticles() {
    // Data dari database (tabel testimonis / "Keseruan Bersama"), urutan sama dengan halaman Kelola
    if (fromServer(KEY_KEGIATAN)) {
      return read(KEY_KEGIATAN, []).filter(function (p) { return p && p.foto; }).map(function (p) {
        var body = String(p.deskripsi || '').split(/\n+/).map(function (t) { return t.trim(); }).filter(Boolean);
        return {
          id: p.id, title: p.judul, date: p.tanggal || todayLocal(), image: p.foto,
          excerpt: p.deskripsi || '', body: body.length ? body : [p.judul], highlight: p.highlight || ''
        };
      });
    }
    var raw = read(KEY_KEGIATAN, null);
    var admin = Array.isArray(raw) && localStorage.getItem(KEY_KEGIATAN_VER) === '2';
    if (!admin) return orderedSeed();   // admin belum pernah menyimpan -> pakai data awal

    var base = {};
    seeded().forEach(function (a) { base[a.id] = a; });

    var news = [], kept = [];
    raw.forEach(function (p) {
      if (!p || !p.foto) return;
      var orig = p.articleId ? base[p.articleId] : null;
      if (p.articleId && !orig) return;   // artikel asli sudah tidak ada di articles.js
      var item;
      if (orig) {
        item = Object.assign({}, orig);
        if (p.diedit) {
          item.title = p.judul; item.excerpt = p.deskripsi; item.image = p.foto;
          if (p.judul !== orig.title) item.highlight = '';
        }
      } else {
        item = {
          id: p.id, title: p.judul, date: p.tanggal || todayLocal(), image: p.foto, excerpt: p.deskripsi || '',
          body: String(p.deskripsi || '').split(/\n+/).map(function (t) { return t.trim(); }).filter(Boolean),
          highlight: ''
        };
        if (!item.body.length) item.body = [item.title];
      }
      (p.baru ? news : kept).push({ item: item, key: p.id });
    });
    news.sort(function (a, b) { return b.key - a.key; });   // data baru: terbaru paling depan
    return news.concat(kept).map(function (x) { return x.item; });
  }

  /* =======================================================================
     TENTANG KAMI
     'iconnet_tentang_kami' = { about: string, timeline: [{id, tahun, judul, deskripsi}] }
       about    -> paragraf hero "Tentang ICONNET" (tentang-kami.html)
       timeline -> kartu "Perjalanan ICONNET"; judul tampil sebagai "<tahun> - <judul>"
     Visi & Misi bersifat tetap (belum ada menu kelola-nya).
     ======================================================================= */
  function defaultTentang() {
    return {
      about: 'ICONNET merupakan layanan internet fixed broadband berbasis teknologi fiber optic yang dikelola oleh PT PLN Icon Plus, yang merupakan sub-holding dari PT PLN (Persero). Sebagai bagian dari keluarga besar PLN, ICONNET hadir dengan misi untuk memberikan konektivitas digital yang merata hingga ke berbagai pelosok Indonesia.',
      timeline: [
        { id: 1, tahun: '2021', judul: 'ICONNET Resmi Diluncurkan', deskripsi: 'Pada 1 Juni 2021, PLN melalui ICON+ meluncurkan ICONNET sebagai layanan internet fixed broadband untuk masyarakat. Layanan ini mengusung konsep internet andal, terjangkau, dan tanpa batas kuota.' },
        { id: 2, tahun: '2022', judul: 'Menjadi Subholding PLN', deskripsi: 'Pada 10 Juni 2025, ICONNET Virtual Academy digelar di Banjarbaru untuk meningkatkan kemampuan dan kualitas pemasaran layanan ICONNET di wilayah Kalimantan.' },
        { id: 3, tahun: '2023', judul: 'Menembus 1 Juta Pelanggan', deskripsi: 'Pada 15 Agustus 2025, PLN Icon Plus berkolaborasi menghadirkan konsep Smart Home di Banjarmasin yang mengintegrasikan kebutuhan listrik dan konektivitas internet.' }
      ]
    };
  }
  function loadTentang() {
    if (fromServer(KEY_TENTANG)) return read(KEY_TENTANG, { about: '', timeline: [] });
    var d = read(KEY_TENTANG, null);
    if (!d || typeof d.about !== 'string' || !Array.isArray(d.timeline)) return defaultTentang();
    return d;
  }
  var getTentang = loadTentang;   // halaman publik membaca data yang sama dengan admin

  /* =======================================================================
     PAKET & HARGA
     'iconnet_paket_harga' = [{ id, kategori:'promo'|'reguler', hargaNormal, hargaPromo,
                                mbps, kapasitas, kualitas, terlaris }]
     getPaket() mengubahnya ke bentuk yang dipakai kartu di paket-harga.html:
       promo   -> price = hargaPromo, normalPrice (dicoret) = hargaNormal
       reguler -> price = hargaNormal
     ======================================================================= */
  function defaultPaket() {
    var list = [], id = 0;
    function add(kategori, mbps, normal, promo, kap, terlaris) {
      list.push({ id: ++id, kategori: kategori, hargaNormal: normal, hargaPromo: promo, mbps: mbps,
                  kapasitas: kap, kualitas: 'Lancar Streaming HD', terlaris: terlaris });
    }
    for (var i = 0; i < 4; i++) {
      add('promo', 20, 200000, 184630, '5-8 Perangkat', true);
      add('reguler', 20, 184630, 0, '5-8 Perangkat', false);
    }
    add('promo', 30, 249000, 224640, '8-10 Perangkat', false);   add('reguler', 30, 249000, 0, '8-10 Perangkat', false);
    add('promo', 50, 329000, 299000, '10-12 Perangkat', false);  add('reguler', 50, 329000, 0, '10-12 Perangkat', false);
    add('promo', 100, 469000, 429000, '12-15 Perangkat', false); add('reguler', 100, 469000, 0, '12-15 Perangkat', false);
    add('promo', 200, 649000, 599000, '15-20 Perangkat', false); add('reguler', 200, 649000, 0, '15-20 Perangkat', false);
    return list;
  }
  /* Data lama (field "harga") dimigrasi ke hargaNormal / hargaPromo */
  function normalizePaket(p) {
    if (p.hargaNormal === undefined) {
      var h = Number(p.harga) || 0;
      p = Object.assign({}, p, { hargaNormal: h, hargaPromo: p.kategori === 'promo' ? h : 0 });
    }
    return Object.assign({ hargaPromo: 0 }, p);
  }
  function loadPaket() {
    if (fromServer(KEY_PAKET)) return read(KEY_PAKET, []).map(normalizePaket);
    var d = read(KEY_PAKET, null);
    return (Array.isArray(d) ? d : defaultPaket()).map(normalizePaket);
  }
  function getPaket() {
    return loadPaket().map(function (p) {
      var promo = p.kategori === 'promo' && p.hargaPromo;
      var kap = String(p.kapasitas || '').trim();
      return {
        name: p.kategori === 'promo' ? 'Paket Promo ' + (String(p.durasi || '').trim() || '3 Bulan') : 'Paket Reguler',
        type: p.kategori,
        speed: p.mbps + ' Mbps',
        price: promo ? p.hargaPromo : p.hargaNormal,
        normalPrice: promo ? p.hargaNormal : undefined,
        popular: !!p.terlaris,
        features: [kap ? (/^untuk\s/i.test(kap) ? kap : 'Untuk ' + kap) : '', String(p.kualitas || '').trim()].filter(Boolean)
      };
    });
  }

  /* =======================================================================
     HUBUNGI KAMI
     'iconnet_hubungi_kami' = { alamat, callCenter, whatsapp, email, jam,
                                instagram, facebook, tiktok, twitter }
       -> halaman hubungi-kami.html (saluran, media sosial, alamat)
       -> footer SEMUA halaman publik (call center, e-mail, ikon media sosial)
       -> nomor WhatsApp pada tombol "Hubungi Sales" di paket-harga.html
     ======================================================================= */
  function defaultHubungi() {
    return {
      alamat: 'PT PLN Icon Plus – Kantor Perwakilan Kalselteng\nJl. RO Ulin, Gunung Payung, Kecamatan Landasan Ulin, Kota Banjarbaru, Kalimantan Selatan 70714.',
      callCenter: '150678',
      whatsapp: '0853-3660-3030',
      email: 'iconnet.iconplus@gmail.com',
      jam: 'Kantor layanan: Senin - Jumat (08.00 - 17.00)',
      instagram: '@iconnet.iconplus',
      facebook: '@iconnet.iconplus',
      tiktok: '@iconnet.iconplus',
      twitter: '@iconnet.iconplus'
    };
  }
  function loadHubungi() {
    if (fromServer(KEY_HUBUNGI)) return Object.assign({ alamat: '', callCenter: '', whatsapp: '', email: '', jam: '', instagram: '', facebook: '', tiktok: '', twitter: '' }, read(KEY_HUBUNGI, {}));
    return Object.assign({}, defaultHubungi(), read(KEY_HUBUNGI, {}));
  }
  var getHubungi = loadHubungi;

  /* 0853-3660-3030 -> 6285336603030 (format wa.me, tanpa +) */
  function waNumber(v) {
    var d = String(v || '').replace(/\D/g, '');
    if (!d) return '';
    return d.charAt(0) === '0' ? '62' + d.slice(1) : d;
  }
  function telHref(v) { var t = String(v || '').replace(/[^\d+]/g, ''); return t ? 'tel:' + t : ''; }

  /* Handle (@iconnet) atau tautan penuh (https://...) -> { href, handle }; kosong -> null */
  var SOCIAL_BASE = { instagram: 'https://www.instagram.com/', facebook: 'https://www.facebook.com/', tiktok: 'https://www.tiktok.com/@', twitter: 'https://x.com/' };
  function socialLink(kind, v) {
    v = String(v || '').trim();
    if (!v) return null;
    if (/^https?:\/\//i.test(v)) {
      var last = v.replace(/[?#].*$/, '').replace(/\/+$/, '').split('/').pop().replace(/^@/, '');
      return { href: v, handle: '@' + last };
    }
    var id = v.replace(/^@/, '');
    return { href: SOCIAL_BASE[kind] + encodeURIComponent(id), handle: '@' + id };
  }

  /* Footer yang sama di semua halaman publik: diisi otomatis dari data Hubungi Kami */
  function applyFooter() {
    if (typeof document === 'undefined') return;
    var h = loadHubungi(), el;
    el = document.querySelector('[data-hk="callCenter"]'); if (el && h.callCenter) el.textContent = h.callCenter;
    el = document.querySelector('[data-hk="email"]'); if (el && h.email) el.textContent = h.email;
    ['facebook', 'instagram', 'twitter', 'tiktok'].forEach(function (k) {
      var a = document.querySelector('[data-social="' + k + '"]'); if (!a) return;
      var l = socialLink(k, h[k]);
      if (l) { a.href = l.href; a.style.display = ''; } else { a.style.display = 'none'; }
    });
  }
  if (typeof document !== 'undefined') {
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', applyFooter);
    else applyFooter();
  }

  global.ICONNET = {
    KEY_BANNER: KEY_BANNER, KEY_KEGIATAN: KEY_KEGIATAN, KEY_KEGIATAN_VER: KEY_KEGIATAN_VER, KEY_TENTANG: KEY_TENTANG, KEY_PAKET: KEY_PAKET, KEY_HUBUNGI: KEY_HUBUNGI,
    read: read, esc: esc, todayLocal: todayLocal, dateLabel: dateLabel, dateNumeric: dateNumeric,
    defaultBanners: defaultBanners, loadBanners: loadBanners, getBanners: getBanners,
    defaultKegiatan: defaultKegiatan, loadKegiatan: loadKegiatan, getArticles: getArticles,
    defaultTentang: defaultTentang, loadTentang: loadTentang, getTentang: getTentang,
    defaultPaket: defaultPaket, loadPaket: loadPaket, getPaket: getPaket,
    defaultHubungi: defaultHubungi, loadHubungi: loadHubungi, getHubungi: getHubungi,
    waNumber: waNumber, telHref: telHref, socialLink: socialLink, applyFooter: applyFooter
  };
})(window);
