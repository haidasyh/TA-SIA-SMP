@extends('layouts.app')

@section('title', 'Login - SMP Negeri 1 Bataguh')

@push('styles')
    <style>
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background:
                radial-gradient(circle at top left, rgba(120, 160, 131, 0.16), transparent 28%),
                radial-gradient(circle at right center, rgba(80, 114, 123, 0.14), transparent 22%),
                linear-gradient(180deg, #f4f7f4, #edf3ef);
        }

        .login-shell {
            width: min(1120px, 100%);
            margin: 0 auto;
            padding: 3rem 1.5rem;
        }

        .login-visual {
            min-height: 620px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 2rem;
            background:
                linear-gradient(145deg, rgba(52, 73, 85, 0.98), rgba(53, 55, 75, 0.98)),
                linear-gradient(135deg, #78a083, #50727b);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 28px 60px rgba(53, 55, 75, 0.18);
        }

        .login-visual::before,
        .login-visual::after {
            content: "";
            position: absolute;
            border-radius: 50%;
        }

        .login-visual::before {
            width: 220px;
            height: 220px;
            top: -50px;
            right: -50px;
            background: rgba(120, 160, 131, 0.24);
        }

        .login-visual::after {
            width: 180px;
            height: 180px;
            bottom: -60px;
            left: -40px;
            background: rgba(80, 114, 123, 0.22);
        }

        .login-visual i {
            position: relative;
            z-index: 1;
            font-size: clamp(7rem, 16vw, 15rem);
            color: rgba(255, 255, 255, 0.82);
        }

        .login-visual-badge {
            position: absolute;
            left: 1.5rem;
            bottom: 1.5rem;
            z-index: 1;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(10px);
            border-radius: 999px;
            padding: 0.55rem 0.9rem;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .login-panel {
            padding: 1rem 0 1rem 2rem;
        }

        .login-kicker {
            font-size: 0.82rem;
            font-weight: 700;
            color: #50727b;
            margin-bottom: 1rem;
            text-align: left;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .login-title {
            font-size: clamp(2.2rem, 3.4vw, 3.4rem);
            font-weight: 700;
            color: #35374b;
            line-height: 1.2;
            text-align: left;
            margin-bottom: 1rem;
        }

        .login-subtitle {
            font-size: 1.08rem;
            font-weight: 600;
            color: #5f7278;
            text-align: left;
            margin-bottom: 2rem;
        }

        .login-card {
            max-width: 510px;
            margin: 0 auto 0 0;
            background: rgba(255, 255, 255, 0.76);
            border: 1px solid rgba(80, 114, 123, 0.12);
            border-radius: 1.75rem;
            padding: 2rem;
            box-shadow: 0 18px 40px rgba(53, 55, 75, 0.08);
            backdrop-filter: blur(8px);
        }

        .login-form {
            max-width: 100%;
            margin: 0;
        }

        .login-label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: #344955;
            margin-bottom: 0.65rem;
        }

        .login-field {
            position: relative;
            margin-bottom: 2.25rem;
        }

        .login-input {
            width: 100%;
            border: 0;
            border-bottom: 1.5px solid rgba(52, 73, 85, 0.22);
            background: transparent;
            padding: 0 2.2rem 0.6rem 0;
            font-size: 0.98rem;
            color: #22323a;
            outline: none;
            border-radius: 0;
        }

        .login-input::placeholder {
            color: #97a6aa;
        }

        .login-input:focus {
            border-bottom-color: #50727b;
        }

        .password-toggle {
            position: absolute;
            right: 0;
            bottom: 0.45rem;
            border: 0;
            background: transparent;
            color: #344955;
            padding: 0;
            line-height: 1;
        }

        .forgot-wrap {
            text-align: right;
            margin-top: -0.5rem;
            margin-bottom: 3rem;
        }

        .forgot-link {
            font-size: 0.88rem;
            color: #50727b;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #35374b;
        }

        .login-submit-wrap {
            display: flex;
            justify-content: center;
        }

        .login-submit {
            min-width: 210px;
            border-radius: 999px;
            border: 0;
            background: linear-gradient(135deg, #78a083, #50727b);
            color: #fff;
            font-weight: 700;
            padding: 0.9rem 1.5rem;
            transition: 0.2s ease;
            box-shadow: 0 16px 30px rgba(80, 114, 123, 0.22);
        }

        .login-submit:hover {
            background: linear-gradient(135deg, #6e9578, #45656d);
            color: #fff;
        }

        .login-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.8rem;
            margin-bottom: 1.5rem;
        }

        .login-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            background: rgba(120, 160, 131, 0.12);
            border: 1px solid rgba(120, 160, 131, 0.16);
            color: #344955;
            border-radius: 999px;
            padding: 0.55rem 0.85rem;
            font-size: 0.82rem;
            font-weight: 700;
        }

        @media (max-width: 991.98px) {
            .login-shell {
                padding: 2rem 1.25rem 3rem;
            }

            .login-panel {
                padding: 2.25rem 0 0;
            }

            .login-visual {
                min-height: 360px;
            }

            .login-title {
                margin-bottom: 0.9rem;
            }

            .login-card {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <section class="login-page">
        <div class="login-shell">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-6">
                    <div class="login-visual">
                        <i class="bi bi-image"></i>
                        <span class="login-visual-badge">Portal Login Sekolah</span>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="login-panel">
                        <div class="login-kicker">SELAMAT DATANG</div>
                        <h1 class="login-title">Sistem Informasi SMPN 1 Bataguh</h1>
                        <div class="login-subtitle">Masuk dan verifikasi akun untuk mengakses layanan akademik sekolah.</div>

                        <div class="login-card">

                            <form class="login-form" method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <div class="login-field">
                                    <label class="login-label" for="username">Username</label>
                                    <input
                                        id="username"
                                        type="text"
                                        name="username"
                                        class="login-input"
                                        placeholder="Masukkan username"
                                        value="{{ old('username') }}"
                                        required
                                    >
                                    @error('username')
                                        <div class="text-danger mt-2 small">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="login-field">
                                    <label class="login-label" for="password">Password</label>
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="login-input"
                                        placeholder="Masukkan password"
                                        required
                                    >
                                    <button type="button" class="password-toggle" id="togglePassword" aria-label="Tampilkan password">
                                        <i class="bi bi-eye-slash-fill"></i>
                                    </button>
                                </div>

                                <div class="forgot-wrap">
                                    <a href="#" class="forgot-link">Lupa Password?</a>
                                </div>

                                <div class="login-submit-wrap">
                                    <button type="submit" class="login-submit">Masuk</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');

            if (!passwordInput || !togglePassword) {
                return;
            }

            togglePassword.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                this.innerHTML = isPassword
                    ? '<i class="bi bi-eye-fill"></i>'
                    : '<i class="bi bi-eye-slash-fill"></i>';
            });
        });
    </script>
@endpush
