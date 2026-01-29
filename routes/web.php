<?php

use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('patients.index');
});

Route::resource('patients', PatientController::class);

Route::get('/patients/{patient}/hl7', [PatientController::class, 'hl7'])->name('patients.hl7');
Route::get('/export/csv', [PatientController::class, 'exportCsv'])->name('export.csv');
Route::get('/export/hl7', [PatientController::class, 'exportHl7'])->name('export.hl7');
Route::get('/backup', [PatientController::class, 'backup'])->name('backup');
Route::post('/restore', [PatientController::class, 'restore'])->name('restore');
Route::post('/reset', [PatientController::class, 'reset'])->name('reset');
