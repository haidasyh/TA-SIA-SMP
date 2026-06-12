<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Tugas;
use Illuminate\Support\Facades\DB;

class GuruDashboardController extends Controller
{
    /**
     * 1. HALAMAN UTAMA DASHBOARD GURU
     */
    public function index()
    {
        $guru = Auth::user()->guru;
        
        $totalJadwal = 0;
        $totalKelas = 0;
        $totalMapel = 0;
        $totalTugas = 0;
        $dataJadwalPerHari = array_fill(0, 6, 0);
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        
        if ($guru) {
            $totalJadwal = Jadwal::where('guru_id', $guru->id)->count();
            $totalKelas = Jadwal::where('guru_id', $guru->id)->distinct('kelas_id')->count('kelas_id');
            $totalMapel = Jadwal::where('guru_id', $guru->id)->distinct('mapel_id')->count('mapel_id');
            $totalTugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })->count();

            // Mengambil grafik jumlah jadwal per hari
            $jadwalPerHari = Jadwal::select('hari', DB::raw('count(*) as total'))
                ->where('guru_id', $guru->id)
                ->groupBy('hari')
                ->pluck('total', 'hari');

            // Memasukkan data ke dalam array sesuai urutan hariList
            foreach ($hariList as $index => $hari) {
                $dataJadwalPerHari[$index] = $jadwalPerHari->get($hari, 0);
            }
        }
        
        return view('dashboard.guru', compact(
            'totalJadwal', 'totalKelas', 'totalMapel', 'totalTugas', 'hariList', 'dataJadwalPerHari'
        ));
    }

    /**
     * 2. HALAMAN JADWAL MENGAJAR
     */
    public function jadwalMengajar()
    {
        $guru = Auth::user()->guru;
        $jadwals = collect();
        $currentSemester = Semester::getCurrentSemester();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)
                ->where('semester_id', $currentSemester->id)
                ->with(['kelas', 'mataPelajaran', 'guru', 'semester']) // Eager loading anti N+1
                ->orderBy('hari')
                ->orderBy('jam_mulai')
                ->get();
        }

        return view('guru.jadwal-mengajar', compact('jadwals', 'currentSemester'));
    }

    /**
     * 3. HALAMAN DAFTAR SISWA PER KELAS
     */
    public function daftarSiswa(Request $request)
    {
        $guru = Auth::user()->guru;
        $kelas = collect();
        $siswas = collect();
        $selectedKelas = null;
        $currentSemester = Semester::getCurrentSemester();

        if ($guru) {
            // Ambil daftar kelas unik yang diajar oleh guru ini
            $jadwals = Jadwal::where('guru_id', $guru->id)
                ->where('semester_id', $currentSemester->id)
                ->with('kelas')->get();
            $kelas = $jadwals->pluck('kelas')->unique('id')->values();

            // Jika guru memilih kelas dari dropdown, ambil datanya
            if ($request->has('kelas_id')) {
                $selectedKelas = Kelas::find($request->kelas_id);
                
                // Keamanan: Pastikan kelas yang dicari memang diajar oleh guru tersebut
                if ($selectedKelas && $kelas->contains('id', $selectedKelas->id)) {
                    $siswas = Siswa::where('kelas_id', $selectedKelas->id)->with('kelas')->get();
                }
            }
        }

        return view('guru.daftar-siswa', compact('kelas', 'siswas', 'selectedKelas', 'currentSemester'));
    }
}