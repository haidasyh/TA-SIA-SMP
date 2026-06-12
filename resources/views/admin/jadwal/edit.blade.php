@extends('layouts.app')

@section('title', 'Edit Jadwal - Admin')

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
                            <h1 class="fw-bold">Edit Jadwal</h1>
                            <p class="text-muted">Edit data jadwal</p>
                        </div>
                        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.jadwal.update', $jadwal->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Semester</label>
                                    <select name="semester_id" class="form-control @error('semester_id') is-invalid @enderror" required>
                                        <option value="">Pilih Semester</option>
                                        @foreach($semester as $s)
                                            <option value="{{ $s->id }}" {{ old('semester_id', $jadwal->semester_id) == $s->id ? 'selected' : '' }}>{{ $s->tahun_ajaran }} - {{ $s->semester }}</option>
                                        @endforeach
                                    </select>
                                    @error('semester_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelas</label>
                                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror" required>
                                        <option value="">Pilih Kelas</option>
                                        @foreach($kelas as $k)
                                            <option value="{{ $k->id }}" {{ old('kelas_id', $jadwal->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mata Pelajaran</label>
                                    <select name="mapel_id" class="form-control @error('mapel_id') is-invalid @enderror" required>
                                        <option value="">Pilih Mata Pelajaran</option>
                                        @foreach($mataPelajaran as $mp)
                                            <option value="{{ $mp->id }}" {{ old('mapel_id', $jadwal->mapel_id) == $mp->id ? 'selected' : '' }}>{{ $mp->nama_mapel }}</option>
                                        @endforeach
                                    </select>
                                    @error('mapel_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Guru</label>
                                    <select name="guru_id" class="form-control @error('guru_id') is-invalid @enderror" required>
                                        <option value="">Pilih Guru</option>
                                        @foreach($guru as $g)
                                            <option value="{{ $g->id }}" {{ old('guru_id', $jadwal->guru_id) == $g->id ? 'selected' : '' }}>{{ $g->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('guru_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hari</label>
                                    <select name="hari" class="form-control @error('hari') is-invalid @enderror" required>
                                        <option value="">Pilih Hari</option>
                                        <option value="Senin" {{ old('hari', $jadwal->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                        <option value="Selasa" {{ old('hari', $jadwal->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                        <option value="Rabu" {{ old('hari', $jadwal->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                        <option value="Kamis" {{ old('hari', $jadwal->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                        <option value="Jumat" {{ old('hari', $jadwal->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                        <option value="Sabtu" {{ old('hari', $jadwal->hari) == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                                    </select>
                                    @error('hari')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Mulai</label>
                                    <input type="time" name="jam_mulai" class="form-control @error('jam_mulai') is-invalid @enderror" value="{{ old('jam_mulai', $jadwal->jam_mulai) }}" required>
                                    @error('jam_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Jam Selesai</label>
                                    <input type="time" name="jam_selesai" class="form-control @error('jam_selesai') is-invalid @enderror" value="{{ old('jam_selesai', $jadwal->jam_selesai) }}" required>
                                    @error('jam_selesai')
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
