@extends('layouts.dash')

@section('title', 'Riwayat Absen')

@section('content')

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Jam Masuk</th>
          <th>Jam Pulang</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($daftarAbsensi as $absensi)
          <tr>
            <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d F Y') }}</td>
            <td class="mono">{{ $absensi->jam_masuk ?? '-' }}</td>
            <td class="mono">{{ $absensi->jam_pulang ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="3" style="color:var(--text-muted);">Belum ada riwayat absen.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection
