<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Tambahan untuk frontend ICONNET: data pendaftaran peserta magang (sign up) + alasan penolakan
// + soft delete (Hapus Akun di halaman Akun User tidak menghapus riwayat presensi).
// Hanya MENAMBAH kolom baru (semuanya nullable), tidak mengubah kolom/data yang sudah ada.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'telepon')) {
                $table->string('telepon', 30)->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->string('jenis_kelamin', 1)->nullable()->after('telepon'); // L / P
            }
            if (! Schema::hasColumn('users', 'sekolah')) {
                $table->string('sekolah', 150)->nullable()->after('jenis_kelamin');
            }
            if (! Schema::hasColumn('users', 'alasan_penolakan')) {
                $table->text('alasan_penolakan')->nullable()->after('status');
            }
            if (! Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['telepon', 'jenis_kelamin', 'sekolah', 'alasan_penolakan', 'deleted_at'] as $kolom) {
                if (Schema::hasColumn('users', $kolom)) {
                    $table->dropColumn($kolom);
                }
            }
        });
    }
};
