<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RegisterController;

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('games', GamesController::class);

    Route::apiResource('orders', OrderController::class);

    Route::apiResource('payments', PaymentController::class);

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::post('/customers', [CustomerController::class, 'store']);
    Route::get('/customers/{customer}', [CustomerController::class, 'show']);
    Route::put('/customers/{customer}', [CustomerController::class, 'update']);
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy']);


    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::put('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/logout', [LoginController::class, 'logout']);
});
