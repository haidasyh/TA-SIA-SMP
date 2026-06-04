@extends('layouts.app')

@section('title', 'Dashboard Guru - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Dashboard Guru</h1>
                    <p class="text-muted">Selamat datang, {{ Auth::user()->nama }}!</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-calendar fs-2 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalJadwal }}</h5>
                                        <small class="text-muted">Jadwal Mengajar</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-door-open fs-2 text-success"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalKelas }}</h5>
                                        <small class="text-muted">Jumlah Kelas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="bi bi-book fs-2 text-info"></i>
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
                                    <i class="bi bi-file-earmark-text fs-2 text-warning"></i>
                                    <div>
                                        <h5 class="fw-bold mb-0">{{ $totalTugas }}</h5>
                                        <small class="text-muted">Total Tugas</small>
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
                                <h5 class="fw-bold mb-4">Jadwal per Hari</h5>
                                <canvas id="jadwalPerHariChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">Quick Links</h5>
                                <div class="d-grid gap-2">
                                    <a href="{{ route('guru.jadwal-mengajar') }}" class="btn btn-primary text-start">
                                        <i class="bi bi-calendar me-2"></i> Lihat Jadwal Mengajar
                                    </a>
                                    <a href="{{ route('guru.daftar-siswa') }}" class="btn btn-success text-start">
                                        <i class="bi bi-people me-2"></i> Daftar Siswa
                                    </a>
                                    <a href="{{ route('guru.input-nilai') }}" class="btn btn-info text-start">
                                        <i class="bi bi-file-earmark-spreadsheet me-2"></i> Input Nilai
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
    const jadwalPerHariCtx = document.getElementById('jadwalPerHariChart').getContext('2d');
    new Chart(jadwalPerHariCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($hariList) !!},
            datasets: [{
                label: 'Jumlah Jadwal',
                data: {!! json_encode($dataJadwalPerHari) !!},
                backgroundColor: 'rgba(120, 160, 131, 0.7)',
                borderColor: 'rgba(120, 160, 131, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endpush
