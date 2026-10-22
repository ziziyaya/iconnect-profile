@extends('layouts.dash')

@section('title', 'Edit Prestasi')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <img src="{{ asset('storage/' . $prestasi->foto) }}" style="width:100%; border-radius:12px; margin-bottom:16px;">

    <form method="POST" action="{{ route('admin.prestasis.update', $prestasi->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="judul">Judul Prestasi</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $prestasi->judul) }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
      </div>

      <div class="field">
        <label for="foto">Ganti Foto (kosongkan kalau tidak ganti)</label>
        <input type="file" id="foto" name="foto" accept="image/*">
      </div>

      <div class="field">
        <label for="urutan">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $prestasi->urutan) }}">
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
  </div>
@endsection
