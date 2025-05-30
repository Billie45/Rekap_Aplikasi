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
        Schema::create('revisi_penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('penilaians')->onDelete('cascade');
            $table->text('catatan_revisi');
            $table->string('dokumen_revisi')->nullable();
            $table->string('dokumen_laporan')->nullable();
            $table->enum('status', ['diajukan', 'diproses', 'selesai'])->default('diajukan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revisi_penilaians');
    }
};
