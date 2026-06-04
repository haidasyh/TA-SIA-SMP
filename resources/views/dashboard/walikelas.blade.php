@extends('layouts.app')

@section('title', 'Dashboard Wali Kelas - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Wali Kelas</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-people fs-2 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalSiswa }}</h5>
                                        <small class="text-muted">Total Siswa</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar-check fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ array_sum($presensiStats) }}</h5>
                                        <small class="text-muted">Total Presensi</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-star fs-2 text-warning"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ number_format($nilaiStats['rata-rata'], 2) }}</h5>
                                        <small class="text-muted">Rata-rata Nilai</small>
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
                                <h5 class="fw-bold mb-4">Statistik Presensi</h5>
                                <canvas id="presensiChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Quick Links</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('walikelas.presensi-siswa') }}" class="btn btn-primary text-start">
                                        <i class="bi bi-calendar-check me-2"></i> Input Presensi Siswa
                                    </a>
                                    <a href="{{ route('walikelas.rekap-presensi') }}" class="btn btn-success text-start">
                                        <i class="bi bi-clipboard-data me-2"></i> Rekap Presensi
                                    </a>
                                    <a href="{{ route('walikelas.rekap-nilai') }}" class="btn btn-info text-start">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Rekap Nilai
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
    const presensiCtx = document.getElementById('presensiChart').getContext('2d');
    new Chart(presensiCtx, {
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
