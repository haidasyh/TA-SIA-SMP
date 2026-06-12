<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        // Peningkatan: Menggunakan aturan validasi tanggal yang ketat dari Kode 1
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        JadwalPelaksanaanPpdb::create($validated);

        return redirect()->route('admin.jadwal-ppdb.index')->with('success', 'Jadwal PPDB berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalPelaksanaanPpdb::findOrFail($id);
        return view('admin.jadwal-ppdb.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalPelaksanaanPpdb::findOrFail($id);
        
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'waktu' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
        ]);

        $jadwal->update($validated);

        return redirect()->route('admin.jadwal-ppdb.index')->with('success', 'Jadwal PPDB berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPelaksanaanPpdb::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal-ppdb.index')->with('success', 'Jadwal PPDB berhasil dihapus.');
    }
}