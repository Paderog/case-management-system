<?php

use App\Http\Controllers\CasesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

Route::get('/run-migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return "Migration completed";
});

Route::get('/create-admin', function () {
    Admin::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('123456')
    ]);
    return "Admin created";
});

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