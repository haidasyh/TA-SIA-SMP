<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPelaksanaanPpdb extends Model
{
    protected $table = 'jadwal_pelaksanaan_ppdbs';

    protected $fillable = [
        'kegiatan', 
        'tanggal_mulai', 
        'tanggal_akhir', 
        'waktu', 
        'lokasi'
    ];

    public function getFormattedTanggalAttribute()
    {
        $bulanIndo = [
            1 => 'Juni',
        ];

        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if (!$this->tanggal_mulai) {
            return $this->tanggal;
        }

        $start = \Carbon\Carbon::parse($this->tanggal_mulai);
        $startDay = $start->day;
        $startMonth = $bulanIndo[$start->month];
        $startYear = $start->year;

        if ($this->tanggal_akhir) {
            $end = \Carbon\Carbon::parse($this->tanggal_akhir);
            $endDay = $end->day;
            $endMonth = $bulanIndo[$end->month];
            $endYear = $end->year;

            if ($startYear !== $endYear) {
                return "{$startDay} {$startMonth} {$startYear} s/d {$endDay} {$endMonth} {$endYear}";
            }
            return "{$startDay} {$startMonth} s/d {$endDay} {$endMonth} {$startYear}";
        }

        return "{$startDay} {$startMonth} {$startYear}";
    }
}
