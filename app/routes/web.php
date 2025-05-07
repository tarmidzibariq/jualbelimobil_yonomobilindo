<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route untuk Admin
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('checkRole:admin');

// Route untuk User
Route::get('/user', function () {
    return view('user.dashboard');
})->middleware('checkRole:user');