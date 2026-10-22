<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tambahan untuk halaman Kelola Beranda: jenis banner (foto + teks / foto saja),
// teks tombol, dan status tampil. Banner lama otomatis 'lengkap' & tetap tampil.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            if (! Schema::hasColumn('banners', 'jenis')) {
                $table->string('jenis', 20)->default('lengkap')->after('id'); // lengkap | foto
            }
            if (! Schema::hasColumn('banners', 'teks_tombol')) {
                $table->string('teks_tombol', 60)->nullable()->after('deskripsi');
            }
            if (! Schema::hasColumn('banners', 'aktif')) {
                $table->boolean('aktif')->default(true)->after('teks_tombol');
            }
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            foreach (['jenis', 'teks_tombol', 'aktif'] as $kolom) {
                if (Schema::hasColumn('banners', $kolom)) {
                    $table->dropColumn($kolom);
                }
            }
        });
    }
};
