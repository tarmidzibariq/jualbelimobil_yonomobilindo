<?php

use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
// Route::get('/', function () {
//     return view('welcome');
// });

// route authentication
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//group route with prefix "admin" with middleware "auth" and "checkrole:admin"
Route::prefix('admin')->middleware(['auth', 'checkrole:admin'])->group(function () {

    // Dashboard Route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Users Route
    Route::resource('users', UsersController::class)->names('admin.users');
    
    // Cars Route
    Route::resource('cars', CarsController::class)->names('admin.cars');
    
});