@extends('layouts.app')

@section('title', 'Presensi Siswa - SMP Negeri 1 Bataguh')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <h1 class="fw-bold">Presensi Siswa</h1>
                    <p class="text-muted">Input presensi siswa</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(!$waliKelas)
                    <div class="alert alert-warning">Anda belum ditetapkan sebagai wali kelas. Silakan hubungi admin untuk menetapkan Anda sebagai wali kelas!</div>
                @else
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <form method="POST" action="{{ route('walikelas.store-presensi') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Siswa</label>
                                        <select name="siswa_id" class="form-select" required>
                                            <option value="">Pilih Siswa</option>
                                            @foreach($siswas as $siswa)
                                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tanggal</label>
                                        <input type="date" name="tanggal" class="form-control" required value="{{ date('Y-m-d') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select" required>
                                            <option value="">Pilih Status</option>
                                            <option value="Hadir">Hadir</option>
                                            <option value="Izin">Izin</option>
                                            <option value="Sakit">Sakit</option>
                                            <option value="Alpha">Alpha</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Simpan Presensi</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
