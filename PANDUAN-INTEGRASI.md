# ICONNET — Website + Presensi Magang (Laravel)

Project ini adalah gabungan **frontend ICONNET** (desain final dari `icon.in.zip`) dengan **backend Laravel** dari repo `ziziyaya/iconnect-profile`.
Semua halaman frontend sekarang berjalan di Laravel dan memakai **data asli dari database** (bukan data contoh / localStorage).

> **Data lama aman.** Integrasi ini **tidak menghapus atau mengubah** tabel, kolom, relasi, maupun data yang sudah ada.
> Perubahan database hanya **menambah** kolom/tabel baru (lihat bagian 7). **Jangan pernah** menjalankan
> `php artisan migrate:fresh`, `migrate:refresh`, `migrate:reset`, atau `db:wipe` di database yang sudah berisi data.

---

## Daftar isi
1. [Isi project](#1-isi-project)
2. [Kebutuhan](#2-kebutuhan)
3. [Menjalankan di komputer (lokal)](#3-menjalankan-di-komputer-lokal)
4. [Hosting](#4-hosting)
5. [Akun & halaman per role](#5-akun--halaman-per-role)
6. [Dari mana data tiap halaman diambil](#6-dari-mana-data-tiap-halaman-diambil)
7. [Perubahan database (hanya tambahan)](#7-perubahan-database-hanya-tambahan)
8. [Keputusan & asumsi](#8-keputusan--asumsi)
9. [Pengujian yang sudah dilakukan](#9-pengujian-yang-sudah-dilakukan)
10. [Mengubah desain / CSS](#10-mengubah-desain--css)
11. [Masalah umum](#11-masalah-umum)

---

## 1. Isi project

| Folder / file | Isi |
|---|---|
| `resources/views/iconnet/*.blade.php` | 25 halaman frontend ICONNET (desain asli, link & aset disesuaikan ke Laravel) |
| `app/Http/Controllers/Iconnet/` | Controller halaman & API: login, sign up, lupa password, presensi, izin, verifikasi peserta, kelola tampilan |
| `app/Support/IconnetData.php` | Mengambil data dari database dalam bentuk yang dibaca halaman frontend |
| `app/Http/Middleware/EnsureIconnetRole.php` | Pembatasan halaman per role (peserta / admin / superadmin) |
| `routes/iconnet.php` | Route halaman (`/beranda`, `/absensi`, …) dan API (`/api/v1/...`) |
| `public/js/iconnet-api.js` | Penghubung halaman ↔ server (data awal + kirim perubahan ke API) |
| `public/js/site-data.js`, `public/js/iconnet-data.js` | Script data frontend, sudah diarahkan ke data server |
| `public/css/*.css` | CSS Tailwind frontend yang **sudah di-build** |
| `public/build/` | Aset Vite (halaman Breeze/panel lama) yang **sudah di-build** |
| `public/images/` | Gambar dari frontend (logo, banner, foto kegiatan) |
| `public/vendor/exceljs/` | Library export Excel (sebelumnya dari CDN, sekarang lokal) |
| `database/migrations/2026_10_22_*` | 7 migrasi **tambahan** (lihat bagian 7) |
| `database/seeders/IconnetKontenSeeder.php` | Konten awal dari desain (opsional, hanya mengisi yang masih kosong) |
| `database/sql/iconnet-integrasi-tambahan.sql` | Versi SQL dari 7 migrasi, untuk hosting tanpa terminal (phpMyAdmin) |
| `vendor/` | Dependensi PHP (Composer) mode produksi, sudah terpasang |
| `tests/Feature/IconnetIntegrasiTest.php` | Uji otomatis alur utama |

Panel lama tetap ada dan tetap berfungsi: **`/staff/...`** (persetujuan izin, persetujuan akun, rekap) dan **`/admin/...`** (banner, keunggulan, paket, prestasi, informasi, testimoni, pengaturan situs).

## 2. Kebutuhan

- **PHP 8.2 atau lebih baru** (diuji di PHP 8.3) dengan ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `gd` (umumnya sudah aktif di XAMPP/Laragon/cPanel).
- **MySQL 5.7+ / MariaDB 10.3+** (diuji di MariaDB). SQLite juga bisa untuk coba cepat.
- **Composer** — hanya perlu jika ingin menjalankan uji otomatis (`vendor/` di ZIP sudah lengkap untuk produksi).
- **Node.js 18+** — hanya perlu jika ingin mengubah desain/CSS (aset sudah di-build).

## 3. Menjalankan di komputer (lokal)

Contoh memakai XAMPP / Laragon. Jalankan perintah di terminal, dari dalam folder project.

### 3a. Siapkan `.env`
```bash
cp .env.example .env        # Windows: copy .env.example .env
php artisan key:generate
```
Buka `.env`, isi koneksi database:
```env
APP_URL=http://127.0.0.1:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iconnet        # nama database
DB_USERNAME=root
DB_PASSWORD=
```

### 3b. Database — pilih salah satu

**A. Memakai database lama yang sudah berisi data** (paling umum):
```bash
# 1) BACKUP dulu (wajib):
mysqldump -u root -p iconnet > backup-iconnet-sebelum-integrasi.sql
# 2) Tambah kolom/tabel baru saja (data lama tidak disentuh):
php artisan migrate
# 3) (Opsional) Isi konten awal desain HANYA ke bagian yang masih kosong:
php artisan db:seed --class=IconnetKontenSeeder
```
`IconnetKontenSeeder` hanya mengisi tabel yang **kosong** (banner, kegiatan, timeline, paket) dan kolom pengaturan yang **kosong** (mis. call center). Data yang sudah ada tidak ditimpa. Aman dijalankan berulang.

**B. Database baru / kosong** (instalasi baru):
```bash
# buat database kosong "iconnet" dulu di phpMyAdmin, lalu:
php artisan migrate
php artisan db:seed                                   # akun contoh + pengaturan (seeder bawaan backend)
php artisan db:seed --class=IconnetKontenSeeder       # konten awal dari desain frontend
```

### 3c. Folder foto & jalankan
```bash
php artisan storage:link     # agar foto presensi & foto yang diunggah bisa tampil
php artisan serve
```
Buka **http://127.0.0.1:8000**.

> Kamera presensi hanya berjalan di `http://localhost` / `http://127.0.0.1` atau **https**. Jika dibuka lewat IP jaringan (mis. `http://192.168.x.x`), browser akan memblokir kamera.

## 4. Hosting

### 4a. Persiapan (berlaku untuk semua jenis hosting)
1. **Backup database** yang sudah ada (phpMyAdmin → Export → Go), simpan filenya.
2. Upload isi ZIP ke server (tanpa file `.env` dari komputer Anda).
3. Buat `.env` di server dari `.env.example`, lalu isi:
```env
APP_NAME=ICONNET
APP_ENV=production
APP_DEBUG=false                       # WAJIB false di hosting
APP_URL=https://domainanda.com        # alamat website, pakai https

DB_CONNECTION=mysql
DB_HOST=localhost                     # dari panel hosting (umumnya localhost)
DB_PORT=3306
DB_DATABASE=namauser_iconnet          # nama database di hosting
DB_USERNAME=namauser_iconnet          # user database di hosting
DB_PASSWORD=passwordDatabase

# Email untuk "Lupa Password" (contoh SMTP email hosting / Gmail App Password)
MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=mail.domainanda.com
MAIL_PORT=465
MAIL_USERNAME=no-reply@domainanda.com
MAIL_PASSWORD=passwordEmail
MAIL_FROM_ADDRESS="no-reply@domainanda.com"
MAIL_FROM_NAME="ICONNET"
```
4. **Wajib HTTPS** (aktifkan SSL gratis/AutoSSL di panel hosting). Tanpa https, kamera presensi tidak bisa dibuka browser.

### 4b. Database di server
- **Database sudah ada di hosting (berisi data):** cukup tambahkan perubahan baru.
  - Ada terminal/SSH: `php artisan migrate --force` (tanpa `fresh`/`reset`).
  - Tidak ada terminal: phpMyAdmin → pilih database → tab **SQL** → tempel isi `database/sql/iconnet-integrasi-tambahan.sql` → **Go**. Jalankan sekali saja.
- **Pindah dari komputer ke hosting:** di komputer, export database (phpMyAdmin → Export). Di panel hosting buat database + user (cPanel → *MySQL Databases*: buat database, buat user, *Add User To Database* dengan *ALL PRIVILEGES*), lalu phpMyAdmin hosting → Import file tadi. Jika database lokal belum dimigrasi, jalankan langkah di atas setelah import.
- **Database baru kosong:** `php artisan migrate --force`, `php artisan db:seed --force`, `php artisan db:seed --class=IconnetKontenSeeder --force`. **Segera ganti password akun contoh** (bagian 5).

### 4c. Shared hosting (cPanel)
Laravel harus dibuka dari folder `public`. Pilih salah satu:

**Cara 1 (disarankan) — arahkan domain ke folder `public`:**
upload project ke mis. `/home/namauser/iconnet`, lalu di cPanel → *Domains* → ubah **Document Root** domain menjadi `/home/namauser/iconnet/public`.

**Cara 2 — jika Document Root tidak bisa diubah (`public_html`):**
1. Upload project ke `/home/namauser/iconnet` (di **luar** `public_html`).
2. Salin **isi** folder `iconnet/public/` ke `public_html/` (termasuk `.htaccess`).
3. Edit `public_html/index.php`, ubah dua baris path:
```php
require __DIR__.'/../iconnet/vendor/autoload.php';
$app = require_once __DIR__.'/../iconnet/bootstrap/app.php';
```
   dan untuk Laravel 12 juga baris maintenance:
```php
if (file_exists($maintenance = __DIR__.'/../iconnet/storage/framework/maintenance.php')) {
```
4. Buat link foto: di cPanel → *Terminal* jalankan
   `ln -s /home/namauser/iconnet/storage/app/public /home/namauser/public_html/storage`
   (jika tidak ada Terminal, buat **Cron Job** sekali jalan berisi perintah yang sama, lalu hapus cron-nya).

Lalu (lewat cPanel → *Terminal*, dari folder project):
```bash
php artisan storage:link        # hanya untuk Cara 1
php artisan migrate --force     # atau pakai file SQL lewat phpMyAdmin (bagian 4b)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
Pastikan versi PHP domain ≥ 8.2 (cPanel → *MultiPHP Manager* / *Select PHP Version*).
Folder `storage/` dan `bootstrap/cache/` harus bisa ditulis (permission 755/775).

### 4d. VPS (Ubuntu + Nginx)
```bash
sudo apt install nginx mariadb-server php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-bcmath php8.3-gd php8.3-curl php8.3-zip unzip
sudo mysql -e "CREATE DATABASE iconnet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
  CREATE USER 'iconnet'@'localhost' IDENTIFIED BY 'passwordKuat';
  GRANT ALL ON iconnet.* TO 'iconnet'@'localhost'; FLUSH PRIVILEGES;"
# upload & ekstrak project ke /var/www/iconnet, buat .env (bagian 4a), lalu:
cd /var/www/iconnet
php artisan key:generate         # hanya jika APP_KEY masih kosong
php artisan migrate --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
sudo chown -R www-data:www-data storage bootstrap/cache
```
Contoh blok Nginx (root ke `public`):
```nginx
server {
    server_name domainanda.com;
    root /var/www/iconnet/public;
    index index.php;
    client_max_body_size 20M;              # unggah bukti izin & foto (maks 10MB)
    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }
}
```
Pasang https: `sudo certbot --nginx -d domainanda.com`.
Di `php.ini` naikkan `upload_max_filesize = 12M` dan `post_max_size = 20M` (berlaku juga di shared hosting lewat *Select PHP Version → Options*).

### 4e. Setiap kali update file di hosting
```bash
php artisan migrate --force      # hanya menjalankan migrasi baru
php artisan config:cache && php artisan route:cache && php artisan view:cache
```
Jika mengubah `.env`, jalankan ulang `php artisan config:cache`.

## 5. Akun & halaman per role

Akun contoh **hanya ada jika menjalankan `php artisan db:seed`** pada database baru (seeder bawaan backend). Password semua: `password` — **ganti setelah login** (menu Profil).

| Role | Email contoh | Halaman setelah login |
|---|---|---|
| Peserta magang (role `karyawan` di database) | `karyawan@iconnect.test` | `/beranda`, `/absensi`, `/riwayat`, `/profil` |
| Admin | `admin@iconnect.test` | `/beranda-admin`, `/verifikasi-user`, `/akun-user`, `/profil-admin` + panel lama `/staff/...` |
| Superadmin | `superadmin@iconnect.test` | `/beranda-superadmin`, `/riwayat-superadmin`, `/rekap-superadmin`, `/kelola-beranda`, `/kelola-tentang-kami`, `/kelola-paket-harga`, `/kelola-hubungi-kami`, `/profil-superadmin` + panel lama `/staff/...` & `/admin/...` |

Halaman publik: `/`, `/keseruan`, `/keseruan-detail?id=..`, `/tentang-kami`, `/paket-harga`, `/hubungi-kami`, `/login`, `/signup`, `/forgot-password`.
Link lama berakhiran `.html` (mis. `/beranda.html`) otomatis diarahkan ke alamat barunya. Route lama `/absen`, `/absen/riwayat`, `/izin`, `/paket`, `/saran-kritik`, `/dashboard` diarahkan ke halaman baru yang sesuai.

Alur akun: **Sign Up** → akun berstatus *menunggu* → admin menyetujui/menolak di **Verifikasi User** → peserta bisa login. Akun ditolak/menunggu tidak bisa login (pesan muncul di halaman login), sama seperti aturan backend lama.

## 6. Dari mana data tiap halaman diambil

| Bagian di frontend | Tabel / kolom di database |
|---|---|
| Akun, login, profil | `users` (role `karyawan` = peserta; status `pending/approved/rejected` = menunggu/disetujui/ditolak) |
| Data peserta (telepon, jenis kelamin, sekolah, alasan ditolak) | `users` kolom baru `telepon`, `jenis_kelamin`, `sekolah`, `alasan_penolakan` |
| Presensi masuk/pulang + foto | `absensis` (foto di `storage/app/public/absensi`, sama seperti sistem lama). Status *Terlambat* jika jam masuk > `pengaturans.jam_masuk_standar` |
| Pengajuan izin/sakit + bukti | `izins` (+ kolom baru `jenis`, `tanggal_selesai`, `bukti`, `bukti_nama`). File bukti disimpan **privat** di `storage/app/private/izin` dan hanya bisa dibuka pemiliknya, admin, dan superadmin |
| Banner beranda | `banners` (+ `jenis`, `teks_tombol`, `aktif`) |
| Keseruan Bersama / foto kegiatan | `testimonis` (+ `highlight` = kata yang diberi warna di judul detail). Paragraf isi dipisah baris baru |
| Tentang Kami (paragraf) | `pengaturans.tentang` |
| Perjalanan ICONNET (timeline) | tabel baru `perjalanans` |
| Paket & Harga | `pakets`: `harga` = harga yang dibayar (harga promo untuk paket promo), `harga_normal` (baru) = harga coret, `fitur[0]` = kapasitas perangkat, `fitur[1]` = kualitas |
| Hubungi Kami + footer | `pengaturans`: `alamat`, `call_center` (baru), `no_wa_sales` (WhatsApp), `email`, `jam_operasional`, `instagram`, `facebook`, `tiktok`, `twitter` |

Perubahan dari halaman *Kelola* superadmin langsung tersimpan di database dan tampil di website publik (juga di panel lama `/admin/...`, karena tabelnya sama).

## 7. Perubahan database (hanya tambahan)

| Migrasi | Isi |
|---|---|
| `2026_10_22_000001` | `users`: + `telepon`, `jenis_kelamin`, `sekolah`, `alasan_penolakan`, `deleted_at` |
| `2026_10_22_000002` | `banners`: + `jenis` (default `lengkap`), `teks_tombol`, `aktif` (default 1) |
| `2026_10_22_000003` | `testimonis`: + `highlight` |
| `2026_10_22_000004` | `pakets`: + `harga_normal` |
| `2026_10_22_000005` | `pengaturans`: + `call_center` |
| `2026_10_22_000006` | tabel baru `perjalanans` |
| `2026_10_22_000007` | `izins`: + `jenis` (default `izin`), `tanggal_selesai`, `bukti`, `bukti_nama` |

Semua kolom baru boleh kosong atau punya nilai default, jadi data lama tetap valid dan tidak berubah. Setiap migrasi memeriksa dulu apakah kolom/tabel sudah ada (aman dijalankan ulang). Membatalkan (`php artisan migrate:rollback --step=7`) hanya menghapus kolom/tabel tambahan ini.

## 8. Keputusan & asumsi

- **Hapus akun** di halaman *Akun User* memakai *soft delete* (`users.deleted_at`): akun hilang dari daftar dan tidak bisa login, tetapi **riwayat presensi & izinnya tetap tersimpan** untuk rekap.
- **Pengajuan izin/sakit** dari halaman Presensi tersimpan dengan status `pending` (sama seperti alur izin lama) dan langsung terlihat di riwayat. Persetujuan/penolakan izin tetap lewat panel lama **`/staff/izin`** (desain baru tidak punya halaman persetujuan izin). Izin yang **ditolak** tidak dihitung sebagai izin/sakit di halaman baru.
- **Visi & Misi** di Tentang Kami tetap seperti di desain (desain tidak punya menu kelola untuk itu). Data `visi`/`misi` lama di database tidak diubah.
- **Alamat** di Hubungi Kami memakai kolom `alamat` (kolom `kota` lama tetap ada, tidak ditampilkan di desain baru).
- **Nama paket** tidak ditampilkan di desain baru; untuk paket baru diisi otomatis “Paket Promo” / “Paket Reguler”, durasi promo “3 Bulan”.
- **Login Google/Apple** pada desain belum diaktifkan, karena butuh verifikasi token di server (mis. Laravel Socialite + Client ID). Tombolnya menampilkan pesan bahwa fitur belum aktif.
- **Lupa password** mengirim **link reset ke email** (fitur reset password Laravel), lalu password baru diisi di halaman desain yang sama. Perlu pengaturan SMTP di `.env` (lokal: email ditulis ke `storage/logs/laravel.log`).
- **Tombol “lihat password”** di halaman profil tidak menampilkan password lama, karena password disimpan terenkripsi (hash).
- Jam presensi memakai **jam server** zona **Asia/Makassar (WITA)**, bukan jam perangkat peserta.
- Fitur backend lama yang tidak ada di desain baru (**keunggulan, prestasi, informasi terbaru, saran & kritik, pengaturan situs lainnya**) tetap tersedia di panel lama `/admin/...` dan `/staff/...`.
- Library ExcelJS (export Rekap) disimpan lokal di `public/vendor/exceljs` agar tidak bergantung CDN.

## 9. Pengujian yang sudah dilakukan

Diuji pada salinan database (SQLite dan MariaDB) yang dibuat dari migrasi & seeder **asli** backend + contoh data lama:
- Migrasi tambahan dijalankan di atas database lama: jumlah dan isi data `users`, `absensis`, `izins`, `pakets`, `pengaturans`, `keunggulans`, `informasis` **tidak berubah**. Rollback & migrasi ulang juga aman. File SQL phpMyAdmin diuji dengan cara yang sama.
- Semua 25 halaman dibuka per role di browser (Chromium) tanpa error JavaScript; tampilan dibandingkan dengan file HTML asli (layout & CSS identik, yang berbeda hanya isi data dari database).
- Alur lengkap: sign up → login ditolak saat menunggu → admin menyetujui/menolak → login → absen masuk & pulang dengan kamera → cegah absen ganda → pengajuan sakit + unggah bukti → buka bukti (pemilik boleh, orang lain ditolak) → ganti password → logout → superadmin tambah/ubah/nonaktifkan/hapus banner, tambah kegiatan, timeline, ubah Tentang Kami, tambah paket (validasi harga promo), ubah Hubungi Kami → perubahan tampil di website publik → admin hapus akun → lupa password via link email → login dengan password baru.
- Panel lama `/staff/*` dan `/admin/*` tetap terbuka normal.
- `php artisan test --filter=IconnetIntegrasiTest` → 6 uji lulus.
  Catatan: 9 uji bawaan Breeze (`tests/Feature/Auth/*`, `ProfileTest`, `ExampleTest`) juga **gagal di repo backend asli** sebelum integrasi, karena backend sudah mengubah alur bawaan Breeze (mis. route `/profile` tidak ada, akun baru wajib di-ACC). Uji tersebut dibiarkan apa adanya.
  Untuk menjalankan uji: `composer install` (memasang paket dev) lalu `php artisan test`.

## 10. Mengubah desain / CSS

CSS halaman ICONNET dibuat dengan Tailwind (konfigurasi di `tailwind/iconnet/`, satu config per kelompok halaman: `site`, `auth`, `dashboard`, `panel`, `superadmin`).
```bash
npm ci
npm run build            # build Vite + CSS ICONNET
npm run watch:iconnet    # build ulang CSS ICONNET otomatis saat file Blade diubah
```
Upload ulang folder `public/css` dan `public/build` setelah build.

## 11. Masalah umum

| Masalah | Solusi |
|---|---|
| Error 500 setelah upload | Cek `storage/logs/laravel.log`. Biasanya `.env` belum dibuat, `APP_KEY` kosong (`php artisan key:generate`), atau folder `storage`/`bootstrap/cache` tidak bisa ditulis |
| Foto presensi / banner tidak tampil | Link `public/storage` belum dibuat (`php artisan storage:link`, atau perintah `ln -s` di bagian 4c) |
| Kamera tidak mau terbuka | Website harus dibuka lewat **https** (atau localhost), dan izin kamera di browser diizinkan |
| Halaman “419 / Sesi halaman kedaluwarsa” | Muat ulang halaman lalu login lagi. Pastikan `APP_URL` sama dengan alamat website |
| Email lupa password tidak masuk | Isi pengaturan `MAIL_...` di `.env` lalu `php artisan config:cache` |
| Unggah bukti izin gagal (file besar) | Naikkan `upload_max_filesize` & `post_max_size` di PHP (bagian 4d) |
| Perubahan `.env` tidak berpengaruh | Jalankan `php artisan config:clear` atau `php artisan config:cache` |
