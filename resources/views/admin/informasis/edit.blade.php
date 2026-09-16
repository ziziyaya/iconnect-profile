@extends('layouts.dash')

@section('title', 'Edit Informasi')

@section('content')
  <div class="admin-card" style="max-width:480px;">
    <form method="POST" action="{{ route('admin.informasis.update', $informasi->id) }}">
      @csrf
      @method('PUT')

      <div class="field">
        <label for="icon">Icon (emoji)</label>
        <input type="text" id="icon" name="icon" maxlength="10" value="{{ old('icon', $informasi->icon) }}">
      </div>

      <div class="field">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $informasi->judul) }}" required>
      </div>

      <div class="field">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $informasi->deskripsi) }}</textarea>
      </div>

      <div class="field">
        <label for="tanggal">Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $informasi->tanggal) }}" required>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
    </form>
  </div>
@endsection
