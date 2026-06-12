<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCalonSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID calon siswa langsung dari parameter URL rute resource
        $calonSiswaId = $this->route('calon_siswa'); 

        return [
            'nama'              => 'required|string|max:100',
            'nisn'              => 'required|string|max:10|unique:calon_siswa,nisn,' . $calonSiswaId,
            'jenis_kelamin'     => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'     => 'required|date',
            'no_hp_ortu'        => 'required|string|max:15',
            'asal_sekolah'      => 'required|string|max:100',
            'alamat'            => 'required|string',
            'status_verifikasi' => 'required|in:Pending,Diterima,Ditolak',
        ];
    }
}