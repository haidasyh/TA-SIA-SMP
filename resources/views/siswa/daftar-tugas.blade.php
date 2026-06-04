@extends('layouts.app')

@section('title', 'Daftar Tugas - Siswa')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Daftar Tugas</h1>
                    <p class="text-muted">Lihat tugas Anda</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Judul Tugas</th>
                                        <th>Mata Pelajaran</th>
                                        <th>Guru</th>
                                        <th>Tanggal Diberikan</th>
                                        <th>Deadline</th>
                                        <th>Status</th>
                                        <th>Deskripsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tugases as $tugas)
                                        <tr>
                                            <td>{{ $tugas->judul_tugas }}</td>
                                            <td>{{ $tugas->jadwal->mataPelajaran->nama_mapel }}</td>
                                            <td>{{ $tugas->jadwal->guru->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($tugas->tanggal_diberikan)->format('d/m/Y') }}</td>
                                            <td>{{ $tugas->tanggal_deadline ? \Carbon\Carbon::parse($tugas->tanggal_deadline)->format('d/m/Y') : '-' }}</td>
                                            <td>
                                                <span class="badge {{ $tugas->status == 'Aktif' ? 'bg-primary' : 'bg-success' }}">
                                                    {{ $tugas->status }}
                                                </span>
                                            </td>
                                            <td>{{ $tugas->deskripsi ?? '-' }}</td>
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
