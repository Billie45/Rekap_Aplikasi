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
        Schema::table('revisi_penilaians', function (Blueprint $table) {
            $table->text('dokumen_laporan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revisi_penilaians', function (Blueprint $table) {
            $table->string('dokumen_laporan')->nullable()->change();
        });
    }
};
