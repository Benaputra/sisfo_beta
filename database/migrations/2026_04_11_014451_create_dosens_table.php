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
        Schema::create('dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nidn')->unique();
            $table->string('nuptk')->nullable();
            $table->foreignId('program_studi_id')->constrained('program_studi')->onDelete('cascade');
            $table->string('no_hp')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jabatan_fungsional')->nullable();
            $table->timestamps();
        });

        // Now that the dosen table exists, we could technically add the FK to program_studi.ketua_prodi
        // but for simplicity in migrations, we will handle that in the Model or a separate migration if needed.
        // Let's add the constraint here using a raw statement or Blueprint update if it's the same file,
        // but it's separate files. So we'll skip DB-level FK for ketua_prodi here to keep things clean.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
