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
            $table->date('tanggal')->nullable()->change();
            $table->string('tempat')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar', function (Blueprint $table) {
            $table->date('tanggal')->nullable(false)->change();
            $table->string('tempat')->nullable(false)->change();
        });
    }
};
