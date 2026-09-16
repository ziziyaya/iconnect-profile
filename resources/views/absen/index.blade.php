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
        <canvas id="canvas" style="display:none;"></canvas>
      </div>

      <div id="tombol-kamera">
        <button type="button" class="btn btn-primary btn-block" onclick="ambilFoto()">📸 Ambil Foto</button>
      </div>

      <div id="tombol-konfirmasi" style="display:none; gap:10px;">
        <button type="button" class="btn btn-ghost" style="flex:1;" onclick="ulangFoto()">🔄 Ulang</button>
        <button type="button" class="btn btn-primary" style="flex:1;" onclick="konfirmasiFoto()">✅ Konfirmasi Absen Masuk</button>
      </div>

      <form method="POST" action="{{ route('absen.masuk') }}" id="form-absen">
        @csrf
        <input type="hidden" name="foto" id="input-foto">
      </form>

    @elseif ($absensiHariIni->jam_pulang == null)
      {{-- Sudah absen masuk, belum absen pulang --}}
      <div class="absen-status-box sudah">
        <p style="margin:0; color:var(--navy); font-weight:600;">Absen masuk: {{ $absensiHariIni->jam_masuk }}</p>
      </div>

      <div class="camera-box">
        <video id="video" autoplay playsinline></video>
        <canvas id="canvas" style="display:none;"></canvas>
      </div>

      <div id="tombol-kamera">
        <button type="button" class="btn btn-primary btn-block" onclick="ambilFoto()">📸 Ambil Foto</button>
      </div>

      <div id="tombol-konfirmasi" style="display:none; gap:10px;">
        <button type="button" class="btn btn-ghost" style="flex:1;" onclick="ulangFoto()">🔄 Ulang</button>
        <button type="button" class="btn btn-primary" style="flex:1;" onclick="konfirmasiFoto()">✅ Konfirmasi Absen Pulang</button>
      </div>

      <form method="POST" action="{{ route('absen.pulang') }}" id="form-absen">
        @csrf
        <input type="hidden" name="foto" id="input-foto">
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
  var video = document.getElementById('video');
  var canvas = document.getElementById('canvas');

  // Nyalain kamera pas halaman kebuka (kalau ada elemen video di halaman ini)
  if (video) {
    navigator.mediaDevices.getUserMedia({ video: true })
      .then(function (stream) {
        video.srcObject = stream;
      })
      .catch(function (error) {
        alert('Tidak bisa mengakses kamera. Pastikan kamu mengizinkan akses kamera di browser.');
      });
  }

  // Tahap 1: ambil foto dari video, tampilkan sebagai preview (belum dikirim)
  function ambilFoto() {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;

    var context = canvas.getContext('2d');

    // Balik gambarnya secara horizontal biar hasil fotonya tidak mirror/kebalik
    context.translate(canvas.width, 0);
    context.scale(-1, 1);
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Tampilkan hasil foto (canvas), sembunyikan video yang lagi jalan
    video.style.display = 'none';
    canvas.style.display = 'block';

    // Ganti tombol jadi "Ulang" & "Konfirmasi"
    document.getElementById('tombol-kamera').style.display = 'none';
    document.getElementById('tombol-konfirmasi').style.display = 'flex';
  }

  // Tahap 2 (kalau user pilih Ulang): balik lagi ke tampilan kamera hidup
  function ulangFoto() {
    video.style.display = 'block';
    canvas.style.display = 'none';

    document.getElementById('tombol-kamera').style.display = 'block';
    document.getElementById('tombol-konfirmasi').style.display = 'none';
  }

  // Tahap 2 (kalau user pilih Konfirmasi): baru dikirim ke server
  function konfirmasiFoto() {
    var dataUrlGambar = canvas.toDataURL('image/png');
    document.getElementById('input-foto').value = dataUrlGambar;
    document.getElementById('form-absen').submit();
  }
</script>
@endsection
