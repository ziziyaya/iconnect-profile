<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            // reguler = paket biasa, promo = paket promo/diskon jangka waktu tertentu
            $table->enum('kategori', ['reguler', 'promo'])->default('reguler')->after('nama');
            $table->string('durasi')->nullable()->after('kategori'); // contoh: "3 Bulan"
        });
    }

    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'durasi']);
        });
    }
};
