@php $k = $keunggulan ?? null; @endphp

<div class="field">
  <label for="icon">Icon (emoji)</label>
  <input type="text" id="icon" name="icon" maxlength="10" placeholder="⚡" value="{{ old('icon', $k->icon ?? '') }}">
</div>

<div class="field">
  <label for="judul">Judul</label>
  <input type="text" id="judul" name="judul" value="{{ old('judul', $k->judul ?? '') }}" required>
</div>

<div class="field">
  <label for="deskripsi">Deskripsi</label>
  <textarea id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $k->deskripsi ?? '') }}</textarea>
</div>

<div class="field">
  <label for="urutan">Urutan Tampil</label>
  <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $k->urutan ?? 0) }}">
</div>
