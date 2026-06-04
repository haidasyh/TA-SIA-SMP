@extends('layouts.app')

@section('title', 'Edit Jadwal PPDB - Admin')

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
                            <h1 class="fw-bold">Edit Jadwal PPDB</h1>
                            <p class="text-muted">Perbarui data agenda pelaksanaan</p>
                        </div>
                        <a href="{{ route('admin.jadwal-ppdb.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.jadwal-ppdb.update', $jadwal->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Kegiatan</label>
                                    <input type="text" name="kegiatan" class="form-control @error('kegiatan') is-invalid @enderror" value="{{ old('kegiatan', $jadwal->kegiatan) }}" required>
                                    @error('kegiatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tanggal Pelaksanaan</label>
                                    <input type="date" name="tanggal" class="form-control @error('tanggal') is-invalid @enderror" value="{{ old('tanggal') }}" required>
                                    @error('tanggal') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Waktu</label>
                                    <input type="text" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu', $jadwal->waktu) }}" required>
                                    @error('waktu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $jadwal->lokasi) }}" required>
                                    @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i> Perbarui Jadwal
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection