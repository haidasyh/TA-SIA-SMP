@extends('layouts.app')

@section('title', 'Jadwal Pelaksanaan PPDB - Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Jadwal Pelaksanaan PPDB</h1>
                    <p class="text-muted">Kelola lini masa seluruh rangkaian kegiatan pendaftaran</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">List Jadwal Kegiatan</h5>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addJadwalModal">
                            <i class="bi bi-plus-lg"></i> Tambah Jadwal
                        </button>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>Kegiatan</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>Lokasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($jadwal as $j)
                                        <tr>
                                            <td class="fw-semibold">{{ $j->kegiatan }}</td>
                                            <td>{{ $j->tanggal_mulai }} {{ $j->tanggal_akhir ? ' s/d ' . $j->tanggal_akhir : '' }}</td>
                                            <td>{{ $j->waktu }}</td>
                                            <td>{{ $j->lokasi }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#editJadwalModal{{ $j->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('admin.jadwal-ppdb.destroy', $j->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="editJadwalModal{{ $j->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form action="{{ route('admin.jadwal-ppdb.update', $j->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Jadwal</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kegiatan</label>
                                                                <input type="text" name="kegiatan" class="form-control" value="{{ $j->kegiatan }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Mulai</label>
                                                                <input type="date" name="tanggal_mulai" class="form-control" value="{{ $j->tanggal_mulai }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Berakhir (Opsional)</label>
                                                                <input type="date" name="tanggal_akhir" class="form-control" value="{{ $j->tanggal_akhir }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Waktu</label>
                                                                <input type="text" name="waktu" class="form-control" value="{{ $j->waktu }}" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Lokasi</label>
                                                                <input type="text" name="lokasi" class="form-control" value="{{ $j->lokasi }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">Belum ada jadwal yang diumumkan.</td>
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

    <div class="modal fade" id="addJadwalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.jadwal-ppdb.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Jadwal Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Kegiatan</label>
                            <input type="text" name="kegiatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Berakhir (Opsional)</label>
                            <input type="date" name="tanggal_akhir" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Waktu</label>
                            <input type="text" name="waktu" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection