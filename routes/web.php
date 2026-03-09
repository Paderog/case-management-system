<?php

use App\Http\Controllers\CasesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

//cases routes
//Display all case
Route::get('/cases', [CasesController::class, 'index'])->name('cases.index');
//routes to display the form for creating a case
Route::get('/cases/create', [CasesController:: class, 'create'])->name('cases.create');
//Store a case in the cases table
Route::post('/cases', [CasesController::class, 'store'])->name('cases.store');
//Show detailsof a specific case by ID
Route::get('/cases/{id}', [CasesController::class, 'show'])->name('cases.show');
//Edit an existing case
Route::get('/cases/{case}/edit', [CasesController::class, 'edit'])->name('cases.edit');
//Update an existing case
Route::put('/cases/{case}', [CasesController::class, 'update'])->name('cases.update');
//Delete a Case
Route::delete('/cases/{case}', [CasesController::class, 'destroy'])->name('cases.destroy'); 
//Admin Login
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['admin.auth'])->group(function(){
    Route::resource('cases', CasesController::class);
});