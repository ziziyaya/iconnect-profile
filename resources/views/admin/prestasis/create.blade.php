@extends('layouts.dash')

@section('title', 'Tambah Prestasi')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.prestasis.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field">
        <label for="judul">Judul Prestasi</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="field">
        <label for="foto">Foto</label>
        <input type="file" id="foto" name="foto" accept="image/*" required>
      </div>

      <div class="field">
        <label for="urutan">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', 0) }}">
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan</button>
    </form>
  </div>
@endsection
