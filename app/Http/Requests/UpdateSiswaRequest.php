<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Siswa;

class UpdateSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $siswaId = $this->route('siswa'); // Mengambil ID siswa dari parameter route URL
        $siswa = Siswa::findOrFail($siswaId);

        return [
            'nama'          => 'required|string|max:100',
            'username'      => 'required|string|max:25|unique:users,username,' . $siswa->users_id,
            'password'      => 'nullable|string|min:6',
            'nis'           => 'required|string|max:20|unique:siswa,nis,' . $siswaId,
            'nisn'          => 'required|string|max:10|unique:siswa,nisn,' . $siswaId,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id'      => 'required|exists:kelas,id',
            'alamat'        => 'nullable|string',
            'no_hp_ortu'    => 'nullable|string|max:15',
            'tahun_masuk'   => 'required|digits:4',
        ];
    }
}