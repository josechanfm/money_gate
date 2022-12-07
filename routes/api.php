<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::middleware('auth:sanctum')->apiResource('payments',PaymentController::class);

// Route::apiResource('payment', PaymentController::class);
// Route::apiResource('payment', PaymentController::class);
// Route::post('api/payments/create', 'Api\PaymentController@create_order');
// Route::post('api/payments/query', 'Api\PaymentController@query_order');


Route::name('payment.')->prefix('/payment')->group(function () {
   
    Route::post('create', [PaymentController::class, 'create_order']);
    Route::post('query', [PaymentController::class, 'query_order']);
    // Route::apiResource('query', [PaymentController::class, 'query']);
});