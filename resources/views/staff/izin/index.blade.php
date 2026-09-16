@extends('layouts.dash')

@section('title', 'Persetujuan Izin')

@section('content')

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Karyawan</th>
          <th>Tanggal</th>
          <th>Alasan</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($daftarIzin as $izin)
          <tr>
            <td>{{ $izin->user->name ?? '-' }}</td>
            <td>{{ \Carbon\Carbon::parse($izin->tanggal)->translatedFormat('d F Y') }}</td>
            <td style="max-width:260px;">{{ $izin->alasan }}</td>
            <td>
              @if ($izin->status == 'pending')
                <span class="status-pill pending"><span class="dot"></span> Menunggu</span>
              @elseif ($izin->status == 'approved')
                <span class="status-pill approved"><span class="dot"></span> Disetujui</span>
              @else
                <span class="status-pill rejected"><span class="dot"></span> Ditolak</span>
              @endif
            </td>
            <td>
              @if ($izin->status == 'pending')
                <div class="admin-actions">
                  <form method="POST" action="{{ route('staff.izin.approve', $izin->id) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">ACC</button>
                  </form>
                  <form method="POST" action="{{ route('staff.izin.tolak', $izin->id) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Tolak</button>
                  </form>
                </div>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="5" style="color:var(--text-muted);">Belum ada pengajuan izin.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection
