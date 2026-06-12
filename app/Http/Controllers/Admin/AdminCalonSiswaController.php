<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCalonSiswaRequest; 
use App\Http\Requests\UpdateCalonSiswaRequest; 
use App\Models\CalonSiswa;
use App\Exports\CalonSiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCalonSiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = CalonSiswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%')
                  ->orWhere('no_pendaftaran', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }

        $calonSiswa = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.calon-siswa.index', compact('calonSiswa'));
    }

    public function create()
    {
        return view('admin.calon-siswa.create');
    }

    public function store(StoreCalonSiswaRequest $request)
    {
        $validated = $request->validated();

        $validated['no_pendaftaran'] = 'PSB-' . date('Ymd') . '-' . rand(1000, 9999);
        $validated['status_verifikasi'] = 'Pending'; 

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

    public function update(UpdateCalonSiswaRequest $request, $id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        $calonSiswa->update($request->validated());

        return redirect()->route('admin.calon-siswa.index')->with('success', 'Data calon siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        
        $files = [$calonSiswa->berkas_akta, $calonSiswa->berkas_kk, $calonSiswa->berkas_ktp_ortu, $calonSiswa->berkas_persetujuan, $calonSiswa->pasfoto];
        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }

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

    public function download($id, $type)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);
        
        $filePath = match($type) {
            'akta'    => $calonSiswa->berkas_akta,
            'kk'      => $calonSiswa->berkas_kk,
            'ktp'     => $calonSiswa->berkas_ktp_ortu,
            'persetujuan' => $calonSiswa->berkas_persetujuan,
            'pasfoto' => $calonSiswa->pasfoto,
            default   => abort(404)
        };
        
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404);
        }
        
        return Storage::disk('public')->download($filePath);
    }
}