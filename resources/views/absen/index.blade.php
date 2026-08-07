@extends('layouts.dash')

@section('title', 'Absen Saya')

@section('content')

  <div class="absen-card">
    <p style="font-family:var(--font-mono); color:var(--text-muted); text-transform:uppercase; font-size:0.8rem;">
      {{ date('l, d F Y') }}
    </p>

    @if ($absensiHariIni == null)
      {{-- Belum absen masuk sama sekali hari ini --}}
      <div class="absen-status-box belum">
        <p style="margin:0; color:var(--navy); font-weight:600;">Kamu belum absen masuk hari ini.</p>
      </div>

      <div class="camera-box">
        <video id="video" autoplay playsinline></video>
        <canvas id="canvas"></canvas>
      </div>

      <form method="POST" action="{{ route('absen.masuk') }}" id="form-absen">
        @csrf
        <input type="hidden" name="foto" id="input-foto">
        <button type="button" class="btn btn-primary btn-block" onclick="ambilFotoDanKirim()">📸 Ambil Foto &amp; Absen Masuk</button>
      </form>

    @elseif ($absensiHariIni->jam_pulang == null)
      {{-- Sudah absen masuk, belum absen pulang --}}
      <div class="absen-status-box sudah">
        <p style="margin:0; color:var(--navy); font-weight:600;">Absen masuk: {{ $absensiHariIni->jam_masuk }}</p>
      </div>

      <div class="camera-box">
        <video id="video" autoplay playsinline></video>
        <canvas id="canvas"></canvas>
      </div>

      <form method="POST" action="{{ route('absen.pulang') }}" id="form-absen">
        @csrf
        <input type="hidden" name="foto" id="input-foto">
        <button type="button" class="btn btn-primary btn-block" onclick="ambilFotoDanKirim()">📸 Ambil Foto &amp; Absen Pulang</button>
      </form>

    @else
      {{-- Sudah lengkap absen masuk & pulang hari ini --}}
      <div class="absen-status-box sudah">
        <p style="margin:0; color:var(--navy); font-weight:600;">Absen hari ini sudah lengkap 🎉</p>
      </div>

      <div style="display:flex; gap:24px; justify-content:center; margin-bottom:20px;">
        <div>
          <img src="{{ asset('storage/' . $absensiHariIni->foto_masuk) }}" class="absen-foto-kecil">
          <p style="font-size:0.85rem; margin-top:6px;">Masuk: {{ $absensiHariIni->jam_masuk }}</p>
        </div>
        <div>
          <img src="{{ asset('storage/' . $absensiHariIni->foto_pulang) }}" class="absen-foto-kecil">
          <p style="font-size:0.85rem; margin-top:6px;">Pulang: {{ $absensiHariIni->jam_pulang }}</p>
        </div>
      </div>
    @endif

    <a href="{{ route('absen.riwayat') }}" class="btn btn-ghost btn-block" style="margin-top:8px;">Lihat Riwayat Absen</a>
  </div>

@endsection

@section('script')
<script>
  // Nyalain kamera pas halaman kebuka (kalau ada elemen video di halaman ini)
  var videoElement = document.getElementById('video');

  if (videoElement) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function (stream) {
        videoElement.srcObject = stream;
      })
      .catch(function (error) {
        alert('Tidak bisa mengakses kamera. Pastikan kamu mengizinkan akses kamera di browser.');
      });
  }

  // Ambil foto dari video yang lagi jalan, ubah jadi gambar, lalu kirim form
  function ambilFotoDanKirim() {
    var video = document.getElementById('video');
    var canvas = document.getElementById('canvas');
    var inputFoto = document.getElementById('input-foto');
    var form = document.getElementById('form-absen');

    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    var context = canvas.getContext('2d');
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    var dataUrlGambar = canvas.toDataURL('image/png');
    inputFoto.value = dataUrlGambar;

    form.submit();
  }
</script>
@endsection
