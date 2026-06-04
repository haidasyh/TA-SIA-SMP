@extends('layouts.app')

@section('title', 'Tambah Tugas - Guru')

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
                            <h1 class="fw-bold">Tambah Tugas</h1>
                            <p class="text-muted">Tambahkan tugas baru</p>
                        </div>
                        <a href="{{ route('guru.daftar-tugas') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        @if($jadwals->isEmpty())
                            <div class="alert alert-info" role="alert">
                                Anda tidak memiliki jadwal mengajar. Silakan tambahkan jadwal terlebih dahulu di menu admin!
                            </div>
                        @else
                            <form method="POST" action="{{ route('guru.store-tugas') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Jadwal</label>
                                        <select name="jadwal_id" class="form-control @error('jadwal_id') is-invalid @enderror" required>
                                            <option value="">Pilih Jadwal</option>
                                            @foreach($jadwals as $j)
                                                <option value="{{ $j->id }}" {{ old('jadwal_id') == $j->id ? 'selected' : '' }}>
                                                    {{ $j->kelas->nama_kelas }} - {{ $j->mataPelajaran->nama_mapel }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('jadwal_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Judul Tugas</label>
                                        <input type="text" name="judul_tugas" class="form-control @error('judul_tugas') is-invalid @enderror" value="{{ old('judul_tugas') }}" required>
                                        @error('judul_tugas')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4">{{ old('deskripsi') }}</textarea>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Tanggal Diberikan</label>
                                        <input type="date" name="tanggal_diberikan" class="form-control @error('tanggal_diberikan') is-invalid @enderror" value="{{ old('tanggal_diberikan', date('Y-m-d')) }}" required>
                                        @error('tanggal_diberikan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Deadline (Opsional)</label>
                                        <input type="date" name="tanggal_deadline" class="form-control @error('tanggal_deadline') is-invalid @enderror" value="{{ old('tanggal_deadline') }}">
                                        @error('tanggal_deadline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i> Simpan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
