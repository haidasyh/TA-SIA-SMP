<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;
use App\Services\SiswaWordExportService;
use App\Exports\SiswaExport;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function index(Request $request) 
    {
        $listKelas = Kelas::all();
        $query = Siswa::with(['user', 'kelas'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswa = $query->paginate(10)->withQueryString();

        return view('admin.siswa.index', compact('siswa', 'listKelas'));
    }

    public function export(Request $request, SiswaWordExportService $wordService) 
    {
        $kelasId = $request->input('kelas_id');
        $search = $request->input('search');
        $format = $request->input('format', 'excel'); 
        $namaFile = 'data_siswa_' . date('Y-m-d');

        if ($kelasId) {
            $kelas = Kelas::find($kelasId);
            if ($kelas) {
                $namaFile = 'data_siswa_kelas_' . str_replace(' ', '_', $kelas->nama_kelas);
            }
        }

        if ($format === 'excel') {
            return Excel::download(new SiswaExport($kelasId, $search), $namaFile . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        } elseif ($format === 'pdf') {
            return Excel::download(new SiswaExport($kelasId, $search), $namaFile . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($format === 'word') {
            return $wordService->handle($kelasId, $search, $namaFile);
        }

        return redirect()->back()->with('error', 'Format file tidak dikenali.');
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(StoreSiswaRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole('siswa');

            Siswa::create([
                'users_id'    => $user->id,
                'kelas_id'    => $validated['kelas_id'],
                'nis'         => $validated['nis'],
                'nisn'        => $validated['nisn'],
                'nama'        => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat'      => $validated['alamat'] ?? null,
                'no_hp_ortu'  => $validated['no_hp_ortu'] ?? null,
                'tahun_masuk' => $validated['tahun_masuk'],
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['user', 'kelas'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(UpdateSiswaRequest $request, $id)
    {
        $validated = $request->validated();
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->users_id);

        DB::transaction(function () use ($validated, $siswa, $user) {
            $userData = [
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);

            $siswa->update([
                'kelas_id'    => $validated['kelas_id'],
                'nis'         => $validated['nis'],
                'nisn'        => $validated['nisn'],
                'nama'        => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'alamat'      => $validated['alamat'] ?? null,
                'no_hp_ortu'  => $validated['no_hp_ortu'] ?? null,
                'tahun_masuk' => $validated['tahun_masuk'],
            ]);
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->users_id);
        
        DB::transaction(function () use ($siswa, $user) {
            // Opsional: Hapus rekap nilai atau presensi siswa terlebih dahulu jika foreign key tidak diset cascade
            \App\Models\Nilai::where('siswa_id', $siswa->id)->delete();
            \App\Models\Presensi::where('siswa_id', $siswa->id)->delete();

            $siswa->delete();
            $user->delete();
        });

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}