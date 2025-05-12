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
        Schema::table('rekap_aplikasi', function (Blueprint $table) {
            $table->enum('jenis_assessment', ['Pertama', 'Revisi'])->nullable()->after('assesment_terakhir');
            $table->enum('jenis_jawaban', ['Diterima', 'Ditolak'])->nullable()->after('jenis_assessment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekap_aplikasi', function (Blueprint $table) {
            $table->dropColumn(['jenis_assessment', 'jenis_jawaban']);
        });
    }
};
