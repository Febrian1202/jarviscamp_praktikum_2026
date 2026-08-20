<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomikController;
use App\Http\Controllers\PeminjamanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public Route
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/komik', KomikController::class);
    Route::apiResource('/kategori', KategoriController::class);
    Route::apiResource('/anggota', AnggotaController::class);
    Route::apiResource('/peminjaman', PeminjamanController::class);

    Route::put('/peminjaman/{peminjaman}/kembali', [PeminjamanController::class, 'kembali']);
});
