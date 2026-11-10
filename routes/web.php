<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Aplikasi Pengelolaan KDO BMD
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/perangkat-daerah', [PageController::class, 'perangkatDaerah'])->name('perangkat-daerah.index');
    Route::get('/pns', [PageController::class, 'pns'])->name('pns.index');
    Route::get('/kdo', [PageController::class, 'kdo'])->name('kdo.index');
    Route::get('/pemeliharaan', [PageController::class, 'pemeliharaan'])->name('pemeliharaan.index');
    Route::get('/laporan', [PageController::class, 'laporan'])->name('laporan.index');
    Route::get('/laporan/cetak', [PageController::class, 'cetakLaporan'])->name('laporan.cetak');
    Route::get('/kdo/{id}/cetak-kartu', [PageController::class, 'cetakKdo'])->name('kdo.cetak-kartu');
    Route::get('/api-docs', [PageController::class, 'apiDocs'])->name('api-docs');
});
