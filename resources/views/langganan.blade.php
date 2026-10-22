@extends('layouts.app')

@section('title', 'Berlangganan — ' . $pengaturan->nama_perusahaan)

@section('content')

  <section style="padding-top:56px;">
    <div class="container">
      <div class="section-head">
        <h2>Info Berlangganan</h2>
        <p>Pilih paket yang sesuai kebutuhan kamu, lalu hubungi sales kami buat proses berlangganan.</p>
      </div>

      <div class="pkg-grid">
        @foreach ($pakets as $paket)
          <div class="pkg-card {{ $paket->is_popular ? 'popular' : '' }}">
            @if ($paket->is_popular)
              <span class="pkg-badge">Terlaris</span>
            @endif
            <div class="pkg-name">{{ $paket->nama }}</div>
            <div class="pkg-speed">{{ $paket->kecepatan_mbps }} <span>Mbps</span></div>
            <div class="pkg-price">Rp{{ number_format($paket->harga, 0, ',', '.') }} <span>/ bulan</span></div>
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
                💬 Hubungi Sales
              </a>
            @endif
          </div>
        @endforeach
      </div>
    </div>
  </section>

@endsection
