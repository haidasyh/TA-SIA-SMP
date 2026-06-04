<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WaliKelas;
use App\Models\Guru;
use App\Models\Kelas;

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

        return view('admin.wali-kelas.create', compact('gurus', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id|unique:wali_kelas,kelas_id',
        ]);

        WaliKelas::create([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.wali-kelas.index')->with('success', 'Wali kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $waliKelas = WaliKelas::findOrFail($id);
        $gurus = Guru::all();
        $kelas = Kelas::all();

        return view('admin.wali-kelas.edit', compact('waliKelas', 'gurus', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $waliKelas = WaliKelas::findOrFail($id);

        $request->validate([
            'guru_id' => 'required|exists:guru,id',
            'kelas_id' => 'required|exists:kelas,id|unique:wali_kelas,kelas_id,' . $id,
        ]);

        $waliKelas->update([
            'guru_id' => $request->guru_id,
            'kelas_id' => $request->kelas_id,
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
