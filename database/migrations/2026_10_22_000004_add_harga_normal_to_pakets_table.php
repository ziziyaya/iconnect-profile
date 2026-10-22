<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Harga normal (dicoret) untuk paket promo. Kolom 'harga' tetap = harga yang dibayar.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            if (! Schema::hasColumn('pakets', 'harga_normal')) {
                $table->unsignedBigInteger('harga_normal')->nullable()->after('harga');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pakets', function (Blueprint $table) {
            if (Schema::hasColumn('pakets', 'harga_normal')) {
                $table->dropColumn('harga_normal');
            }
        });
    }
};
