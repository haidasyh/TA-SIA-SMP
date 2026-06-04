@extends('layouts.app')

@section('title', 'Data Siswa - Admin')

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
                            <h1 class="fw-bold">Data Siswa</h1>
                            <p class="text-muted">Kelola data siswa</p>
                        </div>
                        <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-2"></i> Tambah
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="row g-3 align-items-center">
            
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama, NIS, atau NISN..." value="{{ request('search') }}">
                </div>
            </div>

            <div class="col-md-3">
                <select name="kelas_id" class="form-select">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($listKelas as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas_id') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }} </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-5 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-4">
                    Filter
                </button>
                @if(request('search') || request('kelas_id'))
                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif

                <div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-download"></i> Unduh Data
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.siswa.export', ['format' => 'excel', 'kelas_id' => request('kelas_id'), 'search' => request('search')]) }}">
                                <i class="far fa-file-excel text-success me-2"></i> Ekspor ke Excel (.xlsx)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.siswa.export', ['format' => 'pdf', 'kelas_id' => request('kelas_id'), 'search' => request('search')]) }}">
                                <i class="far fa-file-pdf text-danger me-2"></i> Ekspor ke PDF (.pdf)
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.siswa.export', ['format' => 'word', 'kelas_id' => request('kelas_id'), 'search' => request('search')]) }}">
                                <i class="far fa-file-word text-primary me-2"></i> Ekspor ke Word (.docx)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </form>
    </div>
</div>
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tahun Masuk</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswa as $s)
                                        <tr>
                                            <td>{{ $s->nis }}</td>
                                            <td>{{ $s->nama }}</td>
                                            <td>{{ $s->kelas->nama_kelas }}</td>
                                            <td>{{ $s->jenis_kelamin }}</td>
                                            <td>{{ $s->tahun_masuk }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.siswa.show', $s->id) }}" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.siswa.edit', $s->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.siswa.destroy', $s->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
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
                                            <td colspan="6" class="text-center text-muted py-4">Belum ada data siswa</td>
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
