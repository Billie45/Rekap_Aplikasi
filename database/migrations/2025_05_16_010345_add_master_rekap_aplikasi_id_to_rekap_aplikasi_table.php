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
             $table->foreignId('master_rekap_aplikasi_id')->nullable()->constrained('master_rekap_aplikasi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekap_aplikasi', function (Blueprint $table) {
            //
        });
    }
};
