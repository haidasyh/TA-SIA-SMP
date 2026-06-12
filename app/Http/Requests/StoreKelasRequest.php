<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_kelas' => 'required|string|max:20|unique:kelas,nama_kelas', // Mencegah nama kelas ganda
            'tingkat'    => 'required|integer|min:1|max:12', // Range disesuaikan (bisa sampai tingkat SMP/SMA)
        ];
    }

    public function messages(): array
    {
        return [
            'nama_kelas.unique' => 'Nama kelas tersebut sudah terdaftar di sistem.',
        ];
    }
}