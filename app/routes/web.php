<?php

use App\Http\Controllers\Admin\CarPhotoController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use App\Models\CarType;


// Route::get('/', function () {
//     return view('welcome');
// });

// route authentication
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// API route to get car models based on brand
Route::get('/api/models', function (Request $request) {
    $brand = $request->query('brand');

    if (!$brand) {
        return response()->json([]);
    }

    $models = CarType::where('brand', $brand)
        ->orderBy('model', 'asc')
        ->pluck('model')
        ->unique()
        ->values();

    return response()->json($models);
});

//group route with prefix "admin" with middleware "auth" and "checkrole:admin"
Route::prefix('admin')->middleware(['auth', 'checkrole:admin'])->group(function () {

    // Dashboard Route
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Users Route
    Route::resource('users', UsersController::class)->names('admin.users');
    // Cars Route
    Route::resource('cars', CarsController::class)->names('admin.cars');

    // Car Photos Route
    Route::resource('carsPhoto', CarPhotoController::class)->names('admin.carsPhoto')
        ->except(['create', 'edit', 'show']);
});
