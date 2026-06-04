@extends('layouts.app')

@section('title', 'Dashboard Siswa - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Siswa</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-book fs-2 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalMapel }}</h5>
                                        <small class="text-muted">Mata Pelajaran</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar-week fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalJadwal }}</h5>
                                        <small class="text-muted">Jadwal Pelajaran</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-file-earmark-text fs-2 text-info"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalTugas }}</h5>
                                        <small class="text-muted">Total Tugas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-clock-history fs-2 text-warning"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $tugasAktif }}</h5>
                                        <small class="text-muted">Tugas Aktif</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Statistik Presensi Pribadi</h5>
                                <canvas id="presensiSiswaChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Quick Links</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('siswa.jadwal-pelajaran') }}" class="btn btn-primary text-start">
                                        <i class="bi bi-calendar-week me-2"></i> Lihat Jadwal Pelajaran
                                    </a>
                                    <a href="{{ route('siswa.rekap-presensi') }}" class="btn btn-success text-start">
                                        <i class="bi bi-clipboard-check me-2"></i> Rekap Presensi
                                    </a>
                                    <a href="{{ route('siswa.nilai') }}" class="btn btn-info text-start">
                                        <i class="bi bi-file-earmark-text me-2"></i> Lihat Nilai
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const presensiSiswaCtx = document.getElementById('presensiSiswaChart').getContext('2d');
    new Chart(presensiSiswaCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                label: 'Jumlah',
                data: [
                    {{ $presensiStats['Hadir'] }},
                    {{ $presensiStats['Izin'] }},
                    {{ $presensiStats['Sakit'] }},
                    {{ $presensiStats['Alpha'] }}
                ],
                backgroundColor: [
                    'rgba(120, 160, 131, 0.8)',
                    'rgba(80, 114, 123, 0.8)',
                    'rgba(254, 229, 153, 0.8)',
                    'rgba(220, 76, 100, 0.8)'
                ],
                borderColor: [
                    'rgba(120, 160, 131, 1)',
                    'rgba(80, 114, 123, 1)',
                    'rgba(254, 229, 153, 1)',
                    'rgba(220, 76, 100, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
});
</script>
@endpush
