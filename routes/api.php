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

Route::apiResource('payment', PaymentController::class);


// Route::name('payment.')->prefix('/payment')->group(function () {
   
//     Route::apiResource('create', [PaymentController::class, 'create']);
//     Route::apiResource('query', [PaymentController::class, 'query']);
// });