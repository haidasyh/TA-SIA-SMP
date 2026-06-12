<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep2Request extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama'            => 'required|string|max:100',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'   => 'required|date',
            'no_hp_ortu'      => 'required|string|max:15',
            'asal_sekolah'    => 'required|string|max:100',
            'alamat'          => 'required|string',
            'berkas_akta'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_kk'       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'berkas_ktp_ortu' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pasfoto'         => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}