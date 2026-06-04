<?php

namespace App\Http\Controllers;

use App\Models\PersyaratanPendaftaran;
use Illuminate\Http\Request;

class AdminPersyaratanPpdbController extends Controller
{
    // 1. TAMBAHKAN FUNGSI INDEX INI
    public function index()
    {
        // Mengambil data pertama, jika belum ada otomatis buat record kosong
        $persyaratan = PersyaratanPendaftaran::firstOrCreate(['id' => 1], [
            'umum' => '',
            'khusus' => '',
            'alur' => ''
        ]);

        return view('admin.persyaratan-ppdb.index', compact('persyaratan'));
    }

    public function edit()
    {
        $persyaratan = PersyaratanPendaftaran::firstOrCreate(['id' => 1], [
            'umum' => '',
            'khusus' => '',
            'alur' => ''
        ]);

        return view('admin.persyaratan-ppdb.edit', compact('persyaratan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'umum' => 'required',
            'khusus' => 'required',
            'alur' => 'required',
        ]);

        $persyaratan = PersyaratanPendaftaran::find(1);
        $persyaratan->update($request->all());

        // Setelah update, kita arahkan kembali ke halaman index yang baru dibuat
        return redirect()->route('admin.persyaratan-ppdb.index')->with('success', 'Persyaratan PPDB berhasil diperbarui.');
    }
}