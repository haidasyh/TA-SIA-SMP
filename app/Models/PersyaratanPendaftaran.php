<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersyaratanPendaftaran extends Model
{
    use HasFactory;

    // Pastikan nama tabel sesuai database
    protected $table = 'persyaratan_pendaftarans'; 

    // Izinkan kolom-kolom ini untuk disimpan massal
    protected $fillable = [
        'id', // Ditambahkan karena kita definisikan id manual di firstOrCreate
        'umum', 
        'khusus', 
        'alur'
    ]; 
}