<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\OfficerReportController;

// ✅ AUTH API
Route::post('/register', [AuthController::class, 'registerApi']);
Route::post('/login', [AuthController::class, 'loginApi']);

Route::middleware('auth:sanctum')->get('/reports/user', [ReportController::class, 'userReports']);
Route::get('/cities', [ReportController::class, 'getCities']);

 // Buat laporan baru
Route::put('/reports/{id}/status', [ReportController::class, 'updateStatus']); // Update status laporan
Route::delete('/reports/{id}', [ReportController::class, 'destroy']); // Hapus laporan

Route::middleware(['auth:sanctum', 'role:petugas'])->prefix('officer')->group(function () {
    Route::get('/assignments', [OfficerReportController::class, 'index']); // Lihat tugas
    Route::get('/assignments/{id}', [OfficerReportController::class, 'show']); // Detail tugas
    Route::post('/assignments/{id}/update', [OfficerReportController::class, 'updateStatus']); // Ubah status
    Route::post('/assignments/{id}/complete', [OfficerReportController::class, 'completeAssignment']);

});

// ✅ Middleware untuk API yang membutuhkan autentikasi
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/reports', [ReportController::class, 'store']);
    Route::get('/reports', [ReportController::class, 'index']); // Semua laporan
    Route::get('/reports/{id}', [ReportController::class, 'show']); // Detail laporan
    Route::get('/reports/{id}/history', [ReportController::class, 'getReportHistory']);



    // 🔹 Logout
    Route::post('/logout', [AuthController::class, 'logoutApi']);
});
