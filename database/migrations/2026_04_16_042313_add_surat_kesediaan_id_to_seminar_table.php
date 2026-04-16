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
        Schema::table('seminar', function (Blueprint $table) {
            $table->foreignId('surat_kesediaan_id')->nullable()->constrained('surats')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar', function (Blueprint $table) {
            $table->dropForeign(['surat_kesediaan_id']);
            $table->dropColumn('surat_kesediaan_id');
        });
    }
};
