@extends('layouts.app')

@section('title', 'SMP Negeri 1 Bataguh')

@section('content')
    <x-navbar />

    <section id="beranda" class="hero-section section-frame d-flex align-items-center">
        <div class="container section-space">
            <div class="row align-items-center gy-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <h1 class="school-title mb-4">SMP Negeri 1 Bataguh</h1>
                    <p class="hero-copy mb-4">
                        Membangun generasi yang berkarakter, adaptif, dan siap berkembang lewat pendidikan yang
                        berkualitas, lingkungan belajar yang hangat, dan budaya sekolah yang positif.
                    </p>
                    <div class="hero-actions justify-content-center justify-content-lg-start">
                        <a href="{{ route('biodata-peserta') }}" class="btn btn-cta">Pendaftaran</a>
                        <a href="#tentang" class="btn btn-ghost">Lihat Profil</a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="placeholder-box hero-image">
                        <i class="bi bi-image"></i>
                        <span class="placeholder-label">Hero Sekolah</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="about-section">
        <div class="container section-space">
            <div class="row align-items-center gy-5 gx-lg-5">
                <div class="col-lg-5">
                    <div class="placeholder-box about-image">
                        <i class="bi bi-image"></i>
                        <span class="placeholder-label">Profil Sekolah</span>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="content-card">
                        <span class="eyebrow mb-3">Tentang Kami</span>
                        <h2 class="school-subtitle mb-4">SMP Negeri 1 Bataguh</h2>
                        <p class="section-copy mb-0">
                            SMPN 1 Bataguh adalah institusi pendidikan menengah pertama yang berkomitmen untuk
                            menyelenggarakan pendidikan berkualitas di wilayah Bataguh. Kami berfokus pada
                            pembentukan karakter siswa yang berakhlak mulia, cerdas secara akademik, dan memiliki
                            keterampilan teknologi yang relevan dengan perkembangan zaman. Dengan dukungan tenaga
                            pendidik yang berdedikasi, kami berupaya mewujudkan lingkungan belajar yang kondusif demi
                            mencetak generasi penerus bangsa yang unggul.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="lainnya" class="vision-section section-frame">
        <div class="container section-space">
            <div class="text-center mb-5 pb-2 section-title-wrap">
                <h2 class="section-heading mb-0">Visi dan Misi<br>SMP Negeri 1 Bataguh</h2>
            </div>

            <div class="row justify-content-center g-4 g-lg-5">
                <div class="col-md-6 col-lg-4">
                    <div class="vision-card text-center">
                        <div class="vision-icon mx-auto">
                            <i class="bi bi-eye"></i>
                        </div>
                        <h3>Visi</h3>
                        <p>
                            Berfokus pada perwujudan profil pelajar Pancasila yang berakhlak mulia, berprestasi
                            (akademik/nonakademik), cerdas, mandiri, dan peduli lingkungan (Adiwiyata).
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="vision-card text-center">
                        <div class="vision-icon mx-auto">
                            <i class="bi bi-bullseye"></i>
                        </div>
                        <h3>Misi</h3>
                        <p>
                            Berfokus pada perwujudan profil pelajar Pancasila yang berakhlak mulia, berprestasi
                            (akademik/nonakademik), cerdas, mandiri, dan peduli lingkungan (Adiwiyata).
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="gallery-section">
        <div class="container section-space">
            <div class="text-center mb-5 section-title-wrap">
                <div class="gallery-title">Galeri Kami</div>
                <div class="gallery-dot"></div>
            </div>

            <div class="row justify-content-center g-4 g-lg-5">
                <div class="col-md-4 col-lg-3">
                    <div class="placeholder-box gallery-image">
                        <i class="bi bi-image"></i>
                        <span class="placeholder-label">Kegiatan Siswa</span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="placeholder-box gallery-image">
                        <i class="bi bi-image"></i>
                        <span class="placeholder-label">Aktivitas Belajar</span>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="placeholder-box gallery-image">
                        <i class="bi bi-image"></i>
                        <span class="placeholder-label">Lingkungan Sekolah</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
@endsection
