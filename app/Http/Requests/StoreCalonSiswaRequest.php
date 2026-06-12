<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCalonSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Jangan lupa diubah ke true
    }

    public function rules(): array
    {
        return [
            'nama'          => 'required|string|max:100',
            'nisn'          => 'required|string|max:10|unique:calon_siswa,nisn',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'no_hp_ortu'    => 'required|string|max:15',
            'asal_sekolah'  => 'required|string|max:100',
            'alamat'        => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nisn.unique'   => 'NISN ini sudah terdaftar dalam sistem PPDB.',
            'nama.required' => 'Nama calon siswa wajib diisi.',
        ];
    }
}