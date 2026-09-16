@extends('layouts.dash')

@section('title', 'Izin')

@section('content')

  <div class="dash-bottom-grid">
    <div class="admin-card">
      <h3>Riwayat Pengajuan Izin</h3>
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Alasan</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($daftarIzin as $izin)
            <tr>
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
            </tr>
          @empty
            <tr><td colspan="3" style="color:var(--text-muted);">Belum ada pengajuan izin.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="admin-card">
      <h3>Ajukan Izin Baru</h3>
      <form method="POST" action="{{ route('izin.store') }}">
        @csrf

        <div class="field">
          <label for="tanggal">Tanggal Izin</label>
          <input type="date" id="tanggal" name="tanggal" required>
        </div>

        <div class="field">
          <label for="alasan">Alasan</label>
          <textarea id="alasan" name="alasan" rows="4" placeholder="Contoh: Sakit, keperluan keluarga, dll" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Kirim Pengajuan</button>
      </form>
    </div>
  </div>

@endsection
