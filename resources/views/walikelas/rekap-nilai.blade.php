@extends('layouts.app')

@section('title', 'Rekap Nilai - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Rekap Nilai</h1>
                    <p class="text-muted">Lihat rekap nilai siswa</p>
                </div>

                @if(!$waliKelas)
                    <div class="alert alert-warning">Anda belum ditetapkan sebagai wali kelas. Silakan hubungi admin untuk menetapkan Anda sebagai wali kelas!</div>
                @else
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            @forelse($rekapNilai as $item)
                                <div class="mb-4">
                                    <h5 class="fw-bold">{{ $item['siswa']->nama }} ({{ $item['siswa']->nis }})</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Mata Pelajaran</th>
                                                    <th>Kategori</th>
                                                    <th>Nilai</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($item['nilais'] as $nilai)
                                                    <tr>
                                                        <td>{{ $nilai->mataPelajaran->nama_mapel }}</td>
                                                        <td>{{ $nilai->kategori->nama_kategori }}</td>
                                                        <td>{{ $nilai->skor_nilai }}</td>
                                                        <td>{{ $nilai->keterangan }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">Tidak ada nilai</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted">Tidak ada data nilai</div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
