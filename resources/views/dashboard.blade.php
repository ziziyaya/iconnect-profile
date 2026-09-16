@extends('layouts.dash')

@section('title', 'Beranda')

@section('content')

  <div class="dash-hero">
    <h2>Halo, {{ $user->name }} 👋</h2>
    <p>Selamat datang di sistem absensi dan informasi karyawan {{ $pengaturan->nama_perusahaan }}.</p>
    <p>Tetap semangat dan berikan yang terbaik hari ini!</p>
  </div>

  <div class="dash-info-grid">
    <div class="dash-info-card">
      <div class="ic">👤</div>
      <div>
        <div class="label">Jenis Pengguna</div>
        <div class="value">{{ ucfirst($user->role) }}</div>
        <div class="sub">Anda memiliki akses sesuai dengan hak pengguna.</div>
      </div>
    </div>
    <div class="dash-info-card">
      <div class="ic">📅</div>
      <div>
        <div class="label">Hari Ini</div>
        <div class="value">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
        <div class="sub">Semangat beraktivitas!</div>
      </div>
    </div>
  </div>

  <div class="dash-stat-grid">
    <div class="dash-stat-card hijau">
      <div class="ic">📅</div>
      <div class="label">Total Kehadiran Bulan Ini</div>
      <div class="value">{{ $totalKehadiran }} Hari</div>
      <div class="sub">dari {{ $jumlahHariKerja }} hari kerja</div>
    </div>
    <div class="dash-stat-card biru">
      <div class="ic">⏰</div>
      <div class="label">Terlambat</div>
      <div class="value">{{ $totalTerlambat }} Hari</div>
      <div class="sub">dari {{ $jumlahHariKerja }} hari kerja</div>
    </div>
    <div class="dash-stat-card merah">
      <div class="ic">🏥</div>
      <div class="label">Izin</div>
      <div class="value">{{ $totalIzin }} Hari</div>
      <div class="sub">dari {{ $jumlahHariKerja }} hari kerja</div>
    </div>
    <div class="dash-stat-card ungu">
      <div class="ic">⛔</div>
      <div class="label">Alpa</div>
      <div class="value">{{ $totalAlpa }} Hari</div>
      <div class="sub">dari {{ $jumlahHariKerja }} hari kerja</div>
    </div>
  </div>

  <div class="dash-bottom-grid">
    <div class="admin-card">
      <div class="admin-page-head">
        <h3 style="margin:0;">Informasi Terbaru</h3>
      </div>

      @forelse ($informasiTerbaru as $info)
        <div class="dash-informasi-item">
          <div class="ic">{{ $info->icon ?? '📢' }}</div>
          <div style="flex:1;">
            <h4>{{ $info->judul }}</h4>
            <p>{{ $info->deskripsi }}</p>
          </div>
          <div class="tgl">{{ \Carbon\Carbon::parse($info->tanggal)->translatedFormat('d M Y') }}</div>
        </div>
      @empty
        <p style="color:var(--text-muted);">Belum ada informasi terbaru.</p>
      @endforelse
    </div>

    <div class="admin-card" style="background:linear-gradient(160deg, var(--blue-dim), #fff);">
      <h3>Tentang {{ $pengaturan->nama_perusahaan }}</h3>
      <p style="font-size:0.9rem;">{{ \Illuminate\Support\Str::limit($pengaturan->tentang, 160) }}</p>

      <div style="display:flex; gap:16px; margin:16px 0;">
        <div style="text-align:center; flex:1;">
          <div style="font-size:1.2rem;">⚡</div>
          <div style="font-size:0.75rem; color:var(--text-muted);">Internet Cepat</div>
        </div>
        <div style="text-align:center; flex:1;">
          <div style="font-size:1.2rem;">🛡️</div>
          <div style="font-size:0.75rem; color:var(--text-muted);">Jaringan Stabil</div>
        </div>
        <div style="text-align:center; flex:1;">
          <div style="font-size:1.2rem;">🎧</div>
          <div style="font-size:0.75rem; color:var(--text-muted);">Layanan 24 Jam</div>
        </div>
      </div>

      <a href="{{ route('tentang') }}" class="btn btn-primary btn-block">Kenali Lebih Lanjut →</a>
    </div>
  </div>

@endsection
