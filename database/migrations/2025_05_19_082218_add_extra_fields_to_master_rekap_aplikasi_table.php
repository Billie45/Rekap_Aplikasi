<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('master_rekap_aplikasi', function (Blueprint $table) {
            $table->string('tipe')->nullable();
            $table->string('jenis')->nullable();
            $table->string('jenis_permohonan')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('akun_link')->nullable();
            $table->string('akun_username')->nullable();
            $table->string('akun_password')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_rekap_aplikasi', function (Blueprint $table) {
            $table->dropColumn([
                'tipe',
                'jenis',
                'jenis_permohonan',
                'subdomain',
                'akun_link',
                'akun_username',
                'akun_password',
            ]);
        });
    }
};
