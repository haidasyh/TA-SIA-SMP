@extends('layouts.app')

@section('title', 'Dashboard Guru - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Guru</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar fs-2 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Jadwal Mengajar</h5>
                                        <small class="text-muted">Lihat jadwal mengajar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-people fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Daftar Siswa</h5>
                                        <small class="text-muted">Lihat daftar siswa diampu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-file-earmark-spreadsheet fs-2 text-info"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">Input Nilai</h5>
                                        <small class="text-muted">Masukkan dan edit nilai</small>
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
