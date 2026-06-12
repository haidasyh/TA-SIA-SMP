<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\Jadwal;
use App\Models\Presensi;
use App\Models\Nilai;
use App\Models\Tugas;

class SiswaDashboardController extends Controller
{
    /**
     * 1. HALAMAN UTAMA DASHBOARD SISWA
     */
    public function index()
    {
        $siswa = Auth::user()->siswa;
        
        $totalMapel = 0;
        $totalJadwal = 0;
        $totalTugas = 0;
        $tugasAktif = 0;
        $rataRataNilai = 0;
        $presensiStats = ['Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpha' => 0];
        
        if ($siswa) {
            if ($siswa->kelas_id) {
                $totalMapel = Jadwal::where('kelas_id', $siswa->kelas_id)->distinct('mapel_id')->count('mapel_id');
                $totalJadwal = Jadwal::where('kelas_id', $siswa->kelas_id)->count();
                $totalTugas = Tugas::whereHas('jadwal', function($q) use ($siswa) {
                    $q->where('kelas_id', $siswa->kelas_id);
                })->count();
                $tugasAktif = Tugas::whereHas('jadwal', function($q) use ($siswa) {
                    $q->where('kelas_id', $siswa->kelas_id);
                })->where('status', 'Aktif')->count();
            }
            
            $presensi = Presensi::where('siswa_id', $siswa->id)->get();
            $presensiStats = [
                'Hadir' => $presensi->where('status', 'Hadir')->count(),
                'Izin'  => $presensi->where('status', 'Izin')->count(),
                'Sakit' => $presensi->where('status', 'Sakit')->count(),
                'Alpha' => $presensi->where('status', 'Alpha')->count(),
            ];
            
            $nilais = Nilai::where('siswa_id', $siswa->id)->get();
            $rataRataNilai = $nilais->isEmpty() ? 0 : $nilais->avg('skor_nilai');
        }
        
        return view('dashboard.siswa', compact(
            'totalMapel', 'totalJadwal', 'totalTugas', 'tugasAktif', 'presensiStats', 'rataRataNilai'
        ));
    }

    /**
     * 2. HALAMAN JADWAL PELAJARAN
     */
    public function jadwalPelajaran()
    {
        $siswa = Auth::user()->siswa;
        $jadwals = collect();
        
        if ($siswa && $siswa->kelas_id) {
            $jadwals = Jadwal::where('kelas_id', $siswa->kelas_id)->with(['mataPelajaran', 'guru'])->get();
        }

        return view('siswa.jadwal-pelajaran', compact('jadwals'));
    }

    /**
     * 3. HALAMAN REKAP PRESENSI PRIBADI
     */
    public function rekapPresensi()
    {
        $siswa = Auth::user()->siswa;
        $presensis = collect();
        $rekap = [
            'hadir' => 0,
            'izin'  => 0,
            'sakit' => 0,
            'alpha' => 0,
        ];
        
        if ($siswa) {
            $presensis = Presensi::where('siswa_id', $siswa->id)->get();
            $rekap = [
                'hadir' => $presensis->where('status', 'Hadir')->count(),
                'izin'  => $presensis->where('status', 'Izin')->count(),
                'sakit' => $presensis->where('status', 'Sakit')->count(),
                'alpha' => $presensis->where('status', 'Alpha')->count(),
            ];
        }

        return view('siswa.rekap-presensi', compact('presensis', 'rekap'));
    }

    /**
     * 4. HALAMAN NILAI SISWA
     */
    public function nilai()
    {
        $siswa = Auth::user()->siswa;
        $nilais = collect();
        
        if ($siswa) {
            $nilais = Nilai::where('siswa_id', $siswa->id)->with(['mataPelajaran', 'kategori'])->get();
        }

        return view('siswa.nilai', compact('nilais'));
    }
    /**
     * 5. HALAMAN DAFTAR TUGAS
     */
    public function daftarTugas()
    {
        $siswa = Auth::user()->siswa;
        $tugases = collect();
        
        if ($siswa && $siswa->kelas_id) {
            $tugases = Tugas::whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->with(['jadwal.mataPelajaran', 'jadwal.guru'])->orderBy('tanggal_diberikan', 'desc')->get();
        }

        return view('siswa.daftar-tugas', compact('tugases'));
    }
}