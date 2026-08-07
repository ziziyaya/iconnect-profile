@extends('layouts.app')

@section('title', $pengaturan->nama_perusahaan . ' — ' . $pengaturan->tagline)

@section('content')

  <!-- BANNER GESER -->
  <section style="padding-top:32px; padding-bottom:32px;">
    <div class="container">
      @if ($banners->count() > 0)
        <div class="banner-slider">
          <div class="banner-track">
            @foreach ($banners as $banner)
              <div class="banner-slide">
                <img src="{{ asset('storage/' . $banner->gambar) }}" alt="{{ $banner->judul }}">
                <div class="banner-caption">
                  <h3>{{ $banner->judul }}</h3>
                  @if ($banner->deskripsi)
                    <p>{{ $banner->deskripsi }}</p>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="banner-dots"></div>
      @else
        <div class="hero">
          <span class="eyebrow">● {{ $pengaturan->nama_perusahaan }}</span>
          <h1>{{ $pengaturan->tagline ?? 'Internet rumah cepat & stabil.' }}</h1>
        </div>
      @endif
    </div>
  </section>

  <!-- TENTANG KAMI -->
  <section class="alt">
    <div class="container">
      <div class="section-head">
        <h2>Tentang {{ $pengaturan->nama_perusahaan }}</h2>
        <p>{{ $pengaturan->tentang ?? 'Belum ada deskripsi. Superadmin bisa isi lewat Panel Superadmin > Pengaturan Situs.' }}</p>
      </div>
      <div class="hero-cta">
        <a href="{{ route('langganan') }}" class="btn btn-primary">Lihat Layanan Kami</a>
        <button class="btn btn-ghost" data-open-contact-modal>Hubungi Kami</button>
      </div>
    </div>
  </section>

  <!-- KENAPA PILIH KAMI -->
  <section id="keunggulan">
    <div class="container">
      <div class="section-head">
        <h2>Kenapa Harus Pilih {{ $pengaturan->nama_perusahaan }}?</h2>
        <p>Beberapa alasan kenapa pelanggan memilih kami.</p>
      </div>

      @if ($keunggulans->count() == 0)
        <p>Belum ada data. Superadmin bisa tambahkan lewat Panel Superadmin &gt; Kenapa Pilih Kami.</p>
      @else
        <div class="feature-grid">
          @foreach ($keunggulans as $item)
            <div class="feature-card">
              <div class="icon">{{ $item->icon ?? '⭐' }}</div>
              <h3>{{ $item->judul }}</h3>
              @if ($item->deskripsi)
                <p>{{ $item->deskripsi }}</p>
              @endif
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  <!-- LOKASI -->
  <section class="alt">
    <div class="container">
      <div class="section-head">
        <h2>Lokasi &amp; Kontak</h2>
      </div>
      <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
        <div class="admin-card">
          <div class="contact-line" style="border-top:none;">
            <div class="ic" style="background:var(--blue-dim); color:var(--blue);">📍</div>
            <div>
              <div style="color:var(--navy); font-weight:600;">{{ $pengaturan->alamat }}</div>
              <div style="color:var(--text-muted); font-size:0.9rem;">{{ $pengaturan->kota }}</div>
            </div>
          </div>
          <div class="contact-line">
            <div class="ic" style="background:var(--blue-dim); color:var(--blue);">📞</div>
            <div>
              <div class="mono" style="color:var(--navy); font-weight:600;">{{ $pengaturan->no_wa_sales }}</div>
              <div style="color:var(--text-muted); font-size:0.9rem;">{{ $pengaturan->jam_operasional }}</div>
            </div>
          </div>
          <button class="btn btn-primary btn-block" data-open-contact-modal style="margin-top:12px;">📍 Lihat Peta &amp; Chat WhatsApp</button>
        </div>

        @if ($pengaturan->maps_embed_url)
          <div class="map-frame" style="height:auto; min-height:260px;">
            <iframe src="{{ $pengaturan->maps_embed_url }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="width:100%; height:100%; min-height:260px; border:0;"></iframe>
          </div>
        @endif
      </div>
    </div>
  </section>

@endsection
