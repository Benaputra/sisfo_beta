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
        Schema::create('skripsi', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->text('judul');
            $table->foreignId('pembimbing1_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('pembimbing2_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->foreignId('penguji1_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->foreignId('penguji2_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->date('tanggal');
            $table->string('tempat');
            $table->string('bukti_bayar')->nullable();
            $table->string('transkrip_nilai')->nullable();
            $table->string('toefl')->nullable();
            $table->foreignId('surat_undangan_id')->nullable()->constrained('surats')->nullOnDelete();
            $table->boolean('notifikasi_whatsapp')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skripsi');
    }
};
