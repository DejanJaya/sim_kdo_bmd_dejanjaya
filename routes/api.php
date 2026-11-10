<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\KdoController;
use App\Http\Controllers\Api\LaporanController;
use App\Http\Controllers\Api\PerangkatDaerahController;
use App\Http\Controllers\Api\PnsController;
use App\Http\Controllers\Api\RiwayatPemegangController;
use App\Http\Controllers\Api\RiwayatPemeliharaanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| REST API Routes - Sistem Informasi KDO BMD
|--------------------------------------------------------------------------
*/

// Authentication
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Dashboard Analitik & Rekapitulasi Laporan BMD
Route::get('/dashboard/summary', [DashboardController::class, 'summary']);
Route::get('/laporan/rekapitulasi', [LaporanController::class, 'rekapitulasi']);

// Master & Operasional Resources
Route::name('api.')->group(function () {
    Route::apiResource('perangkat-daerah', PerangkatDaerahController::class);
    Route::apiResource('pns', PnsController::class);
    Route::apiResource('kdo', KdoController::class);
    Route::apiResource('riwayat-pemeliharaan', RiwayatPemeliharaanController::class);
    Route::apiResource('riwayat-pemegang', RiwayatPemegangController::class);
});
