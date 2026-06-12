<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJadwalRequest;
use App\Http\Requests\UpdateJadwalRequest;
use App\Models\Jadwal;
use App\Models\Semester;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Guru;

class JadwalController extends Controller
{
    public function index()
    {
        // Penggunaan paginate(15) jauh lebih diutamakan daripada get() untuk tabel master data
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'guru'])
            ->orderBy('created_at', 'desc')
            ->paginate(15); 

        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();
        $guru = Guru::all();
        $semester = Semester::all();
        $currentSemester = Semester::getCurrentSemester();
        
        return view('admin.jadwal.create', compact('kelas', 'mataPelajaran', 'guru', 'semester', 'currentSemester'));
    }

    public function store(StoreJadwalRequest $request)
    {
        // Validasi otomatis berjalan di file StoreJadwalRequest sebelum baris ini dieksekusi
        Jadwal::create($request->validated());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function show($id)
    {
        $jadwal = Jadwal::with(['kelas', 'mataPelajaran', 'guru', 'semester'])->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $kelas = Kelas::all();
        $mataPelajaran = MataPelajaran::all();
        $guru = Guru::all();
        $semester = Semester::all();
        
        return view('admin.jadwal.edit', compact('jadwal', 'kelas', 'mataPelajaran', 'guru', 'semester'));
    }

    public function update(UpdateJadwalRequest $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->validated());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}