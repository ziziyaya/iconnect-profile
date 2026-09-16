<?php

namespace Database\Seeders;

use App\Models\Informasi;
use App\Models\Keunggulan;
use App\Models\Paket;
use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Pengaturan Situs (contoh, edit lewat Panel Superadmin) ----------
        Pengaturan::create([
            'id' => 1,
            'nama_perusahaan' => 'IConnect',
            'tagline' => 'Internet rumah cepat & stabil untuk keluarga Indonesia.',
            'tentang' => 'IConnect adalah penyedia layanan internet rumah berbasis fiber optik yang melayani pelanggan dengan jaringan stabil dan customer service yang responsif.',
            'visi' => 'Menjadi penyedia layanan internet rumah pilihan utama masyarakat Indonesia.',
            'misi' => 'Menghadirkan koneksi internet cepat, harga terjangkau, dan pelayanan yang mudah dijangkau oleh siapa saja.',
            'alamat' => 'Jl. Contoh Raya No. 123',
            'kota' => 'Jakarta Selatan',
            'no_wa_sales' => '6281234567890',
            'email' => 'sales@iconnect.test',
            'instagram' => 'iconnect.id',
            'twitter' => 'iconnect_id',
            'facebook' => 'iconnect.id',
            'tiktok' => 'iconnect.id',
            'jam_operasional' => 'Setiap hari, 08.00 - 21.00 WIB',
            'jam_masuk_standar' => '08:00:00',
            'maps_embed_url' => 'https://www.google.com/maps?q=Jakarta&output=embed',
        ]);

        // ---------- Kenapa Pilih Kami (contoh, edit lewat Panel Superadmin) ----------
        Keunggulan::create([
            'icon' => '⚡',
            'judul' => 'Jaringan Cepat & Stabil',
            'deskripsi' => 'Fiber optik dengan uptime tinggi, minim gangguan.',
            'urutan' => 1,
        ]);

        Keunggulan::create([
            'icon' => '💬',
            'judul' => 'Customer Service Responsif',
            'deskripsi' => 'Tim sales & support siap bantu lewat WhatsApp.',
            'urutan' => 2,
        ]);

        Keunggulan::create([
            'icon' => '💰',
            'judul' => 'Harga Transparan',
            'deskripsi' => 'Tanpa biaya tersembunyi, sesuai paket yang dipilih.',
            'urutan' => 3,
        ]);

        // ---------- Paket / Layanan (contoh, edit lewat Panel Superadmin) ----------
        Paket::create([
            'nama' => 'Hemat',
            'kategori' => 'reguler',
            'kecepatan_mbps' => 10,
            'harga' => 150000,
            'fitur' => ['Untuk 1-3 perangkat', 'Cocok browsing & chat'],
            'is_popular' => false,
            'urutan' => 1,
        ]);

        Paket::create([
            'nama' => 'Keluarga',
            'kategori' => 'reguler',
            'kecepatan_mbps' => 30,
            'harga' => 250000,
            'fitur' => ['Untuk 4-6 perangkat', 'Lancar streaming HD'],
            'is_popular' => true,
            'urutan' => 2,
        ]);

        Paket::create([
            'nama' => 'Ultra',
            'kategori' => 'reguler',
            'kecepatan_mbps' => 100,
            'harga' => 550000,
            'fitur' => ['Perangkat tanpa batas', 'Streaming 4K & server rumahan'],
            'is_popular' => false,
            'urutan' => 3,
        ]);

        Paket::create([
            'nama' => 'Promo Ngebut',
            'kategori' => 'promo',
            'durasi' => '3 Bulan',
            'kecepatan_mbps' => 20,
            'harga' => 184630,
            'fitur' => ['Untuk 5-8 perangkat', 'Lancar streaming HD'],
            'is_popular' => true,
            'urutan' => 4,
        ]);

        // ---------- Akun Superadmin ----------
        $superadmin = new User();
        $superadmin->name = 'Super Admin';
        $superadmin->email = 'superadmin@iconnect.test';
        $superadmin->password = Hash::make('password');
        $superadmin->role = 'superadmin';
        $superadmin->status = 'approved';
        $superadmin->save();

        // ---------- Akun Admin ----------
        $admin = new User();
        $admin->name = 'Admin IConnect';
        $admin->email = 'admin@iconnect.test';
        $admin->password = Hash::make('password');
        $admin->role = 'admin';
        $admin->status = 'approved';
        $admin->save();

        // ---------- Contoh Akun Karyawan (sudah di-ACC, buat langsung dicoba) ----------
        $karyawan = new User();
        $karyawan->name = 'Contoh Karyawan';
        $karyawan->email = 'karyawan@iconnect.test';
        $karyawan->password = Hash::make('password');
        $karyawan->role = 'karyawan';
        $karyawan->status = 'approved';
        $karyawan->save();

        // ---------- Contoh Informasi Terbaru (tampil di dashboard karyawan) ----------
        Informasi::create([
            'icon' => '📢',
            'judul' => 'Sosialisasi Program Magang',
            'deskripsi' => 'Kepada seluruh peserta magang, akan diadakan sosialisasi program kerja pada hari Selasa.',
            'tanggal' => date('Y-m-d'),
        ]);

        Informasi::create([
            'icon' => '✅',
            'judul' => 'Update Sistem Absensi',
            'deskripsi' => 'Pastikan wajah terlihat jelas saat melakukan absen foto.',
            'tanggal' => date('Y-m-d', strtotime('-3 days')),
        ]);
    }
}
