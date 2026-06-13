@extends('layouts.app')

@section('title', 'Biodata Peserta')

@section('content')
    <x-navbar />

    <div class="container py-5">
        <a href="{{ url('/') }}" class="d-flex align-items-center gap-3 text-decoration-none text-dark mb-4">
            <i class="bi bi-arrow-left fs-5"></i>
            <span class="fw-semibold">Kembali ke Beranda</span>
        </a>

        <h1 class="text-center fw-bold mb-5" style="font-size: 1.75rem; line-height: 1.3;">
            Pendaftaran Calon Murid Baru<br>
            SMP Negeri 1 Bataguh
        </h1>

        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="d-flex flex-column gap-4 mt-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle border border-dark d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-hash fs-6"></i>
                        </div>
                        <span class="fw-semibold">No. Peserta</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle border border-dark d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; {{ $step >= 2 ? '' : 'opacity: 0.5;' }}">
                            <i class="bi bi-person-lines-fill fs-6"></i>
                        </div>
                        <span class="fw-semibold" style="{{ $step >= 2 ? '' : 'opacity: 0.5;' }}">Biodata Peserta</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle border border-dark d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; {{ $step >= 3 ? '' : 'opacity: 0.3;' }}">
                            <i class="bi bi-check-circle fs-6"></i>
                        </div>
                        <span class="fw-semibold" style="{{ $step >= 3 ? '' : 'opacity: 0.3;' }}">Konfirmasi Isian</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="content-card">
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($step == 1)
                        <h2 class="fw-bold mb-4" style="font-size: 1.25rem;">PESERTA BARU</h2>
                        <form action="{{ route('biodata-peserta.step1') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nisn" class="form-label fw-semibold">NISN (Nomor Induk Siswa Nasional) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nisn" name="nisn" value="{{ old('nisn', $data['nisn'] ?? '') }}" required style="border: 2px solid #333; border-radius: 0.375rem;">
                            </div>
                            <div class="mb-4">
                                <label for="tahun_lulus" class="form-label fw-semibold">Tahun Lulus <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ old('tahun_lulus', $data['tahun_lulus'] ?? '') }}" required style="border: 2px solid #333; border-radius: 0.375rem;">
                            </div>
                            <div class="text-center mt-5">
                                <button type="submit" class="btn px-5 py-2" style="border: 2px solid #333; border-radius: 8px; background: #fff; color: #333; font-weight: 500;">
                                    Selanjutnya
                                </button>
                            </div>
                        </form>
                    @elseif($step == 2)
                        <div class="mb-4">
                            <form action="{{ route('biodata-peserta.back', 1) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none text-dark p-0 mb-3">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </button>
                            </form>
                        </div>
                        <h2 class="fw-bold mb-4" style="font-size: 1.25rem;">BIODATA PESERTA</h2>
                        <form action="{{ route('biodata-peserta.step2') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <h5 class="mb-3 text-dark fw-bold">DATA DIRI</h5>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $data['nama'] ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki-laki" value="Laki-laki" {{ old('jenis_kelamin', $data['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="laki-laki">Laki-laki</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="Perempuan" {{ old('jenis_kelamin', $data['jenis_kelamin'] ?? '') == 'Perempuan' ? 'checked' : '' }} required>
                                            <label class="form-check-label" for="perempuan">Perempuan</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $data['tanggal_lahir'] ?? '') }}" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3 text-dark fw-bold">DATA ORANG TUA & SEKOLAH</h5>
                                
                                <div class="mb-3">
                                    <label for="no_hp_ortu" class="form-label fw-semibold">No HP Orang Tua <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="no_hp_ortu" name="no_hp_ortu" value="{{ old('no_hp_ortu', $data['no_hp_ortu'] ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="asal_sekolah" class="form-label fw-semibold">Asal Sekolah <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="{{ old('asal_sekolah', $data['asal_sekolah'] ?? '') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label fw-semibold">Alamat <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $data['alamat'] ?? '') }}</textarea>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3 text-dark fw-bold">BERKAS PENDUKUNG</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="berkas_akta" class="form-label fw-semibold">Akta Kelahiran</label>
                                        <input type="file" class="form-control" id="berkas_akta" name="berkas_akta" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="berkas_kk" class="form-label fw-semibold">Kartu Keluarga (KK)</label>
                                        <input type="file" class="form-control" id="berkas_kk" name="berkas_kk" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="berkas_ktp_ortu" class="form-label fw-semibold">KTP Orang Tua</label>
                                        <input type="file" class="form-control" id="berkas_ktp_ortu" name="berkas_ktp_ortu" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pasfoto" class="form-label fw-semibold">Pas Foto</label>
                                        <input type="file" class="form-control" id="pasfoto" name="pasfoto" accept=".jpg,.jpeg,.png">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="berkas_persetujuan" class="form-label fw-semibold">Berkas Persetujuan</label>
                                        <input type="file" class="form-control" id="berkas_persetujuan" name="berkas_persetujuan" accept=".pdf,.jpg,.jpeg,.png">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn px-5 py-2" style="border: 2px solid #333; border-radius: 8px; background: #fff; color: #333; font-weight: 500;">
                                    Selanjutnya
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4">
                            <form action="{{ route('biodata-peserta.back', 2) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link text-decoration-none text-dark p-0 mb-3">
                                    <i class="bi bi-arrow-left me-2"></i> Kembali
                                </button>
                            </form>
                        </div>
                        <h2 class="fw-bold mb-4" style="font-size: 1.25rem;">KONFIRMASI DATA</h2>
                        
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">INFO PESERTA</h5>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">NISN</div>
                                <div class="col-8">{{ $data['nisn'] ?? '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">Tahun Lulus</div>
                                <div class="col-8">{{ $data['tahun_lulus'] ?? '' }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">DATA ASAL SEKOLAH</h5>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">Nama Sekolah</div>
                                <div class="col-8">{{ $data['asal_sekolah'] ?? '' }}</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="fw-bold mb-3">BIODATA MURID</h5>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">Nama Lengkap</div>
                                <div class="col-8">{{ $data['nama'] ?? '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">Jenis Kelamin</div>
                                <div class="col-8">{{ $data['jenis_kelamin'] ?? '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">Tanggal Lahir</div>
                                <div class="col-8">{{ isset($data['tanggal_lahir']) ? date('d F Y', strtotime($data['tanggal_lahir'])) : '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">Alamat Lengkap</div>
                                <div class="col-8">{{ $data['alamat'] ?? '' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-4 fw-semibold">No. HP/WA Aktif</div>
                                <div class="col-8">{{ $data['no_hp_ortu'] ?? '' }}</div>
                            </div>
                        </div>

                        @if(isset($data['berkas_akta_name']) || isset($data['berkas_kk_name']) || isset($data['berkas_ktp_ortu_name']) || isset($data['berkas_persetujuan_name']) || isset($data['pasfoto_name']))
                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">BERKAS YANG DIUPLOAD</h5>
                                @if(isset($data['berkas_akta_name']))
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-semibold">Scan/Foto Surat Keterangan Lulus/SKHU</div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary toggleFileBtn" data-target="skhu">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div id="skhu" class="file-content" style="display: none;">
                                            @if(str_ends_with(strtolower($data['berkas_akta_name']), '.pdf'))
                                                <a href="{{ Storage::url($data['berkas_akta_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat {{ $data['berkas_akta_name'] }}
                                                </a>
                                            @else
                                                <div class="mt-2">
                                                    <img src="{{ Storage::url($data['berkas_akta_path']) }}" alt="{{ $data['berkas_akta_name'] }}" class="img-thumbnail" style="max-width: 300px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if(isset($data['berkas_kk_name']))
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-semibold">Kartu Keluarga (KK)</div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary toggleFileBtn" data-target="kk">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div id="kk" class="file-content" style="display: none;">
                                            @if(str_ends_with(strtolower($data['berkas_kk_name']), '.pdf'))
                                                <a href="{{ Storage::url($data['berkas_kk_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat {{ $data['berkas_kk_name'] }}
                                                </a>
                                            @else
                                                <div class="mt-2">
                                                    <img src="{{ Storage::url($data['berkas_kk_path']) }}" alt="{{ $data['berkas_kk_name'] }}" class="img-thumbnail" style="max-width: 300px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if(isset($data['berkas_ktp_ortu_name']))
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-semibold">KTP Orang Tua</div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary toggleFileBtn" data-target="ktp">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div id="ktp" class="file-content" style="display: none;">
                                            @if(str_ends_with(strtolower($data['berkas_ktp_ortu_name']), '.pdf'))
                                                <a href="{{ Storage::url($data['berkas_ktp_ortu_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat {{ $data['berkas_ktp_ortu_name'] }}
                                                </a>
                                            @else
                                                <div class="mt-2">
                                                    <img src="{{ Storage::url($data['berkas_ktp_ortu_path']) }}" alt="{{ $data['berkas_ktp_ortu_name'] }}" class="img-thumbnail" style="max-width: 300px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if(isset($data['berkas_persetujuan_name']))
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-semibold">Berkas Persetujuan</div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary toggleFileBtn" data-target="persetujuan">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div id="persetujuan" class="file-content" style="display: none;">
                                            @if(str_ends_with(strtolower($data['berkas_persetujuan_name']), '.pdf'))
                                                <a href="{{ Storage::url($data['berkas_persetujuan_path']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-file-earmark-pdf me-1"></i> Lihat {{ $data['berkas_persetujuan_name'] }}
                                                </a>
                                            @else
                                                <div class="mt-2">
                                                    <img src="{{ Storage::url($data['berkas_persetujuan_path']) }}" alt="{{ $data['berkas_persetujuan_name'] }}" class="img-thumbnail" style="max-width: 300px;">
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif                                
                                @if(isset($data['pasfoto_name']))
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <div class="fw-semibold">Pas Foto</div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary toggleFileBtn" data-target="pasfoto">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </div>
                                        <div id="pasfoto" class="file-content" style="display: none;">
                                            <div class="mt-2">
                                                <img src="{{ Storage::url($data['pasfoto_path']) }}" alt="{{ $data['pasfoto_name'] }}" class="img-thumbnail" style="max-width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="d-flex gap-3 justify-content-center">
                        <form action="{{ route('biodata-peserta.store') }}" method="POST" id="confirmForm">
                            @csrf

                            <div class="border p-3 mb-4" style="background: #f8f9fa;">
                                <p class="mb-0 small">
                                    Saya yang tercantum di atas menyatakan bahwa data yang saya isikan di atas adalah benar.
                                    Dan Saya menyatakan mengikuti proses PPDB secara benar dan bersedia menerima konsekuensi
                                    jika di kemudian hari data yang saya ungkap tidak sesuai dengan data sebenarnya,
                                    maka saya bersedia mendapat sanksi sesuai Undang-undang yang berlaku.
                                </p>
                                <div class="mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirm" name="setuju_pernyataan" value="1" required>
                                        <label class="form-check-label" for="confirm">
                                            Saya setuju dengan pernyataan di atas <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-center">
                                <button type="submit" formaction="{{ route('biodata-peserta.back', 2) }}" class="btn px-4 py-2" style="border: 2px solid #333; border-radius: 8px; background: #fff; color: #333; font-weight: 500;">
                                    Kembali
                                </button>
                                
                                <button type="submit" class="btn px-4 py-2" style="border: 2px solid #333; border-radius: 8px; background: #fff; color: #333; font-weight: 500;">
                                    Simpan
                                </button>
                            </div>
                        </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-3">
                <div class="content-card">
                    <h3 class="fw-bold mb-3">Petunjuk Pengisian</h3>
                    <p class="text-muted small mb-4">Lengkapi formulir di samping sesuai dengan data anda</p>
                    <p class="text-muted small">NISN (Nomor Induk Siswa Nasional) Anda 10 digit terakhir tanpa tanda (-)</p>
                </div>
            </div>
        </div>
    </div>

    <x-footer />

    <script>
        document.querySelectorAll('.toggleFileBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const fileContent = document.getElementById(targetId);
                const eyeIcon = this.querySelector('i');
                
                if (fileContent.style.display === 'none') {
                    fileContent.style.display = 'block';
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    fileContent.style.display = 'none';
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });
        });
    </script>
@endsection
