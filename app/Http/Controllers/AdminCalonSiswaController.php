<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use App\Exports\CalonSiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class AdminCalonSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::query();

        // 1. Logika Pencarian (Nama, NISN, dan Nomor Pendaftaran)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%')
                  ->orWhere('no_pendaftaran', 'like', '%' . $search . '%');
            });
        }

        // 2. Logika Filter Jenis Kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        // 3. Logika Filter Status (DIUBAH ke 'status_verifikasi' sesuai database asli kamu)
        if ($request->has('status') && $request->status != '') {
            $query->where('status_verifikasi', $request->status);
        }

        // Tampilkan dengan Pagination (10 data per halaman) dan simpan Query String URL-nya
        $calonSiswa = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

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
        $validated['status_verifikasi'] = 'Pending'; // DIUBAH ke 'status_verifikasi'

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
            'status_verifikasi' => 'required|in:Pending,Diterima,Ditolak', // DIUBAH ke 'status_verifikasi'
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
        $calonSiswa->update(['status_verifikasi' => 'Diterima']); // DIUBAH ke 'status_verifikasi'

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Calon siswa berhasil diverifikasi (Diterima)!');
    }

    public function tolak($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        $calonSiswa->update(['status_verifikasi' => 'Ditolak']); // DIUBAH ke 'status_verifikasi'

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Calon siswa berhasil ditolak!');
    }

    public function export()
    {
        return Excel::download(new CalonSiswaExport, 'rekap-calon-siswa-' . date('YmdHis') . '.xlsx');
    }
}