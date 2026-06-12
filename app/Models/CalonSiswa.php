<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class CalonSiswa extends Model
{
    use HasFactory;

    protected $table = 'calon_siswa';
    
    protected $fillable = [
        'no_pendaftaran',
        'nama',
        'nisn',
        'jenis_kelamin',
        'tanggal_lahir',
        'no_hp_ortu',
        'asal_sekolah',
        'alamat',
        'status_verifikasi',
        'berkas_akta',
        'berkas_kk',
        'berkas_ktp_ortu',
        'berkas_persetujuan',
        'pasfoto',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function getBerkasAktaUrlAttribute()
    {
        return $this->berkas_akta ? Storage::url($this->berkas_akta) : null;
    }

    public function getBerkasKkUrlAttribute()
    {
        return $this->berkas_kk ? Storage::url($this->berkas_kk) : null;
    }

    public function getBerkasKtpOrtuUrlAttribute()
    {
        return $this->berkas_ktp_ortu ? Storage::url($this->berkas_ktp_ortu) : null;
    }

    public function getBerkasPersetujuanUrlAttribute()
    {
        return $this->berkas_persetujuan ? Storage::url($this->berkas_persetujuan) : null;
    }

    public function getPasfotoUrlAttribute()
    {
        return $this->pasfoto ? Storage::url($this->pasfoto) : null;
    }

}
