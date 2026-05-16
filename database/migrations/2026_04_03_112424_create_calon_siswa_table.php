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
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('no_pendaftaran', 25)->unique();
            $table->string('nama', 100);
            $table->string('nisn', 10)->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('no_hp_ortu', 15);
            $table->string('asal_sekolah', 100);
            $table->text('alamat');
            $table->enum('status_verifikasi', ['Pending', 'Diterima', 'Ditolak'])->default('Pending');
            
            $table->string('berkas_akta')->nullable();
            $table->string('berkas_kk')->nullable();
            $table->string('berkas_ktp_ortu')->nullable();
            $table->string('pasfoto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calon_siswa');
    }
};