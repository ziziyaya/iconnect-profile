@extends('layouts.dash')

@section('title', 'Edit Banner')

@section('content')
  <div class="admin-card" style="max-width:520px;">
    <img src="{{ asset('storage/' . $banner->gambar) }}" style="width:100%; border-radius:12px; margin-bottom:16px;">

    <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="judul">Judul Banner</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $banner->judul) }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi (opsional)</label>
        <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi', $banner->deskripsi) }}">
      </div>

      <div class="field">
        <label for="gambar">Ganti Gambar (kosongkan kalau tidak ganti)</label>
        <input type="file" id="gambar" name="gambar" accept="image/*">
      </div>

      <div class="field">
        <label for="urutan">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $banner->urutan) }}">
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
  </div>
@endsection
