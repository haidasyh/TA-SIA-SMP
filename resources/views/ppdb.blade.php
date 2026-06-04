@extends('layouts.app')

@section('title', 'Persyaratan Pendaftaran - SMP Negeri 1 Bataguh')

@push('styles')
    <style>
        .persyaratan-page {
            padding: 3rem 0 4rem;
        }

        .persyaratan-shell {
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(80, 114, 123, 0.12);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-soft);
            padding: 2rem;
        }

        .persyaratan-heading {
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.35rem;
        }

        .persyaratan-copy {
            color: var(--muted);
            margin-bottom: 1.75rem;
        }

        .table-persyaratan {
            background: #fff;
            border: 1px solid rgba(52, 73, 85, 0.1);
            border-radius: 1rem;
            overflow: hidden;
        }

        .table-persyaratan thead th {
            border-bottom: 1px solid rgba(52, 73, 85, 0.12);
            color: var(--navy);
            font-size: 0.95rem;
            font-weight: 700;
            background: rgba(237, 243, 239, 0.7);
            padding: 1rem 0.9rem;
            vertical-align: middle;
        }

        .table-persyaratan tbody td {
            color: var(--slate);
            font-size: 0.96rem;
            padding: 1rem 0.9rem;
            vertical-align: top;
            border-color: rgba(52, 73, 85, 0.08);
        }

        .persyaratan-section-title {
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .persyaratan-section-title i {
            color: var(--teal);
        }

        .persyaratan-subtitle {
            font-weight: 600;
            color: var(--teal);
            margin-bottom: 0.75rem;
        }

        .persyaratan-list {
            color: var(--slate);
            line-height: 2;
        }

        @media (max-width: 991.98px) {
            .persyaratan-shell {
                padding: 1.25rem;
            }
        }
    </style>
@endpush

@section('content')
    <x-navbar />

    <section class="persyaratan-page">
        <div class="container">
            <div class="persyaratan-shell">
                <h1 class="persyaratan-heading">Persyaratan Pendaftaran</h1>
                <p class="persyaratan-copy">Informasi lengkap tentang syarat dan ketentuan pendaftaran calon murid baru SMP Negeri 1 Bataguh.</p>

                {{-- DINAMIS: SEKSI JADWAL PELAKSANAAN --}}
                <div class="mb-5">
                    <h3 class="persyaratan-section-title">
                        <i class="bi bi-calendar-check"></i>
                        Jadwal Pelaksanaan
                    </h3>
                    <div class="table-responsive table-persyaratan">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Kegiatan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jadwal as $item)
                                    <tr>
                                        <td>{{ $item->kegiatan }}</td>
                                        <td>{{ $item->tanggal }}</td>
                                        <td>{{ $item->waktu }}</td>
                                        <td>{{ $item->lokasi }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada data jadwal pelaksanaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- DINAMIS: SEKSI PERSYARATAN UMUM & KHUSUS --}}
                <div class="mb-5">
                    <h3 class="persyaratan-section-title">
                        <i class="bi bi-clipboard-check"></i>
                        Persyaratan Pendaftaran
                    </h3>

                    <div class="mb-4">
                        <h5 class="persyaratan-subtitle">1. Persyaratan Umum</h5>
                        <ol class="persyaratan-list">
                            {!! $persyaratan->umum ?? '<li>Belum ada data persyaratan umum.</li>' !!}
                        </ol>
                    </div>

                    <div>
                        <h5 class="persyaratan-subtitle">2. Persyaratan Khusus</h5>
                        <ol class="persyaratan-list">
                            {!! $persyaratan->khusus ?? '<li>Belum ada data persyaratan khusus.</li>' !!}
                        </ol>
                    </div>
                </div>

                {{-- DINAMIS: SEKSI ALUR PELAKSANAAN --}}
                <div>
                    <h3 class="persyaratan-section-title">
                        <i class="bi bi-list-stars"></i>
                        Alur Pelaksanaan
                    </h3>
                    <ol class="persyaratan-list">
                        {!! $persyaratan->alur ?? '<li>Belum ada data alur pelaksanaan.</li>' !!}
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
@endsection