<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMataPelajaranRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true; // Wajib diubah ke true agar tidak error 403 Unauthorized
    }

    /**
     * Aturan validasi untuk proses TAMBAH data.
     */
    public function rules(): array
    {
        return [
            'kode_mapel' => 'required|string|max:10|unique:mata_pelajaran,kode_mapel',
            'nama_mapel' => 'required|string|max:50',
            'kkm'        => 'nullable|integer|min:0|max:100',
            'deskripsi'  => 'nullable|string',
        ];
    }

    /**
     * Kustomisasi pesan error (Opsional, agar tampilan di blade berbahasa Indonesia).
     */
    public function messages(): array
    {
        return [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.unique'   => 'Kode mata pelajaran ini sudah terdaftar.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'kkm.max'             => 'Nilai KKM maksimal adalah 100.',
        ];
    }
}