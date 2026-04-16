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
            $table->foreignId('pengajuan_judul_id')->nullable()->after('nim')->constrained('pengajuan_juduls')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar', function (Blueprint $table) {
            $table->dropForeign(['pengajuan_judul_id']);
            $table->dropColumn('pengajuan_judul_id');
        });
    }
};
