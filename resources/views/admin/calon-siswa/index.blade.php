@extends('layouts.app')

@section('title', 'Data Calon Siswa - Admin')

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
                            <h1 class="fw-bold">Data Calon Siswa</h1>
                            <p class="text-muted">Kelola data calon siswa baru</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.calon-siswa.export') }}" class="btn btn-success">
                                <i class="bi bi-download me-2"></i> Unduh Rekap
                            </a>
                            <a href="{{ route('admin.calon-siswa.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-lg me-2"></i> Tambah
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('admin.calon-siswa.index') }}" method="GET" class="row g-2 align-items-center">
                            
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Cari Nama / NISN / No. Pendaftaran..." 
                                       value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="">-- Semua Jenis Kelamin --</option>
                                    <option value="Laki-laki" {{ request('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ request('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">-- Semua Status --</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div class="col-md-2 d-flex gap-1">
                                <button type="submit" class="btn btn-primary flex-grow-1">Cari</button>
                                @if(request()->anyFilled(['search', 'jenis_kelamin', 'status']))
                                    <a href="{{ route('admin.calon-siswa.index') }}" class="btn btn-secondary">Reset</a>
                                @endif
                            </div>

                        </form>
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
                                                    <a href="{{ route('admin.calon-siswa.edit', $cs->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
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
                                                    <form method="POST" action="{{ route('admin.calon-siswa.destroy', $cs->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus calon siswa ini?')">
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
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada calon siswa yang mendaftar</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            {{ $calonSiswa->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection