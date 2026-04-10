<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->unsignedBigInteger('anggota_id')->nullable()->after('buku_id');
            $table->foreign('anggota_id')->references('id')->on('anggotas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropForeign(['anggota_id']);
            $table->dropColumn('anggota_id');
        });
    }
};
