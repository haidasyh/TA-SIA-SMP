<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- ADMINISTRATOR PERMISSIONS ---
        $adminPermissions = [
            'menambah calon siswa',
            'mengubah calon siswa',
            'menghapus calon siswa',
            'mengubah status verifikasi pendaftar',
            'menemukan rekap data pendaftaran siswa baru',
            'menambah data siswa',
            'mengubah data siswa',
            'menghapus data siswa',
            'melihat detail data siswa',
            'menambah data guru',
            'mengubah data guru',
            'menghapus data guru',
            'melihat detail data guru',
            'menambah data mata pelajaran',
            'mengubah data mata pelajaran',
            'menghapus data mata pelajaran',
            'melihat detail data mata pelajaran',
            'menambah data kelas',
            'mengubah data kelas',
            'menghapus data kelas',
            'melihat detail data kelas',
            'mengatur jadwal mata pelajaran',
            'menambah data user beserta hak aksesnya',
            'mengubah data user',
            'menghapus data user',
            'melihat detail data user',
        ];

        // --- GURU PERMISSIONS ---
        $guruPermissions = [
            'melihat jadwal mengajar',
            'melihat daftar siswa tipe kelas yang diampu',
            'melihat detail data siswa',
            'memasukkan nilai siswa',
            'mengubah nilai tugas dan nilai ulangan siswa',
            'mencetak nilai siswa',
        ];

        // --- WALI KELAS PERMISSIONS ---
        $waliKelasPermissions = [
            'memasukkan data presensi siswa',
            'mengubah data presensi siswa',
            'melihat detail data siswa',
            'mencetak rekapitulasi presensi siswa',
            'melihat rekapitulasi nilai siswa kelas pada seluruh mata pelajaran',
            'mencetak rekapitulasi nilai siswa kelas pada seluruh mata pelajaran',
        ];

        // --- SISWA PERMISSIONS ---
        $siswaPermissions = [
            'melihat jadwal pelajaran',
            'melihat rekapitulasi presensi',
            'melihat nilai pada setiap mata pelajaran',
        ];

        // Create all permissions
        $allPermissions = array_merge(
            $adminPermissions,
            $guruPermissions,
            $waliKelasPermissions,
            $siswaPermissions
        );
        foreach (array_unique($allPermissions) as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        $guruRole = Role::firstOrCreate(['name' => 'guru', 'guard_name' => 'web']);
        $waliKelasRole = Role::firstOrCreate(['name' => 'wali kelas', 'guard_name' => 'web']);
        $siswaRole = Role::firstOrCreate(['name' => 'siswa', 'guard_name' => 'web']);

        // Assign permissions to roles
        $adminRole->syncPermissions($adminPermissions);
        $guruRole->syncPermissions($guruPermissions);
        $waliKelasRole->syncPermissions($waliKelasPermissions);
        $siswaRole->syncPermissions($siswaPermissions);
    }
}
