<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // AKUN A: Administrator sekaligus Guru
        // ==========================================
        $adminUser = User::firstOrCreate([
            'username' => 'admin',
        ], [
            'nama' => 'Administrator & Guru',
            'email' => 'admin@smpn1bataguh.sch.id',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole('administrator');
        $adminUser->assignRole('guru');

        // Buat data Guru untuk Admin
        Guru::firstOrCreate([
            'users_id' => $adminUser->id,
        ], [
            'nip' => '1234567890',
            'nama' => 'Administrator & Guru',
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '081234567890',
        ]);


        // ==========================================
        // AKUN B: Guru sekaligus Wali Kelas
        // ==========================================
        $waliUser = User::firstOrCreate([
            'username' => 'walikelas',
        ], [
            'nama' => 'Guru & Wali Kelas',
            'email' => 'walikelas@smpn1bataguh.sch.id',
            'password' => Hash::make('password'),
        ]);
        $waliUser->assignRole('guru');
        $waliUser->assignRole('wali kelas');

        // Buat data Guru untuk Wali Kelas
        Guru::firstOrCreate([
            'users_id' => $waliUser->id,
        ], [
            'nip' => '0987654321',
            'nama' => 'Guru & Wali Kelas',
            'jenis_kelamin' => 'Perempuan',
            'no_hp' => '089876543210',
        ]);


        // ==========================================
        // AKUN C: Guru saja
        // ==========================================
        $guruUser = User::firstOrCreate([
            'username' => 'guru',
        ], [
            'nama' => 'Guru Murni',
            'email' => 'guru@smpn1bataguh.sch.id',
            'password' => Hash::make('password'),
        ]);
        $guruUser->assignRole('guru');

        // Buat data Guru
        Guru::firstOrCreate([
            'users_id' => $guruUser->id,
        ], [
            'nip' => '1122334455',
            'nama' => 'Guru Murni',
            'jenis_kelamin' => 'Laki-laki',
            'no_hp' => '081122334455',
        ]);


        // ==========================================
        // AKUN D: Siswa saja
        // ==========================================
        $siswaUser = User::firstOrCreate([
            'username' => 'siswa',
        ], [
            'nama' => 'Siswa Contoh',
            'email' => 'siswa@smpn1bataguh.sch.id',
            'password' => Hash::make('password'),
        ]);
        $siswaUser->assignRole('siswa');

        // Jika kamu punya tabel detail Siswa, bisa ditambahkan di bawah ini
        // Siswa::firstOrCreate(['users_id' => $siswaUser->id], [...]);
    }
}