<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTugasRequest;
use App\Http\Requests\UpdateTugasRequest;
use App\Models\Tugas;
use App\Models\Jadwal;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $tugases = collect();
        $currentSemester = Semester::getCurrentSemester();
        
        if ($guru) {
            $tugases = Tugas::whereHas('jadwal', function($q) use ($guru, $currentSemester) {
                $q->where('guru_id', $guru->id)
                    ->where('semester_id', $currentSemester->id);
            })->with(['jadwal.kelas', 'jadwal.mataPelajaran'])->orderBy('tanggal_diberikan', 'desc')->get();
        }

        return view('guru.daftar-tugas', compact('tugases', 'currentSemester'));
    }

    public function create()
    {
        $guru = Auth::user()->guru;
        $jadwals = collect();
        $currentSemester = Semester::getCurrentSemester();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)
                ->where('semester_id', $currentSemester->id)
                ->with(['kelas', 'mataPelajaran'])->get();
        }

        return view('guru.create-tugas', compact('jadwals', 'currentSemester'));
    }

    public function store(StoreTugasRequest $request)
    {
        Tugas::create($request->validated() + ['status' => 'Aktif']);

        return redirect()->route('guru.daftar-tugas')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $guru = Auth::user()->guru;
        $tugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
            $q->where('guru_id', $guru?->id);
        })->findOrFail($id);
        
        $jadwals = collect();
        $currentSemester = Semester::getCurrentSemester();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)
                ->where('semester_id', $currentSemester->id)
                ->with(['kelas', 'mataPelajaran'])->get();
        }

        return view('guru.edit-tugas', compact('tugas', 'jadwals', 'currentSemester'));
    }

    public function update(UpdateTugasRequest $request, $id)
    {
        $guru = Auth::user()->guru;
        $tugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
            $q->where('guru_id', $guru?->id);
        })->findOrFail($id);

        $tugas->update($request->validated());

        return redirect()->route('guru.daftar-tugas')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroy($id)
    {
        $guru = Auth::user()->guru;
        $tugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
            $q->where('guru_id', $guru?->id);
        })->findOrFail($id);

        $tugas->delete();

        return redirect()->route('guru.daftar-tugas')->with('success', 'Tugas berhasil dihapus');
    }
}