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
        Schema::create('status_servers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('penilaians')->onDelete('cascade')->unique();
            $table->string('nama_server'); // tambah kolom nama_server
            $table->date('tanggal_masuk_server');
            $table->enum('status_server', ['development', 'production', 'luar']);
            $table->string('permohonan')->nullable(); // path file PDF
            $table->string('dokumen_teknis')->nullable(); // path file PDF
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_servers');
    }
};
