<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\AdminCalonSiswaController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminWaliKelasController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\WaliKelasDashboardController;
use App\Http\Controllers\SiswaDashboardController;
use App\Http\Controllers\PpdbController;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/ppdb', function () {
 //   return view('ppdb');
//})->name('ppdb');
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb');
Route::get('/hasil-seleksi', function () {
    $calonSiswa = App\Models\CalonSiswa::orderBy('no_pendaftaran')->get();
    return view('hasil-seleksi', compact('calonSiswa'));
})->name('hasil-seleksi');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch-role');
    
    Route::get('/dashboard/admin', [AuthController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/guru', [AuthController::class, 'guruDashboard'])->name('dashboard.guru');
    Route::get('/dashboard/walikelas', [AuthController::class, 'waliKelasDashboard'])->name('dashboard.walikelas');
    Route::get('/dashboard/siswa', [AuthController::class, 'siswaDashboard'])->name('dashboard.siswa')->middleware('role:siswa');

    Route::prefix('guru')->middleware('role:guru')->group(function () {
        Route::get('/jadwal-mengajar', [GuruDashboardController::class, 'jadwalMengajar'])->name('guru.jadwal-mengajar');
        Route::get('/daftar-siswa', [GuruDashboardController::class, 'daftarSiswa'])->name('guru.daftar-siswa');
        Route::get('/input-nilai', [GuruDashboardController::class, 'inputNilai'])->name('guru.input-nilai');
        Route::post('/input-nilai', [GuruDashboardController::class, 'storeNilai'])->name('guru.store-nilai');
        Route::get('/tugas', [GuruDashboardController::class, 'daftarTugas'])->name('guru.daftar-tugas');
        Route::get('/tugas/create', [GuruDashboardController::class, 'createTugas'])->name('guru.create-tugas');
        Route::post('/tugas', [GuruDashboardController::class, 'storeTugas'])->name('guru.store-tugas');
        Route::get('/tugas/{id}/edit', [GuruDashboardController::class, 'editTugas'])->name('guru.edit-tugas');
        Route::put('/tugas/{id}', [GuruDashboardController::class, 'updateTugas'])->name('guru.update-tugas');
        Route::delete('/tugas/{id}', [GuruDashboardController::class, 'destroyTugas'])->name('guru.destroy-tugas');
    });

    Route::prefix('walikelas')->middleware('role:wali kelas')->group(function () {
        Route::get('/presensi-siswa', [WaliKelasDashboardController::class, 'presensiSiswa'])->name('walikelas.presensi-siswa');
        Route::post('/presensi-siswa', [WaliKelasDashboardController::class, 'storePresensi'])->name('walikelas.store-presensi');
        Route::get('/rekap-presensi', [WaliKelasDashboardController::class, 'rekapPresensi'])->name('walikelas.rekap-presensi');
        Route::get('/rekap-nilai', [WaliKelasDashboardController::class, 'rekapNilai'])->name('walikelas.rekap-nilai');
        Route::post('/store-presensi-bulk', [WaliKelasDashboardController::class, 'storePresensiBulk'])
    ->name('walikelas.store-presensi-bulk');
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

        Route::resource('/jadwal-ppdb', App\Http\Controllers\AdminJadwalPpdbController::class)->names('admin.jadwal-ppdb'); //
        Route::get('/persyaratan-ppdb', [App\Http\Controllers\AdminPersyaratanPpdbController::class, 'index'])->name('admin.persyaratan-ppdb.index');
        Route::get('/persyaratan-ppdb/edit', [App\Http\Controllers\AdminPersyaratanPpdbController::class, 'edit'])->name('admin.persyaratan-ppdb.edit');
        Route::put('/persyaratan-ppdb', [App\Http\Controllers\AdminPersyaratanPpdbController::class, 'update'])->name('admin.persyaratan-ppdb.update');
        Route::post('/calon-siswa/{id}/verifikasi', [AdminCalonSiswaController::class, 'verifikasi'])->name('admin.calon-siswa.verifikasi');
        Route::post('/calon-siswa/{id}/tolak', [AdminCalonSiswaController::class, 'tolak'])->name('admin.calon-siswa.tolak');
        Route::get('/calon-siswa-export', [AdminCalonSiswaController::class, 'export'])->name('admin.calon-siswa.export');
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
