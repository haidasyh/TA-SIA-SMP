<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\WaliKelas;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\Nilai;
use Illuminate\Support\Facades\Auth;

class WaliKelasDashboardController extends Controller
{
    /**
     * 1. HALAMAN UTAMA DASHBOARD WALIKELAS
     */
    public function index()
    {
        $guru = Auth::user()->guru;
        $totalSiswa = 0;
        $presensiStats = ['Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpha' => 0];
        $nilaiStats = ['rata-rata' => 0];
        
        if ($guru) {
            $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $totalSiswa = Siswa::where('kelas_id', $waliKelas->kelas_id)->count();
                
                $presensis = Presensi::whereHas('siswa', function($q) use ($waliKelas) {
                    $q->where('kelas_id', $waliKelas->kelas_id);
                })->get();
                
                $presensiStats = [
                    'Hadir' => $presensis->where('status', 'Hadir')->count(),
                    'Izin'  => $presensis->where('status', 'Izin')->count(),
                    'Sakit' => $presensis->where('status', 'Sakit')->count(),
                    'Alpha' => $presensis->where('status', 'Alpha')->count(),
                ];
                
                $nilais = Nilai::whereHas('siswa', function($q) use ($waliKelas) {
                    $q->where('kelas_id', $waliKelas->kelas_id);
                })->get();
                
                $nilaiStats['rata-rata'] = $nilais->isEmpty() ? 0 : $nilais->avg('skor_nilai');
            }
        }
        
        return view('dashboard.walikelas', compact('totalSiswa', 'presensiStats', 'nilaiStats'));
    }

    /**
     * 2. HALAMAN REKAP PRESENSI SISWA KELAS
     */
    public function rekapPresensi()
    {
        $guru = Auth::user()->guru;
        $waliKelas = null;
        $rekapPresensi = collect();
        
        if ($guru) {
            $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $siswas = Siswa::where('kelas_id', $waliKelas->kelas_id)->with('presensi')->get();
                
                $rekapPresensi = $siswas->map(function ($siswa) {
                    return [
                        'siswa' => $siswa,
                        'hadir' => $siswa->presensi->where('status', 'Hadir')->count(),
                        'izin'  => $siswa->presensi->where('status', 'Izin')->count(),
                        'sakit' => $siswa->presensi->where('status', 'Sakit')->count(),
                        'alpha' => $siswa->presensi->where('status', 'Alpha')->count(),
                    ];
                });
            }
        }

        return view('walikelas.rekap-presensi', compact('rekapPresensi', 'waliKelas'));
    }
    /**
     * 3. HALAMAN REKAP NILAI SISWA KELAS
     */
    public function rekapNilai()
    {
        $guru = Auth::user()->guru;
        $waliKelas = null;
        $rekapNilai = collect();
        
        if ($guru) {
            $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $siswas = Siswa::where('kelas_id', $waliKelas->kelas_id)->get();
                $rekapNilai = $siswas->map(function ($siswa) {
                    $nilais = Nilai::where('siswa_id', $siswa->id)->with(['mataPelajaran', 'kategori'])->get();
                    return [
                        'siswa'  => $siswa,
                        'nilais' => $nilais,
                    ];
                });
            }
        }

        return view('walikelas.rekap-nilai', compact('rekapNilai', 'waliKelas'));
    }
}