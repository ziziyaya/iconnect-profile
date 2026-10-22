@extends('layouts.dash')

@section('title', 'Tambah Testimoni')

@section('content')
  <div class="admin-card" style="max-width:520px;">
    <form method="POST" action="{{ route('admin.testimonis.store') }}" enctype="multipart/form-data">
      @csrf

      <div class="field">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
      </div>

      <div class="field">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}">
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
