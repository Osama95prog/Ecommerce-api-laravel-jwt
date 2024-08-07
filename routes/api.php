<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\V1\OrderController;
use App\Http\Controllers\V1\ProductController;
use App\Http\Middleware\AuthenticateJWT;


Route::group([

    'middleware' => 'api',

], function ($router) {

    Route::post('login',  [AuthController::class, 'login']);
    Route::post('register',  [AuthController::class, 'register']);
    Route::post('logout',  [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::post('me',  [AuthController::class, 'me']);

});



Route::apiResource('products',ProductController::class);
Route::apiResource('orders',OrderController::class);
