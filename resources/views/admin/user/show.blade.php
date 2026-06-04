@extends('layouts.app')

@section('title', 'Detail User - Admin')

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
                            <h1 class="fw-bold">Detail User</h1>
                            <p class="text-muted">{{ $user->nama }}</p>
                        </div>
                        <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Nama</label>
                            <p class="mb-0">{{ $user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Username</label>
                            <p class="mb-0">{{ $user->username }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Email</label>
                            <p class="mb-0">{{ $user->email ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="fw-semibold text-muted small">Role</label>
                            <div>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info me-1">{{ $role->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
