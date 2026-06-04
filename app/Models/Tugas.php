<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tugas extends Model
{
    use HasFactory;

    protected $fillable = [
        'jadwal_id',
        'judul_tugas',
        'deskripsi',
        'tanggal_diberikan',
        'tanggal_deadline',
        'status',
        'kategori_tugas_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($tugas) {
            $kategori = KategoriTugas::firstOrCreate(
                ['nama_kategori' => $tugas->judul_tugas],
                ['bobot' => 100]
            );
            
            $tugas->kategori_tugas_id = $kategori->id;
            $tugas->saveQuietly();
        });
    }

    public function jadwal(): BelongsTo
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function kategoriTugas(): BelongsTo
    {
        return $this->belongsTo(KategoriTugas::class);
    }
}
