@extends('layouts.app')

@section('title', 'Daftar Tugas - Guru')

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
                            <h1 class="fw-bold">Daftar Tugas</h1>
                            <p class="text-muted">Kelola tugas Anda</p>
                        </div>
                        <a href="{{ route('guru.create-tugas') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i> Tambah Tugas
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul Tugas</th>
                                        <th>Kelas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Tanggal Diberikan</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tugases as $tugas)
                                        <tr>
                                            <td>{{ $tugas->judul_tugas }}</td>
                                            <td>{{ $tugas->jadwal->kelas->nama_kelas }}</td>
                                            <td>{{ $tugas->jadwal->mataPelajaran->nama_mapel }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tugas->tanggal_diberikan)->format('d/m/Y') }}</td>
                                            <td>{{ $tugas->tanggal_deadline ? \Carbon\Carbon::parse($tugas->tanggal_deadline)->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                <span class="badge {{ $tugas->status == 'Aktif' ? 'bg-primary' : 'bg-success' }}">
                                                    {{ $tugas->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('guru.edit-tugas', $tugas->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('guru.destroy-tugas', $tugas->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-4">Belum ada tugas</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
