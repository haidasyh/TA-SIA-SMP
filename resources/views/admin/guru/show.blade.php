@extends('layouts.app')

@section('title', 'Detail Guru - Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fw-bold">Detail Guru</h1>
                            <p class="text-muted">{{ $guru->nama }}</p>
                        </div>
                        <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light fw-bold">Data Diri</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">NIP</label>
                                    <p class="mb-0">{{ $guru->nip }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Nama Lengkap</label>
                                    <p class="mb-0">{{ $guru->nama }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Jenis Kelamin</label>
                                    <p class="mb-0">{{ $guru->jenis_kelamin }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">No. HP</label>
                                    <p class="mb-0">{{ $guru->no_hp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light fw-bold">Akun</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Username</label>
                                    <p class="mb-0">{{ $guru->user->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
