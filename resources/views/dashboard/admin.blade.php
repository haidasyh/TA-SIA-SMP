@extends('layouts.app')

@section('title', 'Dashboard Administrator - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <style>
            #siswaPerKelasChart, #calonSiswaStatusChart {
                max-height: 300px;
            }
        </style>
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Administrator</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-person-badge fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalGuru }}</h5>
                                        <small class="text-muted">Total Guru</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.calon-siswa.index') }}" class="text-decoration-none text-dark">
                            <div class="card shadow-sm border-0">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <i class="bi bi-person-plus fs-2 text-warning"></i>
                                        <div>
                                            <h5 class="fw-bold mb-0">{{ $totalCalonSiswa }}</h5>
                                            <small class="text-muted">Calon Siswa</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-building fs-2 text-info"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalKelas }}</h5>
                                        <small class="text-muted">Total Kelas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Siswa per Kelas</h5>
                                <canvas id="siswaPerKelasChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Status Calon Siswa</h5>
                                <canvas id="calonSiswaStatusChart"></canvas>
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
        console.log('Labels Kelas:', @json($labelsKelas));
        console.log('Data Siswa Per Kelas:', @json($dataSiswaPerKelas));
        console.log('Calon Siswa Status:', @json($calonSiswaStatus));

        const ctx1 = document.getElementById('siswaPerKelasChart');
        if (ctx1) {
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: @json($labelsKelas),
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: @json($dataSiswaPerKelas),
                        backgroundColor: 'rgba(120, 160, 131, 0.7)',
                        borderColor: 'rgba(120, 160, 131, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        const ctx2 = document.getElementById('calonSiswaStatusChart');
        if (ctx2) {
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: @json($calonSiswaStatus->keys()),
                    datasets: [{
                        data: @json($calonSiswaStatus->values()),
                        backgroundColor: [
                            'rgba(120, 160, 131, 0.7)',
                            'rgba(80, 114, 123, 0.7)',
                            'rgba(255, 193, 7, 0.7)'
                        ],
                        borderColor: [
                            'rgba(120, 160, 131, 1)',
                            'rgba(80, 114, 123, 1)',
                            'rgba(255, 193, 7, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true
                }
            });
        }
    });
</script>
@endpush
