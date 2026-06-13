<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStep2Request extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        // 1. Batas Paling Tua: Umur 15 tahun (Tahun Sekarang - 15) -> contoh: 2011-12-31
        $maxTahunLahir = date('Y') - 15;
        $batasTanggalTua = $maxTahunLahir . '-12-31';

        // 2. Batas Paling Muda: Umur 11 tahun (Tahun Sekarang - 11) -> contoh: 2015-12-31
        // Jadi tanggal lahir TIDAK BOLEH melewati akhir tahun 2015
        $minTahunLahir = date('Y') - 11;
        $batasTanggalMuda = $minTahunLahir . '-12-31';

        return [
            'nama'            => 'required|string|max:100',
            'jenis_kelamin'   => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir'   => 'required|date|after_or_equal:' . $batasTanggalTua . '|before_or_equal:' . $batasTanggalMuda,
            'no_hp_ortu'      => 'required|string|regex:/^[0-9]+$/|min:10|max:13',
            'asal_sekolah'    => 'required|string|max:100',
            'alamat'          => 'required|string',
        ];
    }

    public function messages(): array
    {
        $maxTahunLahir = date('Y') - 15;
        $minTahunLahir = date('Y') - 11;

        return [
            'tanggal_lahir.required'       => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.after_or_equal' => 'Umur terlalu tua. Maksimal umur adalah 15 tahun (Kelahiran tahun ' . $maxTahunLahir . ').',
            'tanggal_lahir.before_or_equal'=> 'Umur terlalu muda. Minimal umur mendaftar adalah 11 tahun (Maksimal kelahiran tahun ' . $minTahunLahir . ').',
            'no_hp_ortu.required'          => 'Nomor HP orang tua wajib diisi.',
            'no_hp_ortu.regex'             => 'Nomor HP harus berupa angka saja.',
            'no_hp_ortu.min'               => 'Nomor HP terlalu pendek, minimal 10 digit.',
            'no_hp_ortu.max'               => 'Nomor HP terlalu panjang, maksimal 13 digit.',
        ];
    }
}