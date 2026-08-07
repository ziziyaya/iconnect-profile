@php $p = $paket ?? null; @endphp

<div class="field">
  <label for="nama">Nama Paket</label>
  <input type="text" id="nama" name="nama" value="{{ old('nama', $p->nama ?? '') }}" required>
</div>

<div class="field">
  <label for="kecepatan_mbps">Kecepatan (Mbps)</label>
  <input type="number" id="kecepatan_mbps" name="kecepatan_mbps" value="{{ old('kecepatan_mbps', $p->kecepatan_mbps ?? '') }}" required>
</div>

<div class="field">
  <label for="harga">Harga per bulan (Rp)</label>
  <input type="number" id="harga" name="harga" value="{{ old('harga', $p->harga ?? '') }}" required>
</div>

<div class="field">
  <label for="fitur">Fitur (satu baris = satu poin)</label>
  <textarea id="fitur" name="fitur" rows="4">{{ old('fitur', $p ? implode("\n", $p->fitur ?? []) : '') }}</textarea>
</div>

<div class="field">
  <label for="urutan">Urutan tampil</label>
  <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $p->urutan ?? 0) }}">
</div>

<div class="field" style="display:flex; align-items:center; gap:8px;">
  <input type="checkbox" id="is_popular" name="is_popular" value="1" style="width:auto;" {{ old('is_popular', $p->is_popular ?? false) ? 'checked' : '' }}>
  <label for="is_popular" style="margin:0;">Tandai sebagai paket "Terlaris"</label>
</div>
