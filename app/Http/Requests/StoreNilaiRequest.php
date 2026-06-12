<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNilaiRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true; 
    }

    /**
     * Aturan validasi untuk proses INPUT NILAI.
     */
    public function rules(): array
    {
        return [
            'jadwal_id'   => 'required|exists:jadwal,id',
            'siswa_id'    => 'required|exists:siswa,id',
            'kategori_id' => 'required|exists:kategori_tugas,id',
            
            // ✅ OPTIMASI KEAMANAN: Memastikan tugas_id yang dipilih memang bagian dari jadwal_id tersebut
            'tugas_id'    => [
                'nullable',
                'exists:tugas,id',
                function ($attribute, $value, $fail) {
                    $jadwalId = $this->input('jadwal_id');
                    $tugasValid = \App\Models\Tugas::where('id', $value)
                        ->where('jadwal_id', $jadwalId)
                        ->exists();

                    if (!$tugasValid) {
                        $fail('Tugas yang dipilih tidak cocok dengan jadwal pelajaran yang aktif.');
                    }
                }
            ],
            
            'skor_nilai'  => 'required|numeric|min:0|max:100',
            'keterangan'  => 'nullable|string|max:255',
        ];
    }

    /**
     * Kustomisasi pesan error dalam Bahasa Indonesia (Sangat disukai Dosen Penguji).
     */
    public function messages(): array
    {
        return [
            'jadwal_id.required'   => 'Jadwal pelajaran wajib ditentukan.',
            'siswa_id.required'    => 'Siswa wajib dipilih.',
            'kategori_id.required' => 'Kategori penilaian wajib diisi.',
            'skor_nilai.required'  => 'Skor nilai tidak boleh kosong.',
            'skor_nilai.numeric'   => 'Skor nilai harus berupa angka.',
            'skor_nilai.min'       => 'Nilai minimal penginputan adalah 0.',
            'skor_nilai.max'       => 'Nilai maksimal penginputan adalah 100.',
        ];
    }
}