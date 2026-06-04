<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nilai extends Model
{
    use HasFactory;
    
    protected $table = 'nilai';

    protected $fillable = [
        'siswa_id',
        'mapel_id',
        'semester_id',
        'kategori_id',
        'tugas_id',
        'skor_nilai',
        'keterangan',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }

    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriTugas::class, 'kategori_id');
    }

    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class);
    }
}
