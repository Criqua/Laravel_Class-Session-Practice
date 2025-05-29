<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\ReportCitizenController;

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

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('cities', CityController::class);

    Route::get ('cities/import'   , [CityController::class,'showImportForm'])->name('cities.import.form');
    Route::post('cities/import'   , [CityController::class,'import']        )->name('cities.import');

    Route::get('cities/export/csv' , [CityController::class,'exportCsv'] )->name('cities.export.csv');
    Route::get('cities/export/xlsx', [CityController::class,'exportXlsx'])->name('cities.export.xlsx');
    Route::get('cities/export/pdf' , [CityController::class,'exportPdf'] )->name('cities.export.pdf');

    Route::resource('citizens', CitizenController::class);

    Route::get ('citizens/import'   , [CitizenController::class,'showImportForm'])->name('citizens.import.form');
    Route::post('citizens/import'   , [CitizenController::class,'import']        )->name('citizens.import');

    Route::get('citizens/export/csv' , [CitizenController::class,'exportCsv'] )->name('citizens.export.csv');
    Route::get('citizens/export/xlsx', [CitizenController::class,'exportXlsx'])->name('citizens.export.xlsx');
    Route::get('citizens/export/pdf' , [CitizenController::class,'exportPdf'] )->name('citizens.export.pdf');
    
    Route::get('report', [ReportCitizenController::class, 'send_report'])->name('report');
});

require __DIR__.'/auth.php';
