<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMataPelajaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Aturan validasi untuk proses EDIT/UPDATE data.
     */
    public function rules(): array
    {
        // Mengambil ID mapel langsung dari parameter URL route resource
        $mapelId = $this->route('mata_pelajaran'); 

        return [
            // Mengabaikan ID mapel saat ini agar tidak bentrok dengan keunikan kodenya sendiri
            'kode_mapel' => 'required|string|max:10|unique:mata_pelajaran,kode_mapel,' . $mapelId,
            'nama_mapel' => 'required|string|max:50',
            'kkm'        => 'nullable|integer|min:0|max:100',
            'deskripsi'  => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.unique'   => 'Kode mata pelajaran sudah digunakan oleh mapel lain.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
            'kkm.max'             => 'Nilai KKM maksimal adalah 100.',
        ];
    }
}