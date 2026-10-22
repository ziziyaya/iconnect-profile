<?php

namespace App\Http\Controllers\Iconnet;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Paket;
use App\Models\Pengaturan;
use App\Models\Perjalanan;
use App\Models\Testimoni;
use App\Support\IconnetData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Superadmin: Kelola Tampilan (Beranda, Tentang Kami, Paket & Harga, Hubungi Kami).
 * Memakai tabel yang sudah ada: banners, testimonis (Keseruan Bersama), pakets, pengaturans,
 * ditambah tabel baru perjalanans (timeline Tentang Kami).
 * Setiap aksi mengembalikan data terbaru dengan bentuk yang sama seperti yang dibaca halaman.
 */
class KelolaController extends Controller
{
    private const MAX_FOTO_BYTES = 10 * 1024 * 1024;

    /* ============================== BANNER ============================== */

    public function bannerSimpan(Request $request, ?int $id = null)
    {
        $banner = $id ? Banner::findOrFail($id) : new Banner();
        $jenis = $id ? ($banner->jenis === 'foto' ? 'foto' : 'lengkap') : $request->input('jenis');

        $request->validate([
            'jenis' => [$id ? 'nullable' : 'required', 'in:lengkap,foto'],
            'judul' => [$jenis === 'lengkap' ? 'required' : 'nullable', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'teksTombol' => ['nullable', 'string', 'max:60'],
            'aktif' => ['nullable', 'boolean'],
            'foto' => ['required', 'string'],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'foto.required' => 'Foto wajib diunggah.',
        ]);

        $lengkap = $jenis === 'lengkap';
        $gambar = $this->fotoDariRequest($request->foto, $banner->gambar, 'banners');
        if ($gambar === null) {
            return response()->json(['message' => 'Foto tidak valid. Gunakan PNG atau JPG maksimal 10MB.'], 422);
        }

        $banner->jenis = $jenis;
        $banner->judul = $lengkap ? trim((string) $request->judul) : '';
        $banner->deskripsi = $lengkap ? (trim((string) $request->deskripsi) ?: null) : null;
        $banner->teks_tombol = $lengkap ? (trim((string) $request->teksTombol) ?: null) : null;
        if (! $id) {
            $banner->aktif = $request->boolean('aktif', true);
            $banner->urutan = ((int) Banner::max('urutan')) + 1; // data baru di urutan paling akhir
        }
        $this->gantiFoto($banner, 'gambar', $gambar);
        $banner->save();

        return response()->json(['list' => IconnetData::banners()]);
    }

    public function bannerAktif(Request $request, int $id)
    {
        $request->validate(['aktif' => ['required', 'boolean']]);
        $banner = Banner::findOrFail($id);
        $banner->aktif = $request->boolean('aktif');
        $banner->save();

        return response()->json(['list' => IconnetData::banners()]);
    }

    public function bannerHapus(int $id)
    {
        $banner = Banner::findOrFail($id);
        $this->hapusFile($banner->gambar);
        $banner->delete();

        return response()->json(['list' => IconnetData::banners()]);
    }

    /* ======================= KEGIATAN (KESERUAN) ======================= */

    public function kegiatanSimpan(Request $request, ?int $id = null)
    {
        $item = $id ? Testimoni::findOrFail($id) : new Testimoni();

        $request->validate([
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['nullable', 'string', 'max:10000'],
            'foto' => ['required', 'string'],
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'foto.required' => 'Foto wajib diunggah.',
        ]);

        $foto = $this->fotoDariRequest($request->foto, $item->foto, 'testimonis');
        if ($foto === null) {
            return response()->json(['message' => 'Foto tidak valid. Gunakan PNG atau JPG maksimal 10MB.'], 422);
        }

        $judul = trim($request->judul);
        if ($item->highlight && ! Str::contains($judul, $item->highlight)) {
            $item->highlight = null; // kata highlight sudah tidak ada di judul baru
        }
        $item->judul = $judul;
        $item->deskripsi = trim((string) $request->deskripsi) ?: null;
        if (! $id) {
            $item->tanggal = date('Y-m-d');
            $item->urutan = 0; // kegiatan baru tampil paling depan di website
        }
        $this->gantiFoto($item, 'foto', $foto);
        $item->save();

        return response()->json(['list' => IconnetData::kegiatan()]);
    }

    public function kegiatanHapus(int $id)
    {
        $item = Testimoni::findOrFail($id);
        $this->hapusFile($item->foto);
        $item->delete();

        return response()->json(['list' => IconnetData::kegiatan()]);
    }

    /* =========================== TENTANG KAMI =========================== */

    public function tentangSimpan(Request $request)
    {
        $request->validate(['about' => ['required', 'string', 'max:5000']], ['about.required' => 'Deskripsi wajib diisi.']);

        $pengaturan = Pengaturan::instance();
        $pengaturan->tentang = trim($request->about);
        $pengaturan->save();

        return response()->json(['data' => IconnetData::tentang()]);
    }

    public function perjalananSimpan(Request $request, ?int $id = null)
    {
        $request->validate([
            'tahun' => ['required', 'digits:4'],
            'judul' => ['required', 'string', 'max:150'],
            'deskripsi' => ['required', 'string', 'max:2000'],
        ], [
            'tahun.digits' => 'Tahun wajib diisi 4 digit, contoh: 2021.',
            'judul.required' => 'Judul wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
        ]);

        $item = $id ? Perjalanan::findOrFail($id) : new Perjalanan();
        $item->tahun = $request->tahun;
        $item->judul = trim($request->judul);
        $item->deskripsi = trim($request->deskripsi);
        if (! $id) {
            $item->urutan = ((int) Perjalanan::max('urutan')) + 1;
        }
        $item->save();

        return response()->json(['data' => IconnetData::tentang()]);
    }

    public function perjalananHapus(int $id)
    {
        Perjalanan::findOrFail($id)->delete();

        return response()->json(['data' => IconnetData::tentang()]);
    }

    /* ========================== PAKET & HARGA ========================== */

    public function paketSimpan(Request $request, ?int $id = null)
    {
        $request->validate([
            'kategori' => ['required', 'in:promo,reguler'],
            'mbps' => ['required', 'integer', 'min:1', 'max:100000'],
            'hargaNormal' => ['required', 'integer', 'min:1000'],
            'hargaPromo' => ['nullable', 'integer', 'min:0'],
            'kapasitas' => ['required', 'string', 'max:100'],
            'kualitas' => ['required', 'string', 'max:150'],
            'terlaris' => ['nullable', 'boolean'],
        ]);

        $promo = $request->kategori === 'promo';
        $hargaPromo = (int) $request->input('hargaPromo', 0);
        if ($promo && (! $hargaPromo || $hargaPromo >= (int) $request->hargaNormal)) {
            return response()->json(['message' => 'Harga promo wajib diisi dan harus lebih kecil dari harga normal.'], 422);
        }

        $paket = $id ? Paket::findOrFail($id) : new Paket();
        $paket->kategori = $request->kategori;
        $paket->kecepatan_mbps = (int) $request->mbps;
        // Kolom 'harga' = harga yang dibayar pelanggan (sama seperti sebelumnya)
        $paket->harga = $promo ? $hargaPromo : (int) $request->hargaNormal;
        $paket->harga_normal = $promo ? (int) $request->hargaNormal : null;
        $paket->fitur = [trim($request->kapasitas), trim($request->kualitas)];
        $paket->is_popular = $request->boolean('terlaris');
        // Nama paket tidak ditampilkan di desain baru; isi otomatis bila kosong / masih nama bawaan
        if (! $paket->nama || in_array($paket->nama, ['Paket Promo', 'Paket Reguler'], true)) {
            $paket->nama = $promo ? 'Paket Promo' : 'Paket Reguler';
        }
        if ($promo && ! $paket->durasi) {
            $paket->durasi = '3 Bulan';
        }
        if (! $id) {
            $paket->urutan = ((int) Paket::max('urutan')) + 1;
        }
        $paket->save();

        return response()->json(['list' => IconnetData::paket()]);
    }

    public function paketHapus(int $id)
    {
        Paket::findOrFail($id)->delete();

        return response()->json(['list' => IconnetData::paket()]);
    }

    /* =========================== HUBUNGI KAMI =========================== */

    public function hubungiSimpan(Request $request)
    {
        $request->validate([
            'alamat' => ['required', 'string', 'max:255'],
            'callCenter' => ['required', 'string', 'regex:/^[0-9+\-\s()]{3,20}$/'],
            'whatsapp' => ['required', 'string', 'regex:/^[0-9+\-\s()]{8,20}$/'],
            'email' => ['required', 'email', 'max:150'],
            'jam' => ['required', 'string', 'max:100'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'facebook' => ['nullable', 'string', 'max:100'],
            'tiktok' => ['nullable', 'string', 'max:100'],
            'twitter' => ['nullable', 'string', 'max:100'],
        ]);

        $p = Pengaturan::instance();
        $p->alamat = trim($request->alamat);
        $p->call_center = trim($request->callCenter);
        $p->no_wa_sales = trim($request->whatsapp);
        $p->email = trim($request->email);
        $p->jam_operasional = trim($request->jam);
        foreach (['instagram', 'facebook', 'tiktok', 'twitter'] as $kolom) {
            $p->{$kolom} = trim((string) $request->input($kolom)) ?: null;
        }
        $p->save();

        return response()->json(['data' => IconnetData::hubungi()]);
    }

    /* ============================== FOTO ============================== */

    /**
     * Foto dari form dikirim sebagai data URL (foto baru) atau URL lama (tidak diganti).
     * Mengembalikan path untuk disimpan, path lama bila tidak diganti, atau null bila tidak valid.
     * Hasilnya ['baru' => bool, 'path' => string].
     */
    private function fotoDariRequest(string $foto, ?string $pathLama, string $folder): ?array
    {
        if (! Str::startsWith($foto, 'data:')) {
            // Foto tidak diganti: URL yang dikirim harus sama dengan foto yang tersimpan
            if ($pathLama && $foto === IconnetData::fileUrl($pathLama)) {
                return ['baru' => false, 'path' => $pathLama];
            }

            return null;
        }

        if (! preg_match('#^data:image/(png|jpe?g|webp);base64,#i', $foto, $m)) {
            return null;
        }
        $isi = base64_decode(substr($foto, strpos($foto, ',') + 1), true);
        if ($isi === false || strlen($isi) > self::MAX_FOTO_BYTES || @getimagesizefromstring($isi) === false) {
            return null;
        }

        $ext = strtolower($m[1]) === 'png' ? 'png' : (strtolower($m[1]) === 'webp' ? 'webp' : 'jpg');
        $path = $folder.'/'.Str::random(40).'.'.$ext;
        Storage::disk('public')->put($path, $isi);

        return ['baru' => true, 'path' => $path];
    }

    private function gantiFoto($model, string $kolom, array $foto): void
    {
        if ($foto['baru'] && $model->{$kolom} && $model->{$kolom} !== $foto['path']) {
            $this->hapusFile($model->{$kolom}); // sama seperti controller lama: file lama dihapus saat diganti
        }
        $model->{$kolom} = $foto['path'];
    }

    private function hapusFile(?string $path): void
    {
        if ($path && ! Str::startsWith($path, ['http://', 'https://', 'images/'])) {
            Storage::disk('public')->delete($path);
        }
    }
}
