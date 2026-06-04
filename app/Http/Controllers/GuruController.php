<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User;
use App\Models\Jadwal;
use App\Models\WaliKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\GuruExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::query();

        // Logika Pencarian (Nama / NIP)
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        // Logika Filter Jenis Kelamin
        if ($request->has('jenis_kelamin') && $request->jenis_kelamin != '') {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }

        $guru = $query->paginate(10)->withQueryString();

        return view('admin.guru.index', compact('guru'));
    }

    // 2. TAMBAH FUNGSI EXPORT
    public function export(Request $request)
    {
        $jenisKelamin = $request->input('jenis_kelamin');
        $search = $request->input('search');
        $format = $request->input('format', 'excel');
        $namaFile = 'data_guru_' . date('Y-m-d');

        if ($jenisKelamin) {
            $namaFile = 'data_guru_' . strtolower(str_replace(' ', '_', $jenisKelamin));
        }

        if ($format === 'excel') {
            return Excel::download(new GuruExport($jenisKelamin, $search), $namaFile . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        } elseif ($format === 'pdf') {
            return Excel::download(new GuruExport($jenisKelamin, $search), $namaFile . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($format === 'word') {
            return $this->exportToWord($jenisKelamin, $search, $namaFile);
        }

        return redirect()->back()->with('error', 'Format file tidak dikenali.');
    }

    // 3. TAMBAH LOGIKA WORD EXPORT (SUDAH DIPERBAIKI AMAN DARI SYMBOL &)
    private function exportToWord($jenisKelamin, $search, $namaFile)
    {
        $query = Guru::query();
        
        if ($jenisKelamin) { $query->where('jenis_kelamin', $jenisKelamin); }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nip', 'like', '%' . $search . '%');
            });
        }
        $gurus = $query->get();

        // Hapus seluruh buffer yang menggantung agar tidak bocor dan merusak file Word
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        $section->addText("LAPORAN DATA GURU", ['bold' => true, 'size' => 16], ['alignment' => 'center']);
        if ($jenisKelamin) {
            $section->addText("Jenis Kelamin: " . htmlspecialchars($jenisKelamin), ['bold' => true, 'size' => 12], ['alignment' => 'center']);
        }
        $section->addText("Tanggal Unduh: " . date('d-m-Y'), ['italic' => true], ['alignment' => 'center']);
        $section->addTextBreak(1);

        $styleTable = ['borderSize' => 6, 'borderColor' => '999999', 'cellMargin' => 80];
        $styleCellHeader = ['bgColor' => 'EEEEEE'];
        $phpWord->addTableStyle('GuruTable', $styleTable);
        
        $table = $section->addTable('GuruTable');

        // Header
        $table->addRow();
        $table->addCell(800, $styleCellHeader)->addText('No', ['bold' => true]);
        $table->addCell(2000, $styleCellHeader)->addText('NIP', ['bold' => true]);
        $table->addCell(4000, $styleCellHeader)->addText('Nama Guru', ['bold' => true]);
        $table->addCell(2000, $styleCellHeader)->addText('Jenis Kelamin', ['bold' => true]);
        $table->addCell(2000, $styleCellHeader)->addText('No. HP', ['bold' => true]);

        // Isi Data (Wajib dibungkus htmlspecialchars agar karakter khusus/simbol diproses aman)
        $no = 1;
        foreach ($gurus as $item) {
            $table->addRow();
            $table->addCell(800)->addText($no++);
            $table->addCell(2000)->addText(htmlspecialchars($item->nip));
            $table->addCell(4000)->addText(htmlspecialchars($item->nama)); // <-- Aman dari nama ber-simbol seperti &
            $table->addCell(2000)->addText(htmlspecialchars($item->jenis_kelamin));
            $table->addCell(2000)->addText(htmlspecialchars($item->no_hp ?? '-'));
        }

        // Menggunakan teknik pemotongan murni output header agar tidak corrupt
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment;filename="' . $namaFile . '.docx"');
        header('Cache-Control: max-age=0');

        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('php://output');
        exit;
    }
   
    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username',
            'role' => 'required|in:guru,wali kelas',
            'password' => 'required|string|min:6',
            'nip' => 'required|string|max:20|unique:guru,nip',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        Guru::create([
            'users_id' => $user->id,
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp' => $validated['no_hp'] ?? null,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    public function show($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru.show', compact('guru'));
    }

    public function edit($id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
        $user = User::findOrFail($guru->users_id);

        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username,' . $user->id,
            'role' => 'required|in:guru,wali kelas',
            'password' => 'nullable|string|min:6',
            'nip' => 'required|string|max:20|unique:guru,nip,' . $id,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp' => 'nullable|string|max:15',
        ]);

        $userData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);
        
        $user->syncRoles([$validated['role']]);

        $guru->update([
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'no_hp' => $validated['no_hp'] ?? null,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil diupdate!');
    }

    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
        $user = User::findOrFail($guru->users_id);
       
        \App\Models\Jadwal::where('guru_id', $guru->id)->delete();
        \App\Models\WaliKelas::where('guru_id', $guru->id)->delete();
        $guru->delete();
        $user->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}