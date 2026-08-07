@extends('layouts.dash')

@section('title', 'Paket Layanan')

@section('content')
  <div class="admin-page-head">
    <p style="margin:0; color:var(--text-muted);">Total {{ $pakets->count() }} paket.</p>
    <a href="{{ route('admin.pakets.create') }}" class="btn btn-primary">+ Tambah Paket</a>
  </div>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Kecepatan</th>
          <th>Harga</th>
          <th>Populer</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($pakets as $paket)
          <tr>
            <td>{{ $paket->nama }}</td>
            <td class="mono">{{ $paket->kecepatan_mbps }} Mbps</td>
            <td class="mono">Rp{{ number_format($paket->harga, 0, ',', '.') }}</td>
            <td>{{ $paket->is_popular ? 'Ya' : '-' }}</td>
            <td>
              <div class="admin-actions">
                <a href="{{ route('admin.pakets.edit', $paket->id) }}" class="btn btn-ghost">Edit</a>
                <form method="POST" action="{{ route('admin.pakets.destroy', $paket->id) }}" onsubmit="return confirm('Hapus paket {{ $paket->nama }}?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="5" style="color:var(--text-muted);">Belum ada paket.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
@endsection
