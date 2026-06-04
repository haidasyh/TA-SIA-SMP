<?php

namespace App\Exports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    protected $jenisKelamin;
    protected $search;

    public function __construct($jenisKelamin = null, $search = null)
    {
        $this->jenisKelamin = $jenisKelamin;
        $this->search = $search;
    }

    public function query()
    {
        $query = Guru::query();

        // Filter berdasarkan Jenis Kelamin
        if ($this->jenisKelamin) {
            $query->where('jenis_kelamin', $this->jenisKelamin);
        }

        // Filter pencarian berdasarkan nama atau NIP
        if ($this->search) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nip', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function map($guru): array
    {
        return [
            $guru->nip,
            $guru->nama,
            $guru->jenis_kelamin,
            $guru->no_hp ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama Guru',
            'Jenis Kelamin',
            'No. HP'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}