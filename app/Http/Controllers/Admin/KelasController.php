<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKelasRequest;
use App\Http\Requests\UpdateKelasRequest;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        // Menggunakan withCount('siswa') jauh lebih cepat daripada memuat seluruh objek data siswa ke memory
        $kelas = Kelas::withCount('siswa')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('admin.kelas.create');
    }

    public function store(StoreKelasRequest $request)
    {
        Kelas::create($request->validated());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }

    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    public function update(UpdateKelasRequest $request, $id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->validated());

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kelas = Kelas::withCount('siswa')->findOrFail($id);

        // 🛡️ SECURITY CHECK: Mencegah error database jika kelas masih ada siswanya
        if ($kelas->siswa_count > 0) {
            return redirect()->route('admin.kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa aktif di dalamnya!');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus!');
    }
}