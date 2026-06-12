<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep1Request extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nisn'        => 'required|string|max:10|unique:calon_siswa,nisn', // 🛡️ Kunci agar NISN unik
            'tahun_lulus' => 'required|digits:4|integer|min:2000|max:' . date('Y'),
        ];
    }

    public function messages(): array
    {
        return [
            'nisn.unique' => 'NISN ini sudah terdaftar di sistem PPDB kami. Silakan hubungi admin jika ada kesalahan.',
        ];
    }
}