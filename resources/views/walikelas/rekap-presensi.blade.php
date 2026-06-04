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
                    <p class="text-muted">Lihat rekap presensi siswa</p>
                </div>

                @if(!$waliKelas)
                    <div class="alert alert-warning">Anda belum ditetapkan sebagai wali kelas. Silakan hubungi admin untuk menetapkan Anda sebagai wali kelas!</div>
                @else
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>Nama</th>
                                            <th>Hadir</th>
                                            <th>Izin</th>
                                            <th>Sakit</th>
                                            <th>Alpha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($rekapPresensi as $item)
                                            <tr>
                                                <td>{{ $item['siswa']->nis }}</td>
                                                <td>{{ $item['siswa']->nama }}</td>
                                                <td>{{ $item['hadir'] }}</td>
                                                <td>{{ $item['izin'] }}</td>
                                                <td>{{ $item['sakit'] }}</td>
                                                <td>{{ $item['alpha'] }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">Tidak ada data presensi</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
