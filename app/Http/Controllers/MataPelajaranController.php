<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mataPelajaran = MataPelajaran::orderBy('created_at', 'desc')->get();
        return view('admin.mata-pelajaran.index', compact('mataPelajaran'));
    }

    public function create()
    {
        return view('admin.mata-pelajaran.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:10|unique:mata_pelajaran',
            'nama_mapel' => 'required|string|max:50',
            'kkm' => 'nullable|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        MataPelajaran::create($validated);

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    public function show($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        return view('admin.mata-pelajaran.show', compact('mataPelajaran'));
    }

    public function edit($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        return view('admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);

        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:10|unique:mata_pelajaran,kode_mapel,' . $id,
            'nama_mapel' => 'required|string|max:50',
            'kkm' => 'nullable|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $mataPelajaran->update($validated);

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diupdate!');
    }

    public function destroy($id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        $mataPelajaran->delete();

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}
