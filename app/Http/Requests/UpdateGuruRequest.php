<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Mengambil ID Guru dari parameter route
        $guruId = $this->route('guru'); 
        
        // Mencari ID User yang berelasi dengan Guru tersebut secara aman
        $guru = \App\Models\Guru::findOrFail($guruId);

        return [
            'nama'          => 'required|string|max:100',
            'username'      => 'required|string|max:25|unique:users,username,' . $guru->users_id,
            'role'          => 'required|in:guru,wali kelas',
            'password'      => 'nullable|string|min:6',
            'nip'           => 'required|string|max:20|unique:guru,nip,' . $guruId,
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'no_hp'         => 'nullable|string|max:15',
        ];
    }
}