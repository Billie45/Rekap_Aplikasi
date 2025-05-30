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
            $table->date('tanggal_assessment');
            $table->string('surat_undangan')->nullable();
            $table->string('link_zoom_meeting')->nullable();
            $table->date('tanggal_zoom_meeting')->nullable();
            $table->string('waktu_zoom_meeting')->nullable();
            $table->string('tempat')->nullable();
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
