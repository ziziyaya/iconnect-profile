@extends('layouts.app')

@section('title', 'Saran & Kritik — ' . $pengaturan->nama_perusahaan)

@section('content')

  <section style="padding-top:40px;">
    <div class="container">

      <div class="hero-card-gradient">
        <div>
          <h2>Suarakan Pendapat Anda</h2>
          <p>Bagikan saran dan kritik Anda agar kami dapat terus memberikan layanan yang optimal setiap hari.</p>
        </div>
        <a href="#form-saran" class="btn btn-whatsapp" style="flex-shrink:0;">Kirim Saran</a>
      </div>

    </div>
  </section>

  <section id="form-saran" class="deco-bg">
    <div class="container" style="max-width:640px;">
      <div class="section-head" style="text-align:center; margin:0 auto 24px;">
        <h2>Kirim Saran &amp; Kritik</h2>
        <p>Isi form ini, nanti pesan kamu langsung terkirim ke WhatsApp kami.</p>
      </div>

      <form class="admin-card" id="form-saran-kritik">
        <div class="field">
          <label for="s-nama">Nama</label>
          <input type="text" id="s-nama" placeholder="Nama kamu" required>
        </div>
        <div class="field">
          <label for="s-kategori">Kategori</label>
          <select id="s-kategori">
            <option>Saran</option>
            <option>Kritik</option>
            <option>Pertanyaan Layanan</option>
            <option>Lainnya</option>
          </select>
        </div>
        <div class="field">
          <label for="s-pesan">Pesan</label>
          <textarea id="s-pesan" rows="4" placeholder="Tulis saran atau kritik kamu di sini..." required></textarea>
        </div>
        <button type="submit" class="btn btn-whatsapp btn-block">💬 Kirim via WhatsApp</button>
      </form>
    </div>
  </section>

  <section class="alt">
    <div class="container">
      <div class="section-head" style="text-align:center; margin:0 auto 24px;">
        <h2>Hubungi Kami</h2>
      </div>

      <div class="admin-card" style="max-width:640px; margin:0 auto 32px;">
        <h4 style="margin-bottom:4px;">Alamat Kantor Pusat</h4>
        <p style="margin-bottom:20px;">📍 {{ $pengaturan->alamat }}, {{ $pengaturan->kota }}</p>

        <h4 style="margin-bottom:4px;">Contact</h4>
        <p style="margin-bottom:20px;">📞 WhatsApp: {{ $pengaturan->no_wa_sales }}</p>

        <h4 style="margin-bottom:4px;">E-mail</h4>
        <p style="margin-bottom:20px;">✉️ {{ $pengaturan->email }}</p>

        <h4 style="margin-bottom:4px;">Social Media</h4>
        <p style="margin:0;">
          @if ($pengaturan->instagram) 📷 {{ $pengaturan->instagram }} &nbsp; @endif
          @if ($pengaturan->twitter) 🐦 {{ $pengaturan->twitter }} &nbsp; @endif
          @if ($pengaturan->facebook) 📘 {{ $pengaturan->facebook }} @endif
        </p>
      </div>

      @if ($pengaturan->maps_embed_url)
        <div class="map-frame" style="max-width:900px; margin:0 auto; height:360px;">
          <iframe src="{{ $pengaturan->maps_embed_url }}" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="width:100%; height:100%; border:0;"></iframe>
        </div>
      @endif
    </div>
  </section>

@endsection

@section('script')
<script>
  var formSaran = document.getElementById('form-saran-kritik');
  if (formSaran) {
    formSaran.addEventListener('submit', function (e) {
      e.preventDefault();

      var nama = document.getElementById('s-nama').value.trim();
      var kategori = document.getElementById('s-kategori').value;
      var pesan = document.getElementById('s-pesan').value.trim();

      var teks = 'Halo {{ $pengaturan->nama_perusahaan }}, saya ingin menyampaikan ' + kategori.toLowerCase() + '.\n\n';
      teks = teks + 'Nama: ' + nama + '\n';
      teks = teks + 'Pesan: ' + pesan;

      var nomorWa = '{{ $pengaturan->no_wa_sales }}';
      var url = 'https://wa.me/' + nomorWa + '?text=' + encodeURIComponent(teks);

      window.open(url, '_blank');
    });
  }
</script>
@endsection
