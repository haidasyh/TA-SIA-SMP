<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\CalonSiswaController;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCalonSiswaController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\MataPelajaranController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminWaliKelasController;
use App\Http\Controllers\Admin\AdminBerandaPpdbController;
use App\Http\Controllers\Admin\AdminPersyaratanPpdbController;
use App\Http\Controllers\Admin\AdminJadwalPpdbController;

use App\Http\Controllers\Guru\GuruDashboardController;
use App\Http\Controllers\Guru\NilaiController;
use App\Http\Controllers\Guru\TugasController;

use App\Http\Controllers\WaliKelas\WaliKelasDashboardController;
use App\Http\Controllers\WaliKelas\PresensiSiswaController;

use App\Http\Controllers\Siswa\SiswaDashboardController;

Route::get('/', function () {
    $beranda = App\Models\Beranda::first() ?? new App\Models\Beranda();
    return view('welcome', compact('beranda'));
});

Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb');
Route::get('/hasil-seleksi', function () {
    $calonSiswa = App\Models\CalonSiswa::orderBy('no_pendaftaran')->get();
    return view('hasil-seleksi', compact('calonSiswa'));
})->name('hasil-seleksi');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch-role');
    
    Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/dashboard/guru', [GuruDashboardController::class, 'index'])->name('dashboard.guru');
    Route::get('/dashboard/walikelas', [WaliKelasDashboardController::class, 'index'])->name('dashboard.walikelas');
    Route::get('/dashboard/siswa', [SiswaDashboardController::class, 'index'])->name('dashboard.siswa')->middleware('role:siswa');

    Route::prefix('guru')->middleware('role:guru')->group(function () {
        Route::get('/jadwal-mengajar', [GuruDashboardController::class, 'jadwalMengajar'])->name('guru.jadwal-mengajar');
        Route::get('/daftar-siswa', [GuruDashboardController::class, 'daftarSiswa'])->name('guru.daftar-siswa');
        
        Route::get('/input-nilai', [NilaiController::class, 'index'])->name('guru.input-nilai');
        Route::post('/input-nilai', [NilaiController::class, 'store'])->name('guru.store-nilai');
        
        Route::resource('tugas', TugasController::class)->names([
            'index'   => 'guru.daftar-tugas',
            'create'  => 'guru.create-tugas',
            'store'   => 'guru.store-tugas',
            'edit'    => 'guru.edit-tugas',
            'update'  => 'guru.update-tugas',
            'destroy' => 'guru.destroy-tugas',
        ]);
    });

    Route::prefix('walikelas')->middleware('role:wali kelas')->group(function () {
        Route::get('/rekap-presensi', [WaliKelasDashboardController::class, 'rekapPresensi'])->name('walikelas.rekap-presensi');
        Route::get('/rekap-nilai', [WaliKelasDashboardController::class, 'rekapNilai'])->name('walikelas.rekap-nilai');
        
        Route::get('/presensi-siswa', [PresensiSiswaController::class, 'index'])->name('walikelas.presensi-siswa');
        Route::post('/presensi-siswa', [PresensiSiswaController::class, 'store'])->name('walikelas.store-presensi');
        Route::post('/store-presensi-bulk', [PresensiSiswaController::class, 'storeBulk'])->name('walikelas.store-presensi-bulk');
    });

    Route::prefix('siswa')->middleware('role:siswa')->group(function () {
        Route::get('/jadwal-pelajaran', [SiswaDashboardController::class, 'jadwalPelajaran'])->name('siswa.jadwal-pelajaran');
        Route::get('/rekap-presensi', [SiswaDashboardController::class, 'rekapPresensi'])->name('siswa.rekap-presensi');
        Route::get('/nilai', [SiswaDashboardController::class, 'nilai'])->name('siswa.nilai');
        Route::get('/tugas', [SiswaDashboardController::class, 'daftarTugas'])->name('siswa.daftar-tugas');
    });

    Route::prefix('admin')->middleware('role:administrator')->group(function () {
        
        Route::resource('/calon-siswa', AdminCalonSiswaController::class)->names([
            'index' => 'admin.calon-siswa.index',
            'create' => 'admin.calon-siswa.create',
            'store' => 'admin.calon-siswa.store',
            'show' => 'admin.calon-siswa.show',
            'edit' => 'admin.calon-siswa.edit',
            'update' => 'admin.calon-siswa.update',
            'destroy' => 'admin.calon-siswa.destroy',
        ]);
        Route::post('/calon-siswa/{id}/verifikasi', [AdminCalonSiswaController::class, 'verifikasi'])->name('admin.calon-siswa.verifikasi');
        Route::post('/calon-siswa/{id}/tolak', [AdminCalonSiswaController::class, 'tolak'])->name('admin.calon-siswa.tolak');
        Route::get('/calon-siswa-export', [AdminCalonSiswaController::class, 'export'])->name('admin.calon-siswa.export');
        Route::get('/calon-siswa/{id}/download/{type}', [AdminCalonSiswaController::class, 'download'])->name('admin.calon-siswa.download');

        Route::get('/beranda', [AdminBerandaPpdbController::class, 'index'])->name('admin.beranda.index');
        Route::post('/beranda/update', [AdminBerandaPpdbController::class, 'update'])->name('admin.beranda.update');
        Route::post('/beranda/status', [AdminBerandaPpdbController::class, 'updateStatus'])->name('admin.beranda.update-status');

        Route::get('/persyaratan-ppdb', [AdminPersyaratanPpdbController::class, 'index'])->name('admin.persyaratan-ppdb.index');
        Route::post('/persyaratan-ppdb/update', [AdminPersyaratanPpdbController::class, 'update'])->name('admin.persyaratan-ppdb.update');

        Route::get('/jadwal-ppdb', [AdminJadwalPpdbController::class, 'index'])->name('admin.jadwal-ppdb.index');
        Route::post('/jadwal-ppdb', [AdminJadwalPpdbController::class, 'store'])->name('admin.jadwal-ppdb.store');
        Route::put('/jadwal-ppdb/{id}', [AdminJadwalPpdbController::class, 'update'])->name('admin.jadwal-ppdb.update');
        Route::delete('/jadwal-ppdb/{id}', [AdminJadwalPpdbController::class, 'destroy'])->name('admin.jadwal-ppdb.destroy');

        Route::get('/siswa/export', [SiswaController::class, 'export'])->name('admin.siswa.export');
        Route::resource('/siswa', SiswaController::class)->names([
            'index' => 'admin.siswa.index',
            'create' => 'admin.siswa.create',
            'store' => 'admin.siswa.store',
            'show' => 'admin.siswa.show',
            'edit' => 'admin.siswa.edit',
            'update' => 'admin.siswa.update',
            'destroy' => 'admin.siswa.destroy',
        ]);

        Route::get('/guru-export', [GuruController::class, 'export'])->name('admin.guru.export');
        Route::resource('/guru', GuruController::class)->names([
            'index' => 'admin.guru.index',
            'create' => 'admin.guru.create',
            'store' => 'admin.guru.store',
            'show' => 'admin.guru.show',
            'edit' => 'admin.guru.edit',
            'update' => 'admin.guru.update',
            'destroy' => 'admin.guru.destroy',
        ]);

        Route::resource('/wali-kelas', AdminWaliKelasController::class)->names([
            'index' => 'admin.wali-kelas.index',
            'create' => 'admin.wali-kelas.create',
            'store' => 'admin.wali-kelas.store',
            'show' => 'admin.wali-kelas.show',
            'edit' => 'admin.wali-kelas.edit',
            'update' => 'admin.wali-kelas.update',
            'destroy' => 'admin.wali-kelas.destroy',
        ]);

        Route::resource('/mata-pelajaran', MataPelajaranController::class)->names([
            'index' => 'admin.mata-pelajaran.index',
            'create' => 'admin.mata-pelajaran.create',
            'store' => 'admin.mata-pelajaran.store',
            'show' => 'admin.mata-pelajaran.show',
            'edit' => 'admin.mata-pelajaran.edit',
            'update' => 'admin.mata-pelajaran.update',
            'destroy' => 'admin.mata-pelajaran.destroy',
        ]);

        Route::resource('/kelas', KelasController::class)->names([
            'index' => 'admin.kelas.index',
            'create' => 'admin.kelas.create',
            'store' => 'admin.kelas.store',
            'show' => 'admin.kelas.show',
            'edit' => 'admin.kelas.edit',
            'update' => 'admin.kelas.update',
            'destroy' => 'admin.kelas.destroy',
        ]);

        Route::resource('/jadwal', JadwalController::class)->names([
            'index' => 'admin.jadwal.index',
            'create' => 'admin.jadwal.create',
            'store' => 'admin.jadwal.store',
            'show' => 'admin.jadwal.show',
            'edit' => 'admin.jadwal.edit',
            'update' => 'admin.jadwal.update',
            'destroy' => 'admin.jadwal.destroy',
        ]);

        Route::resource('/user', UserController::class)->names([
            'index' => 'admin.user.index',
            'create' => 'admin.user.create',
            'store' => 'admin.user.store',
            'show' => 'admin.user.show',
            'edit' => 'admin.user.edit',
            'update' => 'admin.user.update',
            'destroy' => 'admin.user.destroy',
        ]);
    });
});

Route::get('/biodata-peserta', [CalonSiswaController::class, 'index'])->name('biodata-peserta');
Route::post('/biodata-peserta/step1', [CalonSiswaController::class, 'step1'])->name('biodata-peserta.step1');
Route::post('/biodata-peserta/step2', [CalonSiswaController::class, 'step2'])->name('biodata-peserta.step2');
Route::post('/biodata-peserta/back/{step}', [CalonSiswaController::class, 'backToStep'])->name('biodata-peserta.back');
Route::post('/biodata-peserta/store', [CalonSiswaController::class, 'store'])->name('biodata-peserta.store');