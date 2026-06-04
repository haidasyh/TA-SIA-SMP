<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    protected $kelasId;
    protected $search;

    // Tangkap data filter dari controller
    public function __construct($kelasId = null, $search = null)
    {
        $this->kelasId = $kelasId;
        $this->search = $search;
    }

    public function query()
    {
        // Panggil base query beserta relasi tabel kelas
        $query = Siswa::with('kelas');

        // Jika admin memfilter kelas tertentu
        if ($this->kelasId) {
            $query->where('kelas_id', $this->kelasId);
        }

        // Jika admin memfilter kata kunci tertentu saat mendownload
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nis', 'like', '%' . $this->search . '%')
                  ->orWhere('nisn', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    // Menentukan susunan kolom data yang keluar di Excel/PDF
    public function map($siswa): array
    {
        return [
            $siswa->nis,
            $siswa->nisn,
            $siswa->nama,
            $siswa->kelas ? $siswa->kelas->nama_kelas : '-', // Menampilkan nama kelas asli (misal: 7A) bukan ID angka
            $siswa->jenis_kelamin,
            $siswa->tahun_masuk,
        ];
    }

    public function headings(): array
    {
        return [
            'NIS',
            'NISN',
            'Nama Siswa',
            'Kelas',
            'Jenis Kelamin',
            'Tahun Masuk'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Tebalkan baris header nomor 1
        ];
    }
}