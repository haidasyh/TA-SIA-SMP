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
        $ppdbStatus = Setting::get('ppdb_status', 'nonaktif');
        if ($ppdbStatus !== 'aktif') {
            return view('calon-siswa.pendaftaran-tutup');
        }

        $step = Session::get('pendaftaran_step', 1);
        $data = Session::get('pendaftaran_data', []);
        
        return view('calon-siswa.biodata', compact('step', 'data'));
    }

    public function step1(StoreStep1Request $request)
    {
        Session::put('pendaftaran_step', 2);
        Session::put('pendaftaran_data', array_merge(Session::get('pendaftaran_data', []), $request->validated()));

        return redirect()->route('biodata-peserta');
    }

    public function step2(StoreStep2Request $request)
    {
        $validated = $request->validated();
        $pendaftaranData = Session::get('pendaftaran_data', []);

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

    public function store(Request $request)
    {
        $request->validate([
            'setuju_pernyataan' => 'required|accepted',
        ], [
            'setuju_pernyataan.accepted' => 'Anda harus mencentang persetujuan untuk menyelesaikan pendaftaran.',
        ]);
        
        $pendaftaranData = Session::get('pendaftaran_data', []);

        if (empty($pendaftaranData)) {
            return redirect()->route('biodata-peserta')->with('error', 'Sesi pendaftaran telah kedaluwarsa.');
        }

        $noPendaftaran = '';

        DB::transaction(function () use (&$noPendaftaran, $pendaftaranData) {
            
            // 1. 🛡️ KUNCI BARIS: Ambil data terakhir dan kunci agar request lain mengantre
            $lastSiswa = CalonSiswa::orderBy('id', 'desc')
                ->lockForUpdate()
                ->first();

            // 2. Hitung nomor urut berikutnya (jika belum ada data, mulai dari 1)
            $nextNumber = $lastSiswa ? intval(substr($lastSiswa->no_pendaftaran, -4)) + 1 : 1;
            $year = date('Y');
            
            // 3. Format menjadi urutan cantik (Contoh: PSB-2026-0001)
            $noPendaftaran = 'PSB-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

            $data = [
                'no_pendaftaran'    => $noPendaftaran, // Nomor urut rapi dimasukkan ke database
                'nama'              => $pendaftaranData['nama'],
                'nisn'              => $pendaftaranData['nisn'],
                'jenis_kelamin'     => $pendaftaranData['jenis_kelamin'],
                'tanggal_lahir'     => $pendaftaranData['tanggal_lahir'],
                'no_hp_ortu'        => $pendaftaranData['no_hp_ortu'],
                'asal_sekolah'      => $pendaftaranData['asal_sekolah'],
                'alamat'            => $pendaftaranData['alamat'],
                'status_verifikasi' => 'Pending',
            ];

            foreach (['berkas_akta', 'berkas_kk', 'berkas_ktp_ortu', 'berkas_persetujuan', 'pasfoto'] as $field) {
                if (isset($pendaftaranData[$field . '_path'])) {
                    $tempPath = $pendaftaranData[$field . '_path'];
                    $permanentPath = str_replace('berkas-calon-siswa-temp', 'berkas-calon-siswa-tetap', $tempPath);
                    
                    if (Storage::disk('public')->exists($tempPath)) {
                        Storage::disk('public')->move($tempPath, $permanentPath);
                        $data[$field] = $permanentPath;
                    }
                }
            }

            // 4. Simpan data permanen ke database
            CalonSiswa::create($data);
        });

        Session::forget(['pendaftaran_step', 'pendaftaran_data']);

        return redirect()->route('biodata-peserta')->with('success', 'Pendaftaran berhasil! No. Pendaftaran Anda: ' . $noPendaftaran);
    }
}