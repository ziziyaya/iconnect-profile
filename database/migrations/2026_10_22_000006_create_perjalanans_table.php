<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Timeline "Perjalanan ICONNET" di halaman Tentang Kami (dikelola dari Kelola Tentang Kami).
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('perjalanans')) {
            return;
        }

        Schema::create('perjalanans', function (Blueprint $table) {
            $table->id();
            $table->string('tahun', 4);
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perjalanans');
    }
};
