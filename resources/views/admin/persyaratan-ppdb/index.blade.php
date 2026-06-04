@extends('layouts.app')

@section('title', 'Data Persyaratan PPDB - Admin')

@section('content')
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-lg-2">
                <x-sidebar />
            </div>
            <div class="col-lg-10 dashboard-content">
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="fw-bold">Persyaratan & Alur PPDB</h1>
                            <p class="text-muted">Preview data syarat pendaftaran yang tampil di halaman depan publik</p>
                        </div>
                        <a href="{{ route('admin.persyaratan-ppdb.edit') }}" class="btn btn-warning fw-semibold text-dark">
                            <i class="bi bi-pencil-square me-2"></i> Edit Data
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pt-3 pb-0">
                                <h5 class="fw-bold text-primary"><i class="bi bi-clipboard-check me-2"></i> 1. Persyaratan Umum</h5>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-light rounded-3" style="line-height: 1.8;">
                                    @if(trim($persyaratan->umum))
                                        <ol class="mb-0 ps-3">
                                            {!! $persyaratan->umum !!}
                                        </ol>
                                    @else
                                        <span class="text-muted italic">Belum ada data persyaratan umum.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-white border-0 pt-3 pb-0">
                                <h5 class="fw-bold text-primary"><i class="bi bi-clipboard-plus me-2"></i> 2. Persyaratan Khusus</h5>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-light rounded-3" style="line-height: 1.8;">
                                    @if(trim($persyaratan->khusus))
                                        <ol class="mb-0 ps-3">
                                            {!! $persyaratan->khusus !!}
                                        </ol>
                                    @else
                                        <span class="text-muted italic">Belum ada data persyaratan khusus.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-white border-0 pt-3 pb-0">
                                <h5 class="fw-bold text-success"><i class="bi bi-list-stars me-2"></i> 3. Alur Pelaksanaan</h5>
                            </div>
                            <div class="card-body">
                                <div class="p-3 bg-light rounded-3" style="line-height: 1.8;">
                                    @if(trim($persyaratan->alur))
                                        <ol class="mb-0 ps-3">
                                            {!! $persyaratan->alur !!}
                                        </ol>
                                    @else
                                        <span class="text-muted italic">Belum ada data alur pelaksanaan.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection