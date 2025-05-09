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
        Schema::create('rekap_aplikasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('subdomain')->nullable();
            $table->enum('tipe', ['web', 'apk'])->nullable();
            $table->enum('jenis', ['pengembangan', 'baru'])->nullable();
            $table->enum('status', ['diproses', 'perbaikan', 'assessment1', 'assessment2', 'development', 'prosesBA', 'selesai', 'batal'])->default('diproses');
            $table->string('server')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('last_update')->nullable();
            $table->enum('jenis_permohonan', ['subdomain', 'permohonan'])->nullable();
            $table->date('tanggal_masuk_ba')->nullable();
            $table->string('link_dokumentasi')->nullable();

            // Kolom akun
            $table->string('akun_link')->nullable();
            $table->string('akun_username')->nullable();
            $table->string('akun_password')->nullable();

            // CP OPD
            $table->string('cp_opd_nama')->nullable();
            $table->string('cp_opd_no_telepon')->nullable();

            // CP Pengembang
            $table->string('cp_pengembang_nama')->nullable();
            $table->string('cp_pengembang_no_telepon')->nullable();

            // Rekap Aplikasi
            $table->date('assesment_terakhir')->nullable();

            // Development
            // --- tidak ada data yang ---

            // Assessment
            $table->date('permohonan')->nullable();
            $table->date('undangan_terakhir')->nullable();
            $table->date('laporan_perbaikan')->nullable();

            // Server
            $table->enum('status_server', ['OPEN', 'CLOSE'])->nullable();
            $table->date('open_akses')->nullable();
            $table->date('close_akses')->nullable();
            $table->string('urgensi')->nullable();

            // Relasi ke OPD
            $table->foreignId('opd_id')->constrained('opds')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_aplikasi');
    }
};
