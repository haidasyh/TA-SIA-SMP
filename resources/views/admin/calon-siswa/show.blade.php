@extends('layouts.app')

@section('title', 'Detail Calon Siswa - Admin')

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
                            <h1 class="fw-bold">Detail Calon Siswa</h1>
                            <p class="text-muted">{{ $calonSiswa->nama }} - {{ $calonSiswa->no_pendaftaran }}</p>
                        </div>
                        <a href="{{ route('admin.calon-siswa.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-light fw-bold">Data Diri</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">No. Pendaftaran</label>
                                    <p class="mb-0">{{ $calonSiswa->no_pendaftaran }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Nama Lengkap</label>
                                    <p class="mb-0">{{ $calonSiswa->nama }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">NISN</label>
                                    <p class="mb-0">{{ $calonSiswa->nisn }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Jenis Kelamin</label>
                                    <p class="mb-0">{{ $calonSiswa->jenis_kelamin }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Tanggal Lahir</label>
                                    <p class="mb-0">{{ $calonSiswa->tanggal_lahir->format('d/m/Y') }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">No. HP Orang Tua</label>
                                    <p class="mb-0">{{ $calonSiswa->no_hp_ortu }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Asal Sekolah</label>
                                    <p class="mb-0">{{ $calonSiswa->asal_sekolah }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Alamat</label>
                                    <p class="mb-0">{{ $calonSiswa->alamat }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-semibold text-muted small">Status Verifikasi</label>
                                    <div>
                                        @if($calonSiswa->status_verifikasi == 'Pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($calonSiswa->status_verifikasi == 'Diterima')
                                            <span class="badge bg-success">Diterima</span>
                                        @else
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-light fw-bold">Berkas Pendukung</div>
                            <div class="card-body">
                                @if($calonSiswa->berkas_akta)
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2 d-block">Scan/Foto Surat Keterangan Lulus/SKHU</label>
                                        <div class="d-flex gap-2 mb-2">
                                            @if(str_ends_with(strtolower($calonSiswa->berkas_akta), '.pdf'))
                                                <a href="{{ $calonSiswa->berkas_akta_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Berkas
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.calon-siswa.download', [$calonSiswa->id, 'akta']) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                        @if(!str_ends_with(strtolower($calonSiswa->berkas_akta), '.pdf'))
                                            <img src="{{ $calonSiswa->berkas_akta_url }}" alt="SKHU" class="img-thumbnail" style="max-width: 100%;">
                                        @endif
                                    </div>
                                @endif

                                @if($calonSiswa->berkas_kk)
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2 d-block">Kartu Keluarga (KK)</label>
                                        <div class="d-flex gap-2 mb-2">
                                            @if(str_ends_with(strtolower($calonSiswa->berkas_kk), '.pdf'))
                                                <a href="{{ $calonSiswa->berkas_kk_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Berkas
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.calon-siswa.download', [$calonSiswa->id, 'kk']) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                        @if(!str_ends_with(strtolower($calonSiswa->berkas_kk), '.pdf'))
                                            <img src="{{ $calonSiswa->berkas_kk_url }}" alt="KK" class="img-thumbnail" style="max-width: 100%;">
                                        @endif
                                    </div>
                                @endif

                                @if($calonSiswa->berkas_ktp_ortu)
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2 d-block">KTP Orang Tua</label>
                                        <div class="d-flex gap-2 mb-2">
                                            @if(str_ends_with(strtolower($calonSiswa->berkas_ktp_ortu), '.pdf'))
                                                <a href="{{ $calonSiswa->berkas_ktp_ortu_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Berkas
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.calon-siswa.download', [$calonSiswa->id, 'ktp']) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                        @if(!str_ends_with(strtolower($calonSiswa->berkas_ktp_ortu), '.pdf'))
                                            <img src="{{ $calonSiswa->berkas_ktp_ortu_url }}" alt="KTP Orang Tua" class="img-thumbnail" style="max-width: 100%;">
                                        @endif
                                    </div>
                                @endif

                                @if($calonSiswa->berkas_persetujuan)
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2 d-block">Berkas Persetujuan</label>
                                        <div class="d-flex gap-2 mb-2">
                                            @if(str_ends_with(strtolower($calonSiswa->berkas_persetujuan), '.pdf'))
                                                <a href="{{ $calonSiswa->berkas_persetujuan_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat Berkas
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.calon-siswa.download', [$calonSiswa->id, 'persetujuan']) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                        @if(!str_ends_with(strtolower($calonSiswa->berkas_persetujuan), '.pdf'))
                                            <img src="{{ $calonSiswa->berkas_persetujuan_url }}" alt="Berkas Persetujuan" class="img-thumbnail" style="max-width: 100%;">
                                        @endif
                                    </div>
                                @endif                                

                                @if($calonSiswa->pasfoto)
                                    <div class="mb-4">
                                        <label class="fw-semibold mb-2 d-block">Pas Foto</label>
                                        <div class="d-flex gap-2 mb-2">
                                            <a href="{{ route('admin.calon-siswa.download', [$calonSiswa->id, 'pasfoto']) }}" class="btn btn-sm btn-success">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                        <img src="{{ $calonSiswa->pasfoto_url }}" alt="Pas Foto" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($calonSiswa->status_verifikasi == 'Pending')
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-light fw-bold">Aksi Verifikasi</div>
                                <div class="card-body">
                                    <div class="d-flex gap-2">
                                        <form method="POST" action="{{ route('admin.calon-siswa.verifikasi', $calonSiswa->id) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Yakin ingin menerima calon siswa ini?')">
                                                <i class="bi bi-check-lg me-2"></i> Terima
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.calon-siswa.tolak', $calonSiswa->id) }}" class="flex-1">
                                            @csrf
                                            <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Yakin ingin menolak calon siswa ini?')">
                                                <i class="bi bi-x-lg me-2"></i> Tolak
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
