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
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekap_aplikasi_id')->constrained('rekap_aplikasi')->onDelete('cascade');
            $table->string('dokumen_hasil_assessment')->nullable();
            $table->date('tanggal_deadline_perbaikan')->nullable();
            $table->enum('keputusan_assessment', ['lulus_tanpa_revisi', 'lulus_dengan_revisi', 'assessment_ulang', 'tidak_lulus'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};
