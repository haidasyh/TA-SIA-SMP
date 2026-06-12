<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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