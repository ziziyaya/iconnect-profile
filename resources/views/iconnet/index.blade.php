<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  @include('iconnet.partials.server')
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ICONNET - Solusi Digital & Internet Andal Tanpa Batas</title>

  <!-- Font: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Tailwind CSS (CDN) -->

  <!--
  ============================================================
  ASET YANG PERLU KAMU ISI NANTI:

  images/
  ├── logo-iconin-putih.png        (logo navbar & footer, versi putih)
  ├── banners/
  │   ├── banner-1.jpg          (foto/background saja, teks & tombol dibuat HTML)
  │   └── banner-2.jpg          (gambar promo utuh)
  └── keseruan-1.jpg ... keseruan-4.jpg

  Semua ikon (panah, wifi, dompet, dll.) sudah berupa SVG inline di dalam file ini.
  ============================================================
  -->
  <!-- Tailwind CSS hasil build lokal (npm run build). Sengaja diletakkan paling akhir di <head>
       agar urutan cascade sama seperti saat memakai CDN. Sumber: tailwind/site.config.js -->
  <link rel="stylesheet" href="{{ asset('css/site.css') }}" />
</head>

<body class="overflow-x-hidden bg-[#F9F8FE] font-sans text-brand-ink antialiased">

  <!-- ===================== NAVBAR ===================== -->
  <header class="sticky top-0 z-50 flex h-[67px] items-center justify-between bg-brand-blue px-5 text-white lg:px-[30px]">
    <a href="{{ url('/') }}" class="flex h-full items-center">
      <!-- Taruh logo ICONNET di sini -->
      <img src="{{ asset('images/logo-iconin-putih.png') }}" alt="ICONNET" class="block h-[52px] w-auto -translate-y-[3px] object-contain lg:h-[56px]" />
    </a>

    <!-- Menu desktop -->
    <nav class="absolute left-1/2 -ml-5 hidden -translate-x-1/2 items-center gap-5 lg:flex xl:gap-10">
      <a href="{{ url('/') }}" class="whitespace-nowrap rounded-full bg-brand-active px-5 py-[9px] text-[15px] font-medium shadow-[0_4px_10px_rgba(0,0,0,0.25)] xl:px-[26px]">Beranda</a>
      <a href="{{ url('tentang-kami') }}" class="whitespace-nowrap rounded-full px-5 py-[9px] text-[15px] font-medium transition hover:bg-white/10 xl:px-[26px]">Tentang Kami</a>
      <a href="{{ url('paket-harga') }}" class="whitespace-nowrap rounded-full px-5 py-[9px] text-[15px] font-medium transition hover:bg-white/10 xl:px-[26px]">Paket &amp; Harga</a>
      <a href="{{ url('hubungi-kami') }}" class="whitespace-nowrap rounded-full px-5 py-[9px] text-[15px] font-medium transition hover:bg-white/10 xl:px-[26px]">Hubungi Kami</a>
    </nav>

    <div class="flex items-center gap-3">
      <a href="{{ url('login') }}" class="inline-flex items-center gap-2 rounded-full border border-white px-[22px] py-[7px] text-[13px] transition hover:bg-white/15">
        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
        Login
      </a>

      <!-- Hamburger (mobile) -->
      <button id="menuBtn" type="button" aria-label="Buka menu" aria-expanded="false"
        class="flex h-[38px] w-[38px] flex-col items-center justify-center gap-[5px] lg:hidden">
        <span class="block h-0.5 w-[22px] rounded bg-white"></span>
        <span class="block h-0.5 w-[22px] rounded bg-white"></span>
        <span class="block h-0.5 w-[22px] rounded bg-white"></span>
      </button>
    </div>

    <!-- Menu mobile -->
    <nav id="mobileMenu" class="absolute left-0 right-0 top-[67px] hidden border-t border-white/15 bg-brand-blue px-5 pb-[18px] pt-2 shadow-[0_10px_20px_rgba(0,0,0,0.2)] lg:hidden">
      <a href="{{ url('/') }}" class="mt-1 block rounded-[10px] bg-brand-active px-[18px] py-[11px] text-sm font-medium">Beranda</a>
      <a href="{{ url('tentang-kami') }}" class="mt-1 block rounded-[10px] px-[18px] py-[11px] text-sm font-medium hover:bg-white/10">Tentang Kami</a>
      <a href="{{ url('paket-harga') }}" class="mt-1 block rounded-[10px] px-[18px] py-[11px] text-sm font-medium hover:bg-white/10">Paket &amp; Harga</a>
      <a href="{{ url('hubungi-kami') }}" class="mt-1 block rounded-[10px] px-[18px] py-[11px] text-sm font-medium hover:bg-white/10">Hubungi Kami</a>
    </nav>
  </header>

  <!-- ===================== HERO CAROUSEL ===================== -->
  <section id="beranda" aria-label="Banner utama" class="relative w-full overflow-hidden bg-brand-navy">
    <div id="carousel" class="relative w-full select-none">
      <div id="track" class="flex w-full transition-transform duration-700 ease-in-out">
        <!-- Slide dirender dari data "Kelola Banner" (site-data.js) -->
      </div>

      <!-- Tombol navigasi -->
      <button id="prevBtn" type="button" aria-label="Banner sebelumnya"
        class="absolute left-2 top-1/2 z-10 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-full bg-brand-navy/90 text-white shadow transition hover:bg-brand-navy sm:left-4 sm:h-9 sm:w-9 lg:left-[28px] lg:top-[46%] lg:h-[37px] lg:w-[37px]">
        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
      </button>
      <button id="nextBtn" type="button" aria-label="Banner berikutnya"
        class="absolute right-2 top-1/2 z-10 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-full bg-brand-navy/90 text-white shadow transition hover:bg-brand-navy sm:right-4 sm:h-9 sm:w-9 lg:right-[28px] lg:top-[46%] lg:h-[37px] lg:w-[37px]">
        <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
      </button>

      <!-- Indikator -->
      <div id="dots" class="absolute bottom-2 left-1/2 z-10 flex -translate-x-1/2 gap-1.5 sm:bottom-3"></div>
    </div>
  </section>

  <!-- ===================== KEUNGGULAN ===================== -->
  <section id="tentang" class="mx-auto max-w-[1440px] px-4 pb-8 pt-6 sm:px-6 sm:pt-8 lg:px-[28px] lg:pb-[54px] lg:pt-[36px]">
    <h2 class="max-w-2xl text-[20px] font-semibold leading-[28px] sm:text-[26px] sm:leading-[36px] lg:text-[33px] lg:leading-[50px]">
      Keunggulan Konektivitas Digital &amp; Jaringan ICONNET
    </h2>
    <p class="mt-2 max-w-[690px] text-[12px] font-medium leading-[19px] sm:text-[13px] sm:leading-[21px] lg:mt-[10px] lg:text-[14px] lg:leading-[23px]">
      Menghubungkan jutaan masyarakat Indonesia dengan Teknologi serat Optik dengan masa depan yang andal, efisien, dan didukung penuh oleh kehandalaan PLN.
    </p>

    <div class="mt-5 grid grid-cols-1 gap-3 sm:mt-7 md:grid-cols-3 lg:mt-[46px] lg:gap-[33px]">

      <!-- Card 1 -->
      <article class="flex flex-col items-center rounded-[10px] border border-[#EDEDF4] bg-white px-4 pb-4 pt-4 text-center shadow-[0_1px_4px_rgba(25,87,155,0.04)] lg:px-[11px] lg:pb-[12px] lg:pt-[14px]">
        <div class="flex h-[26px] items-center justify-center lg:h-[30px]">
          <svg class="h-[24px] w-[24px] text-[#03045E] lg:h-[28px] lg:w-[28px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
        </div>
        <h3 class="mt-2 text-[15px] font-medium leading-[22px] lg:mt-[9px] lg:text-[17px] lg:leading-[24px]">Koneksi Stabil &amp; Cepat</h3>
        <p class="mt-2 text-[12px] leading-[19px] text-slate-700 lg:mt-[10px] lg:text-[13px] lg:leading-[20.4px]">
          Mendukung aktivitas digital Anda dengan koneksi yang cepat, stabil, dan andal.
        </p>
      </article>

      <!-- Card 2 -->
      <article class="flex flex-col items-center rounded-[10px] border border-[#EDEDF4] bg-white px-4 pb-4 pt-4 text-center shadow-[0_1px_4px_rgba(25,87,155,0.04)] lg:px-[11px] lg:pb-[12px] lg:pt-[14px]">
        <div class="flex h-[26px] items-center justify-center lg:h-[30px]">
          <svg class="h-[24px] w-[24px] text-[#03045E] lg:h-[28px] lg:w-[28px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
        </div>
        <h3 class="mt-2 text-[15px] font-medium leading-[22px] lg:mt-[9px] lg:text-[17px] lg:leading-[24px]">Paket Internet yang Kompetitif</h3>
        <p class="mt-2 text-[12px] leading-[19px] text-slate-700 lg:mt-[10px] lg:text-[13px] lg:leading-[20.4px]">
          Pilihan paket yang fleksibel dengan harga kompetitif sesuai kebutuhan pelanggan.
        </p>
      </article>

      <!-- Card 3 -->
      <article class="flex flex-col items-center rounded-[10px] border border-[#EDEDF4] bg-white px-4 pb-4 pt-4 text-center shadow-[0_1px_4px_rgba(25,87,155,0.04)] lg:px-[11px] lg:pb-[12px] lg:pt-[14px]">
        <div class="flex h-[26px] items-center justify-center lg:h-[30px]">
          <svg class="h-[24px] w-[24px] text-[#03045E] lg:h-[28px] lg:w-[28px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 14h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 16"/><path d="m7 20 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 15 6 6"/><path d="M19.5 8.5c.7-.7 1.5-1.6 1.5-2.7A2.73 2.73 0 0 0 16 4a2.78 2.78 0 0 0-5 1.8c0 1.2.8 2 1.5 2.8L16 12Z"/></svg>
        </div>
        <h3 class="mt-2 text-[15px] font-medium leading-[22px] lg:mt-[9px] lg:text-[17px] lg:leading-[24px]">Layanan Pelanggan Responsif</h3>
        <p class="mt-2 text-[12px] leading-[19px] text-slate-700 lg:mt-[10px] lg:text-[13px] lg:leading-[20.4px]">
          Didukung oleh tim yang responsif dan berpengalaman untuk memberikan pelayanan terbaik kepada setiap pelanggan.
        </p>
      </article>
    </div>
  </section>

  <!-- ===================== KESERUAN BERSAMA ===================== -->
  <section id="keseruanSection" class="mx-auto max-w-[1440px] px-4 pb-10 sm:px-6 lg:px-[28px] lg:pb-[86px]">
    <h2 class="text-center text-[20px] font-semibold leading-[28px] sm:text-[26px] sm:leading-[36px] lg:text-[33px] lg:leading-[50px]">
      Keseruan Bersama <span class="text-brand-cyan">ICONNET</span>
    </h2>

    <div id="keseruanGrid" class="mt-5 grid grid-cols-1 gap-6 lg:mt-[27px] lg:grid-cols-[minmax(0,1.31fr)_minmax(0,1fr)] lg:gap-x-[48px]"></div>

    <div class="mt-8 flex justify-center lg:mt-[68px]">
      <a href="{{ url('keseruan') }}"
        class="inline-flex h-[34px] items-center justify-center rounded-full bg-brand-violet px-8 text-[12px] font-medium text-white shadow transition hover:bg-brand-blue lg:h-[38px] lg:w-[206px] lg:px-0">
        Lihat Selengkapnya
      </a>
    </div>
  </section>

  <!-- ===================== FOOTER ===================== -->
  <footer id="kontak" class="bg-gradient-to-b from-brand-blue to-brand-navy px-5 pt-8 text-white sm:px-[30px] sm:pt-10">
    <div class="mx-auto flex max-w-[1150px] flex-wrap gap-x-10 gap-y-8 min-[1100px]:flex-nowrap">

      <!-- Brand -->
      <div class="flex-[1_1_100%] min-[1100px]:flex-[0_0_400px]">
        <!-- Taruh logo ICONIN (versi putih) di sini -->
        <img src="{{ asset('images/logo-iconin-putih.png') }}" alt="ICONIN" class="mb-[18px] block h-[68px] w-auto sm:h-[84px]" />
        <p class="max-w-[235px] text-[11px] leading-[1.7]">Nikmati internet cepat dan stabil bersama ICONNET. Nikmati koneksi berkualitas untuk berbagai aktivitas digital.</p>
      </div>

      <!-- Menu -->
      <div class="flex-[1_1_100%] sm:flex-[1_1_200px] min-[1100px]:flex-[0_0_176px]">
        <h4 class="relative mb-[18px] pb-[7px] text-[15px] font-medium after:absolute after:bottom-0 after:left-0 after:h-0.5 after:w-7 after:bg-brand-cyan after:content-['']">Menu</h4>
        <ul>
          <li class="mb-3.5 text-[13px]"><a href="{{ url('/') }}" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Beranda</a></li>
          <li class="mb-3.5 text-[13px]"><a href="{{ url('tentang-kami') }}" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Tentang Kami</a></li>
          <li class="mb-3.5 text-[13px]"><a href="{{ url('paket-harga') }}" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Paket &amp; Harga</a></li>
          <li class="mb-3.5 text-[13px]"><a href="#saran" class="inline-flex items-center gap-2"><svg class="h-[9px] w-[9px]" viewBox="0 0 10 10" fill="none" stroke="#fff" stroke-width="1.6"><path d="M2 1l4 4-4 4"/></svg>Saran &amp; Kritik</a></li>
        </ul>
      </div>

      <!-- Hubungi Kami -->
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

      <!-- Social Media -->
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

  <!-- ===================== DATA & RENDER (relasi dengan halaman admin) ===================== -->
  <script src="{{ asset('js/site-data.js') }}"></script>
  <script>
    (function () {
      const { esc, getBanners, getArticles, dateLabel } = ICONNET;

      // ---------- Banner (dari Kelola Banner; hanya yang berstatus "Ditampilkan") ----------
      const banners = getBanners();
      const heroSec = document.getElementById('beranda');
      if (!banners.length) {
        heroSec.hidden = true;
      } else {
        let h1Used = false;
        document.getElementById('track').innerHTML = banners.map(b => {
          const full = b.jenis !== 'foto' && b.judul;
          const alt = full ? b.judul : 'Banner ICONNET';
          const img = `<img src="${esc(b.foto)}" alt="${esc(alt)}"
            class="aspect-[16/10] w-full bg-brand-blue object-cover sm:aspect-[2.2/1]" draggable="false" />`;
          if (!full) return `
        <div class="carousel-slide relative w-full shrink-0">
          ${img}
        </div>`;
          const tag = h1Used ? 'h2' : 'h1'; h1Used = true;
          const desk = b.deskripsi ? `
            <p class="mt-3 hidden max-w-md text-[10px] leading-relaxed text-white sm:block sm:text-xs lg:mt-[2px] lg:max-w-[345px] lg:text-[15px] lg:font-medium lg:leading-[23px]">${esc(b.deskripsi)}</p>` : '';
          const btn = b.teksTombol ? `
            <a href="{{ url('paket-harga') }}"
              class="mt-3 inline-flex items-center justify-center gap-2 rounded-full bg-brand-cyan px-8 py-2 text-xs font-medium text-white shadow transition hover:brightness-110 sm:mt-5 lg:mt-[26px] lg:h-[37px] lg:w-[201px] lg:px-0 lg:py-0">
              ${esc(b.teksTombol)}
              <svg class="h-3 w-3 sm:h-4 sm:w-4 lg:h-[12px] lg:w-[12px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>` : '';
          return `
        <div class="carousel-slide relative w-full shrink-0">
          ${img}
          <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-brand-navy/70 via-brand-navy/25 to-transparent"></div>
          <div class="absolute left-4 top-1/2 w-[64%] -translate-y-1/2 sm:left-[7%] sm:w-[46%] lg:left-[9.3%] lg:top-[18.5%] lg:w-[470px] lg:translate-y-0">
            <${tag} class="text-[15px] font-bold leading-snug text-white sm:text-xl md:text-2xl lg:text-[35px] lg:leading-[52px]">${esc(b.judul)}</${tag}>${desk}${btn}
          </div>
        </div>`;
        }).join('');
      }

      // ---------- Keseruan Bersama (dari Kelola Foto Kegiatan): 4 teratas ----------
      const list = getArticles().slice(0, 4);
      const sec = document.getElementById('keseruanSection');
      if (!list.length) {
        sec.hidden = true;
      } else {
        const [main, ...side] = list;
        const mainHTML = `
      <article class="group flex cursor-pointer flex-col" data-id="${esc(main.id)}" role="link" tabindex="0">
        <div class="overflow-hidden rounded-[18px] bg-slate-200 lg:rounded-[24px]">
          <img src="${esc(main.image)}" alt="${esc(main.title)}"
            class="aspect-[16/10] w-full object-cover transition duration-500 group-hover:scale-105 sm:aspect-[508/285]" />
        </div>
        <div class="px-2 lg:pl-[12px] lg:pr-[28px]">
          <time class="mt-2 block text-[10px] leading-[12px] text-slate-500 lg:mt-[10px]">${esc(dateLabel(main.date))}</time>
          <h3 class="mt-1 line-clamp-2 text-[14px] font-semibold leading-[22px] lg:mt-[7px] lg:text-[16px] lg:leading-[24px]">${esc(main.title)}</h3>
          <p class="mt-1 line-clamp-5 text-[12px] leading-[18px] text-[#444] lg:mt-[4px] lg:text-[12.5px] lg:leading-[18.7px]">${esc(main.excerpt)}</p>
        </div>
      </article>`;
        const sideHTML = side.length ? `
      <div class="flex flex-col gap-4 lg:-mr-[10px] lg:gap-[30px]">${side.map(a => `
        <article class="group grid cursor-pointer grid-cols-[96px_1fr] gap-3 lg:grid-cols-[125px_1fr] lg:gap-[11px]" data-id="${esc(a.id)}" role="link" tabindex="0">
          <div class="overflow-hidden rounded-[18px] bg-slate-200 lg:rounded-[24px]">
            <img src="${esc(a.image)}" alt="${esc(a.title)}"
              class="h-[100px] w-full object-cover transition duration-500 group-hover:scale-105 lg:h-[128px]" />
          </div>
          <div class="min-w-0">
            <time class="block text-[10px] leading-[12px] text-slate-500 lg:pt-[2px]">${esc(dateLabel(a.date))}</time>
            <h3 class="mt-0.5 line-clamp-2 text-[12.5px] font-semibold leading-[18px] lg:mt-[2px] lg:text-[14.5px] lg:leading-[28px]">${esc(a.title)}</h3>
            <p class="line-clamp-3 text-[11px] leading-[16px] text-[#444] lg:text-[13px] lg:leading-[19px]">${esc(a.excerpt)}</p>
          </div>
        </article>`).join('')}
      </div>` : '';
        const grid = document.getElementById('keseruanGrid');
        grid.innerHTML = mainHTML + sideHTML;
        const go = el => { location.href = '{{ url('keseruan-detail') }}?id=' + encodeURIComponent(el.dataset.id); };
        grid.querySelectorAll('article[data-id]').forEach(card => {
          card.addEventListener('click', () => go(card));
          card.addEventListener('keydown', e => { if (e.key === 'Enter') go(card); });
        });
      }

      // Admin mengubah data di tab lain -> beranda ikut menyesuaikan
      window.addEventListener('storage', e => {
        if ([ICONNET.KEY_BANNER, ICONNET.KEY_KEGIATAN, ICONNET.KEY_KEGIATAN_VER].includes(e.key)) location.reload();
      });
    })();
  </script>

  <!-- ===================== SCRIPT (hanya untuk carousel & menu mobile) ===================== -->
  <script>
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

    // ---------- Carousel ----------
    (function () {
      const AUTOPLAY_MS = 5000;
      // false = panah kiri disembunyikan di slide pertama & panah kanan di slide terakhir (sesuai referensi).
      // true  = kedua panah selalu tampil dan bisa berputar.
      const LOOP_ARROWS = false;

      const carousel = document.getElementById('carousel');
      const track = document.getElementById('track');
      const slides = track.querySelectorAll('.carousel-slide');
      const dotsWrap = document.getElementById('dots');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const total = slides.length;
      let index = 0;
      let timer = null;

      const dots = [];
      slides.forEach((_, i) => {
        const b = document.createElement('button');
        b.type = 'button';
        b.setAttribute('aria-label', 'Ke banner ' + (i + 1));
        b.addEventListener('click', () => { goTo(i); restart(); });
        dotsWrap.appendChild(b);
        dots.push(b);
      });

      function render() {
        track.style.transform = 'translateX(-' + index * 100 + '%)';
        dots.forEach((d, i) => {
          d.className = 'h-1.5 rounded-full transition-all ' +
            (i === index ? 'w-4 bg-white' : 'w-1.5 bg-white/50');
        });
        prevBtn.classList.toggle('hidden', !LOOP_ARROWS && index === 0);
        nextBtn.classList.toggle('hidden', !LOOP_ARROWS && index === total - 1);
      }
      function goTo(i) { index = (i + total) % total; render(); }
      function next() { if (!LOOP_ARROWS && index === total - 1) return; goTo(index + 1); }
      function prev() { if (!LOOP_ARROWS && index === 0) return; goTo(index - 1); }
      function autoNext() { goTo(index + 1); }
      function start() { stop(); if (total > 1) timer = setInterval(autoNext, AUTOPLAY_MS); }   // stop() dulu: cegah interval ganda
      function stop() { clearInterval(timer); }
      function restart() { stop(); start(); }

      nextBtn.addEventListener('click', () => { next(); restart(); });
      prevBtn.addEventListener('click', () => { prev(); restart(); });
      carousel.addEventListener('mouseenter', stop);
      carousel.addEventListener('mouseleave', start);

      // Swipe sentuh
      let startX = 0, deltaX = 0, dragging = false;
      carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX; deltaX = 0; dragging = true; stop();
      }, { passive: true });
      carousel.addEventListener('touchmove', (e) => {
        if (dragging) deltaX = e.touches[0].clientX - startX;
      }, { passive: true });
      carousel.addEventListener('touchend', () => {
        if (!dragging) return;
        dragging = false;
        if (Math.abs(deltaX) > 40) { deltaX < 0 ? next() : prev(); }
        start();
      });

      // Keyboard
      carousel.setAttribute('tabindex', '0');
      carousel.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight') { next(); restart(); }
        if (e.key === 'ArrowLeft') { prev(); restart(); }
      });

      render();
      start();
    })();
  </script>
</body>
</html>
