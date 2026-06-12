<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Semester;

class AdminWaliKelasController extends Controller
{
    public function index()
    {
        $waliKelas = WaliKelas::with(['guru', 'kelas'])->get();

        return view('admin.wali-kelas.index', compact('waliKelas'));
    }

    public function create()
    {
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $semester = Semester::all();
        $currentSemester = Semester::getCurrentSemester();

        return view('admin.wali-kelas.create', compact('gurus', 'kelas', 'semester', 'currentSemester'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semester,id',
        ]);

        WaliKelas::create([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
        ]);

        return redirect()->route('admin.wali-kelas.index')->with('success', 'Wali kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $gurus = Guru::all();
        $kelas = Kelas::all();
        $semester = Semester::all();

        return view('admin.wali-kelas.edit', compact('waliKelas', 'gurus', 'kelas', 'semester'));
    }

    public function update(Request $request, $id)
    {
        $waliKelas = WaliKelas::findOrFail($id);

        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id',
            'semester_id' => 'required|exists:semester,id',
        ]);

        $waliKelas->update([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
            'semester_id' => $request->semester_id,
        ]);

        return redirect()->route('admin.wali-kelas.index')->with('success', 'Wali kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $waliKelas->delete();

        return redirect()->route('admin.wali-kelas.index')->with('success', 'Wali kelas berhasil dihapus');
    }
}
