<?php

use Illuminate\Support\Facades\Route;

Route::resource('/', App\Http\Controllers\WelcomeController::class);
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'store']);

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [App\Http\Controllers\DashboardController::class, 'store']);
    Route::put('/dashboard/update', [App\Http\Controllers\DashboardController::class, 'update']);

    Route::resource('/documents', App\Http\Controllers\DocumentController::class);
    Route::resource('/students', App\Http\Controllers\StudentController::class);
    Route::resource('/requests', App\Http\Controllers\RequestController::class);
    Route::resource('/users', App\Http\Controllers\UserController::class);
    Route::resource('/profile', App\Http\Controllers\ProfileController::class);
    Route::resource('/payment', App\Http\Controllers\PaymentController::class);
});
Route::resource('/locations', App\Http\Controllers\LocationController::class);
require __DIR__.'/auth.php';
