@extends('layouts.app')

@section('title', 'Detail Mata Pelajaran - Admin')

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
                            <h1 class="fw-bold">Detail Mata Pelajaran</h1>
                            <p class="text-muted">{{ $mataPelajaran->nama_mapel }}</p>
                        </div>
                        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Kode Mapel</label>
                            <p class="mb-0">{{ $mataPelajaran->kode_mapel }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Nama Mapel</label>
                            <p class="mb-0">{{ $mataPelajaran->nama_mapel }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">KKM</label>
                            <p class="mb-0">{{ $mataPelajaran->kkm }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Deskripsi</label>
                            <p class="mb-0">{{ $mataPelajaran->deskripsi ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
