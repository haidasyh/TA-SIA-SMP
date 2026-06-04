<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->orderBy('created_at', 'desc')->get();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $hasGuruOrWaliKelas = in_array('guru', (array)$request->roles) || in_array('wali kelas', (array)$request->roles);
        
        $rules = [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:6',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ];
        
        if ($hasGuruOrWaliKelas) {
            $rules['nip'] = 'required|string|max:20|unique:guru,nip';
            $rules['jenis_kelamin'] = 'required|in:Laki-laki,Perempuan';
            $rules['no_hp'] = 'nullable|string|max:15';
        }

        $validated = $request->validate($rules);

        $user = User::create([
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['roles']);

        if ($hasGuruOrWaliKelas) {
            \App\Models\Guru::create([
                'users_id' => $user->id,
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp' => $validated['no_hp'] ?? null,
            ]);
        }

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

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $hasGuruOrWaliKelas = in_array('guru', (array)$request->roles) || in_array('wali kelas', (array)$request->roles);
        
        $rules = [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:25|unique:users,username,' . $id,
            'email' => 'nullable|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ];
        
        if ($hasGuruOrWaliKelas) {
            $existingGuru = \App\Models\Guru::where('users_id', $id)->first();
            $rules['nip'] = 'required|string|max:20' . ($existingGuru ? '|unique:guru,nip,' . $existingGuru->id : '|unique:guru,nip');
            $rules['jenis_kelamin'] = 'required|in:Laki-laki,Perempuan';
            $rules['no_hp'] = 'nullable|string|max:15';
        }

        $validated = $request->validate($rules);

        $userData = [
            'nama' => $validated['nama'],
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($validated['password']);
        }

        $user->update($userData);
        $user->syncRoles($validated['roles']);

        if ($hasGuruOrWaliKelas) {
            $guruData = [
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp' => $validated['no_hp'] ?? null,
            ];
            
            \App\Models\Guru::updateOrCreate(
                ['users_id' => $user->id],
                $guruData
            );
        }

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus!');
    }
}
