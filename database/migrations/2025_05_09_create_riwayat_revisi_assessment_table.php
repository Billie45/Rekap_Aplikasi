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
        Schema::create('riwayat_revisi_assessment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekap_aplikasi_id')->constrained('rekap_aplikasi')->onDelete('cascade');
            $table->date('permohonan')->nullable();
            $table->string('opd_id')->nullable();
            $table->string('jenis')->nullable();
            $table->string('nama')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('tipe')->nullable();
            $table->string('jenis_permohonan')->nullable();
            $table->string('link_dokumentasi')->nullable();
            $table->string('akun_link')->nullable();
            $table->string('akun_username')->nullable();
            $table->string('akun_password')->nullable();
            $table->string('cp_opd_nama')->nullable();
            $table->string('cp_opd_no_telepon')->nullable();
            $table->string('cp_pengembang_nama')->nullable();
            $table->string('cp_pengembang_no_telepon')->nullable();
            $table->string('surat_permohonan')->nullable();
            $table->timestamp('tanggal_pengajuan')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_revisi_assessment');
    }
};
