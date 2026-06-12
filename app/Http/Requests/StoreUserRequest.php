<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $roles = (array) $this->input('roles');
        $hasGuruOrWaliKelas = in_array('guru', $roles) || in_array('wali kelas', $roles);

        $rules = [
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:roles,name',
        ];

        // Validasi tambahan jika rolenya adalah Guru/Wali Kelas
        if ($hasGuruOrWaliKelas) {
            $rules['nip']           = 'required|string|max:20|unique:guru,nip';
            $rules['jenis_kelamin'] = 'required|in:Laki-laki,Perempuan';
            $rules['no_hp']         = 'nullable|string|max:15';
        }

        return $rules;
    }
}