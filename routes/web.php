<?php

use App\Http\Controllers\CasesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Admin;


Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index']);

// Admin Login
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['admin.auth'])->group(function(){
    Route::resource('cases', CasesController::class);
});