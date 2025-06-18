<?php

use App\Http\Controllers\Admin\CarPhotoController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OfferController as AdminOfferController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\DownPaymentController as UserDownPaymentController;
use App\Http\Controllers\User\OfferController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TransactionOfferRecordController;
use App\Http\Controllers\User\TransactionSalesRecordController;
use App\Http\Controllers\Web\DetailCarController;
use App\Http\Controllers\Web\DownPaymentController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\JualMobilController;
use App\Http\Controllers\Web\KontakController;
use App\Http\Controllers\Web\TestimonialController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use Illuminate\Http\Request;
use App\Models\CarType;
use Illuminate\Support\Facades\Auth;

// Auth
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
    
    // Offer Route
    Route::get('offer',[AdminOfferController::class, 'index'])->name('admin.offer.index');
    Route::get('offer/{id}',[AdminOfferController::class, 'show'])->name('admin.offer.show');
    Route::get('offer/{id}/edit-status', [AdminOfferController::class, 'editStatus']);
    Route::post('offer/{id}/update-status', [AdminOfferController::class, 'updateStatus']);
    Route::post('offer/updateNote/{id}', [AdminOfferController::class, 'updateNote'])->name('admin.offer.updateNote');

    // Down Payment Route
    Route::resource('downPayment', App\Http\Controllers\Admin\DownPaymentController::class)->only(['index', 'show'])->names('admin.downPayment');
    Route::get('downPayment/addRefund/{id}', [App\Http\Controllers\Admin\DownPaymentController::class, 'addRefund'])->name('admin.downPayment.addRefund');
    Route::post('downPayment/storeRefund/{id}', [App\Http\Controllers\Admin\DownPaymentController::class, 'storeRefund'])->name('admin.downPayment.storeRefund');
    Route::get('downPayment/editRefund/{id}', [App\Http\Controllers\Admin\DownPaymentController::class, 'editRefund'])->name('admin.downPayment.editRefund');
    Route::post('downPayment/updateRefund/{id}', [App\Http\Controllers\Admin\DownPaymentController::class, 'updateRefund'])->name('admin.downPayment.updateRefund');

    // Sales Records Route
    Route::resource('sales-records', App\Http\Controllers\Admin\SalesRecordController::class)->names('admin.salesRecord')->except(['show', 'edit', 'update']);
    
    // Offer Records Route
    Route::resource('offer-records', App\Http\Controllers\Admin\OfferRecordController::class)->names('admin.offerRecord')->except(['show', 'edit', 'update']);

    
});

//group route with prefix "user" with middleware "auth" and "checkrole:user"
Route::prefix('user')->middleware(['auth', 'checkrole:user'])->group(function () {

    // Dashboard Route
    Route::get('dashboard', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('user.dashboard');

    // Down Payment Route
    Route::get('downPayment', [UserDownPaymentController::class, 'index'])->name('user.downPayment.index');
    Route::get('downPayment/checkout/{id}', [PaymentController::class, 'checkout'])->name('user.downPayment.checkout');
    Route::get('downPayment/change/{id}', [PaymentController::class, 'changeStatus'])->name('user.downPayment.changeStatus');

    // Offer Route
    Route::resource('offer', OfferController::class)->names('user.offer')->except(['edit', 'update', 'create', 'destroy']);
    
    // updateAddress Route
    Route::post('updateUser/{id}', [ProfileController::class, 'updateAddress'])->name('user.updateAdress');

    // Transaction Sales Record Route
    Route::get('transaction-sales-record', [TransactionSalesRecordController::class, 'index'])->name('user.transactionSalesRecord.index');
    Route::get('transaction-sales-record/createTesti/{id}', [TransactionSalesRecordController::class, 'createTesti'])->name('user.transactionSalesRecord.createTesti');
    Route::post('transaction-sales-record/storeTesti/{id}', [TransactionSalesRecordController::class, 'storeTesti'])->name('user.transactionSalesRecord.storeTesti');
   
    // Transaction Offer Record Route
    Route::get('transaction-offer-record', [TransactionOfferRecordController::class, 'index'])->name('user.transactionOfferRecord.index');
});
Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler']);

// Route::post('/midtrans/notification', [PaymentController::class, 'notificationHandler']);
// Route::get('payment/{id}/token', [PaymentController::class, 'getSnapToken'])->name('user.Payment.snapToken');
// Route::post('/midtrans/callback', [\App\Http\Controllers\User\PaymentController::class, 'handle']);

//Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
// Route::get('/show-login', [LoginController::class, 'showLoginForm'])->name('showLoginModal');

Route::prefix('web')->group(function () {
    
    // jual mobil
    Route::get('jualMobil', [JualMobilController::class, 'index'])->name('web.jualMobil.index');

    Route::post('jualMobil', [JualMobilController::class, 'store'])->name('web.jualMobil.store')->middleware(['auth', 'checkrole:user']);
    
    // testimonial
    Route::get('testimonial', [TestimonialController::class, 'index'])->name('web.testimonial');
    
    // kontak
    Route::get('kontak', [KontakController::class, 'index'])->name('web.kontak');
    
    Route::get('/detailMobil/{id}', [DetailCarController::class,'index'])->name('web.detailMobil');
    
    // Down Payment Route
    Route::resource('downPayment', DownPaymentController::class)->names('web.downPayment')->middleware(['auth', 'checkrole:user'])->except(['index', 'edit', 'update', 'create']);

    
});

