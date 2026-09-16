@extends('layouts.dash')

@section('title', 'Edit Testimoni')

@section('content')
  <div class="admin-card" style="max-width:520px;">
    <img src="{{ asset('storage/' . $testimoni->foto) }}" style="width:100%; border-radius:12px; margin-bottom:16px;">

    <form method="POST" action="{{ route('admin.testimonis.update', $testimoni->id) }}" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $testimoni->judul) }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $testimoni->deskripsi) }}</textarea>
      </div>

      <div class="field">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $testimoni->tanggal) }}">
      </div>

      <div class="field">
        <label for="foto">Ganti Foto (kosongkan kalau tidak ganti)</label>
        <input type="file" id="foto" name="foto" accept="image/*">
      </div>

      <div class="field">
        <label for="urutan">Urutan Tampil</label>
        <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $testimoni->urutan) }}">
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
  </div>
@endsection
