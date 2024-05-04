<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\ProductController;
use \App\Http\Controllers\Api\OrderController;


Route::middleware('auth:sanctum', 'admin')
    ->group(function () {
        Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getUser']);
        Route::post('/logout',[\App\Http\Controllers\Api\AuthController::class, 'logout']);

        Route::apiResource('products', ProductController::class);
        Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
        Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('orders/{order}', [OrderController::class, 'view']);
    });

Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);