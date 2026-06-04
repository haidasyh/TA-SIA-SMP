<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPelaksanaanPpdb extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai database
    protected $table = 'jadwal_pelaksanaan_ppdbs';

    // Izinkan kolom-kolom ini untuk disimpan massal
    protected $fillable = [
        'kegiatan', 
        'tanggal', 
        'waktu', 
        'lokasi'
    ];
}