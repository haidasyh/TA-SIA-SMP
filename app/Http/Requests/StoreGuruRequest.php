<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'nama'          => 'required|string|max:100',
            'username'      => 'required|string|max:25|unique:users,username',
            'role'          => 'required|in:guru,wali kelas',
            'password'      => 'required|string|min:6',
            'nip'           => 'required|string|max:20|unique:guru,nip',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp'         => 'nullable|string|max:15',
        ];
    }
}