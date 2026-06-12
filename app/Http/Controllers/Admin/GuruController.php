<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGuruRequest;
use App\Http\Requests\UpdateGuruRequest;
use App\Services\GuruWordExportService;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Exports\GuruExport;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $guru = $query->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('guru'));
    }

    public function export(Request $request, GuruWordExportService $wordService)
    {
        $jenisKelamin = $request->input('jenis_kelamin');
        $search = $request->input('search');
        $format = $request->input('format', 'excel');
        $namaFile = 'data_guru_' . date('Y-m-d');

        if ($jenisKelamin) {
            $namaFile = 'data_guru_' . strtolower(str_replace(' ', '_', $jenisKelamin));
        }

        if ($format === 'excel') {
            return Excel::download(new GuruExport($jenisKelamin, $search), $namaFile . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        } elseif ($format === 'pdf') {
            return Excel::download(new GuruExport($jenisKelamin, $search), $namaFile . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($format === 'word') {
            // Memanggil logika service word yang sudah dipisah
            return $wordService->handle($jenisKelamin, $search, $namaFile);
        }

        return redirect()->back()->with('error', 'Format file tidak dikenali.');
    }
   
    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(StoreGuruRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole($validated['role']);

            Guru::create([
                'users_id'      => $user->id,
                'nip'           => $validated['nip'],
                'nama'          => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp'         => $validated['no_hp'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(UpdateGuruRequest $request, $id)
    {
        $validated = $request->validated();
        $guru = Guru::findOrFail($id);
        $user = User::findOrFail($guru->users_id);

        DB::transaction(function () use ($validated, $guru, $user) {
            $userData = [
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);
            $user->syncRoles([$validated['role']]);

            $guru->update([
                'nip'           => $validated['nip'],
                'nama'          => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp'         => $validated['no_hp'] ?? null,
            ]);
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diupdate!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $user = User::findOrFail($guru->users_id);
       
        DB::transaction(function () use ($guru, $user) {
            // Hapus data terkait terlebih dahulu secara berurutan
            \App\Models\Jadwal::where('guru_id', $guru->id)->delete();
            \App\Models\WaliKelas::where('guru_id', $guru->id)->delete();
            
            $guru->delete();
            $user->delete();
        });

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}