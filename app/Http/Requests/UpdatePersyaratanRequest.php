<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePersyaratanRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'umum'   => 'nullable|array',
            'umum.*' => 'nullable|string|max:255',
            'khusus'   => 'nullable|array',
            'khusus.*' => 'nullable|string|max:255',
            'alur'   => 'nullable|array',
            'alur.*' => 'nullable|string|max:255',
        ];
    }
}