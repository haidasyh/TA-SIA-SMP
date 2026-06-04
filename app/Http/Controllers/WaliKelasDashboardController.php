<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WaliKelas;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Semester;
use App\Models\Presensi;
use App\Models\Nilai;

class WaliKelasDashboardController extends Controller
{
    public function presensiSiswa()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $waliKelas = null;
        $siswas = collect();
        
        if ($guru) {
            $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $siswas = Siswa::where('kelas_id', $waliKelas->kelas_id)->get();
            }
        }

        return view('walikelas.presensi-siswa', compact('siswas', 'waliKelas'));
    }

    public function storePresensi(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        $waliKelas = null;
        if (Auth::user()->guru) {
            $waliKelas = WaliKelas::where('guru_id', Auth::user()->guru->id)->first();
        }

        Presensi::create([
            'siswa_id' => $request->siswa_id,
            'semester_id' => $waliKelas?->semester_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Presensi berhasil ditambahkan');
    }
public function storePresensiBulk(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'presensi' => 'required|array',
    ]);

    $waliKelas = null;
    if (Auth::user()->guru) {
        $waliKelas = WaliKelas::where('guru_id', Auth::user()->guru->id)->first();
    }

    foreach ($request->presensi as $siswaId => $status) {
        if (!$status) continue; // skip kalau belum dipilih

        Presensi::updateOrCreate(
            [
                'siswa_id' => $siswaId,
                'tanggal'  => $request->tanggal,
            ],
            [
                'semester_id' => $waliKelas?->semester_id,
                'status'      => $status,
            ]
        );
    }

    return back()->with('success', 'Presensi berhasil disimpan!');
}
    public function rekapPresensi()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $waliKelas = null;
        $rekapPresensi = collect();
        
        if ($guru) {
            $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $siswas = Siswa::where('kelas_id', $waliKelas->kelas_id)->get();
                $rekapPresensi = $siswas->map(function ($siswa) {
                    $presensi = Presensi::where('siswa_id', $siswa->id)->get();
                    return [
                        'siswa' => $siswa,
                        'hadir' => $presensi->where('status', 'Hadir')->count(),
                        'izin' => $presensi->where('status', 'Izin')->count(),
                        'sakit' => $presensi->where('status', 'Sakit')->count(),
                        'alpha' => $presensi->where('status', 'Alpha')->count(),
                    ];
                });
            }
        }

        return view('walikelas.rekap-presensi', compact('rekapPresensi', 'waliKelas'));
    }

    public function rekapNilai()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $waliKelas = null;
        $rekapNilai = collect();
        
        if ($guru) {
            $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();
            if ($waliKelas) {
                $siswas = Siswa::where('kelas_id', $waliKelas->kelas_id)->get();
                $rekapNilai = $siswas->map(function ($siswa) {
                    $nilais = Nilai::where('siswa_id', $siswa->id)->with('mataPelajaran', 'kategori')->get();
                    return [
                        'siswa' => $siswa,
                        'nilais' => $nilais,
                    ];
                });
            }
        }

        

        return view('walikelas.rekap-nilai', compact('rekapNilai', 'waliKelas'));
    }
}
