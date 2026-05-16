<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriTugas extends Model
{
    use HasFactory;
    
    protected $table = 'kategori_tugas';

    protected $fillable = [
        'nama_kategori',
        'bobot',
    ];

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'kategori_id');
    }
}
