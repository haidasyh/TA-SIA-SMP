@extends('layouts.app')

@section('title', 'Verifikasi Pendaftar - Admin')

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
                            <h1 class="fw-bold">Verifikasi Pendaftar</h1>
                            <p class="text-muted">Kelola verifikasi calon siswa baru</p>
                        </div>
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
                                        <th>No. Pendaftaran</th>
                                        <th>Nama</th>
                                        <th>NISN</th>
                                        <th>Asal Sekolah</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($calonSiswa as $cs)
                                        <tr>
                                            <td>{{ $cs->no_pendaftaran }}</td>
                                            <td>{{ $cs->nama }}</td>
                                            <td>{{ $cs->nisn }}</td>
                                            <td>{{ $cs->asal_sekolah }}</td>
                                            <td>
                                                @if($cs->status_verifikasi == 'Pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($cs->status_verifikasi == 'Diterima')
                                                    <span class="badge bg-success">Diterima</span>
                                                @else
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.calon-siswa.show', $cs->id) }}" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    @if($cs->status_verifikasi == 'Pending')
                                                        <form method="POST" action="{{ route('admin.calon-siswa.verifikasi', $cs->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin menerima calon siswa ini?')">
                                                                <i class="bi bi-check-lg"></i>
                                                            </button>
                                                        </form>
                                                        <form method="POST" action="{{ route('admin.calon-siswa.tolak', $cs->id) }}" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menolak calon siswa ini?')">
                                                                <i class="bi bi-x-lg"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada calon siswa yang mendaftar</td>
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
