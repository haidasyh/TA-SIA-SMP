<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\CalonSiswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalCalonSiswa = CalonSiswa::count();
        $totalKelas = Kelas::count();
        
        $siswaPerKelas = Kelas::withCount('siswa')->get();
        $labelsKelas = $siswaPerKelas->pluck('nama_kelas');
        $dataSiswaPerKelas = $siswaPerKelas->pluck('siswa_count');
        
        if ($labelsKelas->isEmpty()) {
            $labelsKelas = collect(['Tidak ada kelas']);
            $dataSiswaPerKelas = collect([0]);
        }
        
        $calonSiswaStatus = CalonSiswa::select('status_verifikasi', DB::raw('count(*) as total'))
            ->groupBy('status_verifikasi')
            ->pluck('total', 'status_verifikasi');
        
        if ($calonSiswaStatus->isEmpty()) {
            $calonSiswaStatus = collect(['Belum diverifikasi' => 0]);
        }
        
        return view('dashboard.admin', compact(
            'totalSiswa', 'totalGuru', 'totalCalonSiswa', 'totalKelas',
            'labelsKelas', 'dataSiswaPerKelas', 'calonSiswaStatus'
        ));
    }
}