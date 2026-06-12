<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTugasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'jadwal_id'         => 'required|exists:jadwal,id',
            'judul_tugas'       => 'required|string|max:100',
            'deskripsi'         => 'nullable|string',
            'tanggal_diberikan' => 'required|date',
            'tanggal_deadline'  => 'nullable|date|after_or_equal:tanggal_diberikan',
            'status'            => 'required|in:Aktif,Selesai',
        ];
    }
}