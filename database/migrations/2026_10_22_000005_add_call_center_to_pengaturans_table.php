<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Nomor call center untuk halaman Hubungi Kami & footer website.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            if (! Schema::hasColumn('pengaturans', 'call_center')) {
                $table->string('call_center', 30)->nullable()->after('no_wa_sales');
            }
        });
    }

    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            if (Schema::hasColumn('pengaturans', 'call_center')) {
                $table->dropColumn('call_center');
            }
        });
    }
};
