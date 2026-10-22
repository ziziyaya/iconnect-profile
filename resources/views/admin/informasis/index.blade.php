@extends('layouts.dash')

@section('title', 'Informasi Terbaru')

@section('content')
  <div class="admin-page-head">
    <p style="margin:0; color:var(--text-muted);">Total {{ $daftarInformasi->count() }} informasi.</p>
    <a href="{{ route('admin.informasis.create') }}" class="btn btn-primary">+ Tambah Informasi</a>
  </div>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Icon</th>
          <th>Judul</th>
          <th>Tanggal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($daftarInformasi as $info)
          <tr>
            <td style="font-size:1.2rem;">{{ $info->icon }}</td>
            <td>{{ $info->judul }}</td>
            <td>{{ \Carbon\Carbon::parse($info->tanggal)->translatedFormat('d M Y') }}</td>
            <td>
              <div class="admin-actions">
                <a href="{{ route('admin.informasis.edit', $info->id) }}" class="btn btn-ghost">Edit</a>
                <form method="POST" action="{{ route('admin.informasis.destroy', $info->id) }}" onsubmit="return confirm('Hapus {{ $info->judul }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="color:var(--text-muted);">Belum ada informasi.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
