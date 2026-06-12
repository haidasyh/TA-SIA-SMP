@extends('layouts.app')

@section('title', 'Pendaftaran Belum Dibuka - SMP Negeri 1 Bataguh')

@section('content')
    <x-navbar />

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="text-center p-5 shadow-sm rounded-4 bg-white border">
            <div class="mb-4">
                <i class="bi bi-info-circle text-warning" style="font-size: 4rem;"></i>
            </div>
            <h2 class="fw-bold mb-3">Mohon Maaf</h2>
            <p class="text-muted fs-5 mb-4">Pendaftaran belum dibuka atau sudah ditutup.</p>
            <a href="{{ url('/') }}" class="btn btn-primary px-4">Kembali ke Beranda</a>
        </div>
    </div>

    <x-footer />
@endsection
