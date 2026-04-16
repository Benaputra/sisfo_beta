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
        Schema::table('pengajuan_judul', function (Blueprint $table) {
            $table->string('file_kesediaan')->nullable()->after('surat_kesediaan');
            $table->boolean('is_kesediaan_valid')->default(false)->after('file_kesediaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_judul', function (Blueprint $table) {
            $table->dropColumn(['file_kesediaan', 'is_kesediaan_valid']);
        });
    }
};
