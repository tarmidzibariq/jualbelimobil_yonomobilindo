<?php

use App\Http\Controllers\Api\WhatsappController;
use App\Http\Controllers\User\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/webhook', [PaymentController::class, 'notificationHandler']);
Route::get('/check-midtrans-status/{id}', [PaymentController::class, 'checkMidtransStatus']);

Route::post('/whatsapp/send', [WhatsappController::class, 'send']);
