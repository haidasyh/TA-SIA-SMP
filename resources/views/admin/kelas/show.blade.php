@extends('layouts.app')

@section('title', 'Detail Kelas - Admin')

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
                            <h1 class="fw-bold">Detail Kelas</h1>
                            <p class="text-muted">{{ $kelas->nama_kelas }}</p>
                        </div>
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light fw-bold">Data Kelas</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Nama Kelas</label>
                                    <p class="mb-0">{{ $kelas->nama_kelas }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Tingkat</label>
                                    <p class="mb-0">{{ $kelas->tingkat }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Jumlah Siswa</label>
                                    <p class="mb-0">{{ $kelas->siswa->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light fw-bold">Daftar Siswa</div>
                            <div class="card-body">
                                @if($kelas->siswa->count() > 0)
                                    <ul class="list-group list-group-flush">
                                        @foreach($kelas->siswa as $s)
                                            <li class="list-group-item">
                                                {{ $s->nama }} ({{ $s->nis }})
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted">Belum ada siswa di kelas ini</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
