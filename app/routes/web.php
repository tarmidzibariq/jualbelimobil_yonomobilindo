<?php

use App\Http\Controllers\Admin\CarPhotoController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Web\DetailCarController;
use App\Http\Controllers\Web\DownPaymentController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\KontakController;
use App\Http\Controllers\Web\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use App\Models\CarType;

// Route::get('/', function () {
//     return view('welcome');
// });

// route authentication
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home-cms');

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

    // Cars Route with custom methods
    Route::get('cars/{id}/edit-status', [CarsController::class, 'editStatus']);
    Route::post('cars/{id}/update-status', [CarsController::class, 'updateStatus']);

    // Car Photos Route
    Route::resource('cars-photo', CarPhotoController::class)->names('admin.carPhotos')->except(['show', 'edit', 'update', 'create', 'store']);
});

//group route with prefix "admin" with middleware "auth" and "checkrole:user"
Route::prefix('user')->middleware(['auth', 'checkrole:user'])->group(function () {

    // Dashboard Route
    Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');

    Route::resource('downPayment', App\Http\Controllers\User\DownPaymentController::class)->names('user.downPayment');
});

//Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/show-login', [LoginController::class, 'showLoginForm'])->name('showLoginModal');

Route::prefix('web')->group(function () {
    
    // jual mobil
    Route::resource('jualMobil', App\Http\Controllers\Web\JualMobilController::class)->names('web.jualMobil');
    
    // testimonial
    Route::get('testimonial', [TestimonialController::class, 'index'])->name('web.testimonial');
    
    // kontak
    Route::get('kontak', [KontakController::class, 'index'])->name('web.kontak');
    
    Route::get('/detailMobil/{id}', [DetailCarController::class,'index'])->name('web.detailMobil');
    
    // Route::get('/downPayment/{id}', [DownPaymentController::class,'index'])->name('web.downPayment')->middleware('auth');
    
    // Route::post('/downPayment/{id}', [DownPaymentController::class,'store'])->name('web.downPayment')->middleware('auth');
    
    Route::resource('downPayment', DownPaymentController::class)->names('web.downPayment')->middleware(['auth', 'checkrole:user'])->except(['index', 'edit', 'update', 'create']);

    
});