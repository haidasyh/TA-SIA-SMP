<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';
    
    protected $fillable = [
        'no_pendaftaran',
        'nama',
        'nisn',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp_ortu',
        'asal_sekolah',
        'alamat',
        'status_verifikasi',
        'berkas_akta',
        'berkas_kk',
        'berkas_ktp_ortu',
        'pasfoto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

}
