<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminPetugasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::get('', 'loginview')->name('login.view');
    Route::post('login', 'loginWeb')->name('login.action');
    Route::post('logout', 'logoutWeb')->middleware('auth')->name('logout.web');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [AdminController::class, 'Dashboard'])->name('Dashboard');


    Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
        Route::get('/reports', [AdminReportController::class, 'index'])->name('admin.reports.index');
        Route::post('/reports/{id}/verify', [AdminReportController::class, 'verify'])->name('admin.reports.verify');
        Route::get('/reports/{id}/assign', [AdminReportController::class, 'assignForm'])->name('admin.reports.assignForm');
        Route::post('/reports/{id}/assign', [AdminReportController::class, 'assign'])->name('admin.reports.assign');

        Route::get('/petugas', [AdminPetugasController::class, 'index'])->name('admin.petugas.index');
        Route::get('/petugas/create', [AdminPetugasController::class, 'create'])->name('admin.petugas.create');
        Route::post('/petugas/store', [AdminPetugasController::class, 'store'])->name('admin.petugas.store');
        Route::get('/petugas/{id}/edit', [AdminPetugasController::class, 'edit'])->name('admin.petugas.edit');
        Route::put('/petugas/{id}', [AdminPetugasController::class, 'update'])->name('admin.petugas.update');
        Route::delete('/petugas/{id}', [AdminPetugasController::class, 'destroy'])->name('admin.petugas.destroy');
    });

    });

