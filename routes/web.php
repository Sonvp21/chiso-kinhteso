<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ChiSoController;
use App\Http\Controllers\Admin\BoChiSoPhienBanController;
use App\Http\Controllers\KhaoSatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {

    // Admin
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::resource('chi-so', ChiSoController::class);
        Route::resource('phien-ban', BoChiSoPhienBanController::class);
        Route::get('bao-cao', [KhaoSatController::class, 'baoCaoAdmin'])->name('bao-cao');
    });

    // Doanh nghiệp
    Route::get('khao-sat', [KhaoSatController::class, 'index'])->name('khao-sat.index');
    Route::get('khao-sat/tao', [KhaoSatController::class, 'create'])->name('khao-sat.create');
    Route::post('khao-sat', [KhaoSatController::class, 'store'])->name('khao-sat.store');
    Route::get('khao-sat/{khaoSat}', [KhaoSatController::class, 'edit'])->name('khao-sat.edit');
    Route::post('khao-sat/{khaoSat}/luu', [KhaoSatController::class, 'luu'])->name('khao-sat.luu');
    Route::post('khao-sat/{khaoSat}/nop', [KhaoSatController::class, 'nop'])->name('khao-sat.nop');
});

require __DIR__.'/auth.php';
