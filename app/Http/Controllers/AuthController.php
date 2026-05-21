<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $roles = $user->roles->pluck('name')->toArray();
            
            if (in_array('siswa', $roles)) {
                return redirect()->route('dashboard.siswa');
            }
            
            $activeRole = $roles[0] ?? null;
            session(['active_role' => $activeRole]);
            
            return $this->redirectToDashboard($activeRole);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            $roles = $user->roles->pluck('name')->toArray();
            
            if (in_array('siswa', $roles)) {
                return redirect()->route('dashboard.siswa');
            }
            
            $activeRole = $roles[0] ?? null;
            session(['active_role' => $activeRole]);
            
            return $this->redirectToDashboard($activeRole);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function switchRole(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
        ]);

        $user = Auth::user();
        
        if (!$user->hasRole($request->role)) {
            abort(403);
        }

        session(['active_role' => $request->role]);

        return $this->redirectToDashboard($request->role);
    }

    private function redirectToDashboard($role)
    {
        $routes = [
            'administrator' => 'dashboard.admin',
            'guru' => 'dashboard.guru',
            'wali kelas' => 'dashboard.walikelas',
            'siswa' => 'dashboard.siswa',
        ];

        return redirect()->route($routes[$role] ?? 'login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function adminDashboard()
    {
        return view('dashboard.admin');
    }

    public function guruDashboard()
    {
        return view('dashboard.guru');
    }

    public function waliKelasDashboard()
    {
        return view('dashboard.walikelas');
    }

    public function siswaDashboard()
    {
        return view('dashboard.siswa');
    }
}
