@extends('layouts.dash')

@section('title', 'Kenapa Pilih Kami')

@section('content')
  <div class="admin-page-head">
    <p style="margin:0; color:var(--text-muted);">Total {{ $keunggulans->count() }} item.</p>
    <a href="{{ route('admin.keunggulans.create') }}" class="btn btn-primary">+ Tambah</a>
  </div>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Icon</th>
          <th>Judul</th>
          <th>Deskripsi</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($keunggulans as $item)
          <tr>
            <td style="font-size:1.3rem;">{{ $item->icon }}</td>
            <td>{{ $item->judul }}</td>
            <td style="color:var(--text-muted); max-width:280px;">{{ \Illuminate\Support\Str::limit($item->deskripsi, 70) }}</td>
            <td>
              <div class="admin-actions">
                <a href="{{ route('admin.keunggulans.edit', $item->id) }}" class="btn btn-ghost">Edit</a>
                <form method="POST" action="{{ route('admin.keunggulans.destroy', $item->id) }}" onsubmit="return confirm('Hapus {{ $item->judul }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="color:var(--text-muted);">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
