@extends('layouts.app')

@section('title', 'Dashboard Siswa - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Siswa</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar-week fs-2 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Jadwal Pelajaran</h5>
                                        <small class="text-muted">Lihat jadwal pelajaran</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-clipboard-check fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Rekap Presensi</h5>
                                        <small class="text-muted">Lihat rekap presensi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-file-earmark-text fs-2 text-info"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Nilai</h5>
                                        <small class="text-muted">Lihat nilai setiap mata pelajaran</small>
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
