<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Semester;
use App\Models\Presensi;
use App\Models\Nilai;
use App\Models\Tugas;

class SiswaDashboardController extends Controller
{
    public function jadwalPelajaran()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $jadwals = collect();
        
        if ($siswa && $siswa->kelas_id) {
            $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)->with(['mataPelajaran', 'guru'])->get();
        }

        return view('siswa.jadwal-pelajaran', compact('jadwals'));
    }

    public function rekapPresensi()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $presensis = collect();
        $rekap = [
            'hadir' => 0,
            'izin' => 0,
            'sakit' => 0,
            'alpha' => 0,
        ];
        
        if ($siswa) {
            $presensis = Presensi::where('siswa_id', $siswa->id)->get();
            $rekap = [
                'hadir' => $presensis->where('status', 'Hadir')->count(),
                'izin' => $presensis->where('status', 'Izin')->count(),
                'sakit' => $presensis->where('status', 'Sakit')->count(),
                'alpha' => $presensis->where('status', 'Alpha')->count(),
            ];
        }

        return view('siswa.rekap-presensi', compact('presensis', 'rekap'));
    }

    public function nilai()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $nilais = collect();
        
        if ($siswa) {
            $nilais = Nilai::where('siswa_id', $siswa->id)->with(['mataPelajaran', 'kategori'])->get();
        }

        return view('siswa.nilai', compact('nilais'));
    }

    public function daftarTugas()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        $tugases = collect();
        
        if ($siswa && $siswa->kelas_id) {
            $tugases = Tugas::whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->with(['jadwal.mataPelajaran', 'jadwal.guru'])->orderBy('tanggal_diberikan', 'desc')->get();
        }

        return view('siswa.daftar-tugas', compact('tugases'));
    }
}
