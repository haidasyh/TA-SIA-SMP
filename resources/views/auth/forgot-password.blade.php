@extends('layouts.app')

@section('title', 'Lupa Password - SMP Negeri 1 Bataguh')

@section('content')
<div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card p-4 shadow-lg border-0" style="max-width: 450px; width: 100%; border-radius: 1.5rem; background: rgba(255, 255, 255, 0.9);">
        <h3 class="fw-bold text-center mb-2" style="color: #35374b;">Minta Reset Password</h3>
        <p class="text-muted text-center small mb-4">Masukkan email akun Anda. Kami akan mengirimkan link untuk membuat password baru.</p>

        @if (session('status'))
            <div class="alert alert-success small mb-3" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label small fw-bold text-secondary">Alamat Email</label>
                <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="contoh@email.com" value="{{ old('email') }}" required autofocus style="border-radius: 0.5rem;">
                @error('email')
                    <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2 mt-4">
                <button type="submit" class="btn text-white fw-bold" style="background: linear-gradient(135deg, #78a083, #50727b); border-radius: 999px; padding: 0.75rem;">
                    Kirim Link Reset
                </button>
                <a href="{{ route('login') }}" class="btn btn-link btn-sm text-decoration-none mt-2" style="color: #50727b;">Kembali ke Login</a>
            </div>
        </form>
    </div>
</div>
@endsection