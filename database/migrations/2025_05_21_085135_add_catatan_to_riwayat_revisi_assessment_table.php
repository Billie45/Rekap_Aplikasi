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
        Schema::table('riwayat_revisi_assessment', function (Blueprint $table) {
            $table->text('catatan')->nullable()->after('surat_permohonan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_revisi_assessment', function (Blueprint $table) {
            $table->dropColumn('catatan');
        });
    }
};
