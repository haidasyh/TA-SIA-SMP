<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Exports\CalonSiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AdminCalonSiswaController extends Controller
{
    public function index()
    {
        $calonSiswa = CalonSiswa::orderBy('created_at', 'desc')->get();
        return view('admin.calon-siswa.index', compact('calonSiswa'));
    }

    public function create()
    {
        return view('admin.calon-siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nisn' => 'required|string|max:10|unique:calon_siswa',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_hp_ortu' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:100',
            'alamat' => 'required|string',
        ]);

        $validated['no_pendaftaran'] = 'PSB-' . date('Ymd') . '-' . rand(1000, 9999);

        CalonSiswa::create($validated);

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Calon siswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        return view('admin.calon-siswa.show', compact('calonSiswa'));
    }

    public function edit($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        return view('admin.calon-siswa.edit', compact('calonSiswa'));
    }

    public function update(Request $request, $id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nisn' => 'required|string|max:10|unique:calon_siswa,nisn,' . $id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_hp_ortu' => 'required|string|max:15',
            'asal_sekolah' => 'required|string|max:100',
            'alamat' => 'required|string',
            'status_verifikasi' => 'required|in:Pending,Diterima,Ditolak',
        ]);

        $calonSiswa->update($validated);

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Data calon siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        $calonSiswa->delete();

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Data calon siswa berhasil dihapus!');
    }

    public function verifikasi($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        $calonSiswa->update(['status_verifikasi' => 'Diterima']);

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Calon siswa berhasil diverifikasi (Diterima)!');
    }

    public function tolak($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        $calonSiswa->update(['status_verifikasi' => 'Ditolak']);

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Calon siswa berhasil ditolak!');
    }

    public function export()
    {
        return Excel::download(new CalonSiswaExport, 'rekap-calon-siswa-' . date('YmdHis') . '.xlsx');
    }
}
