@extends('layouts.app')

@section('title', 'Detail Jadwal - Admin')

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
                            <h1 class="fw-bold">Detail Jadwal</h1>
                            <p class="text-muted">{{ $jadwal->kelas->nama_kelas }} - {{ $jadwal->mataPelajaran->nama_mapel }}</p>
                        </div>
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold text-muted small">Semester</label>
                                <p class="mb-0">{{ $jadwal->semester->kode_semester }} - {{ $jadwal->semester->tahun_ajaran }} ({{ $jadwal->semester->semester }})</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold text-muted small">Kelas</label>
                                <p class="mb-0">{{ $jadwal->kelas->nama_kelas }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold text-muted small">Mata Pelajaran</label>
                                <p class="mb-0">{{ $jadwal->mataPelajaran->nama_mapel }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold text-muted small">Guru</label>
                                <p class="mb-0">{{ $jadwal->guru->nama }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold text-muted small">Hari</label>
                                <p class="mb-0">{{ $jadwal->hari }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-semibold text-muted small">Jam</label>
                                <p class="mb-0">{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
