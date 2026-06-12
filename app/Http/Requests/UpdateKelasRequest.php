<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kelasId = $this->route('kela'); // Mengambil parameter id kelas dari route resource bawaan Laravel

        return [
            'nama_kelas' => 'required|string|max:20|unique:kelas,nama_kelas,' . $kelasId,
            'tingkat'    => 'required|integer|min:1|max:12',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.unique' => 'Nama kelas tersebut sudah digunakan oleh kelas lain.',
        ];
    }
}