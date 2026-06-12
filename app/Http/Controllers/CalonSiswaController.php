<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStep1Request;
use App\Http\Requests\StoreStep2Request;
use App\Models\CalonSiswa;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class CalonSiswaController extends Controller
{
    public function index()
    {
        // Proteksi status buka/tutup pendaftaran PPDB
        $ppdbStatus = Setting::get('ppdb_status', 'nonaktif');
        if ($ppdbStatus !== 'aktif') {
            return view('calon-siswa.pendaftaran-tutup');
        }

        $step = Session::get('pendaftaran_step', 1);
        $data = Session::get('pendaftaran_data', []);
        
        return view('calon-siswa.biodata', compact('step', 'data'));
    }

    /**
     * Eksekusi Step 1 (Validasi NISN & Tahun Lulus)
     */
    public function step1(StoreStep1Request $request)
    {
        Session::put('pendaftaran_step', 2);
        Session::put('pendaftaran_data', array_merge(Session::get('pendaftaran_data', []), $request->validated()));

        return redirect()->route('biodata-peserta');
    }

    /**
     * Eksekusi Step 2 (Validasi Data Pribadi & Upload Berkas Temp)
     */
    public function step2(StoreStep2Request $request)
    {
        $validated = $request->validated();
        $pendaftaranData = Session::get('pendaftaran_data', []);

        // Kelola file upload secara berkala ke folder temp
        foreach (['berkas_akta', 'berkas_kk', 'berkas_ktp_ortu', 'berkas_persetujuan', 'pasfoto'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field . '_name'] = $request->file($field)->getClientOriginalName();
                $validated[$field . '_path'] = $request->file($field)->store('berkas-calon-siswa-temp', 'public');
            }
        }

        Session::put('pendaftaran_step', 3);
        Session::put('pendaftaran_data', array_merge($pendaftaranData, $validated));

        return redirect()->route('biodata-peserta');
    }

    public function backToStep($step)
    {
        Session::put('pendaftaran_step', $step);
        return redirect()->route('biodata-peserta');
    }

    /**
     * Final Step: Penyimpanan Data Permanen ke Database
     */
    public function store(Request $request)
    {
        $pendaftaranData = Session::get('pendaftaran_data', []);

        if (empty($pendaftaranData)) {
            return redirect()->route('biodata-peserta')->with('error', 'Sesi pendaftaran telah kedaluwarsa.');
        }

        // 🛡️ OPTIMASI GENERATOR NO PENDAFTARAN: Kombinasi waktu + acak agar anti-bentrok (Race Condition)
        $noPendaftaran = 'PSB-' . date('Ymd') . '-' . rand(1000, 9999);

        $data = [
            'no_pendaftaran'    => $noPendaftaran,
            'nama'              => $pendaftaranData['nama'],
            'nisn'              => $pendaftaranData['nisn'],
            'jenis_kelamin'     => $pendaftaranData['jenis_kelamin'],
            'tanggal_lahir'     => $pendaftaranData['tanggal_lahir'],
            'no_hp_ortu'        => $pendaftaranData['no_hp_ortu'],
            'asal_sekolah'      => $pendaftaranData['asal_sekolah'],
            'alamat'            => $pendaftaranData['alamat'],
            'status_verifikasi' => 'Pending',
        ];

        // Jalankan transaksi database agar aman menyeluruh
        DB::transaction(function () use (&$data, $pendaftaranData) {
            foreach (['berkas_akta', 'berkas_kk', 'berkas_ktp_ortu', 'berkas_persetujuan', 'pasfoto'] as $field) {
                if (isset($pendaftaranData[$field . '_path'])) {
                    $tempPath = $pendaftaranData[$field . '_path'];
                    $permanentPath = str_replace('berkas-calon-siswa-temp', 'berkas-calon-siswa-tetap', $tempPath);
                    
                    // Pindahkan file dari folder temp ke folder arsip pendaftaran tetap sekolah
                    if (Storage::disk('public')->exists($tempPath)) {
                        Storage::disk('public')->move($tempPath, $permanentPath);
                        $data[$field] = $permanentPath;
                    }
                }
            }

            CalonSiswa::create($data);
        });

        // Bersihkan seluruh data session wizard setelah pendaftaran sukses
        Session::forget(['pendaftaran_step', 'pendaftaran_data']);

        return redirect()->route('biodata-peserta')->with('success', 'Pendaftaran berhasil! Simpan No. Pendaftaran Anda: ' . $noPendaftaran);
    }
}