<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Guru;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user'); // Ambil parameter ID user dari rute URL
        $roles = (array) $this->input('roles');
        $hasGuruOrWaliKelas = in_array('guru', $roles) || in_array('wali kelas', $roles);

        $rules = [
            'nama'     => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username,' . $userId,
            'email'    => 'nullable|email|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6',
            'roles'    => 'required|array',
            'roles.*'  => 'exists:roles,name',
        ];

        if ($hasGuruOrWaliKelas) {
            $existingGuru = Guru::where('users_id', $userId)->first();
            
            // Abaikan ID guru saat ini saat validasi keunikan NIP agar tidak bentrok dengan dirinya sendiri
            $rules['nip'] = 'required|string|max:20' . ($existingGuru ? '|unique:guru,nip,' . $existingGuru->id : '|unique:guru,nip');
            $rules['jenis_kelamin'] = 'required|in:Laki-laki,Perempuan';
            $rules['no_hp']         = 'nullable|string|max:15';
        }

        return $rules;
    }
}