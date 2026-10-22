@extends('layouts.dash')

@section('title', 'Pengaturan Situs')

@section('content')
  <div class="admin-card" style="max-width:600px;">
    <form method="POST" action="{{ route('admin.pengaturan.update') }}">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="nama_perusahaan">Nama Perusahaan</label>
        <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="{{ old('nama_perusahaan', $pengaturan->nama_perusahaan) }}" required>
      </div>

      <div class="field">
        <label for="tagline">Tagline</label>
        <input type="text" id="tagline" name="tagline" value="{{ old('tagline', $pengaturan->tagline) }}">
      </div>

      <div class="field">
        <label for="tentang">Tentang Kami</label>
        <textarea id="tentang" name="tentang" rows="4">{{ old('tentang', $pengaturan->tentang) }}</textarea>
      </div>

      <div class="field">
        <label for="alamat">Alamat Kantor</label>
        <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $pengaturan->alamat) }}">
      </div>

      <div class="grid-2col">
        <div class="field">
          <label for="kota">Kota</label>
          <input type="text" id="kota" name="kota" value="{{ old('kota', $pengaturan->kota) }}">
        </div>
        <div class="field">
          <label for="jam_operasional">Jam Operasional</label>
          <input type="text" id="jam_operasional" name="jam_operasional" value="{{ old('jam_operasional', $pengaturan->jam_operasional) }}">
        </div>
      </div>

      <div class="grid-2col">
        <div class="field">
          <label for="no_wa_sales">Nomor WhatsApp Sales</label>
          <input type="text" id="no_wa_sales" name="no_wa_sales" placeholder="6281234567890" value="{{ old('no_wa_sales', $pengaturan->no_wa_sales) }}">
        </div>
        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $pengaturan->email) }}">
        </div>
      </div>

      <div class="field">
        <label for="maps_embed_url">Link Embed Google Maps</label>
        <input type="text" id="maps_embed_url" name="maps_embed_url" value="{{ old('maps_embed_url', $pengaturan->maps_embed_url) }}">
      </div>

      <p style="font-size:0.78rem; text-transform:uppercase; letter-spacing:0.04em; color:var(--text-muted); font-weight:700; margin:24px 0 12px;">Social Media (isi username-nya aja, tanpa @ atau URL)</p>

      <div class="grid-2col">
        <div class="field">
          <label for="instagram">Instagram</label>
          <input type="text" id="instagram" name="instagram" placeholder="iconnet.iconplus" value="{{ old('instagram', $pengaturan->instagram) }}">
        </div>
        <div class="field">
          <label for="twitter">Twitter / X</label>
          <input type="text" id="twitter" name="twitter" placeholder="iconnet.iconplus" value="{{ old('twitter', $pengaturan->twitter) }}">
        </div>
      </div>

      <div class="grid-2col">
        <div class="field">
          <label for="facebook">Facebook</label>
          <input type="text" id="facebook" name="facebook" value="{{ old('facebook', $pengaturan->facebook) }}">
        </div>
        <div class="field">
          <label for="tiktok">TikTok</label>
          <input type="text" id="tiktok" name="tiktok" value="{{ old('tiktok', $pengaturan->tiktok) }}">
        </div>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan Pengaturan</button>
    </form>
  </div>
@endsection
