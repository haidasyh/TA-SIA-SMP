<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semester extends Model
{
    use HasFactory;

    protected $table = 'semester';

    protected $fillable = [
        'kode_semester',
        'tahun_ajaran',
        'semester',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class);
    }

    public function presensi(): HasMany
    {
        return $this->hasMany(Presensi::class);
    }
}