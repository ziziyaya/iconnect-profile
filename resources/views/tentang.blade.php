@extends('layouts.app')

@section('title', 'Tentang Kami — ' . $pengaturan->nama_perusahaan)

@section('content')

  <section style="padding-top:48px;" class="deco-bg">
    <div class="container" style="text-align:center;">
      <h2>Tentang <span style="color:var(--cyan);">{{ strtoupper($pengaturan->nama_perusahaan) }}</span></h2>
      <p style="max-width:60ch; margin:0 auto 32px;">{{ $pengaturan->tentang ?? 'Belum ada deskripsi. Superadmin bisa isi lewat Panel Superadmin > Pengaturan Situs.' }}</p>

      <div class="grid-2col" style="max-width:800px; margin:0 auto 48px; text-align:left;">
        <div class="feature-card" style="border-top:4px solid var(--blue);">
          <div class="icon">🎯</div>
          <h3>Visi</h3>
          <p style="margin:0;">{{ $pengaturan->visi ?? 'Belum diisi.' }}</p>
        </div>
        <div class="feature-card" style="border-top:4px solid var(--cyan);">
          <div class="icon">🚀</div>
          <h3>Misi</h3>
          <p style="margin:0;">{{ $pengaturan->misi ?? 'Belum diisi.' }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="alt">
    <div class="container">
      <div class="section-head" style="text-align:center; margin:0 auto 24px;">
        <h2>Berbagai Prestasi Kami</h2>
      </div>

      @if ($prestasis->count() == 0)
        <p style="text-align:center;">Belum ada data prestasi.</p>
      @else
        <div class="feature-grid">
          @foreach ($prestasis as $item)
            <div class="feature-card" style="padding:0; overflow:hidden;">
              <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" style="width:100%; height:160px; object-fit:cover;">
              <div style="padding:20px;">
                <h3>{{ $item->judul }}</h3>
                @if ($item->deskripsi)
                  <p style="margin:0;">{{ $item->deskripsi }}</p>
                @endif
              </div>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </section>

  <section>
    <div class="container" style="text-align:center;">
      <div class="hero-cta" style="justify-content:center;">
        <a href="{{ route('paket') }}" class="btn btn-primary">Lihat Paket &amp; Harga</a>
        <a href="{{ route('saran') }}" class="btn btn-ghost">Hubungi Kami</a>
      </div>
    </div>
  </section>

@endsection
