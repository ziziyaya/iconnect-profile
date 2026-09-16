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

  <!-- TENTANG KAMI (ringkas) -->
  <section class="alt">
    <div class="container">
      <div class="tentang-split">
        <div>
          <div class="section-head" style="margin-bottom:20px;">
            <h2>Tentang {{ $pengaturan->nama_perusahaan }}</h2>
            <p>{{ $pengaturan->tentang ?? 'Belum ada deskripsi. Superadmin bisa isi lewat Panel Superadmin > Pengaturan Situs.' }}</p>
          </div>
          <div class="hero-cta">
            <a href="{{ route('tentang') }}" class="btn btn-ghost">Selengkapnya Tentang Kami</a>
            <a href="{{ route('paket') }}" class="btn btn-primary">Lihat Paket &amp; Harga</a>
          </div>
        </div>

        <div class="tentang-blob">
          <div class="blob-shape">
            <div class="blob-icon">📶</div>
            <div class="blob-text">{{ $pengaturan->nama_perusahaan }}</div>
          </div>
          <div class="blob-dot d1"></div>
          <div class="blob-dot d2"></div>
          <div class="blob-dot d3"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- KENAPA PILIH KAMI -->
  <section id="keunggulan" class="deco-bg">
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

  <!-- KESERUAN BERSAMA -->
  @if ($testimonis->count() > 0)
    <section class="alt">
      <div class="container">
        <div class="section-head">
          <h2>Keseruan Bersama {{ $pengaturan->nama_perusahaan }}</h2>
          <p>Cerita dan momen seru dari kegiatan kami.</p>
        </div>

        <div class="keseruan-grid">
          @foreach ($testimonis as $item)
            @if ($loop->first)
              <div class="keseruan-featured">
                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}">
                <div class="keseruan-featured-caption">
                  @if ($item->tanggal)
                    <div class="tgl" style="color:rgba(255,255,255,0.75);">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                  @endif
                  <h4 style="color:#fff;">{{ $item->judul }}</h4>
                </div>
              </div>
            @endif
          @endforeach

          @if ($testimonis->count() > 1)
            <div class="keseruan-list">
              @foreach ($testimonis as $item)
                @if (! $loop->first)
                  <div class="testimoni-card">
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}">
                    <div>
                      @if ($item->tanggal)
                        <div class="tgl">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                      @endif
                      <h4>{{ $item->judul }}</h4>
                      @if ($item->deskripsi)
                        <p>{{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}</p>
                      @endif
                    </div>
                  </div>
                @endif
              @endforeach
            </div>
          @else
            <div class="keseruan-desc">
              @php $featured = $testimonis->first(); @endphp
              @if ($featured->deskripsi)
                <p style="font-size:1.05rem;">{{ $featured->deskripsi }}</p>
              @endif
            </div>
          @endif
        </div>
      </div>
    </section>
  @endif

  <!-- CTA PENUTUP -->
  <section>
    <div class="container">
      <div class="cta-box">
        <h2>Siap Berlangganan?</h2>
        <p style="max-width:46ch; margin:0 auto 20px;">Cek daftar paket kami dan hubungi sales untuk mulai berlangganan hari ini.</p>
        <a href="{{ route('paket') }}" class="btn btn-primary">Lihat Paket &amp; Harga</a>
      </div>
    </div>
  </section>

@endsection
