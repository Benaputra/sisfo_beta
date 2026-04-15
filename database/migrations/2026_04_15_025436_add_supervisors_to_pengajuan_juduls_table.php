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
            $table->unsignedBigInteger('pembimbing1_id')->nullable();
            $table->unsignedBigInteger('pembimbing2_id')->nullable();

            $table->foreign('pembimbing1_id')->references('id')->on('dosens')->onDelete('set null');
            $table->foreign('pembimbing2_id')->references('id')->on('dosens')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_juduls', function (Blueprint $table) {
            $table->dropForeign(['pembimbing1_id']);
            $table->dropForeign(['pembimbing2_id']);
            $table->dropColumn(['pembimbing1_id', 'pembimbing2_id']);
        });
    }
};
