<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Form izin/sakit di halaman Presensi: jenis, rentang tanggal, dan file bukti.
// Kolom 'tanggal' tetap dipakai sebagai tanggal mulai, 'status' tetap alur persetujuan lama.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('izins', function (Blueprint $table) {
            if (! Schema::hasColumn('izins', 'jenis')) {
                $table->string('jenis', 10)->default('izin')->after('user_id'); // izin | sakit
            }
            if (! Schema::hasColumn('izins', 'tanggal_selesai')) {
                $table->date('tanggal_selesai')->nullable()->after('tanggal');
            }
            if (! Schema::hasColumn('izins', 'bukti')) {
                $table->string('bukti')->nullable()->after('alasan');
            }
            if (! Schema::hasColumn('izins', 'bukti_nama')) {
                $table->string('bukti_nama')->nullable()->after('bukti');
            }
        });
    }

    public function down(): void
    {
        Schema::table('izins', function (Blueprint $table) {
            foreach (['jenis', 'tanggal_selesai', 'bukti', 'bukti_nama'] as $kolom) {
                if (Schema::hasColumn('izins', $kolom)) {
                    $table->dropColumn($kolom);
                }
            }
        });
    }
};
