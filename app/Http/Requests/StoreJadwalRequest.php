<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Jadwal;

class StoreJadwalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'semester_id' => 'required|exists:semester,id',
            'kelas_id'    => 'required|exists:kelas,id',
            'mapel_id'    => 'required|exists:mata_pelajaran,id',
            'guru_id'     => 'required|exists:guru,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ];
    }

    // Logika kustom untuk mencegah jadwal bentrok
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $hari       = $this->input('hari');
            $jamMulai   = $this->input('jam_mulai');
            $jamSelesai = $this->input('jam_selesai');
            $guruId     = $this->input('guru_id');
            $kelasId    = $this->input('kelas_id');
            $semesterId = $this->input('semester_id');

            // 1. Cek apakah GURU sudah mengajar di kelas lain pada jam tersebut
            $guruBentrok = Jadwal::where('semester_id', $semesterId)
                ->where('guru_id', $guruId)
                ->where('hari', $hari)
                ->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                      ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                      ->orWhere(function ($sub) use ($jamMulai, $jamSelesai) {
                          $sub->where('jam_mulai', '<=', $jamMulai)
                              ->where('jam_selesai', '>=', $jamSelesai);
                      });
                })->exists();

            if ($guruBentrok) {
                $validator->errors()->add('guru_id', 'Guru tersebut sudah memiliki jadwal mengajar di jam dan hari yang sama.');
            }

            // 2. Cek apakah KELAS tersebut sudah diisi oleh pelajaran/guru lain
            $kelasBentrok = Jadwal::where('semester_id', $semesterId)
                ->where('kelas_id', $kelasId)
                ->where('hari', $hari)
                ->where(function ($q) use ($jamMulai, $jamSelesai) {
                    $q->where('jam_mulai', [$jamMulai, $jamSelesai])
                      ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                      ->orWhere(function ($sub) use ($jamMulai, $jamSelesai) {
                          $sub->where('jam_mulai', '<=', $jamMulai)
                              ->where('jam_selesai', '>=', $jamSelesai);
                      });
                })->exists();

            if ($kelasBentrok) {
                $validator->errors()->add('kelas_id', 'Kelas tersebut sudah terisi pelajaran lain di jam dan hari yang sama.');
            }
        });
    }
}