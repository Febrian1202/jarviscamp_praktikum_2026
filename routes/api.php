<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomikController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get("/user", function (Request $request) {
    return $request->user();
})->middleware("auth:sanctum");

Route::apiResource("/komik", KomikController::class);
Route::apiResource("/kategori", KategoriController::class);
Route::apiResource("/anggota", AnggotaController::class);
