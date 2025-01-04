<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Main\UserController;
use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\Main\PerguruanTinggiSwastaController;
use App\Http\Controllers\Main\PerguruanTinggiNegeriController;
use App\Http\Controllers\Main\LaporanSwastaController;
use App\Http\Controllers\Main\LaporanNegeriController;
use App\Http\Middleware\AksesMiddleware;
use App\Http\Controllers\Main\ContributorController;
use App\Http\Controllers\Main\DataHistoriPTController; 

// Rute untuk halaman login
Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

// Rute untuk halaman home dan akses yang membutuhkan autentikasi
Route::middleware(['auth', AksesMiddleware::class])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rute laporan Perguruan Tinggi Swasta menggunakan UUID
    Route::resource('laporan-pts', LaporanSwastaController::class)->except(['create'])->names([
        'index' => 'laporan-pts.index',
        'store' => 'laporan-pts.store',
        'edit' => 'laporan-pts.edit',
        'update' => 'laporan-pts.update',
        'destroy' => 'laporan-pts.destroy'
    ]);
    Route::get('laporan-pts/create/{uuid}', [LaporanSwastaController::class, 'create'])->name('laporan-pts.create');
    Route::get('laporan-pts/show/{uuid}', [LaporanSwastaController::class, 'show'])->name('laporan-pts.show');
    Route::get('laporan-pts/{uuid}/pdf', [LaporanSwastaController::class, 'printToPdf'])->name('laporan-pts.printToPdf');

    // Rute laporan Perguruan Tinggi Negeri menggunakan UUID
    Route::resource('laporan-ptn', LaporanNegeriController::class)->except(['create'])->names([
        'index' => 'laporan-ptn.index',
        'store' => 'laporan-ptn.store',
        'edit' => 'laporan-ptn.edit',
        'update' => 'laporan-ptn.update',
        'destroy' => 'laporan-ptn.destroy',
    ]);

    // Rute tambahan untuk metode yang tidak dibuat otomatis oleh Route::resource
    Route::get('laporan-ptn/create/{uuid}', [LaporanNegeriController::class, 'create'])->name('laporan-ptn.create');
    Route::get('laporan-ptn/show/{uuid}', [LaporanNegeriController::class, 'show'])->name('laporan-ptn.show');
    Route::get('laporan-ptn/{uuid}/pdf', [LaporanNegeriController::class, 'printToPdf'])->name('laporan-ptn.printToPdf');

    // Rute khusus untuk Perguruan Tinggi Swasta menggunakan UUID
    Route::resource('pts', PerguruanTinggiSwastaController::class)->names([
        'index' => 'pts.index',
        'create' => 'pts.create',
        'store' => 'pts.store',
        'edit' => 'pts.edit',
        'update' => 'pts.update',
        'destroy' => 'pts.destroy'
    ]);
    Route::get('pts/{uuid}/edit', [PerguruanTinggiSwastaController::class, 'edit'])->name('pts.edit');
    Route::put('pts/{uuid}', [PerguruanTinggiSwastaController::class, 'update'])->name('pts.update');
    Route::delete('pts/{uuid}', [PerguruanTinggiSwastaController::class, 'destroy'])->name('pts.destroy');

    // Rute khusus untuk Perguruan Tinggi Negeri menggunakan UUID
    Route::resource('ptn', PerguruanTinggiNegeriController::class)->names([
        'index' => 'ptn.index',
        'create' => 'ptn.create',
        'store' => 'ptn.store',
        'edit' => 'ptn.edit',
        'update' => 'ptn.update',
        'destroy' => 'ptn.destroy'
    ]);
    Route::get('ptn/{uuid}/edit', [PerguruanTinggiNegeriController::class, 'edit'])->name('ptn.edit');
    Route::put('ptn/{uuid}', [PerguruanTinggiNegeriController::class, 'update'])->name('ptn.update');
    Route::delete('ptn/{uuid}', [PerguruanTinggiNegeriController::class, 'destroy'])->name('ptn.destroy');

    // Rute lainnya
    Route::get('/contributors', [ContributorController::class, 'index'])->name('contributors');

    // Rute khusus untuk Admin
    Route::resource('users', UserController::class)->parameters([
        'users' => 'uuid'
    ])->names([
        'index' => 'user.index',
        'create' => 'user.create',
        'store' => 'user.store',
        'edit' => 'user.edit',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    ]);

    Route::get('/histori-pt', [DataHistoriPTController::class, 'userIndex'])->name('histori-pt.index');

    // Rute tambahan untuk menghapus semua data histori PT
    Route::delete('/data-histori-pt/destroy-all', [DataHistoriPTController::class, 'destroyAll'])->name('data-histori-pt.destroyAll');
    Route::get('/data-histori-pt/download', [DataHistoriPTController::class, 'downloadExcel'])->name('data-histori-pt.download');
    
    // Rute khusus untuk Admin
    Route::resource('data-histori-pt', DataHistoriPTController::class)->parameters([
        'data-histori-pt' => 'uuid'
    ])->names([
        'index' => 'data-histori-pt.index',
        'create' => 'data-histori-pt.create',
        'store' => 'data-histori-pt.store',
        'edit' => 'data-histori-pt.edit',
        'update' => 'data-histori-pt.update',
        'destroy' => 'data-histori-pt.destroy',
    ]);

    // Notifikasi
    Route::get('/notifications/markAllAsRead', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('notifications.markAllAsRead');
});
