@extends('layouts.app')

@section('title', 'Kelola Persyaratan PPDB - Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <div>
                        <h1 class="fw-bold">Kelola Persyaratan & Alur PPDB</h1>
                        <p class="text-muted">Isi isi teks menggunakan format HTML list `&lt;li&gt;Isi Syarat&lt;/li&gt;` agar tersusun dengan rapi.</p>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.persyaratan-ppdb.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">1. Persyaratan Umum</label>
                                <textarea name="umum" rows="6" class="form-control @error('umum') is-invalid @enderror" required>{{ old('umum', $persyaratan->umum) }}</textarea>
                                @error('umum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">2. Persyaratan Khusus</label>
                                <textarea name="khusus" rows="6" class="form-control @error('khusus') is-invalid @enderror" required>{{ old('khusus', $persyaratan->khusus) }}</textarea>
                                @error('khusus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-navy">3. Alur Pelaksanaan</label>
                                <textarea name="alur" rows="6" class="form-control @error('alur') is-invalid @enderror" required>{{ old('alur', $persyaratan->alur) }}</textarea>
                                @error('alur') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i> Simpan Seluruh Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection