<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

use App\Http\Controllers\ScreeningController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');

    // Screening Module
    Route::get('/screenings/{screening}/convert', [ScreeningController::class, 'convertToPatient'])->name('screenings.convert');
    Route::resource('screenings', ScreeningController::class);

    Route::resource('patients', PatientController::class);

    Route::get('/patients/{patient}/hl7', [PatientController::class, 'hl7'])->name('patients.hl7');
    Route::get('/export/csv', [PatientController::class, 'exportCsv'])->name('export.csv');
    Route::get('/export/hl7', [PatientController::class, 'exportHl7'])->name('export.hl7');
    Route::get('/backup', [PatientController::class, 'backup'])->name('backup');
    Route::post('/restore', [PatientController::class, 'restore'])->name('restore');
    Route::post('/reset', [PatientController::class, 'reset'])->name('reset');
    Route::view('/system', 'system.index')->name('system.index');
});
