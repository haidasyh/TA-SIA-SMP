<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'exists:users,email',
 
                function ($attribute, $value, $fail) {
                    $user = User::where('email', $value)->first();
                    
                    // Cek jika user ditemukan dan memiliki role 'siswa'
                    if ($user && $user->hasRole('siswa')) {
                        $fail('Mohon maaf, email yang terdaftar merupakan siswa, silakan lapor ke admin untuk mereset password.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.exists'   => 'Alamat email tidak terdaftar dalam sistem kami.',
        ];
    }
}