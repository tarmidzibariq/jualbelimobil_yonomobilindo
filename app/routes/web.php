<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//group route with prefix "admin"
Route::prefix('admin')->middleware(['auth', 'checkrole:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Gunakan resource controller agar semua nama route otomatis sesuai konvensi Laravel
    Route::resource('users', UsersController::class)->names('admin.users');
});