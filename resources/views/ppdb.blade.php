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
                                <tr>
                                    <td>Pendaftaran & Verifikasi Berkas</td>
                                    <td>01 Juni 2025 s/d 30 Juni 2025</td>
                                    <td>08.00 - 16.00 WIB</td>
                                    <td>Online / Offline</td>
                                </tr>
                                <tr>
                                    <td>Pengumuman Hasil Seleksi</td>
                                    <td>05 Juli 2025</td>
                                    <td>10.00 WIB</td>
                                    <td>Website Sekolah</td>
                                </tr>
                                <tr>
                                    <td>Daftar Ulang</td>
                                    <td>07 Juli 2025 s/d 10 Juli 2025</td>
                                    <td>08.00 - 15.00 WIB</td>
                                    <td>SMP Negeri 1 Bataguh</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="persyaratan-section-title">
                        <i class="bi bi-clipboard-check"></i>
                        Persyaratan Pendaftaran
                    </h3>

                    <div class="mb-4">
                        <h5 class="persyaratan-subtitle">1. Persyaratan Umum</h5>
                        <ol class="persyaratan-list">
                            <li>Berusia paling tinggi 15 (lima belas) tahun pada tanggal 01 Juli 2025;</li>
                            <li>Bersedia mengikuti seluruh kegiatan sekolah;</li>
                            <li>Kartu keluarga (KK);</li>
                            <li>Akta kelahiran (asli surat keterangan lahir yang dikeluarkan oleh pihak yang berwenang dan dilegalisir oleh domisili calon Murid);</li>
                            <li>Calon tangan buku NISN SD/MI;</li>
                            <li>Memiliki surat keterangan untuk penyandang disabilitas (Murid yang berkebutuhan dan dilegalisir oleh unit pelayanan setempat lain).</li>
                        </ol>
                    </div>

                    <div>
                        <h5 class="persyaratan-subtitle">2. Persyaratan Khusus</h5>
                        <ol class="persyaratan-list">
                            <li>Calon murid harus wajib mengisi formulir pendaftaran secara lengkap dan pada portal yang tersedia;</li>
                            <li>Sesuai ketentuan formulir pendaftaran dan kecocokan tanggapan dengan data primer formulir pendaftaran;</li>
                            <li>Dinas pendidikan tetap mempertimbangkan usia calon murid baru yang bersekolah di luar kecamatan;</li>
                            <li>Calon murid harus melengkapi dokumen pendukung yang diminta pada portal pendaftaran online;</li>
                            <li>Jika sistem pendaftaran sudah melebihi kuota, maka penerima pendaftaran berdasarkan urutan waktu pendaftaran dan hasil verifikasi dilakukan;</li>
                            <li>Calon murid baru harus memahami seluruh ketentuan dan tata tertib apabila diterima.</li>
                        </ol>
                    </div>
                </div>

                <div>
                    <h3 class="persyaratan-section-title">
                        <i class="bi bi-list-stars"></i>
                        Alur Pelaksanaan
                    </h3>
                    <ol class="persyaratan-list">
                        <li>Calon murid baru wajib mengisi dan mengunggah dokumen yang telah ditentukan pada portal pendaftaran tersebut sesuai dengan yang ditentukan bagian pendaftaran;</li>
                        <li>Panitia sekolah melakukan verifikasi dan validasi berkas yang calon murid baru telah upload;</li>
                        <li>Calon murid baru melihat pengumuman hasil seleksi sesuai jadwal yang telah ditentukan;</li>
                        <li>Calon murid baru yang telah lulus seleksi, wajib melakukan daftar ulang/ lapor diri sesuai jadwal ke sekolah dengan membawa berkas yang diminta saat pengumuman pendaftaran.</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
@endsection
