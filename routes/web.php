<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BookingController::class, 'index'])->name('booking.index');
Route::post('/', [BookingController::class, 'store'])->name('booking.store');
Route::post('/payment/callback', [PaymentController::class, 'handle']);
Route::get('/payment/success', [PaymentController::class, 'redirectPage']);