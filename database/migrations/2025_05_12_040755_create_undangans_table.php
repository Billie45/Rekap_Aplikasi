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
        Schema::create('undangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekap_aplikasi_id')->constrained('rekap_aplikasi')->onDelete('cascade');
            $table->date('tanggal_undangan');
            $table->string('assessment_dokumentasi')->nullable();
            $table->text('catatan_assessment')->nullable();
            $table->string('surat_rekomendasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('undangans');
    }
};
