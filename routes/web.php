<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortalController;

Route::get('/', function () {
    return view('welcome');
});

// Portal Routes
Route::get('/portal/login', [PortalController::class, 'login'])->name('login');
Route::post('/portal/login', [PortalController::class, 'authenticate'])->name('portal.login.post');
Route::post('/portal/logout', [PortalController::class, 'logout'])->name('portal.logout');

Route::middleware(['auth'])->prefix('portal')->name('portal.')->group(function () {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/mahasiswa', [PortalController::class, 'mahasiswa'])->name('mahasiswa');
    
    // Seminar
    Route::get('/seminar', [PortalController::class, 'seminar'])->name('seminar');
    Route::post('/seminar', [PortalController::class, 'storeSeminar'])->name('seminar.store');
    Route::get('/riwayat-seminar', [PortalController::class, 'riwayatSeminar'])->name('riwayatSeminar');
    Route::get('/seminar/{id}/edit', [PortalController::class, 'editSeminar'])->name('seminar.edit');
    Route::put('/seminar/{id}', [PortalController::class, 'updateSeminar'])->name('seminar.update');
    Route::delete('/seminar/{id}', [PortalController::class, 'destroySeminar'])->name('seminar.destroy');
    Route::get('/seminar/{id}/undangan', [PortalController::class, 'downloadUndanganSeminar'])->name('seminar.undangan');
    Route::post('/seminar/{id}/notify', [PortalController::class, 'sendSeminarNotification'])->name('seminar.notify');

    // Skripsi
    Route::get('/skripsi', [PortalController::class, 'skripsi'])->name('skripsi');
    Route::post('/skripsi', [PortalController::class, 'storeSkripsi'])->name('skripsi.store');
    Route::get('/riwayat-skripsi', [PortalController::class, 'riwayatSkripsi'])->name('riwayatSkripsi');
    Route::get('/skripsi/{id}/edit', [PortalController::class, 'editSkripsi'])->name('skripsi.edit');
    Route::put('/skripsi/{id}', [PortalController::class, 'updateSkripsi'])->name('skripsi.update');
    Route::delete('/skripsi/{id}', [PortalController::class, 'destroySkripsi'])->name('skripsi.destroy');

    // Pengajuan Judul
    Route::get('/pengajuan-judul', [PortalController::class, 'pengajuanJudul'])->name('pengajuanJudul');
    Route::post('/pengajuan-judul', [PortalController::class, 'storePengajuanJudul'])->name('pengajuanJudul.store');
    Route::get('/riwayat-pengajuan-judul', [PortalController::class, 'riwayatPengajuanJudul'])->name('riwayatPengajuanJudul');
    Route::post('/pengajuan-judul/{id}/approve', [PortalController::class, 'approvePengajuanJudul'])->name('pengajuanJudul.approve');
    Route::get('/pengajuan-judul/{id}/download-surat', [PortalController::class, 'downloadSuratKesediaan'])->name('pengajuanJudul.downloadSurat');
    Route::post('/pengajuan-judul/{id}/notify', [PortalController::class, 'notifyJudul'])->name('pengajuanJudul.notify');
    Route::delete('/pengajuan-judul/{id}', [PortalController::class, 'destroyPengajuanJudul'])->name('pengajuanJudul.destroy');

    // Praktek Lapang
    Route::get('/praktek-lapang', [PortalController::class, 'praktekLapang'])->name('praktekLapang');
    Route::post('/praktek-lapang', [PortalController::class, 'storePraktekLapang'])->name('praktekLapang.store');
    Route::get('/riwayat-praktek-lapang', [PortalController::class, 'riwayatPraktekLapang'])->name('riwayatPraktekLapang');
    Route::get('/praktek-lapang/{id}/edit', [PortalController::class, 'editPraktekLapang'])->name('praktekLapang.edit');
    Route::put('/praktek-lapang/{id}', [PortalController::class, 'updatePraktekLapang'])->name('praktekLapang.update');
    Route::delete('/praktek-lapang/{id}', [PortalController::class, 'destroyPraktekLapang'])->name('praktekLapang.destroy');
    
    // Theme
    Route::post('/update-theme', [PortalController::class, 'updateTheme'])->name('updateTheme');

    // Surat
    Route::get('/riwayat-surat', [PortalController::class, 'riwayatSurat'])->name('riwayatSurat');
    Route::post('/surat', [PortalController::class, 'storeSurat'])->name('surat.store');
    Route::get('/surat/{id}', [PortalController::class, 'viewSurat'])->name('surat.view');
});
