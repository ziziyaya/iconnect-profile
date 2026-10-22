@extends('layouts.dash')

@section('title', 'Persetujuan Karyawan')

@section('content')

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nama</th>
          <th>Email</th>
          <th>Status</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse ($daftarKaryawan as $karyawan)
          <tr>
            <td>{{ $karyawan->name }}</td>
            <td>{{ $karyawan->email }}</td>
            <td>
              @if ($karyawan->status == 'pending')
                <span class="status-pill pending"><span class="dot"></span> Menunggu</span>
              @elseif ($karyawan->status == 'approved')
                <span class="status-pill approved"><span class="dot"></span> Disetujui</span>
              @else
                <span class="status-pill rejected"><span class="dot"></span> Ditolak</span>
              @endif
            </td>
            <td>
              <div class="admin-actions">
                @if ($karyawan->status != 'approved')
                  <form method="POST" action="{{ route('staff.persetujuan.approve', $karyawan->id) }}">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary">ACC</button>
                  </form>
                @endif
                @if ($karyawan->status != 'rejected')
                  <form method="POST" action="{{ route('staff.persetujuan.tolak', $karyawan->id) }}" onsubmit="return confirm('Tolak akun {{ $karyawan->name }}?');">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger">Tolak</button>
                  </form>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="4" style="color:var(--text-muted);">Belum ada pendaftaran karyawan.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection
