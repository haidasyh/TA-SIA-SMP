@extends('layouts.app')

@section('title', 'Perbarui Password - SMP Negeri 1 Bataguh')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg border-0" style="max-width: 450px; width: 100%; border-radius: 1.5rem; background: rgba(255, 255, 255, 0.9);">
        <h3 class="fw-bold text-center mb-2" style="color: #35374b;">Password Baru</h3>
        <p class="text-muted text-center small mb-4">Silakan ketik password baru Anda di bawah ini.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-secondary">Email Konfirmasi</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ request()->email ?? old('email') }}" required autofocus style="border-radius: 0.5rem;">
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label small fw-bold text-secondary">Password Baru</label>
                <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required style="border-radius: 0.5rem;" placeholder="Minimal 8 karakter">
                @error('password')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password-confirm" class="form-label small fw-bold text-secondary">Konfirmasi Password Baru</label>
                <input id="password-confirm" type="password" name="password_confirmation" class="form-control" required style="border-radius: 0.5rem;" placeholder="Ulangi password baru">
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn text-white fw-bold" style="background: linear-gradient(135deg, #78a083, #50727b); border-radius: 999px; padding: 0.75rem;">
                    Perbarui Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection