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
        Schema::table('dendas', function (Blueprint $table) {
            $table->enum('jenis', ['terlambat', 'kerusakan', 'hilang'])->default('terlambat')->change();
        });
    }

    public function down(): void
    {
        Schema::table('dendas', function (Blueprint $table) {
            $table->enum('jenis', ['terlambat', 'kerusakan'])->default('terlambat')->change();
        });
    }
};
