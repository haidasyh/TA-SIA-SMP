@extends('layouts.app')

@section('title', 'Detail Siswa - Admin')

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
                            <h1 class="fw-bold">Detail Siswa</h1>
                            <p class="text-muted">{{ $siswa->nama }}</p>
                        </div>
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-secondary">
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
                                    <label class="fw-semibold text-muted small">NIS</label>
                                    <p class="mb-0">{{ $siswa->nis }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">NISN</label>
                                    <p class="mb-0">{{ $siswa->nisn }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Nama Lengkap</label>
                                    <p class="mb-0">{{ $siswa->nama }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Jenis Kelamin</label>
                                    <p class="mb-0">{{ $siswa->jenis_kelamin }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Kelas</label>
                                    <p class="mb-0">{{ $siswa->kelas->nama_kelas }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Tahun Masuk</label>
                                    <p class="mb-0">{{ $siswa->tahun_masuk }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">No. HP Orang Tua</label>
                                    <p class="mb-0">{{ $siswa->no_hp_ortu ?? '-' }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Alamat</label>
                                    <p class="mb-0">{{ $siswa->alamat ?? '-' }}</p>
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
                                    <p class="mb-0">{{ $siswa->user->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
