<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNilaiRequest;
use App\Models\Jadwal;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\KategoriTugas;
use App\Models\Tugas;
use App\Models\Semester;
use Illuminate\Http\Request; // Tambahkan ini untuk membaca filter dinamis
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $guru = Auth::user()->guru;
        $currentSemester = Semester::getCurrentSemester();
        
        $jadwals = collect();
        $kategoris = KategoriTugas::all();
        $tugases = collect();
        $siswas = collect();
        
        if ($guru) {
            // 1. Ambil daftar jadwal aktif milik guru berjalan
            $jadwals = Jadwal::where('guru_id', $guru->id)
                ->where('semester_id', $currentSemester->id)
                ->with(['kelas', 'mataPelajaran'])->get();
                
            // 2. Ambil daftar tugas aktif milik guru berjalan
            $tugases = Tugas::whereHas('jadwal', function($q) use ($guru, $currentSemester) {
                $q->where('guru_id', $guru->id)
                    ->where('semester_id', $currentSemester->id);
            })->with(['jadwal.kelas', 'jadwal.mataPelajaran'])->get();
            
            // 3. OPTIMASI UX & PERFORMA: Filter siswa berdasarkan kelas yang dipilih guru di form
            if ($request->filled('kelas_id')) {
                // Pastikan kelas yang dicari memang diajar oleh guru ini (Security Check)
                $kelasIdsTaught = $jadwals->pluck('kelas_id')->unique()->toArray();
                
                if (in_array($request->kelas_id, $kelasIdsTaught)) {
                    $siswas = Siswa::where('kelas_id', $request->kelas_id)
                        ->orderBy('nama', 'asc')
                        ->get();
                }
            }
        }

        // Cari data nilai yang sudah diinput untuk ditampilkan sebagai rekap di bawah form (Opsional tapi disukai guru)
        $riwayatNilai = Nilai::where('semester_id', $currentSemester->id)
            ->whereHas('mataPelajaran.jadwal', function($q) use ($guru) {
                $q->where('guru_id', $guru?->id);
            })->with(['siswa', 'mataPelajaran', 'kategori'])->latest()->paginate(10);

        return view('guru.input-nilai', compact('jadwals', 'kategoris', 'tugases', 'siswas', 'currentSemester', 'riwayatNilai'));
    }

    public function store(StoreNilaiRequest $request)
    {
        $guru = Auth::user()->guru;

        // 🛡️ SECURITY CHECK: Pastikan jadwal_id yang dikirim benar-benar milik guru yang login
        $jadwal = Jadwal::where('id', $request->jadwal_id)
            ->where('guru_id', $guru?->id)
            ->firstOrFail(); // Mengembalikan 404 jika ada indikasi manipulasi ID form

        Nilai::create([
            'siswa_id'    => $request->siswa_id,
            'mapel_id'    => $jadwal->mapel_id,
            'semester_id' => $jadwal->semester_id,
            'kategori_id' => $request->kategori_id,
            'tugas_id'    => $request->tugas_id,
            'skor_nilai'  => $request->skor_nilai,
            'keterangan'  => $request->keterangan,
        ]);

        return back()->with('success', 'Nilai siswa berhasil disimpan!');
    }
}