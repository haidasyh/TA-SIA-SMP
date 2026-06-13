<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersyaratanPendaftaran extends Model
{
    use HasFactory;

    protected $table = 'persyaratan_pendaftarans'; 

    protected $fillable = [
        'umum', 
        'khusus', 
        'alur'
    ]; 
}