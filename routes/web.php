<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\Order\OrderController;
use App\Models\User;

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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//     //     'canLogin' => Route::has('login'),
//     //     'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    
});


Route::get('api/payment/index', 'Api\PaymentController@index');

Route::resource('access_tokens',AccessTokenController::class);
Route::get('access_tokens_test',[AccessTokenController::class,'test']);
Route::get('http_api',[AdminController::class,'http_api']);

//Route::get('/payment/dashboard',[PaymentController::class,'index'])->name('payment.dashboard');
Route::get('payment/table_list',[PaymentController::class,'table_list']);

Route::get('payment/newPayment', 'Payment\PaymentController@newPayment')->name('payments.new-payment');


Route::get('/login', function () {
    if (auth()->check()) {
        return redirect('/admin');
    }

    return Inertia::render('Login');
})->name('login');

Route::get('/', function () {
        return redirect('/login');
});

Route::group([
    'prefix'=>'admin',
    'as' => 'admin.',
    'middleware' => [
        'role:Admin|Master',
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ],
], function () {
        Route::resource('user',UserController::class);
        Route::get('/', 'AdminController@index')->name('admin');
        Route::resource('order', OrderController::class);

        Route::name('payment.')->prefix('/payment')->group(function () {
            Route::resource('payment_crud', 'Payment\PaymentCrudController')->names('payment_crud');
            Route::resource('payments', 'Payment\PaymentSpaController')->names('payments');
            Route::resource('payment', 'Payment\PaymentController')->names('payment');
            Route::post('/payments/order', 'Payment\PaymentSpaController@order')->name('payments.order');
        }); 
        

});