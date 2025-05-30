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
        Schema::create('bas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilaian_id')->constrained('penilaians')->onDelete('cascade');
            $table->date('tanggal_pelaksanaan');
            $table->text('ringkasan_hasil');
            $table->string('dokumen_ba')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bas');
    }
};
