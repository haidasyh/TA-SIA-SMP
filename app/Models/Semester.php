<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

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

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function waliKelas(): HasMany
    {
        return $this->hasMany(WaliKelas::class);
    }

    public static function getCurrentSemester()
    {
        $now = Carbon::now();
        $month = $now->month;
        $year = $now->year;

        if ($month >= 7 && $month <= 12) {
            $semester = 'Ganjil';
            $tahunAjaran = $year . '/' . ($year + 1);
            $kodeSemester = $year . '1';
        } else {
            $semester = 'Genap';
            $tahunAjaran = ($year - 1) . '/' . $year;
            $kodeSemester = $year . '2';
        }

        $semesterRecord = self::firstOrCreate(
            ['kode_semester' => $kodeSemester],
            [
                'tahun_ajaran' => $tahunAjaran,
                'semester' => $semester,
                'is_active' => true
            ]
        );

        // If it's not active, make it active and deactivate others
        if (!$semesterRecord->is_active) {
            self::where('is_active', true)->update(['is_active' => false]);
            $semesterRecord->update(['is_active' => true]);
        }

        return $semesterRecord;
    }
}