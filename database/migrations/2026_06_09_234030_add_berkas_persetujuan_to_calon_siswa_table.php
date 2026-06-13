<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            // Menambahkan field baru, nullable agar tidak error kalau data lama kosong
            $table->string('berkas_persetujuan')->nullable()->after('berkas_ktp_ortu');
        });
    }

    public function down(): void
    {
        Schema::table('calon_siswa', function (Blueprint $table) {
            // Menghapus field jika migration di-rollback
            $table->dropColumn('berkas_persetujuan');
        });
    }
};