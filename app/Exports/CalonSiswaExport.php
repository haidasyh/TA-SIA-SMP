<?php

namespace App\Exports;

use App\Models\CalonSiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CalonSiswaExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return CalonSiswa::all();
    }

    public function headings(): array
    {
        return [
            'No. Pendaftaran',
            'Nama',
            'NISN',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'No. HP Orang Tua',
            'Asal Sekolah',
            'Alamat',
            'Status Verifikasi',
            'Tanggal Daftar',
        ];
    }

    public function map($calonSiswa): array
    {
        return [
            $calonSiswa->no_pendaftaran,
            $calonSiswa->nama,
            $calonSiswa->nisn,
            $calonSiswa->jenis_kelamin,
            $calonSiswa->tanggal_lahir?->format('d/m/Y'),
            $calonSiswa->no_hp_ortu,
            $calonSiswa->asal_sekolah,
            $calonSiswa->alamat,
            $calonSiswa->status_verifikasi,
            $calonSiswa->created_at?->format('d/m/Y H:i'),
        ];
    }
}
