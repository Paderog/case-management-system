<?php

use App\Http\Controllers\CasesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Admin;
use App\Http\Controllers\FiscalYearController;
use App\Http\Controllers\AdministrativeCaseController;

Route::get('/years/create', [FiscalYearController::class, 'create'])->name('years.create');
Route::post('/years/store', [FiscalYearController::class, 'store'])->name('years.store');
Route::delete('/years/{id}', [FiscalYearController::class, 'destroy'])->name('years.destroy');

Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
Route::get('/', function () {
    return view('home');   // landing page
})->name('home');

// Admin Login
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/cases/year/{year}', [CasesController::class, 'byYear'])->name('cases.year');
Route::get('/cases/year/{year}/create', [CasesController::class, 'create'])->name('cases.create');
Route::post('/cases/year/{year}', [CasesController::class, 'store'])->name('cases.store');
Route::delete('/cases/{case}', [CasesController::class, 'destroy'])->name('cases.destroy');
Route::resource('admin-cases', AdministrativeCaseController::class);
// Route::get('/admin-cases/{id}', [AdministrativeCaseController::class, 'show'])
//     ->name('admin-cases.show');
Route::get('/admin-cases/{id}/add', [AdministrativeCaseController::class, 'addRow'])
    ->name('admin-cases.add-row');
Route::post('/admin-cases/{id}/store-row', [AdministrativeCaseController::class, 'storeRow'])
    ->name('admin-cases.store-row');
Route::get('/admin-cases/{id}/print', [AdministrativeCaseController::class, 'print'])
    ->name('admin-cases.print');
Route::get('/admin-cases/{id}/edit', [AdministrativeCaseController::class, 'edit'])
    ->name('admin-cases.edit');
Route::put('/admin-cases/{id}', [AdministrativeCaseController::class, 'update'])
    ->name('admin-cases.update');

// Protected routes
Route::middleware(['admin.auth'])->group(function(){
    Route::resource('cases', CasesController::class)->except(['index']);
});
Route::get('/cases', function () {
    $year = \App\Models\FiscalYear::latest()->first();

    if ($year) {
        return redirect()->route('cases.year', $year->id);
    }
    return redirect()->route('dashboard');
});
