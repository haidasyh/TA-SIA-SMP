@extends('layouts.app')

@section('title', 'Data Mata Pelajaran - Admin')

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
                            <h1 class="fw-bold">Data Mata Pelajaran</h1>
                            <p class="text-muted">Kelola data mata pelajaran</p>
                        </div>
                        <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-primary">
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

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Kode Mapel</th>
                                        <th>Nama Mapel</th>
                                        <th>KKM</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($mataPelajaran as $mp)
                                        <tr>
                                            <td>{{ $mp->kode_mapel }}</td>
                                            <td>{{ $mp->nama_mapel }}</td>
                                            <td>{{ $mp->kkm }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('admin.mata-pelajaran.show', $mp->id) }}" class="btn btn-sm btn-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.mata-pelajaran.edit', $mp->id) }}" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form method="POST" action="{{ route('admin.mata-pelajaran.destroy', $mp->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
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
                                            <td colspan="4" class="text-center text-muted py-4">Belum ada data mata pelajaran</td>
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
