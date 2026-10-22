@extends('layouts.app')

@section('title', 'Paket & Harga — ' . $pengaturan->nama_perusahaan)

@section('content')

  <section style="padding-top:56px;" class="deco-bg">
    <div class="container" style="text-align:center;">
      <h2>Paket <span style="color:var(--cyan);">Internet</span></h2>
      <p style="max-width:46ch; margin:0 auto 24px;">Pilih paket berlangganan yang sesuai dengan kebutuhan Anda.</p>

      <div class="filter-tabs" style="margin-bottom:36px;">
        <a href="{{ route('paket') }}" class="{{ $filterKategori == null ? 'active' : '' }}">Semua</a>
        <a href="{{ route('paket', ['kategori' => 'promo']) }}" class="{{ $filterKategori == 'promo' ? 'active' : '' }}">Promo</a>
        <a href="{{ route('paket', ['kategori' => 'reguler']) }}" class="{{ $filterKategori == 'reguler' ? 'active' : '' }}">Reguler</a>
      </div>
    </div>

    <div class="container">
      @if ($pakets->count() == 0)
        <p style="text-align:center;">Belum ada paket di kategori ini.</p>
      @else
        <div class="pkg-grid">
          @foreach ($pakets as $paket)
            <div class="pkg-card {{ $paket->is_popular ? 'popular' : '' }}">
              @if ($paket->is_popular)
                <span class="pkg-badge">Terlaris</span>
              @endif

              <div class="pkg-kategori">
                @if ($paket->kategori == 'promo')
                  Paket Promo {{ $paket->durasi }}
                @else
                  Paket Reguler
                @endif
              </div>

              <div class="pkg-name">{{ $paket->nama }}</div>
              <div class="pkg-speed">{{ $paket->kecepatan_mbps }} <span>Mbps</span></div>
              <div class="pkg-price pkg-price-red">Rp{{ number_format($paket->harga, 0, ',', '.') }} <span style="color:var(--text-muted);">/bulan</span></div>

              <ul class="pkg-list">
                @foreach ($paket->fitur ?? [] as $item)
                  <li>{{ $item }}</li>
                @endforeach
              </ul>

              @if ($pengaturan->no_wa_sales)
                @php
                  $pesanWa = 'Halo, saya mau tanya soal paket ' . $paket->nama . ' (' . $paket->kecepatan_mbps . ' Mbps).';
                @endphp
                <a class="btn btn-whatsapp btn-block" href="https://wa.me/{{ $pengaturan->no_wa_sales }}?text={{ urlencode($pesanWa) }}" target="_blank" rel="noopener">
                  Hubungi Sales
                </a>
              @endif
            </div>
          @endforeach
        </div>

        @if ($pakets->hasMorePages())
          <div style="text-align:center; margin-top:32px;">
            <a href="{{ $pakets->nextPageUrl() }}" class="btn" style="background:var(--navy); color:#fff; padding:12px 28px; border-radius:999px; font-weight:700;">
              Lihat Selengkapnya
            </a>
          </div>
        @endif
      @endif
    </div>
  </section>

@endsection
