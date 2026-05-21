@extends('layouts.app')

@section('title', 'Dashboard Administrator - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Administrator</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-3">
                        <a href="{{ route('admin.calon-siswa.index') }}" class="text-decoration-none text-dark">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-person-plus fs-2 text-warning"></i>
                                        <div>
                                            <h5 class="fw-bold mb-0">Verifikasi Pendaftar</h5>
                                            <small class="text-muted">Kelola verifikasi calon siswa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-people fs-2 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Data Siswa</h5>
                                        <small class="text-muted">Kelola data siswa</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-person-badge fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Data Guru</h5>
                                        <small class="text-muted">Kelola data guru</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-book fs-2 text-info"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Mata Pelajaran</h5>
                                        <small class="text-muted">Kelola mata pelajaran</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
