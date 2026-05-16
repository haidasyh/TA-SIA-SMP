<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kkm',
        'deskripsi',
    ];

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'mapel_id');
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'mapel_id');
    }

}
