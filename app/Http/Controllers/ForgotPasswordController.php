<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        // 🛡️ SECURITY DOUBLE CHECK: Antisipasi jika lolos dari request validation
        $user = User::where('email', $request->email)->first();
        if ($user && $user->hasRole('siswa')) {
            return back()->withErrors([
                'email' => 'Mohon maaf, email yang terdaftar merupakan siswa, silakan lapor ke admin untuk mereset password.'
            ]);
        }

        // Menggunakan broker bawaan Laravel jika lolos validasi (bukan siswa)
        $status = Password::broker()->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', 'Kami telah mengirimkan link reset password ke email Anda!')
            : back()->withErrors(['email' => __($status)]);
    }
}