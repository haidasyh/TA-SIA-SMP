<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Guru;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $roles = (array) $validated['roles'];
        $hasGuruOrWaliKelas = in_array('guru', $roles) || in_array('wali kelas', $roles);

        // Menggunakan Database Transaction untuk menjamin sinkronisasi dua tabel
        DB::transaction(function () use ($validated, $roles, $hasGuruOrWaliKelas) {
            $user = User::create([
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
                'email'    => $validated['email'] ?? null,
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole($roles);

            if ($hasGuruOrWaliKelas) {
                Guru::create([
                    'users_id'      => $user->id,
                    'nip'           => $validated['nip'],
                    'nama'          => $validated['nama'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'no_hp'         => $validated['no_hp'] ?? null,
                ]);
            }
        });

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::with(['roles', 'guru'])->findOrFail($id);
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);
        $roles = (array) $validated['roles'];
        $hasGuruOrWaliKelas = in_array('guru', $roles) || in_array('wali kelas', $roles);

        DB::transaction(function () use ($validated, $user, $roles, $hasGuruOrWaliKelas) {
            $userData = [
                'nama'     => $validated['nama'],
                'username' => $validated['username'],
                'email'    => $validated['email'] ?? null,
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $user->update($userData);
            $user->syncRoles($roles);

            if ($hasGuruOrWaliKelas) {
                $guruData = [
                    'nip'           => $validated['nip'],
                    'nama'          => $validated['nama'],
                    'jenis_kelamin' => $validated['jenis_kelamin'],
                    'no_hp'         => $validated['no_hp'] ?? null,
                ];
                
                Guru::updateOrCreate(
                    ['users_id' => $user->id],
                    $guruData
                );
            }
        });

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        DB::transaction(function () use ($user) {
            // Jika user yang dihapus adalah guru, bersihkan juga data jabatan dan jadwalnya
            $guru = Guru::where('users_id', $user->id)->first();
            if ($guru) {
                \App\Models\Jadwal::where('guru_id', $guru->id)->delete();
                \App\Models\WaliKelas::where('guru_id', $guru->id)->delete();
                $guru->delete();
            }

            // Catatan: Jika user adalah siswa, kamu bisa menambahkan hapus riwayat siswa di sini
            $siswa = \App\Models\Siswa::where('users_id', $user->id)->first();
            if ($siswa) {
                \App\Models\Nilai::where('siswa_id', $siswa->id)->delete();
                \App\Models\Presensi::where('siswa_id', $siswa->id)->delete();
                $siswa->delete();
            }

            $user->delete();
        });

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}