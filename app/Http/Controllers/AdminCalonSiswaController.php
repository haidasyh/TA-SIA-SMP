<?php

namespace App\Http\Controllers;

use App\Models\CalonSiswa;
use Illuminate\Http\Request;

class AdminCalonSiswaController extends Controller
{
    public function index()
    {
        $calonSiswa = CalonSiswa::orderBy('created_at', 'desc')->get();
        return view('admin.calon-siswa.index', compact('calonSiswa'));
    }

    public function show($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        return view('admin.calon-siswa.show', compact('calonSiswa'));
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
}
