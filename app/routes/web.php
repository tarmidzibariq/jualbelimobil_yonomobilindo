<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



//group route with prefix "admin"
Route::prefix('admin')->group(function () {

    Route::group(['middleware' => ['auth', 'checkrole:admin']], function () {
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        
    });
});