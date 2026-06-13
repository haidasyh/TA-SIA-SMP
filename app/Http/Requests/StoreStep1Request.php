<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep1Request extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nisn'        => 'required|digits:10|unique:calon_siswa,nisn',
            'tahun_lulus' => 'required|digits:4|integer|min:' . (date('Y') - 3) . '|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        $tahunMin = date('Y') - 3;
        $tahunMax = date('Y');

        return [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.digits'   => 'NISN harus berupa angka dan tepat 10 digit.',
            'nisn.unique'   => 'NISN ini sudah terdaftar di sistem PPDB kami. Silakan hubungi admin jika ada kesalahan.',
            'tahun_lulus.required' => 'Tahun lulus wajib diisi.',
            'tahun_lulus.digits'   => 'Tahun lulus harus berupa 4 digit angka (Contoh: 2025).',
            'tahun_lulus.integer'  => 'Tahun lulus harus berupa angka valid.',
            'tahun_lulus.min'      => 'Tahun lulus minimal adalah tahun ' . $tahunMin . ' (Menyesuaikan syarat umur maksimal 15 tahun).',
            'tahun_lulus.max'      => 'Tahun lulus maksimal adalah tahun ' . $tahunMax . ' (Tahun berjalan).',
        ];
    }
}