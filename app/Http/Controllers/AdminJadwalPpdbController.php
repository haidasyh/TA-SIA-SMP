<?php

namespace App\Http\Controllers;

use App\Models\JadwalPelaksanaanPpdb;
use Illuminate\Http\Request;

class AdminJadwalPpdbController extends Controller
{
    public function index()
    {
        $jadwal = JadwalPelaksanaanPpdb::all();
        return view('admin.jadwal-ppdb.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal-ppdb.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|string|max:255',
            'waktu' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        JadwalPelaksanaanPpdb::create($request->all());

        return redirect()->route('admin.jadwal-ppdb.index')->with('success', 'Jadwal PPDB berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalPelaksanaanPpdb::findOrFail($id);
        return view('admin.jadwal-ppdb.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        $jadwal = JadwalPelaksanaanPpdb::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal-ppdb.index')->with('success', 'Jadwal PPDB berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPelaksanaanPpdb::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-ppdb.index')->with('success', 'Jadwal PPDB berhasil dihapus.');
    }
}