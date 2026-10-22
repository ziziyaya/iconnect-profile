@extends('layouts.dash')

@section('title', 'Rekap Absensi')

@section('content')

  <form method="GET" action="{{ route('staff.rekap.index') }}" class="admin-card" style="margin-bottom:20px; display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap;">
    <div class="field" style="margin-bottom:0;">
      <label for="tanggal">Pilih Tanggal</label>
      <input type="date" id="tanggal" name="tanggal" value="{{ $tanggalDipilih }}">
    </div>
    <button type="submit" class="btn btn-primary">Tampilkan</button>
  </form>

  <div class="admin-card">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Nama Karyawan</th>
          <th>Foto Masuk</th>
          <th>Jam Masuk</th>
          <th>Foto Pulang</th>
          <th>Jam Pulang</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($daftarAbsensi as $absensi)
          <tr>
            <td>{{ $absensi->user->name ?? '-' }}</td>
            <td>
              @if ($absensi->foto_masuk)
                <img src="{{ asset('storage/' . $absensi->foto_masuk) }}" class="absen-foto-kecil">
              @else
                -
              @endif
            </td>
            <td class="mono">{{ $absensi->jam_masuk ?? '-' }}</td>
            <td>
              @if ($absensi->foto_pulang)
                <img src="{{ asset('storage/' . $absensi->foto_pulang) }}" class="absen-foto-kecil">
              @else
                -
              @endif
            </td>
            <td class="mono">{{ $absensi->jam_pulang ?? '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="5" style="color:var(--text-muted);">Tidak ada data absensi di tanggal ini.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

@endsection
