@php $p = $paket ?? null; @endphp

<div class="field">
  <label for="nama">Nama Paket</label>
  <input type="text" id="nama" name="nama" value="{{ old('nama', $p->nama ?? '') }}" required>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
  <div class="field">
    <label for="kategori">Kategori</label>
    <select id="kategori" name="kategori" required>
      <option value="reguler" {{ old('kategori', $p->kategori ?? 'reguler') == 'reguler' ? 'selected' : '' }}>Reguler</option>
      <option value="promo" {{ old('kategori', $p->kategori ?? '') == 'promo' ? 'selected' : '' }}>Promo</option>
    </select>
  </div>
  <div class="field">
    <label for="durasi">Durasi (khusus Promo, contoh: 3 Bulan)</label>
    <input type="text" id="durasi" name="durasi" value="{{ old('durasi', $p->durasi ?? '') }}">
  </div>
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
