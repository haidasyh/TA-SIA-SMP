<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersyaratanPendaftaran;
use Illuminate\Http\Request;

class AdminPersyaratanPpdbController extends Controller
{
    public function index()
    {
        $persyaratan = PersyaratanPendaftaran::firstOrCreate(['id' => 1], [
            'umum' => '',
            'khusus' => '',
            'alur' => ''
        ]);

        return view('admin.persyaratan-ppdb.index', compact('persyaratan'));
    }

    public function edit()
    {
        $persyaratan = PersyaratanPendaftaran::firstOrCreate(['id' => 1]);
        return view('admin.persyaratan-ppdb.edit', compact('persyaratan'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'umum' => 'required',
            'khusus' => 'required',
            'alur' => 'required',
        ]);

        $umum = is_array($request->umum) ? implode("\n", array_filter($request->umum)) : $request->umum;
        $khusus = is_array($request->khusus) ? implode("\n", array_filter($request->khusus)) : $request->khusus;
        $alur = is_array($request->alur) ? implode("\n", array_filter($request->alur)) : $request->alur;

        $persyaratan = PersyaratanPendaftaran::findOrFail(1);
        $persyaratan->update([
            'umum' => $umum,
            'khusus' => $khusus,
            'alur' => $alur,
        ]);

        return redirect()->route('admin.persyaratan-ppdb.index')->with('success', 'Persyaratan PPDB berhasil diperbarui.');
    }
}