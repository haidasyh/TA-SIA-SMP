<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\KategoriTugas;
use App\Models\Tugas;

class GuruDashboardController extends Controller
{
    public function jadwalMengajar()
    {
        $jadwals = Jadwal::with(['kelas', 'mataPelajaran', 'guru'])->orderBy('hari')->orderBy('jam_mulai')->get();

        return view('guru.jadwal-mengajar', compact('jadwals'));
    }

    public function daftarSiswa()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $siswas = collect();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)->with('kelas')->get();
            $kelasIds = $jadwals->pluck('kelas_id')->unique();
            $siswas = $kelasIds->isEmpty() ? collect() : Siswa::whereIn('kelas_id', $kelasIds)->with('kelas')->get();
        }

        return view('guru.daftar-siswa', compact('siswas'));
    }

    public function inputNilai()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $jadwals = collect();
        $kategoris = KategoriTugas::all();
        $tugases = collect();
        $siswas = collect();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->get();
            $tugases = Tugas::whereHas('jadwal', function($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })->with(['jadwal.kelas', 'jadwal.mataPelajaran'])->get();
            $kelasIds = $jadwals->pluck('kelas_id')->unique();
            $siswas = $kelasIds->isEmpty() ? collect() : Siswa::whereIn('kelas_id', $kelasIds)->get();
        }

        return view('guru.input-nilai', compact('jadwals', 'kategoris', 'tugases', 'siswas'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'siswa_id' => 'required|exists:siswa,id',
            'kategori_id' => 'required|exists:kategori_tugas,id',
            'tugas_id' => 'nullable|exists:tugas,id',
            'skor_nilai' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        Nilai::create([
            'siswa_id' => $request->siswa_id,
            'mapel_id' => $jadwal->mapel_id,
            'semester_id' => $jadwal->semester_id,
            'kategori_id' => $request->kategori_id,
            'tugas_id' => $request->tugas_id,
            'skor_nilai' => $request->skor_nilai,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Nilai berhasil ditambahkan');
    }

    public function daftarTugas()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tugases = collect();
        
        if ($guru) {
            $tugases = Tugas::whereHas('jadwal', function($q) use ($guru) {
                $q->where('guru_id', $guru->id);
            })->with(['jadwal.kelas', 'jadwal.mataPelajaran'])->orderBy('tanggal_diberikan', 'desc')->get();
        }

        return view('guru.daftar-tugas', compact('tugases'));
    }

    public function createTugas()
    {
        $user = Auth::user();
        $guru = $user->guru;
        $jadwals = collect();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->get();
        }

        return view('guru.create-tugas', compact('jadwals'));
    }

    public function storeTugas(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'judul_tugas' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal_diberikan' => 'required|date',
            'tanggal_deadline' => 'nullable|date|after_or_equal:tanggal_diberikan',
        ]);

        Tugas::create([
            'jadwal_id' => $request->jadwal_id,
            'judul_tugas' => $request->judul_tugas,
            'deskripsi' => $request->deskripsi,
            'tanggal_diberikan' => $request->tanggal_diberikan,
            'tanggal_deadline' => $request->tanggal_deadline,
            'status' => 'Aktif',
        ]);

        return redirect()->route('guru.daftar-tugas')->with('success', 'Tugas berhasil ditambahkan');
    }

    public function editTugas($id)
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
            $q->where('guru_id', $guru?->id);
        })->findOrFail($id);
        $jadwals = collect();
        
        if ($guru) {
            $jadwals = Jadwal::where('guru_id', $guru->id)->with(['kelas', 'mataPelajaran'])->get();
        }

        return view('guru.edit-tugas', compact('tugas', 'jadwals'));
    }

    public function updateTugas(Request $request, $id)
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
            $q->where('guru_id', $guru?->id);
        })->findOrFail($id);

        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'judul_tugas' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'tanggal_diberikan' => 'required|date',
            'tanggal_deadline' => 'nullable|date|after_or_equal:tanggal_diberikan',
            'status' => 'required|in:Aktif,Selesai',
        ]);

        $tugas->update([
            'jadwal_id' => $request->jadwal_id,
            'judul_tugas' => $request->judul_tugas,
            'deskripsi' => $request->deskripsi,
            'tanggal_diberikan' => $request->tanggal_diberikan,
            'tanggal_deadline' => $request->tanggal_deadline,
            'status' => $request->status,
        ]);

        return redirect()->route('guru.daftar-tugas')->with('success', 'Tugas berhasil diperbarui');
    }

    public function destroyTugas($id)
    {
        $user = Auth::user();
        $guru = $user->guru;
        $tugas = Tugas::whereHas('jadwal', function($q) use ($guru) {
            $q->where('guru_id', $guru?->id);
        })->findOrFail($id);

        $tugas->delete();

        return redirect()->route('guru.daftar-tugas')->with('success', 'Tugas berhasil dihapus');
    }
}
