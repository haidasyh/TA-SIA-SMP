<?php

namespace Database\Seeders;

use App\Models\Beranda;
use App\Models\JadwalPelaksanaanPpdb;
use App\Models\PersyaratanPendaftaran;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class BerandaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Beranda::updateOrCreate(['id' => 1], [
            'profil' => 'Membangun generasi yang berkarakter, adaptif, dan siap berkembang lewat pendidikan yang berkualitas, lingkungan belajar yang hangat, dan budaya sekolah yang positif.',
            'tentang_kami' => 'SMPN 1 Bataguh adalah institusi pendidikan menengah pertama yang berkomitmen untuk menyelenggarakan pendidikan berkualitas di wilayah Bataguh. Kami berfokus pada pembentukan karakter siswa yang berakhlak mulia, cerdas secara akademik, dan memiliki keterampilan teknologi yang relevan dengan perkembangan zaman. Dengan dukungan tenaga pendidik yang berdedikasi, kami berupaya mewujudkan lingkungan belajar yang kondusif demi mencetak generasi penerus bangsa yang unggul.',
            'visi' => 'Berfokus pada perwujudan profil pelajar Pancasila yang berakhlak mulia, berprestasi (akademik/nonakademik), cerdas, mandiri, dan peduli lingkungan (Adiwiyata).',
            'misi' => 'Melaksanakan pembelajaran yang aktif, inovatif, kreatif, efektif, dan menyenangkan guna mengembangkan potensi peserta didik secara optimal.', // ✍️ Teks misi diperbaiki agar tidak kembar dengan visi
        ]);

        JadwalPelaksanaanPpdb::updateOrCreate(['kegiatan' => 'Pendaftaran & Verifikasi Berkas'], [
            'tanggal_mulai' => '2026-06-01',
            'tanggal_akhir' => '2026-06-30',
            'waktu'   => '08.00 - 15.00 WIB',
            'lokasi'  => 'Online / Offline',
        ]);

        JadwalPelaksanaanPpdb::updateOrCreate(['kegiatan' => 'Pengumuman Hasil Seleksi'], [
            'tanggal_mulai' => '2026-07-05',
            'tanggal_akhir' => null,
            'waktu'   => '08.00 - 15.00 WIB',
            'lokasi'  => 'Website Sekolah',
        ]);

        JadwalPelaksanaanPpdb::updateOrCreate(['kegiatan' => 'Daftar Ulang'], [
            'tanggal_mulai' => '2026-07-05',
            'tanggal_akhir' => null,
            'waktu'   => '08.00 - 15.00 WIB',
            'lokasi'  => 'SMP Negeri 1 Bataguh',
        ]);

        PersyaratanPendaftaran::updateOrCreate(['id' => 1], [
            'umum' => "Berusia paling tinggi 15 (lima belas) tahun pada tanggal 01 Juli tahun berjalan.\nBersedia mengikuti seluruh kegiatan sekolah.\nKartu keluarga (KK).\nAkta kelahiran (asli atau surat keterangan lahir yang dikeluarkan oleh pihak yang berwenang).\nMemiliki cetak NISN resmi dari SD/MI.",
            'khusus' => "Calon murid wajib mengisi formulir pendaftaran secara lengkap pada portal yang tersedia.\nMenjaga kesesuaian data yang diinput dengan berkas fisik asli saat verifikasi.\nCalon murid harus mengunggah seluruh dokumen pendukung pendaftaran yang diminta.",
            'alur' => "Calon murid baru wajib mengisi dan mengunggah dokumen pada portal pendaftaran PPDB online.\nPanitia sekolah melakukan proses verifikasi dan validasi berkas pendaftaran.\nCalon murid melihat pengumuman kelulusan hasil seleksi di web sesuai jadwal.\nSiswa yang lulus wajib melakukan daftar ulang ke sekolah dengan membawa berkas asli.",
        ]);

        Setting::set('ppdb_status', 'aktif');
    }
}