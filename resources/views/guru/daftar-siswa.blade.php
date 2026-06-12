@extends('layouts.app')

@section('title', 'Daftar Siswa - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Daftar Siswa</h1>
                    <p class="text-muted">Lihat daftar siswa di kelas yang Anda ampu</p>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('guru.daftar-siswa') }}" class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label">Pilih Kelas</label>
                                <select name="kelas_id" class="form-control" onchange="this.form.submit()" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach($kelas as $k)
                                        <option value="{{ $k->id }}" {{ $selectedKelas && $selectedKelas->id == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                @if($selectedKelas)
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="fw-bold mb-4">Daftar Siswa {{ $selectedKelas->nama_kelas }}</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIS</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th>Kelas</th>
                                            <th>Jenis Kelamin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($siswas as $siswa)
                                            <tr>
                                                <td>{{ $siswa->nis }}</td>
                                                <td>{{ $siswa->nisn }}</td>
                                                <td>{{ $siswa->nama }}</td>
                                                <td>{{ $siswa->kelas->nama_kelas }}</td>
                                                <td>{{ $siswa->jenis_kelamin }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">Tidak ada siswa di kelas ini</td>
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
