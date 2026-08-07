# Panduan: IConnect — Absensi Karyawan + Company Profile

Ini versi baru, ganti total dari versi sebelumnya (company profile doang). Sekarang ada sistem login 3 role: **Superadmin**, **Admin**, **Karyawan** — dan fitur absen pakai kamera.

## Kenapa perlu reset folder & database?

Skema database-nya beda total dari versi sebelumnya (tabel baru: `banners`, `keunggulans`, `absensis`, kolom baru di `users`). Daripada ribet edit satu-satu migration lama, lebih cepat & aman **hapus folder project lama, bikin ulang** — tapi nama project & database **tetap sama** (`iconnect-profile`) sesuai maumu.

---

## Langkah 1: Reset folder project

1. Tutup dulu server kalau masih jalan (`Ctrl + C` di terminal `php artisan serve`)
2. Hapus folder `C:\xamppcute\htdocs\iconnect-profile` (folder lama)
3. Buat ulang dari nol:
```bash
cd C:\xamppcute\htdocs
composer create-project laravel/laravel iconnect-profile
cd iconnect-profile

composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
```

## Langkah 2: Reset database

1. Buka `http://localhost/phpmyadmin`
2. Klik database `iconnect-profile` di sidebar kiri
3. Klik tab **Operations**, scroll ke bawah, klik **Drop the database (DROP)** — atau paling gampang: klik kanan database itu → **Drop**
4. Klik **New** lagi, bikin database baru nama `iconnect-profile` (sama persis)

## Langkah 3: Setting `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iconnect-profile
DB_USERNAME=root
DB_PASSWORD=
```

## Langkah 4: Salin semua file dari zip

1. Extract `laravel-files.zip` terbaru
2. Taruh `deploy-windows.bat` sejajar folder `laravel-files` hasil extract
3. Double-click, masukin path: `C:\xamppcute\htdocs\iconnect-profile`
4. Tunggu sampai selesai

## Langkah 5: Daftarkan middleware

Buka `bootstrap/app.php`, ikuti instruksi di `CARA-DAFTAR-MIDDLEWARE.txt` — tambahkan alias `superadmin` dan `staff`.

## Langkah 6: Aktifkan folder storage (buat foto banner & foto absen)

```bash
php artisan storage:link
```
Ini WAJIB dijalankan, kalau tidak, foto banner dan foto absen tidak akan muncul di browser.

## Langkah 7: Migrate & seed

```bash
php artisan migrate --seed
```

## Langkah 8: Jalankan

```bash
php artisan serve
```
Buka `127.0.0.1:8000`.

---

## Akun contoh buat testing

| Role | Email | Password |
|---|---|---|
| Superadmin | `superadmin@iconnect.test` | `password` |
| Admin | `admin@iconnect.test` | `password` |
| Karyawan (contoh, sudah di-ACC) | `karyawan@iconnect.test` | `password` |

## Alur pemakaian sistemnya

**Publik (belum login):**
- Beranda: banner geser, tentang perusahaan, kenapa pilih kami, lokasi
- Berlangganan: info paket + tombol langsung ke WhatsApp sales
- Tombol **Login Karyawan** di navbar

**Karyawan baru (daftar sendiri):**
1. Klik Login → klik link **Register** di halaman login
2. Isi form daftar → otomatis jadi status **pending**, belum bisa login
3. Nunggu admin/superadmin nge-ACC dulu

**Admin / Superadmin (approve karyawan):**
1. Login → masuk ke Panel
2. Menu **Persetujuan Karyawan** → klik **ACC** buat approve, atau **Tolak**
3. Setelah di-ACC, karyawan itu baru bisa login

**Karyawan yang sudah di-ACC:**
1. Login → otomatis masuk halaman **Absen**
2. Browser bakal minta izin akses kamera — klik **Allow**
3. Klik **Ambil Foto & Absen Masuk** → foto kesimpen, jam masuk tercatat
4. Nanti pas mau pulang, buka lagi halaman Absen → tombolnya berubah jadi **Absen Pulang**
5. Bisa cek **Riwayat Absen** buat lihat history sendiri

**Superadmin (kelola konten):**
- **Banner Beranda** — upload gambar buat slider di beranda
- **Kenapa Pilih Kami** — kelola poin-poin keunggulan
- **Paket Layanan** — kelola daftar paket WiFi
- **Pengaturan Situs** — nama perusahaan, tagline, tentang, alamat, WA sales, dll
- Superadmin juga bisa akses **Persetujuan Karyawan** dan **Rekap Absensi** (sama kaya admin)

**Admin & Superadmin** juga bisa **Rekap Absensi** — lihat siapa aja yang udah absen di tanggal tertentu, lengkap sama foto.

---

## Catatan soal kamera

Fitur kamera (`getUserMedia`) cuma jalan di **localhost** (`127.0.0.1`) tanpa perlu HTTPS — jadi aman dicoba pakai `php artisan serve` seperti biasa. Kalau nanti di-hosting online (bukan localhost), wajib pakai HTTPS baru kameranya bisa diakses browser.

Yang pertama kali harus kamu ganti setelah login sebagai superadmin: **Pengaturan Situs** (nomor WA sales, alamat, link Google Maps — masih data contoh), **Banner** (masih kosong, upload gambar promo asli), dan **Kenapa Pilih Kami** (sudah ada 3 contoh, edit sesuai kebutuhan).
