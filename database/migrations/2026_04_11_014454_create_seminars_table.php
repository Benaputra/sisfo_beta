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
        Schema::create('seminar', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
            $table->text('judul');
            $table->foreignId('pembimbing1_id')->constrained('dosen')->onDelete('cascade');
            $table->foreignId('pembimbing2_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->foreignId('penguji_seminar_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->foreignId('penguji2_id')->nullable()->constrained('dosen')->onDelete('set null');
            $table->date('tanggal');
            $table->string('tempat');
            $table->string('bukti_bayar')->nullable();
            $table->boolean('acc_seminar')->default(false);
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
        Schema::dropIfExists('seminar');
    }
};
