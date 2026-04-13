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
    Route::get('/seminar', [PortalController::class, 'seminar'])->name('seminar');
    Route::get('/skripsi', [PortalController::class, 'skripsi'])->name('skripsi');
    Route::get('/praktek-lapang', [PortalController::class, 'praktekLapang'])->name('praktekLapang');
    Route::get('/riwayat-seminar', [PortalController::class, 'riwayatSeminar'])->name('riwayatSeminar');
    Route::get('/riwayat-skripsi', [PortalController::class, 'riwayatSkripsi'])->name('riwayatSkripsi');
    Route::get('/riwayat-praktek-lapang', [PortalController::class, 'riwayatPraktekLapang'])->name('riwayatPraktekLapang');
});
