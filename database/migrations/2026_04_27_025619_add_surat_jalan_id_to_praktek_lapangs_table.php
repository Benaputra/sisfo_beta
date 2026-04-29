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
        Schema::table('praktek_lapangs', function (Blueprint $table) {
            $table->foreignId('surat_jalan_id')->after('surat_id')->nullable()->constrained('surats')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('praktek_lapangs', function (Blueprint $table) {
            $table->dropForeign(['surat_jalan_id']);
            $table->dropColumn('surat_jalan_id');
        });
    }
};
