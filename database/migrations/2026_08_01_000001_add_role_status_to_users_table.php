<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // superadmin = akses semua fitur
            // admin      = approve akun karyawan + absen sendiri
            // karyawan   = cuma absen
            $table->enum('role', ['superadmin', 'admin', 'karyawan'])->default('karyawan')->after('email');

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
};
