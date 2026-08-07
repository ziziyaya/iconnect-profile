<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan')->default('IConnect');
            $table->string('tagline')->nullable();
            $table->text('tentang')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('no_wa_sales')->nullable();
            $table->string('email')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->string('maps_embed_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
