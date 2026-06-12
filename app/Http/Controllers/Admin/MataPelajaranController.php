<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMataPelajaranRequest;
use App\Http\Requests\UpdateMataPelajaranRequest;
use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Tampilan Daftar Mata Pelajaran (Dengan Pencarian & Pagination)
     */
    public function index(Request $request)
    {
        $query = MataPelajaran::query();

        if ($request->filled('search')) {
            $query->where('nama_mapel', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_mapel', 'like', '%' . $request->search . '%');
        }

        $mataPelajaran = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

        return view('admin.mata-pelajaran.index', compact('mataPelajaran'));
    }

    public function create()
    {
        return view('admin.mata-pelajaran.create');
    }

    /**
     * Proses Simpan Data (Menggunakan StoreMataPelajaranRequest)
     */
    public function store(StoreMataPelajaranRequest $request)
    {
        // Validasi otomatis berjalan sebelum baris ini dieksekusi
        MataPelajaran::create($request->validated());

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

    /**
     * Proses Update Data (Menggunakan UpdateMataPelajaranRequest)
     */
    public function update(UpdateMataPelajaranRequest $request, $id)
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        
        // Menggunakan data yang telah lolos validasi request kustom
        $mataPelajaran->update($request->validated());

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil diupdate!');
    }

    /**
     * Hapus Mata Pelajaran (Dengan Proteksi Relasi Database)
     */
    public function destroy($id)
    {
        // Hitung data relasi pada tabel jadwal dan nilai sebelum menghapus
        $mataPelajaran = MataPelajaran::withCount(['jadwal', 'nilai'])->findOrFail($id);

        // 🛡️ SECURITY CHECK: Cegah halaman crash akibat foreign key constraint
        if ($mataPelajaran->jadwal_count > 0 || $mataPelajaran->nilai_count > 0) {
            return redirect()->route('admin.mata-pelajaran.index')
                ->with('error', 'Mata pelajaran gagal dihapus karena sudah terikat dengan Jadwal Mengajar atau Nilai Siswa!');
        }

        $mataPelajaran->delete();

        return redirect()->route('admin.mata-pelajaran.index')->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}