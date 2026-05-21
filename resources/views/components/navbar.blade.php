<nav class="navbar navbar-expand-lg navbar-school sticky-top py-3">
    <div class="container">
        <a class="navbar-brand navbar-school-brand d-flex align-items-center gap-1" href="{{ url('/') }}">
            <span class="navbar-brand-box">
                <img src="{{ asset('logo.png') }}" alt="Logo SMP Negeri 1 Bataguh" class="navbar-brand-logo">
            </span>
            <span class="navbar-brand-text">SMP Negeri 1 Bataguh</span>
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNavbar">
            <ul class="navbar-nav align-items-lg-center gap-lg-3">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#beranda">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('ppdb') }}">PPDB</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('hasil-seleksi') }}">Hasil Seleksi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item ms-lg-3">
                    <a class="btn navbar-register-btn" href="{{ route('biodata-peserta') }}">
                        <i class="bi bi-person-circle"></i>
                        <span>Daftarkan Murid</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
