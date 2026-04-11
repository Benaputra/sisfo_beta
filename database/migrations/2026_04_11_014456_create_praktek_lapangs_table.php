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
        Schema::create('praktek_lapangs', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->string('laporan')->nullable();
            $table->string('lokasi');
            $table->string('bukti_bayar')->nullable();
            $table->foreignId('dosen_pembimbing_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('surat_id')->nullable()->constrained('surats')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('praktek_lapangs');
    }
};
