@extends('layouts.dash')

@section('title', 'Profil Saya')

@section('content')

  <div class="dash-bottom-grid">
    <div class="admin-card">
      <h3>Data Diri</h3>
      <form method="POST" action="{{ route('profil.update') }}">
        @csrf
        @method('PUT')

        <div class="field">
          <label for="name">Nama</label>
          <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="field">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
          @error('email')<p style="color:var(--danger); font-size:0.85rem;">{{ $message }}</p>@enderror
        </div>

        <div class="field">
          <label>Role</label>
          <input type="text" value="{{ ucfirst($user->role) }}" disabled style="background:var(--bg);">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </form>
    </div>

    <div class="admin-card">
      <h3>Ganti Password</h3>
      <form method="POST" action="{{ route('profil.password') }}">
        @csrf
        @method('PUT')

        <div class="field">
          <label for="current_password">Password Saat Ini</label>
          <input type="password" id="current_password" name="current_password" required>
          @error('current_password')<p style="color:var(--danger); font-size:0.85rem;">{{ $message }}</p>@enderror
        </div>

        <div class="field">
          <label for="password">Password Baru</label>
          <input type="password" id="password" name="password" required>
        </div>

        <div class="field">
          <label for="password_confirmation">Konfirmasi Password Baru</label>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Ubah Password</button>
      </form>
    </div>
  </div>

@endsection
