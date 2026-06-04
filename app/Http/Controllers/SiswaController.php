<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// Tambahkan library baru untuk export di bagian atas:
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class SiswaController extends Controller
{
   public function index(Request $request) 
    {
        // 1. Ambil list semua kelas untuk dropdown filter di view
        $listKelas = Kelas::all();

        // 2. Mulai query dasar siswa beserta relasinya
        $query = Siswa::with(['user', 'kelas'])->orderBy('created_at', 'desc');

        // 3. Logika Filter Searchbar (Cari berdasarkan Nama, NIS, atau NISN)
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%')
                  ->orWhere('nisn', 'like', '%' . $request->search . '%');
            });
        }

        // 4. Logika Filter Berdasarkan Kelas
        if ($request->has('kelas_id') && $request->kelas_id != '') {
            $query->where('kelas_id', $request->kelas_id);
        }

        // 5. Ambil data menggunakan pagination
        $siswa = $query->paginate(10)->withQueryString();

        // 6. Kembalikan ke view dengan variabel yang dibutuhkan
        return view('admin.siswa.index', compact('siswa', 'listKelas'));
    }

    // =========================================================
    // FUNGSI EXPORT (Pastikan juga ada)
    // =========================================================
    public function export(Request $request) 
    {
        $kelasId = $request->input('kelas_id');
        $search = $request->input('search');
        $format = $request->input('format', 'excel'); 
        $namaFile = 'data_siswa_' . date('Y-m-d');

        if ($kelasId) {
            $kelas = Kelas::find($kelasId);
            if ($kelas) {
                $namaFile = 'data_siswa_kelas_' . str_replace(' ', '_', $kelas->nama_kelas);
            }
        }

        if ($format === 'excel') {
            return Excel::download(new SiswaExport($kelasId, $search), $namaFile . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        } elseif ($format === 'pdf') {
            return Excel::download(new SiswaExport($kelasId, $search), $namaFile . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($format === 'word') {
            return $this->exportToWord($kelasId, $search, $namaFile);
        }

        return redirect()->back()->with('error', 'Format file tidak dikenali.');
    }

    private function exportToWord($kelasId, $search, $namaFile)
    {
        $query = Siswa::with('kelas');
        if ($kelasId) { $query->where('kelas_id', $kelasId); }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%');
            });
        }
        $siswas = $query->get();

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $section->addText("LAPORAN DATA SISWA", ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        if ($kelasId && isset($siswas[0]->kelas)) {
            $section->addText("Kelas: " . $siswas[0]->kelas->nama_kelas, ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        }
        $section->addText("Tanggal Unduh: " . date('d-m-Y'), ['italic' => true], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $styleTable = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80];
        $styleCellHeader = ['bgColor' => 'EEEEEE'];
        $phpWord->addTableStyle('SiswaTable', $styleTable);
        $table = $section->addTable('SiswaTable');

        $table->addRow();
        $table->addCell(800, $styleCellHeader)->addText('No', ['bold' => true]);
        $table->addCell(1500, $styleCellHeader)->addText('NIS', ['bold' => true]);
        $table->addCell(4000, $styleCellHeader)->addText('Nama Siswa', ['bold' => true]);
        $table->addCell(1500, $styleCellHeader)->addText('Kelas', ['bold' => true]);
        $table->addCell(1800, $styleCellHeader)->addText('Jenis Kelamin', ['bold' => true]);

        $no = 1;
        foreach ($siswas as $item) {
            $table->addRow();
            $table->addCell(800)->addText($no++);
            $table->addCell(1500)->addText($item->nis);
            $table->addCell(4000)->addText($item->nama);
            $table->addCell(1500)->addText($item->kelas ? $item->kelas->nama_kelas : '-');
            $table->addCell(1800)->addText($item->jenis_kelamin);
        }

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $pathFile = storage_path($namaFile . '.docx');
        $objWriter->save($pathFile);

        return response()->download($pathFile)->deleteFileAfterSend(true);
    }
    // ==========================================
    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.siswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username',
            'password' => 'required|string|min:6',
            'nis' => 'required|string|max:20|unique:siswa,nis',
            'nisn' => 'required|string|max:10|unique:siswa,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:15',
            'tahun_masuk' => 'required|digits:4',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole('siswa');

        Siswa::create([
            'users_id' => $user->id,
            'kelas_id' => $validated['kelas_id'],
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'] ?? null,
            'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
            'tahun_masuk' => $validated['tahun_masuk'],
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['user', 'kelas'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    public function edit($id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->users_id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
            'nis' => 'required|string|max:20|unique:siswa,nis,' . $id,
            'nisn' => 'required|string|max:10|unique:siswa,nisn,' . $id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string|max:15',
            'tahun_masuk' => 'required|digits:4',
        ]);

        $userData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);

        $siswa->update([
            'kelas_id' => $validated['kelas_id'],
            'nis' => $validated['nis'],
            'nisn' => $validated['nisn'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'] ?? null,
            'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
            'tahun_masuk' => $validated['tahun_masuk'],
        ]);

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $user = User::findOrFail($siswa->users_id);
        $siswa->delete();
        $user->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}