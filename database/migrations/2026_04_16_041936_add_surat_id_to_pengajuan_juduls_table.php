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
        Schema::table('pengajuan_juduls', function (Blueprint $table) {
            $table->foreignId('surat_id')->nullable()->after('surat_kesediaan')->constrained('surats')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_juduls', function (Blueprint $table) {
            $table->dropForeign(['surat_id']);
            $table->dropColumn('surat_id');
        });
    }
};
