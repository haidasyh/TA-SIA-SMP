<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
    'kelas_id',
    'nis',
    'nisn',
    'nama',
    'jenis_kelamin',
    'alamat',
    'no_hp_ortu',
    'foto',
    'tahun_masuk',
    ];

        public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class);
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }
}
