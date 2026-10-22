<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Paket & Harga - ICONNET</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!--
    Aset yang dipakai (isi nanti): images/logo-iconin-putih.png
    Data paket ada di bagian script paling bawah (array PACKAGES).
  -->
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/site.config.js -->
  <link rel="stylesheet" href="{{ asset('css/site.css') }}" />
</head>

<body class="overflow-x-hidden bg-white font-sans text-brand-ink antialiased">

  <!-- ===================== NAVBAR ===================== -->
  <header class="sticky top-0 z-50 flex h-[67px] items-center justify-between bg-brand-blue px-5 text-white lg:px-[30px]">
    <a href="{{ url('/') }}" class="flex h-full items-center">
      <img src="{{ asset('images/logo-iconin-putih.png') }}" alt="ICONNET" class="block h-[52px] w-auto -translate-y-[3px] object-contain lg:h-[56px]" />
    </a>

    <nav class="absolute left-1/2 -ml-5 hidden -translate-x-1/2 items-center gap-5 lg:flex xl:gap-10">
      <a href="{{ url('/') }}" class="whitespace-nowrap rounded-full px-5 py-[9px] text-[15px] font-medium transition hover:bg-white/10 xl:px-[26px]">Beranda</a>
      <a href="{{ url('tentang-kami') }}" class="whitespace-nowrap rounded-full px-5 py-[9px] text-[15px] font-medium transition hover:bg-white/10 xl:px-[26px]">Tentang Kami</a>
      <a href="{{ url('paket-harga') }}" class="whitespace-nowrap rounded-full bg-brand-active px-5 py-[9px] text-[15px] font-medium shadow-[0_4px_10px_rgba(0,0,0,0.25)] xl:px-[26px]">Paket &amp; Harga</a>
      <a href="{{ url('hubungi-kami') }}" class="whitespace-nowrap rounded-full px-5 py-[9px] text-[15px] font-medium transition hover:bg-white/10 xl:px-[26px]">Hubungi Kami</a>
    </nav>

    <div class="flex items-center gap-3">
      <a href="{{ url('login') }}" class="inline-flex items-center gap-2 rounded-full border border-white px-[22px] py-[7px] text-[13px] transition hover:bg-white/15">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
        Login
      </a>
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false"
        class="flex h-[38px] w-[38px] flex-col items-center justify-center gap-[5px] lg:hidden">
        <span class="block h-0.5 w-[22px] rounded bg-white"></span>
        <span class="block h-0.5 w-[22px] rounded bg-white"></span>
        <span class="block h-0.5 w-[22px] rounded bg-white"></span>
      </button>
    </div>

    <nav id="mobileMenu" class="absolute left-0 right-0 top-[67px] hidden border-t border-white/15 bg-brand-blue px-5 pb-[18px] pt-2 shadow-[0_10px_20px_rgba(0,0,0,0.2)] lg:hidden">
      <a href="{{ url('/') }}" class="mt-1 block rounded-[10px] px-[18px] py-[11px] text-sm font-medium hover:bg-white/10">Beranda</a>
      <a href="{{ url('tentang-kami') }}" class="mt-1 block rounded-[10px] px-[18px] py-[11px] text-sm font-medium hover:bg-white/10">Tentang Kami</a>
      <a href="{{ url('paket-harga') }}" class="mt-1 block rounded-[10px] bg-brand-active px-[18px] py-[11px] text-sm font-medium">Paket &amp; Harga</a>
      <a href="{{ url('hubungi-kami') }}" class="mt-1 block rounded-[10px] px-[18px] py-[11px] text-sm font-medium hover:bg-white/10">Hubungi Kami</a>
    </nav>
  </header>

  <!-- ===================== PAKET INTERNET ===================== -->
  <main class="bg-slate-50">
    <div class="mx-auto max-w-[1400px] px-4 py-10 sm:px-8 sm:py-14 lg:px-12 xl:px-16">

      <h1 class="text-center text-3xl font-semibold sm:text-4xl">
        Paket <span class="text-brand-cyan">Internet</span>
      </h1>
      <p class="mt-2 text-center text-xs sm:text-sm">Pilih paket berlangganan yang sesuai dengan kebutuhan Anda.</p>

      <!-- Filter -->
      <div class="mt-5 flex justify-center">
        <div id="tabs" role="tablist" aria-label="Filter paket"
          class="inline-flex rounded-full border border-slate-200 bg-white p-[3px] shadow-[0_2px_8px_rgba(0,0,0,0.12)]">
          <button type="button" role="tab" data-filter="all" class="tab-btn rounded-full px-8 py-2 text-xs font-medium lg:px-12 lg:py-2.5 lg:text-sm">Semua</button>
          <button type="button" role="tab" data-filter="promo" class="tab-btn rounded-full px-8 py-2 text-xs font-medium lg:px-12 lg:py-2.5 lg:text-sm">Promo</button>
          <button type="button" role="tab" data-filter="reguler" class="tab-btn rounded-full px-8 py-2 text-xs font-medium lg:px-12 lg:py-2.5 lg:text-sm">Reguler</button>
        </div>
      </div>

      <!-- Kartu paket (diisi oleh script) -->
      <div id="packageGrid" class="mt-8 grid grid-cols-2 gap-x-3 gap-y-6 sm:mt-10 md:grid-cols-3 md:gap-x-5 lg:grid-cols-4 lg:gap-x-8 lg:gap-y-10 xl:gap-x-10 xl:gap-y-12"></div>

      <p id="emptyState" class="hidden py-10 text-center text-sm text-slate-500">Belum ada paket pada kategori ini.</p>

      <!-- Lihat Selengkapnya (hanya tab Semua; Promo & Reguler langsung menampilkan semua paket) -->
      <div id="moreWrap" class="mt-10 hidden justify-center">
        <button id="moreBtn" type="button"
          class="rounded-full bg-brand-violet px-8 py-2 text-xs font-medium text-white shadow transition hover:bg-brand-blue lg:px-12 lg:py-2.5 lg:text-sm">
          Lihat Selengkapnya
        </button>
      </div>
    </div>
  </main>

  <!-- ===================== FOOTER ===================== -->
  <footer id="kontak" class="bg-gradient-to-b from-brand-blue to-brand-navy px-5 pt-8 text-white sm:px-[30px] sm:pt-10">
    <div class="mx-auto flex max-w-[1150px] flex-wrap gap-x-10 gap-y-8 min-[1100px]:flex-nowrap">

      <div class="flex-[1_1_100%] min-[1100px]:flex-[0_0_400px]">
        <img src="{{ asset('images/logo-iconin-putih.png') }}" alt="ICONNET" class="mb-[18px] block h-[68px] w-auto sm:h-[84px]" />
        <p class="max-w-[235px] text-[11px] leading-[1.7]">Nikmati internet cepat dan stabil bersama ICONNET. Nikmati koneksi berkualitas untuk berbagai aktivitas digital.</p>
      </div>

      <div class="flex-[1_1_100%] sm:flex-[1_1_200px] min-[1100px]:flex-[0_0_176px]">
        <h4 class="relative mb-[18px] pb-[7px] text-[15px] font-medium after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-7 after:bg-brand-cyan after:content-['']">Menu</h4>
        <ul>
          <li class="mb-3.5 text-[13px]"><a href="{{ url('/') }}" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Beranda</a></li>
          <li class="mb-3.5 text-[13px]"><a href="{{ url('tentang-kami') }}" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Tentang Kami</a></li>
          <li class="mb-3.5 text-[13px]"><a href="{{ url('paket-harga') }}" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Paket &amp; Harga</a></li>
          <li class="mb-3.5 text-[13px]"><a href="#saran" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Saran &amp; Kritik</a></li>
        </ul>
      </div>

      <div class="flex-[1_1_100%] sm:flex-[1_1_200px] min-[1100px]:flex-[0_0_267px]">
        <h4 class="relative mb-[18px] pb-[7px] text-[15px] font-medium after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-7 after:bg-brand-cyan after:content-['']">Hubungi Kami</h4>

        <div class="mb-5 flex gap-3 text-[13px] leading-[1.5]">
          <span class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-full border border-white"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2"><path d="M12 22s7-6.5 7-12a7 7 0 10-14 0c0 5.5 7 12 7 12z"/><circle cx="12" cy="10" r="2.5"/></svg></span>
          <div>Banjarbaru, Kalimantan Selatan</div>
        </div>
        <div class="mb-5 flex gap-3 text-[13px] leading-[1.5]">
          <span class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-full border border-white"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 01-2.2 2 19.8 19.8 0 01-8.6-3.1 19.5 19.5 0 01-6-6A19.8 19.8 0 012.1 4.2 2 2 0 014.1 2h3a2 2 0 012 1.7c.1 1 .4 1.9.7 2.8a2 2 0 01-.5 2.1L8.1 9.9a16 16 0 006 6l1.3-1.3a2 2 0 012.1-.4c.9.3 1.8.6 2.8.7a2 2 0 011.7 2z"/></svg></span>
          <div><strong class="block text-sm font-medium">Contact Center</strong><span data-hk="callCenter">150678</span></div>
        </div>
        <div class="mb-5 flex gap-3 text-[13px] leading-[1.5]">
          <span class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-full border border-white"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg></span>
          <div><strong class="block text-sm font-medium">E-mail</strong><span data-hk="email" class="block max-w-[160px] break-all">iconnet.iconplus@gmail.com</span></div>
        </div>
      </div>

      <div class="flex-[1_1_100%] sm:flex-[1_1_200px] min-[1100px]:flex-none">
        <h4 class="relative mb-[18px] pb-[7px] text-[15px] font-medium after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-7 after:bg-brand-cyan after:content-['']">Social Media</h4>
        <div class="flex gap-3">
          <a href="https://www.facebook.com/iconnet.iconplus" target="_blank" rel="noopener noreferrer" aria-label="Facebook" data-social="facebook" class="flex h-[23px] w-[23px] items-center justify-center rounded-full border border-white transition hover:bg-white/20"><svg class="h-3 w-3 fill-white" viewBox="0 0 24 24"><path d="M14 8V6.5c0-.7.2-1 1.2-1H17V2.2C16.6 2.1 15.6 2 14.500 2 12 2 10.500 3.500 10.500 6v2H8v3.500h2.500V22H14V11.500h2.800L17.300 8H14z"/></svg></a>
          <a href="https://www.instagram.com/iconnet.iconplus" target="_blank" rel="noopener noreferrer" aria-label="Instagram" data-social="instagram" class="flex h-[23px] w-[23px] items-center justify-center rounded-full border border-white transition hover:bg-white/20"><svg class="h-3 w-3 fill-white" viewBox="0 0 24 24"><path d="M12 7.400A4.600 4.600 0 1016.600 12 4.600 4.600 0 0012 7.400zm0 7.600a3 3 0 113-3 3 3 0 01-3 3zM17.800 6.200a1.100 1.100 0 11-1.100-1.100 1.100 1.100 0 011.100 1.100zM21.500 7.400a5.500 5.500 0 00-1.500-3.900A5.500 5.500 0 0016.100 2c-1.500-.1-6.700-.1-8.200 0A5.500 5.500 0 004 3.500 5.500 5.500 0 002.500 7.400c-.1 1.500-.1 6.700 0 8.200A5.500 5.500 0 004 19.500a5.500 5.500 0 003.900 1.500c1.500.1 6.700.1 8.200 0a5.500 5.500 0 003.900-1.500 5.500 5.500 0 001.500-3.900c.1-1.500.1-6.700 0-8.200zM19.600 17.200A3.400 3.400 0 0117.800 19c-1.300.5-4.300.4-5.800.4s-4.500.1-5.800-.4A3.400 3.400 0 014.400 17.200c-.5-1.300-.4-4.300-.4-5.200s-.1-4 .4-5.200A3.400 3.400 0 016.200 5c1.300-.5 4.300-.4 5.800-.4s4.500-.1 5.800.4a3.400 3.400 0 011.800 1.800c.5 1.300.4 4.300.4 5.200s.1 4-.4 5.200z"/></svg></a>
          <a href="https://x.com/iconnet.iconplus" target="_blank" rel="noopener noreferrer" aria-label="Twitter" data-social="twitter" class="flex h-[23px] w-[23px] items-center justify-center rounded-full border border-white transition hover:bg-white/20"><svg class="h-3 w-3 fill-white" viewBox="0 0 24 24"><path d="M22 5.900a8.200 8.200 0 01-2.400.6 4.200 4.200 0 001.800-2.300 8.400 8.400 0 01-2.700 1A4.200 4.200 0 0011.500 9 12 12 0 012.800 4.600a4.200 4.200 0 001.300 5.600 4.200 4.200 0 01-1.900-.5v.1a4.200 4.200 0 003.400 4.100 4.200 4.200 0 01-1.900.1 4.200 4.200 0 003.900 2.900A8.400 8.400 0 012 18.600 11.900 11.900 0 008.400 20.500c7.700 0 11.900-6.400 11.900-11.900v-.5A8.500 8.500 0 0022 5.900z"/></svg></a>
          <a href="https://www.tiktok.com/@iconnet.iconplus" target="_blank" rel="noopener noreferrer" aria-label="TikTok" data-social="tiktok" class="flex h-[23px] w-[23px] items-center justify-center rounded-full border border-white transition hover:bg-white/20"><svg class="h-3 w-3 fill-white" viewBox="0 0 24 24"><path d="M19.600 7.600a4.800 4.800 0 01-3.800-4.100h-3.300v12.600a2.700 2.700 0 11-2.700-2.700c.3 0 .5 0 .8.100V10a6 6 0 105.200 5.900V9.500a8 8 0 004.700 1.500V7.700a4.800 4.800 0 01-.9-.1z"/></svg></a>
        </div>
      </div>

    </div>

    <div class="mx-auto mt-[30px] max-w-[1150px] border-t border-white/10 pb-[22px] pt-5 text-center text-xs">© 2026 PLN Icon Plus. All rights reserved.</div>
  </footer>

  <!-- ===================== SCRIPT ===================== -->
  <script src="{{ asset('js/site-data.js') }}"></script>
  <script>
    /* =====================================================================
       DATA PAKET  (dikelola dari kelola-paket-harga.html; data awal di site-data.js)
       - type     : 'promo' atau 'reguler'
       - popular  : true -> tampil label "TERLARIS"
       - price    : harga yang dibayar, angka tanpa titik (184630 -> Rp184.630)
       - normalPrice : (opsional, untuk paket promo) harga normal yang dicoret,
                       mis. Rp200.000/bulan -> Rp184.630/bulan
       - features : daftar poin singkat
       ===================================================================== */
    const WA_NUMBER = ICONNET.waNumber(ICONNET.getHubungi().whatsapp) || '6285336603030'; // dari Kelola Hubungi Kami (format internasional, tanpa +)
    // Jumlah kartu yang tampil sebelum tombol "Lihat Selengkapnya" diklik, per tab.
    // Infinity = semua langsung tampil dan tombol tidak ada (dipakai di tab Promo & Reguler).
    const INITIAL_VISIBLE = { all: 8, reguler: Infinity, promo: Infinity };

    // Dikelola dari kelola-paket-harga.html (data awal & pemetaan ada di site-data.js)
    const PACKAGES = ICONNET.getPaket();
    const esc = ICONNET.esc;

    // ---------- Helper ----------
    const rupiah = n => 'Rp' + n.toLocaleString('id-ID');

    function waLink(p) {
      const text = 'Halo ICONNET, saya ingin berlangganan ' + p.name + ' ' + p.speed +
                   ' (' + rupiah(p.price) + '/bulan). Mohon informasinya.';
      return 'https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(text);
    }

    function cardHTML(p, reserveStrikeLine) {
      // Baris harga normal (dicoret). Di tab Semua, kartu reguler diberi baris kosong
      // supaya tinggi kartu promo & reguler dalam satu baris tetap sejajar.
      let strikeLine = '';
      if (p.normalPrice) {
        strikeLine = `<p class="mt-1.5 text-[9px] leading-none text-slate-400 sm:text-[11px] lg:text-xs"><span class="line-through">${rupiah(p.normalPrice)}</span>/bulan</p>`;
      } else if (reserveStrikeLine) {
        strikeLine = '<p class="invisible mt-1.5 text-[9px] leading-none sm:text-[11px] lg:text-xs" aria-hidden="true">&nbsp;</p>';
      }
      return `
        <article class="relative flex flex-col rounded-lg border border-slate-100 bg-white p-2.5 shadow-[0_3px_10px_rgba(0,0,0,0.15)] sm:p-3.5 lg:p-5 xl:p-6">
          ${p.popular ? '<span class="absolute -right-1.5 -top-2.5 rounded-t-md bg-brand-gold px-2 py-0.5 text-[8px] font-semibold uppercase tracking-wide text-white sm:-right-2.5 sm:px-3 sm:text-[9px] lg:-right-3 lg:-top-3 lg:px-4 lg:py-1 lg:text-[11px]">Terlaris</span>' : ''}
          <h2 class="text-center text-[10px] font-bold uppercase leading-tight text-brand-deep sm:text-xs lg:text-sm xl:text-base">${esc(p.name)}</h2>
          <p class="mt-2.5 text-sm font-medium leading-none sm:mt-3 sm:text-lg lg:mt-5 lg:text-xl xl:text-2xl">${esc(p.speed)}</p>
          ${strikeLine}
          <p class="mt-1 leading-none">
            <span class="text-[11px] font-bold text-brand-price sm:text-sm lg:text-lg xl:text-xl">${rupiah(p.price)}</span><span class="text-[8px] text-slate-500 sm:text-[10px] lg:text-xs">/bulan</span>
          </p>
          <ul class="mb-3 mt-2.5 space-y-1 text-[9px] sm:mb-4 sm:mt-3 sm:space-y-1.5 sm:text-[11px] lg:mb-6 lg:mt-4 lg:space-y-2 lg:text-sm">
            ${p.features.map(f => `<li class="flex items-center gap-1.5"><span class="h-1 w-1 shrink-0 rounded-full bg-brand-ink lg:h-1.5 lg:w-1.5"></span>${esc(f)}</li>`).join('')}
          </ul>
          <a href="${waLink(p)}" target="_blank" rel="noopener noreferrer"
            class="mt-auto block rounded-full bg-brand-cyan py-2 text-center text-xs font-medium text-white shadow transition hover:brightness-110 lg:py-2.5 lg:text-sm">
            Hubungi Sales
          </a>
        </article>`;
    }

    // ---------- Render + filter ----------
    const grid = document.getElementById('packageGrid');
    const emptyState = document.getElementById('emptyState');
    const moreWrap = document.getElementById('moreWrap');
    const moreBtn = document.getElementById('moreBtn');
    const tabBtns = document.querySelectorAll('.tab-btn');
    let filter = 'all';
    let expanded = false;

    function render() {
      const list = PACKAGES.filter(p => filter === 'all' || p.type === filter);
      const limit = INITIAL_VISIBLE[filter];
      const shown = expanded ? list : list.slice(0, limit);

      grid.innerHTML = shown.map(p => cardHTML(p, filter === 'all')).join('');
      emptyState.classList.toggle('hidden', list.length > 0);

      // Tombol hanya ada di tab Semua & Reguler, dan hilang setelah semua kartu tampil
      const hasMore = !expanded && list.length > limit;
      moreWrap.classList.toggle('hidden', !hasMore);
      moreWrap.classList.toggle('flex', hasMore);

      tabBtns.forEach(b => {
        const active = b.dataset.filter === filter;
        b.setAttribute('aria-selected', active);
        b.classList.toggle('bg-brand-tab', active);
        b.classList.toggle('text-white', active);
        b.classList.toggle('text-brand-ink', !active);
      });
    }

    tabBtns.forEach(b => b.addEventListener('click', () => {
      filter = b.dataset.filter;
      expanded = false;
      render();
    }));
    moreBtn.addEventListener('click', () => { expanded = true; render(); });

    render();

    // Admin mengubah paket di tab lain -> halaman ikut menyesuaikan
    window.addEventListener('storage', e => { if (e.key === ICONNET.KEY_PAKET || e.key === ICONNET.KEY_HUBUNGI) location.reload(); });

    // ---------- Menu mobile ----------
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    menuBtn.addEventListener('click', () => {
      const isOpen = mobileMenu.classList.toggle('hidden') === false;
      menuBtn.setAttribute('aria-expanded', isOpen);
    });
    mobileMenu.querySelectorAll('a').forEach(a =>
      a.addEventListener('click', () => mobileMenu.classList.add('hidden'))
    );
  </script>
</body>
</html>
