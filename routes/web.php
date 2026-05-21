<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalonSiswaController;
use App\Http\Controllers\AdminCalonSiswaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ppdb', function () {
    return view('ppdb');
})->name('ppdb');

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

    Route::prefix('admin')->middleware('role:administrator')->group(function () {
        Route::get('/calon-siswa', [AdminCalonSiswaController::class, 'index'])->name('admin.calon-siswa.index');
        Route::get('/calon-siswa/{id}', [AdminCalonSiswaController::class, 'show'])->name('admin.calon-siswa.show');
        Route::post('/calon-siswa/{id}/verifikasi', [AdminCalonSiswaController::class, 'verifikasi'])->name('admin.calon-siswa.verifikasi');
        Route::post('/calon-siswa/{id}/tolak', [AdminCalonSiswaController::class, 'tolak'])->name('admin.calon-siswa.tolak');
    });
});

Route::get('/biodata-peserta', [CalonSiswaController::class, 'index'])->name('biodata-peserta');
Route::post('/biodata-peserta/step1', [CalonSiswaController::class, 'step1'])->name('biodata-peserta.step1');
Route::post('/biodata-peserta/step2', [CalonSiswaController::class, 'step2'])->name('biodata-peserta.step2');
Route::post('/biodata-peserta/back/{step}', [CalonSiswaController::class, 'backToStep'])->name('biodata-peserta.back');
Route::post('/biodata-peserta/store', [CalonSiswaController::class, 'store'])->name('biodata-peserta.store');
