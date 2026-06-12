<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePresensiBulkRequest;
use App\Models\WaliKelas;
use App\Models\Siswa;
use App\Models\Presensi;
use Illuminate\Support\Facades\Auth;

class PresensiSiswaController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
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

    public function storeBulk(StorePresensiBulkRequest $request)
    {
        $guru = Auth::user()->guru;
        
        // 1. Pastikan user adalah guru dan terdaftar sebagai Wali Kelas
        if (!$guru) {
            return back()->with('error', 'Akses ditolak. Anda bukan Guru.');
        }

        $waliKelas = WaliKelas::where('guru_id', $guru->id)->first();

        if (!$waliKelas) {
            return back()->with('error', 'Anda tidak terdaftar sebagai Wali Kelas.');
        }

        // 2. Jika lolos verifikasi, lakukan loop untuk simpan data
        foreach ($request->presensi as $siswaId => $status) {
            if (!$status) continue; 

            Presensi::updateOrCreate(
                [
                    'siswa_id' => $siswaId,
                    'tanggal'  => $request->tanggal,
                ],
                [
                    // Mengambil semester_id langsung dari model WaliKelas sesuai relasi di databasemu
                    'semester_id' => $waliKelas->semester_id, 
                    'status'      => $status,
                ]
            );
        }

        return back()->with('success', 'Presensi berhasil disimpan!');
    }
}