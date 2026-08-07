@extends('layouts.dash')

@section('title', 'Banner Beranda')

@section('content')
  <div class="admin-page-head">
    <p style="margin:0; color:var(--text-muted);">Total {{ $banners->count() }} banner.</p>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">+ Tambah Banner</a>
  </div>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Gambar</th>
          <th>Judul</th>
          <th>Urutan</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($banners as $banner)
          <tr>
            <td><img src="{{ asset('storage/' . $banner->gambar) }}" style="width:100px; height:56px; object-fit:cover; border-radius:8px;"></td>
            <td>{{ $banner->judul }}</td>
            <td>{{ $banner->urutan }}</td>
            <td>
              <div class="admin-actions">
                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-ghost">Edit</a>
                <form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" onsubmit="return confirm('Hapus banner {{ $banner->judul }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="color:var(--text-muted);">Belum ada banner.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
