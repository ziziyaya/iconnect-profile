@extends('layouts.dash')

@section('title', 'Prestasi')

@section('content')
  <div class="admin-page-head">
    <p style="margin:0; color:var(--text-muted);">Total {{ $prestasis->count() }} prestasi.</p>
    <a href="{{ route('admin.prestasis.create') }}" class="btn btn-primary">+ Tambah Prestasi</a>
  </div>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Foto</th>
          <th>Judul</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($prestasis as $item)
          <tr>
            <td><img src="{{ asset('storage/' . $item->foto) }}" style="width:70px; height:56px; object-fit:cover; border-radius:8px;"></td>
            <td>{{ $item->judul }}</td>
            <td>
              <div class="admin-actions">
                <a href="{{ route('admin.prestasis.edit', $item->id) }}" class="btn btn-ghost">Edit</a>
                <form method="POST" action="{{ route('admin.prestasis.destroy', $item->id) }}" onsubmit="return confirm('Hapus {{ $item->judul }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-muted);">Belum ada prestasi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
