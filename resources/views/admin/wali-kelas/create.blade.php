@extends('layouts.app')

@section('title', 'Tambah Wali Kelas - Admin')

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
                            <h1 class="fw-bold">Tambah Wali Kelas</h1>
                            <p class="text-muted">Tambahkan wali kelas baru</p>
                        </div>
                        <a href="{{ route('admin.wali-kelas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.wali-kelas.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Semester</label>
                                    <select name="semester_id" class="form-control @error('semester_id') is-invalid @enderror" required>
                                        <option value="">Pilih Semester</option>
                                        @foreach($semester as $s)
                                            <option value="{{ $s->id }}" {{ old('semester_id', $currentSemester->id) == $s->id ? 'selected' : '' }}>{{ $s->tahun_ajaran }} - {{ $s->semester }}</option>
                                        @endforeach
                                    </select>
                                    @error('semester_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Guru</label>
                                    <select name="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach($gurus as $guru)
                                            <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                                {{ $guru->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('guru_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelas</label>
                                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                                {{ $k->nama_kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i> Simpan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
