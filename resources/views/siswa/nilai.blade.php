@extends('layouts.app')

@section('title', 'Nilai - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Nilai</h1>
                    <p class="text-muted">Lihat nilai Anda pada setiap mata pelajaran</p>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mata Pelajaran</th>
                                        <th>Kategori</th>
                                        <th>Nilai</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($nilais as $nilai)
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
                </div>
            </div>
        </div>
    </div>
@endsection
