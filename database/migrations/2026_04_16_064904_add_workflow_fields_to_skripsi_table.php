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
        Schema::table('skripsi', function (Blueprint $table) {
            $table->string('status')->default('menunggu')->after('toefl');
            $table->foreignId('surat_kesediaan_id')->nullable()->after('status')->constrained('surats')->nullOnDelete();
            $table->string('file_kesediaan')->nullable()->after('surat_kesediaan_id');
            $table->boolean('is_kesediaan_valid')->default(false)->after('file_kesediaan');
            $table->foreignId('pengajuan_judul_id')->nullable()->after('is_kesediaan_valid')->constrained('pengajuan_juduls')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skripsi', function (Blueprint $table) {
            $table->dropForeign(['surat_kesediaan_id']);
            $table->dropForeign(['pengajuan_judul_id']);
            $table->dropColumn(['status', 'surat_kesediaan_id', 'file_kesediaan', 'is_kesediaan_valid', 'pengajuan_judul_id']);
        });
    }
};
