@extends('layouts.app')

@section('title', 'Pengaturan Beranda & Status - Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Pengaturan Beranda</h1>
                    <p class="text-muted">Kelola konten landing page utama dan status pendaftaran PPDB</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-0 pt-4 px-4">
                                <h5 class="fw-bold mb-0">Status Pendaftaran PPDB</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('admin.beranda.update-status') }}" method="POST">
                                    @csrf
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="flex-grow-1">
                                            <p class="mb-0">Aktifkan atau nonaktifkan formulir pendaftaran calon siswa baru.</p>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="status" value="aktif" id="ppdbStatusSwitch" {{ $ppdbStatus === 'aktif' ? 'checked' : '' }} onchange="this.form.submit()">
                                            <label class="form-check-label fw-bold {{ $ppdbStatus === 'aktif' ? 'text-success' : 'text-danger' }}" for="ppdbStatusSwitch">
                                                {{ $ppdbStatus === 'aktif' ? 'Aktif' : 'Nonaktif' }}
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-0 pt-4 px-4">
                                <h5 class="fw-bold mb-0">Informasi Beranda</h5>
                            </div>
                            <div class="card-body p-4">
                                <form action="{{ route('admin.beranda.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Hero Title (Profil Singkat)</label>
                                            <textarea name="profil" class="form-control" rows="3">{{ old('profil', $beranda->profil) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Tentang Kami</label>
                                            <textarea name="tentang_kami" class="form-control" rows="3">{{ old('tentang_kami', $beranda->tentang_kami) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Visi</label>
                                            <textarea name="visi" class="form-control" rows="3">{{ old('visi', $beranda->visi) }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Misi</label>
                                            <textarea name="misi" class="form-control" rows="3">{{ old('misi', $beranda->misi) }}</textarea>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Hero Image</label>
                                            @if($beranda->hero_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $beranda->hero_image) }}" alt="Hero" class="img-thumbnail" style="height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="hero_image" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">About Image</label>
                                            @if($beranda->about_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $beranda->about_image) }}" alt="About" class="img-thumbnail" style="height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="about_image" class="form-control">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Gallery 1</label>
                                            @if($beranda->gallery_1)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $beranda->gallery_1) }}" alt="Gallery 1" class="img-thumbnail" style="height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="gallery_1" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Gallery 2</label>
                                            @if($beranda->gallery_2)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $beranda->gallery_2) }}" alt="Gallery 2" class="img-thumbnail" style="height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="gallery_2" class="form-control">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Gallery 3</label>
                                            @if($beranda->gallery_3)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $beranda->gallery_3) }}" alt="Gallery 3" class="img-thumbnail" style="height: 100px;">
                                                </div>
                                            @endif
                                            <input type="file" name="gallery_3" class="form-control">
                                        </div>

                                        <div class="col-12 text-end">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection