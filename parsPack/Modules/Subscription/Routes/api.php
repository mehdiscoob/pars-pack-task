<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->prefix('subscription')->group(function () {
    Route::post('/chengestatussubscriptionbyuserid/{id}', [\Modules\Subscription\Http\Controllers\SubscriptionController::class, 'changeStatusSubscriptionByUserId']);
});
Route::middleware('api')->prefix('subscription')->group(function () {
Route::post('/getlastexpiredsubscriprions', [\Modules\Subscription\Http\Controllers\SubscriptionController::class, 'getLastExpiredSubscriprions']);
});
