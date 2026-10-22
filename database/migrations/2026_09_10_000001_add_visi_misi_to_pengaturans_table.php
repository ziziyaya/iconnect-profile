<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->text('visi')->nullable()->after('tentang');
            $table->text('misi')->nullable()->after('visi');
            // Jam masuk standar, dipakai buat hitung status "Terlambat" di dashboard karyawan
            $table->time('jam_masuk_standar')->default('08:00:00')->after('jam_operasional');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->dropColumn(['visi', 'misi', 'jam_masuk_standar']);
        });
    }
};
