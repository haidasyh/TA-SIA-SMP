<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roles = $user->roles->pluck('name')->toArray();
            
            if (in_array('siswa', $roles)) {
                return redirect()->route('dashboard.siswa');
            }
            
            $activeRole = $roles[0] ?? null;
            session(['active_role' => $activeRole]);
            
            return $this->redirectToDashboard($activeRole);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $roles = $user->roles->pluck('name')->toArray();
            
            if (in_array('siswa', $roles)) {
                return redirect()->route('dashboard.siswa');
            }
            
            $activeRole = $roles[0] ?? null;
            session(['active_role' => $activeRole]);
            
            return $this->redirectToDashboard($activeRole);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $user = Auth::user();
        
        if (!$user->hasRole($request->role)) {
            abort(403);
        }

        session(['active_role' => $request->role]);

        return $this->redirectToDashboard($request->role);
    }

    private function redirectToDashboard($role)
    {
        $routes = [
            'administrator' => 'dashboard.admin',
            'guru' => 'dashboard.guru',
            'wali kelas' => 'dashboard.walikelas',
            'siswa' => 'dashboard.siswa',
        ];

        return redirect()->route($routes[$role] ?? 'login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function adminDashboard()
    {
        $totalSiswa = \App\Models\Siswa::count();
        $totalGuru = \App\Models\Guru::count();
        $totalCalonSiswa = \App\Models\CalonSiswa::count();
        $totalKelas = \App\Models\Kelas::count();
        
        $siswaPerKelas = \App\Models\Kelas::withCount('siswa')->get();
        $labelsKelas = $siswaPerKelas->pluck('nama_kelas');
        $dataSiswaPerKelas = $siswaPerKelas->pluck('siswa_count');
        
        if ($labelsKelas->isEmpty()) {
            $labelsKelas = collect(['Tidak ada kelas']);
            $dataSiswaPerKelas = collect([0]);
        }
        
        $calonSiswaStatus = \App\Models\CalonSiswa::select('status_verifikasi', \DB::raw('count(*) as total'))
            ->groupBy('status_verifikasi')
            ->pluck('total', 'status_verifikasi');
        
        if ($calonSiswaStatus->isEmpty()) {
            $calonSiswaStatus = collect(['Belum diverifikasi' => 0]);
        }
        
        return view('dashboard.admin', compact(
            'totalSiswa',
            'totalGuru',
            'totalCalonSiswa',
            'totalKelas',
            'labelsKelas',
            'dataSiswaPerKelas',
            'calonSiswaStatus'
        ));
    }

    public function guruDashboard()
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        $totalJadwal = 0;
        $totalKelas = 0;
        $totalMapel = 0;
        $totalTugas = 0;
        
        if ($guru) {
            $totalJadwal = \App\Models\Jadwal::where('guru_id', $guru->id)->count();
            $totalKelas = \App\Models\Jadwal::where('guru_id', $guru->id)->distinct('kelas_id')->count('kelas_id');
            $totalMapel = \App\Models\Jadwal::where('guru_id', $guru->id)->distinct('mapel_id')->count('mapel_id');
            $totalTugas = 0;
        }
        
        $jadwalPerHari = collect();
        if ($guru) {
            $jadwalPerHari = \App\Models\Jadwal::select('hari', \DB::raw('count(*) as total'))
                ->where('guru_id', $guru->id)
                ->groupBy('hari')
                ->pluck('total', 'hari');
        }
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $dataJadwalPerHari = [];
        foreach ($hariList as $hari) {
            $dataJadwalPerHari[] = $jadwalPerHari->get($hari, 0);
        }
        
        return view('dashboard.guru', compact(
            'totalJadwal',
            'totalKelas',
            'totalMapel',
            'totalTugas',
            'hariList',
            'dataJadwalPerHari'
        ));
    }

    public function waliKelasDashboard()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $waliKelas = null;
        
        $totalSiswa = 0;
        $presensiStats = ['Hadir' => 0, 'Izin' => 0, 'Sakit' => 0, 'Alpha' => 0];
        $nilaiStats = ['rata-rata' => 0];
        
        if ($guru) {
            $waliKelas = \App\Models\WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $totalSiswa = \App\Models\Siswa::where('kelas_id', $waliKelas->kelas_id)->count();
                
                $presensis = \App\Models\Presensi::whereHas('siswa', function($q) use ($waliKelas) {
                    $q->where('kelas_id', $waliKelas->kelas_id);
                })->get();
                $presensiStats = [
                    'Hadir' => $presensis->where('status', 'Hadir')->count(),
                    'Izin' => $presensis->where('status', 'Izin')->count(),
                    'Sakit' => $presensis->where('status', 'Sakit')->count(),
                    'Alpha' => $presensis->where('status', 'Alpha')->count(),
                ];
                
                $nilais = \App\Models\Nilai::whereHas('siswa', function($q) use ($waliKelas) {
                    $q->where('kelas_id', $waliKelas->kelas_id);
                })->get();
                $nilaiStats['rata-rata'] = $nilais->isEmpty() ? 0 : $nilais->avg('skor_nilai');
            }
        }
        
        return view('dashboard.walikelas', compact(
            'totalSiswa',
            'presensiStats',
            'nilaiStats'
        ));
    }

    public function siswaDashboard()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $totalMapel = 0;
        $totalJadwal = 0;
        $totalTugas = 0;
        $tugasAktif = 0;
        
        if ($siswa && $siswa->kelas_id) {
            $totalMapel = \App\Models\Jadwal::where('kelas_id', $siswa->kelas_id)->distinct('mapel_id')->count('mapel_id');
            $totalJadwal = \App\Models\Jadwal::where('kelas_id', $siswa->kelas_id)->count();
            $totalTugas = \App\Models\Tugas::whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->count();
            $tugasAktif = \App\Models\Tugas::whereHas('jadwal', function($q) use ($siswa) {
                $q->where('kelas_id', $siswa->kelas_id);
            })->where('status', 'Aktif')->count();
        }
        
        $presensi = collect();
        $presensiStats = [
            'Hadir' => 0,
            'Izin' => 0,
            'Sakit' => 0,
            'Alpha' => 0,
        ];
        $nilais = collect();
        $rataRataNilai = 0;
        
        if ($siswa) {
            $presensi = \App\Models\Presensi::where('siswa_id', $siswa->id)->get();
            $presensiStats = [
                'Hadir' => $presensi->where('status', 'Hadir')->count(),
                'Izin' => $presensi->where('status', 'Izin')->count(),
                'Sakit' => $presensi->where('status', 'Sakit')->count(),
                'Alpha' => $presensi->where('status', 'Alpha')->count(),
            ];
            
            $nilais = \App\Models\Nilai::where('siswa_id', $siswa->id)->get();
            $rataRataNilai = $nilais->isEmpty() ? 0 : $nilais->avg('skor_nilai');
        }
        
        return view('dashboard.siswa', compact(
            'totalMapel',
            'totalJadwal',
            'totalTugas',
            'tugasAktif',
            'presensiStats',
            'rataRataNilai'
        ));
    }
}
