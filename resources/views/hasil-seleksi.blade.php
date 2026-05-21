@extends('layouts.app')

@section('title', 'Hasil Seleksi - SMP Negeri 1 Bataguh')

@push('styles')
    <style>
        .selection-page {
            padding: 3rem 0 4rem;
        }

        .selection-shell {
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(80, 114, 123, 0.12);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-soft);
            padding: 2rem;
        }

        .selection-table-wrap {
            overflow: hidden;
            border: 1px solid rgba(52, 73, 85, 0.1);
            border-radius: 1rem;
            background: #fff;
        }

        .selection-table {
            margin-bottom: 0;
        }

        .selection-table thead th {
            border-bottom: 1px solid rgba(52, 73, 85, 0.12);
            color: var(--navy);
            font-size: 0.95rem;
            font-weight: 700;
            background: rgba(237, 243, 239, 0.7);
            padding: 1rem 0.9rem;
            vertical-align: middle;
        }

        .selection-table tbody td {
            color: var(--slate);
            font-size: 0.96rem;
            padding: 1rem 0.9rem;
            vertical-align: top;
            border-color: rgba(52, 73, 85, 0.08);
        }

        .selection-table tbody tr:hover {
            background: rgba(80, 114, 123, 0.04);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-diterima {
            background: rgba(0, 255, 72, 0.18);
            /* color: var(--teal); */
        }

        .status-ditolak {
            background: rgba(220, 76, 100, 0.12);
            color: #b8445f;
        }

        .status-pending {
            background: rgba(206, 152, 63, 0.12);
            color: #b8860b;
        }

        .selection-heading {
            font-size: 2rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 0.35rem;
        }

        .selection-copy {
            color: var(--muted);
            margin-bottom: 1.75rem;
        }

        @media (max-width: 991.98px) {
            .selection-shell {
                padding: 1.25rem;
            }

            .selection-sidebar {
                padding-right: 0;
                margin-bottom: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <x-navbar />

    <section class="selection-page">
        <div class="container">
            <div class="selection-shell">
                <h1 class="selection-heading">Hasil Seleksi</h1>
                <p class="selection-copy">Daftar calon siswa yang telah mendaftar dan status verifikasinya.</p>

                <div class="selection-table-wrap">
                    <div class="table-responsive">
                        <table class="table selection-table align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">No Urut</th>
                                    <th style="width: 180px;">No Pendaftaran</th>
                                    <th>Nama</th>
                                    <th>Asal Sekolah</th>
                                    <th style="width: 150px;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calonSiswa as $index => $siswa)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $siswa->no_pendaftaran }}</td>
                                        <td>{{ $siswa->nama }}</td>
                                        <td>{{ $siswa->asal_sekolah }}</td>
                                        <td>
                                            @if($siswa->status_verifikasi == 'Diterima')
                                                <span class="status-badge status-diterima">
                                                    <i class="bi bi-check-circle-fill"></i> Diterima
                                                </span>
                                            @elseif($siswa->status_verifikasi == 'Ditolak')
                                                <span class="status-badge status-ditolak">
                                                    <i class="bi bi-x-circle-fill"></i> Ditolak
                                                </span>
                                            @else
                                                <span class="status-badge status-pending">
                                                    <i class="bi bi-clock-fill"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
@endsection
