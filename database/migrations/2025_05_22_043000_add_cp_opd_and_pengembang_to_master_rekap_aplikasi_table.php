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
            // CP OPD
            $table->string('cp_opd_nama')->nullable();
            $table->string('cp_opd_no_telepon')->nullable();

            // CP Pengembang
            $table->string('cp_pengembang_nama')->nullable();
            $table->string('cp_pengembang_no_telepon')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_rekap_aplikasi', function (Blueprint $table) {
            $table->dropColumn([
                'cp_opd_nama',
                'cp_opd_no_telepon',
                'cp_pengembang_nama',
                'cp_pengembang_no_telepon',
            ]);
        });
    }
};
