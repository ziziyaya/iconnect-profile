-- =====================================================================
-- ICONNET: perubahan database TAMBAHAN untuk integrasi frontend (MySQL / MariaDB)
-- Pakai file ini HANYA jika hosting tidak punya akses terminal untuk "php artisan migrate".
-- Isinya sama dengan migrasi database/migrations/2026_10_22_*.php:
--   hanya MENAMBAH kolom/tabel baru. Tidak ada data, tabel, atau kolom lama yang dihapus/diubah.
-- Cara pakai: BACKUP database dulu (phpMyAdmin > Export), lalu phpMyAdmin > pilih database > tab SQL > tempel isi file ini > Go.
-- Jalankan SEKALI saja. Jika muncul "Duplicate column name", berarti perubahan itu sudah pernah dijalankan.
-- =====================================================================

alter table `users` add `telepon` varchar(30) null after `email`;
alter table `users` add `jenis_kelamin` varchar(1) null after `telepon`;
alter table `users` add `sekolah` varchar(150) null after `jenis_kelamin`;
alter table `users` add `alasan_penolakan` text null after `status`;
alter table `users` add `deleted_at` timestamp null;
alter table `banners` add `jenis` varchar(20) not null default 'lengkap' after `id`;
alter table `banners` add `teks_tombol` varchar(60) null after `deskripsi`;
alter table `banners` add `aktif` tinyint(1) not null default '1' after `teks_tombol`;
alter table `testimonis` add `highlight` varchar(100) null after `judul`;
alter table `pakets` add `harga_normal` bigint unsigned null after `harga`;
alter table `pengaturans` add `call_center` varchar(30) null after `no_wa_sales`;
create table `perjalanans` (`id` bigint unsigned not null auto_increment primary key, `tahun` varchar(4) not null, `judul` varchar(150) not null, `deskripsi` text not null, `urutan` int unsigned not null default '0', `created_at` timestamp null, `updated_at` timestamp null) default character set utf8mb4 collate 'utf8mb4_unicode_ci';
alter table `izins` add `jenis` varchar(10) not null default 'izin' after `user_id`;
alter table `izins` add `tanggal_selesai` date null after `tanggal`;
alter table `izins` add `bukti` varchar(255) null after `alasan`;
alter table `izins` add `bukti_nama` varchar(255) null after `bukti`;

-- Catat migrasi sebagai sudah dijalankan, supaya "php artisan migrate" di kemudian hari tidak mengulanginya
SET @batch = (SELECT IFNULL(MAX(batch), 0) + 1 FROM migrations);
INSERT INTO migrations (migration, batch) VALUES
  ('2026_10_22_000001_add_profil_peserta_to_users_table', @batch),
  ('2026_10_22_000002_add_tampilan_to_banners_table', @batch),
  ('2026_10_22_000003_add_highlight_to_testimonis_table', @batch),
  ('2026_10_22_000004_add_harga_normal_to_pakets_table', @batch),
  ('2026_10_22_000005_add_call_center_to_pengaturans_table', @batch),
  ('2026_10_22_000006_create_perjalanans_table', @batch),
  ('2026_10_22_000007_add_detail_to_izins_table', @batch);
