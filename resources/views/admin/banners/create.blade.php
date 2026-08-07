@extends('layouts.dash')

@section('title', 'Tambah Banner')

@section('content')
  <div class="admin-card" style="max-width:520px;">
    <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field">
        <label for="judul">Judul Banner</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi (opsional)</label>
        <input type="text" id="deskripsi" name="deskripsi" value="{{ old('deskripsi') }}">
      </div>

      <div class="field">
        <label for="gambar">Gambar Banner</label>
        <input type="file" id="gambar" name="gambar" accept="image/*" required>
      </div>

      <div class="field">
        <label for="urutan">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', 0) }}">
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan Banner</button>
    </form>
  </div>
@endsection
