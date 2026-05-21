<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonSiswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class CalonSiswaController extends Controller
{
    public function index()
    {
        $step = Session::get('pendaftaran_step', 1);
        $data = Session::get('pendaftaran_data', []);
        return view('calon-siswa.biodata', compact('step', 'data'));
    }

    public function step1(Request $request)
    {
        $validated = $request->validate([
            'nisn' => 'required|string|max:10',
            'tahun_lulus' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
        ]);

        Session::put('pendaftaran_step', 2);
        Session::put('pendaftaran_data', array_merge(Session::get('pendaftaran_data', []), $validated));

        return redirect()->route('biodata-peserta');
    }

    public function step2(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_hp_ortu' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:100',
            'alamat' => 'required|string',
            'berkas_akta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_ktp_ortu' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pasfoto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pendaftaranData = Session::get('pendaftaran_data', []);

        foreach (['berkas_akta', 'berkas_kk', 'berkas_ktp_ortu', 'pasfoto'] as $field) {
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
        $pendaftaranData = Session::get('pendaftaran_data', []);

        $lastSiswa = CalonSiswa::orderBy('id', 'desc')->first();
        $nextNumber = $lastSiswa ? intval(substr($lastSiswa->no_pendaftaran, -4)) + 1 : 1;
        $year = date('Y');
        $noPendaftaran = 'PSB-' . $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $data = [
            'no_pendaftaran' => $noPendaftaran,
            'nama' => $pendaftaranData['nama'],
            'nisn' => $pendaftaranData['nisn'],
            'jenis_kelamin' => $pendaftaranData['jenis_kelamin'],
            'tanggal_lahir' => $pendaftaranData['tanggal_lahir'],
            'no_hp_ortu' => $pendaftaranData['no_hp_ortu'],
            'asal_sekolah' => $pendaftaranData['asal_sekolah'],
            'alamat' => $pendaftaranData['alamat'],
            'status_verifikasi' => 'Pending',
        ];

        foreach (['berkas_akta', 'berkas_kk', 'berkas_ktp_ortu', 'pasfoto'] as $field) {
            if (isset($pendaftaranData[$field . '_path'])) {
                $data[$field] = $pendaftaranData[$field . '_path'];
            }
        }

        CalonSiswa::create($data);

        Session::forget(['pendaftaran_step', 'pendaftaran_data']);

        return redirect()->route('biodata-peserta')->with('success', 'Biodata berhasil disimpan! No. Pendaftaran: ' . $noPendaftaran);
    }
}
