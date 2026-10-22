<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Paket;
use App\Models\Pengaturan;
use App\Models\Perjalanan;
use App\Models\Testimoni;
use Illuminate\Database\Seeder;

/**
 * Konten awal dari desain frontend ICONNET (banner, Keseruan Bersama, Tentang Kami, Paket, Hubungi Kami).
 *
 * AMAN untuk database yang sudah berisi data:
 *  - tabel hanya diisi bila masih KOSONG (banners, testimonis, perjalanans, pakets)
 *  - pengaturan hanya mengisi kolom yang masih kosong (NULL / string kosong)
 *  - tidak ada data yang dihapus atau ditimpa
 *
 * Jalankan: php artisan db:seed --class=IconnetKontenSeeder
 * Foto memakai file bawaan di public/images (tidak perlu disalin ke storage).
 */
class IconnetKontenSeeder extends Seeder
{
    public function run(): void
    {
        $this->banner();
        $this->keseruan();
        $this->perjalanan();
        $this->paket();
        $this->pengaturan();
    }

    private function banner(): void
    {
        if (Banner::query()->exists()) {
            $this->command?->line('  banners: sudah berisi data, dilewati');

            return;
        }

        Banner::create([
            'jenis' => 'lengkap',
            'judul' => 'Solusi Digital & internet Andal Tanpa Batas Dari ICONNET',
            'deskripsi' => 'jaringan 100% Full Fiber Optic terhubung langsung ke infrastruktur ketenagalistrikan andal PLN. kuota tanpa batas, kecepatan simetris, dan jangkauan luas se-indonesia.',
            'teks_tombol' => 'Pelajari Layanan Kami',
            'aktif' => true,
            'gambar' => 'images/banners/banner-1.png',
            'urutan' => 1,
        ]);
        Banner::create([
            'jenis' => 'foto',
            'judul' => '',
            'aktif' => true,
            'gambar' => 'images/banners/banner-2.jpeg',
            'urutan' => 2,
        ]);
        $this->command?->line('  banners: 2 banner ditambahkan');
    }

    private function keseruan(): void
    {
        if (Testimoni::query()->exists()) {
            $this->command?->line('  testimonis: sudah berisi data, dilewati');

            return;
        }

        $data = json_decode(file_get_contents(__DIR__.'/data/keseruan.json'), true);
        foreach ($data as $item) {
            $t = new Testimoni();
            $t->judul = $item['judul'];
            $t->highlight = $item['highlight'];
            $t->tanggal = $item['tanggal'];
            $t->foto = $item['foto'];
            $t->deskripsi = $item['deskripsi'];
            $t->urutan = $item['urutan'];
            $t->save();
        }
        $this->command?->line('  testimonis: '.count($data).' kegiatan ditambahkan');
    }

    private function perjalanan(): void
    {
        if (Perjalanan::query()->exists()) {
            $this->command?->line('  perjalanans: sudah berisi data, dilewati');

            return;
        }

        $timeline = [
            ['2021', 'ICONNET Resmi Diluncurkan', 'Pada 1 Juni 2021, PLN melalui ICON+ meluncurkan ICONNET sebagai layanan internet fixed broadband untuk masyarakat. Layanan ini mengusung konsep internet andal, terjangkau, dan tanpa batas kuota.'],
            ['2022', 'Menjadi Subholding PLN', 'Pada 10 Juni 2025, ICONNET Virtual Academy digelar di Banjarbaru untuk meningkatkan kemampuan dan kualitas pemasaran layanan ICONNET di wilayah Kalimantan.'],
            ['2023', 'Menembus 1 Juta Pelanggan', 'Pada 15 Agustus 2025, PLN Icon Plus berkolaborasi menghadirkan konsep Smart Home di Banjarmasin yang mengintegrasikan kebutuhan listrik dan konektivitas internet.'],
        ];
        foreach ($timeline as $i => [$tahun, $judul, $deskripsi]) {
            Perjalanan::create(['tahun' => $tahun, 'judul' => $judul, 'deskripsi' => $deskripsi, 'urutan' => $i + 1]);
        }
        $this->command?->line('  perjalanans: 3 timeline ditambahkan');
    }

    private function paket(): void
    {
        if (Paket::query()->exists()) {
            $this->command?->line('  pakets: sudah berisi data, dilewati');

            return;
        }

        // [mbps, harga normal, harga promo, kapasitas]
        $daftar = [
            [20, 200000, 184630, '5-8 Perangkat'],
            [30, 249000, 224640, '8-10 Perangkat'],
            [50, 329000, 299000, '10-12 Perangkat'],
            [100, 469000, 429000, '12-15 Perangkat'],
            [200, 649000, 599000, '15-20 Perangkat'],
        ];
        $urutan = 0;
        foreach ($daftar as $i => [$mbps, $normal, $promo, $kapasitas]) {
            Paket::create([
                'nama' => 'Paket Promo', 'kategori' => 'promo', 'durasi' => '3 Bulan',
                'kecepatan_mbps' => $mbps, 'harga' => $promo, 'harga_normal' => $normal,
                'fitur' => [$kapasitas, 'Lancar Streaming HD'], 'is_popular' => $i === 0, 'urutan' => ++$urutan,
            ]);
            Paket::create([
                'nama' => 'Paket Reguler', 'kategori' => 'reguler',
                'kecepatan_mbps' => $mbps, 'harga' => $i === 0 ? 184630 : $normal,
                'fitur' => [$kapasitas, 'Lancar Streaming HD'], 'is_popular' => false, 'urutan' => ++$urutan,
            ]);
        }
        $this->command?->line('  pakets: 10 paket ditambahkan');
    }

    private function pengaturan(): void
    {
        $p = Pengaturan::instance();
        $bawaan = [
            'tentang' => 'ICONNET merupakan layanan internet fixed broadband berbasis teknologi fiber optic yang dikelola oleh PT PLN Icon Plus, yang merupakan sub-holding dari PT PLN (Persero). Sebagai bagian dari keluarga besar PLN, ICONNET hadir dengan misi untuk memberikan konektivitas digital yang merata hingga ke berbagai pelosok Indonesia.',
            'alamat' => "PT PLN Icon Plus – Kantor Perwakilan Kalselteng\nJl. RO Ulin, Gunung Payung, Kecamatan Landasan Ulin, Kota Banjarbaru, Kalimantan Selatan 70714.",
            'call_center' => '150678',
            'no_wa_sales' => '0853-3660-3030',
            'email' => 'iconnet.iconplus@gmail.com',
            'jam_operasional' => 'Kantor layanan: Senin - Jumat (08.00 - 17.00)',
            'instagram' => '@iconnet.iconplus',
            'facebook' => '@iconnet.iconplus',
            'tiktok' => '@iconnet.iconplus',
            'twitter' => '@iconnet.iconplus',
        ];

        $diisi = [];
        foreach ($bawaan as $kolom => $nilai) {
            if ($p->{$kolom} === null || trim((string) $p->{$kolom}) === '') {
                $p->{$kolom} = $nilai;
                $diisi[] = $kolom;
            }
        }
        if ($p->jam_masuk_standar === null) {
            $p->jam_masuk_standar = '08:00:00';
            $diisi[] = 'jam_masuk_standar';
        }
        $p->save();
        $this->command?->line('  pengaturans: '.($diisi ? 'kolom kosong diisi ('.implode(', ', $diisi).')' : 'semua kolom sudah terisi, dilewati'));
    }
}
