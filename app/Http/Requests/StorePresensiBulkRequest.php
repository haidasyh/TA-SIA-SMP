<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresensiBulkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal'  => 'required|date',
            'presensi' => 'required|array',
            'presensi.*' => 'nullable|in:Hadir,Izin,Sakit,Alpha',
        ];
    }
}