<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Kata yang diberi highlight di judul halaman detail Keseruan (opsional).
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonis', function (Blueprint $table) {
            if (! Schema::hasColumn('testimonis', 'highlight')) {
                $table->string('highlight', 100)->nullable()->after('judul');
            }
        });
    }

    public function down(): void
    {
        Schema::table('testimonis', function (Blueprint $table) {
            if (Schema::hasColumn('testimonis', 'highlight')) {
                $table->dropColumn('highlight');
            }
        });
    }
};
