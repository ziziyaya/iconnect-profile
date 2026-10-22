<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->string('instagram')->nullable()->after('email');
            $table->string('twitter')->nullable()->after('instagram');
            $table->string('facebook')->nullable()->after('twitter');
            $table->string('tiktok')->nullable()->after('facebook');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturans', function (Blueprint $table) {
            $table->dropColumn(['instagram', 'twitter', 'facebook', 'tiktok']);
        });
    }
};
