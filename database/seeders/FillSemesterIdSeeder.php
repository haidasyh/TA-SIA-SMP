<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Semester;
use App\Models\Jadwal;
use App\Models\WaliKelas;
use App\Models\Presensi;
use App\Models\Nilai;

class FillSemesterIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentSemester = Semester::getCurrentSemester();

        // Fill semester_id for jadwal where it's null
        Jadwal::whereNull('semester_id')->update(['semester_id' => $currentSemester->id]);

        // Fill semester_id for wali_kelas where it's null
        WaliKelas::whereNull('semester_id')->update(['semester_id' => $currentSemester->id]);

        // Fill semester_id for presensi where it's null
        Presensi::whereNull('semester_id')->update(['semester_id' => $currentSemester->id]);

        // Fill semester_id for nilai where it's null
        Nilai::whereNull('semester_id')->update(['semester_id' => $currentSemester->id]);
    }
}
