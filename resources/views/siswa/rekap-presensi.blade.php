@extends('layouts.app')

@section('title', 'Rekap Presensi - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Rekap Presensi</h1>
                    <p class="text-muted">Lihat rekap presensi Anda</p>
                </div>

                <div class="row g-4 mb-4">
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="fw-bold mb-0 text-success">{{ $rekap['hadir'] }}</h5>
                                <small class="text-muted">Hadir</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="fw-bold mb-0 text-info">{{ $rekap['izin'] }}</h5>
                                <small class="text-muted">Izin</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="fw-bold mb-0 text-warning">{{ $rekap['sakit'] }}</h5>
                                <small class="text-muted">Sakit</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body">
                                <h5 class="fw-bold mb-0 text-danger">{{ $rekap['alpha'] }}</h5>
                                <small class="text-muted">Alpha</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($presensis as $presensi)
                                        <tr>
                                            <td>{{ $presensi->tanggal }}</td>
                                            <td>
                                                <span class="badge bg-{{ $presensi->status == 'Hadir' ? 'success' : ($presensi->status == 'Izin' ? 'info' : ($presensi->status == 'Sakit' ? 'warning' : 'danger')) }}">
                                                    {{ $presensi->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">Tidak ada data presensi</td>
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
