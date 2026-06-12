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
                        {{ $beranda->profil ?? 'Membangun generasi yang berkarakter, adaptif, dan siap berkembang lewat pendidikan yang berkualitas, lingkungan belajar yang hangat, dan budaya sekolah yang positif.' }}
                    </p>
                    <div class="hero-actions justify-content-center justify-content-lg-start">
                        <a href="{{ route('biodata-peserta') }}" class="btn btn-cta">Pendaftaran</a>
                        <a href="#tentang" class="btn btn-ghost">Lihat Profil</a>
                    </div>
                </div>
                <div class="col-lg-7">
                    @if($beranda->hero_image)
                        <img src="{{ asset('storage/' . $beranda->hero_image) }}" alt="Hero" class="hero-image shadow-lg">
                    @else
                        <div class="placeholder-box hero-image">
                            <i class="bi bi-image"></i>
                            <span class="placeholder-label">Hero Sekolah</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="about-section">
        <div class="container section-space">
            <div class="row align-items-center gy-5 gx-lg-5">
                <div class="col-lg-5">
                    @if($beranda->about_image)
                        <img src="{{ asset('storage/' . $beranda->about_image) }}" alt="Tentang Kami" class="about-image shadow-lg">
                    @else
                        <div class="placeholder-box about-image">
                            <i class="bi bi-image"></i>
                            <span class="placeholder-label">Profil Sekolah</span>
                        </div>
                    @endif
                </div>
                <div class="col-lg-7">
                    <div class="content-card">
                        <span class="eyebrow mb-3">Tentang Kami</span>
                        <h2 class="school-subtitle mb-4">SMP Negeri 1 Bataguh</h2>
                        <p class="section-copy mb-0">
                            {{ $beranda->tentang_kami ?? 'SMPN 1 Bataguh adalah institusi pendidikan menengah pertama yang berkomitmen untuk menyelenggarakan pendidikan berkualitas di wilayah Bataguh. Kami berfokus pada pembentukan karakter siswa yang berakhlak mulia, cerdas secara akademik, dan memiliki keterampilan teknologi yang relevan dengan perkembangan zaman. Dengan dukungan tenaga pendidik yang berdedikasi, kami berupaya mewujudkan lingkungan belajar yang kondusif demi mencetak generasi penerus bangsa yang unggul.' }}
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
                            {{ $beranda->visi ?? 'Berfokus pada perwujudan profil pelajar Pancasila yang berakhlak mulia, berprestasi (akademik/nonakademik), cerdas, mandiri, dan peduli lingkungan (Adiwiyata).' }}
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
                            {{ $beranda->misi ?? 'Berfokus pada perwujudan profil pelajar Pancasila yang berakhlak mulia, berprestasi (akademik/nonakademik), cerdas, mandiri, dan peduli lingkungan (Adiwiyata).' }}
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
                    @if($beranda->gallery_1)
                        <img src="{{ asset('storage/' . $beranda->gallery_1) }}" alt="Galeri 1" class="gallery-image shadow-sm">
                    @else
                        <div class="placeholder-box gallery-image">
                            <i class="bi bi-image"></i>
                            <span class="placeholder-label">Kegiatan Siswa</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-4 col-lg-3">
                    @if($beranda->gallery_2)
                        <img src="{{ asset('storage/' . $beranda->gallery_2) }}" alt="Galeri 2" class="gallery-image shadow-sm">
                    @else
                        <div class="placeholder-box gallery-image">
                            <i class="bi bi-image"></i>
                            <span class="placeholder-label">Aktivitas Belajar</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-4 col-lg-3">
                    @if($beranda->gallery_3)
                        <img src="{{ asset('storage/' . $beranda->gallery_3) }}" alt="Galeri 3" class="gallery-image shadow-sm">
                    @else
                        <div class="placeholder-box gallery-image">
                            <i class="bi bi-image"></i>
                            <span class="placeholder-label">Lingkungan Sekolah</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section class="map-section pb-5">
        <div class="container">
            <div class="map-wrapper shadow-sm rounded overflow-hidden" style="border: 1px solid #e3e6f0;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.721447012695!2d114.4379468!3d-3.4173873!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de41231ceb54ff5%3A0x7544e833a005af42!2sSMP%201%20BATAGUH!5e0!3m2!1sid!2sid!4v1710000000000!5m2!1sid!2sid" 
                    width="100%" 
                    height="400" 
                    style="border:0; display:block;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>   

    <x-footer />
@endsection
