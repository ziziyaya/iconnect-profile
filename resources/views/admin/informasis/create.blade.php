@extends('layouts.dash')

@section('title', 'Tambah Informasi')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.informasis.store') }}">
      @csrf

      <div class="field">
        <label for="icon">Icon (emoji)</label>
        <input type="text" id="icon" name="icon" maxlength="10" placeholder="📢" value="{{ old('icon') }}">
      </div>

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
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan</button>
    </form>
  </div>
@endsection
