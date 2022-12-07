<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Order\OrderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/admin',[AdminController::class,'index'])->name('admin');
});

Route::name('order.')->prefix('/order')->group(function () {
    Route::resource('order', OrderController::class);
});

Route::name('payment.')->prefix('/payment')->group(function () {
   
    // Route::resource('payment_crud',Payment\PaymentCrudController::class);
    // Route::resource('payments',Payment\PaymentSpaController::class);
    // Route::resource('payment',Payment\PaymentController::class);
    Route::resource('payment_crud', 'Payment\PaymentCrudController')->names('payment_crud');
    Route::resource('payments', 'Payment\PaymentSpaController')->names('payments');
    Route::resource('payment', 'Payment\PaymentController')->names('payment');
    Route::post('/payments/order', 'Payment\PaymentSpaController@order')->name('payments.order');

    // Route::post('/payments/createOrder', 'Payment\PaymentSpaController@createOrder')->name('payments.createOrder');

});

// Route::post('/api/payments/order', 'Api\PaymentController@order')->name('paymentApi.order');

Route::get('api/payments/notify', 'Api\PaymentController@notify')->name('paymentApi.notify');
Route::get('api/payments/order', 'Api\PaymentController@order')->name('paymentApi.order');

Route::resource('access_tokens',AccessTokenController::class);
Route::get('access_tokens_test',[AccessTokenController::class,'test']);
Route::get('http_api',[AdminController::class,'http_api']);

//Route::get('/payment/dashboard',[PaymentController::class,'index'])->name('payment.dashboard');
Route::get('payment/table_list',[PaymentController::class,'table_list']);

Route::get('payment/newPayment', 'Payment\PaymentController@newPayment')->name('payments.new-payment');


// Route::prefix('/payment')->group(function(){
//     Route::resource('/',PaymentController::class);
//     // Route::get('dashboard',[PaymentController::class,'index'])->name('dashboard');
//     Route::get('table_list',[PaymentController::class,'table_list']);
// });