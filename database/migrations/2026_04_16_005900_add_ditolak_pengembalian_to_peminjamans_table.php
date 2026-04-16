<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('menunggu','dipinjam','terlambat','menunggu_verifikasi','ditolak','ditolak_pengembalian','selesai') DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('menunggu','dipinjam','terlambat','menunggu_verifikasi','ditolak','selesai') DEFAULT 'menunggu'");
    }
};
