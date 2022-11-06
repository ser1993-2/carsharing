<?php

use Illuminate\Support\Facades\Route;

Route::post('/register', [\App\Http\Controllers\Auth\UserAuthController::class,'register']);
Route::post('/login', [\App\Http\Controllers\Auth\UserAuthController::class,'login']);

Route::prefix('/user')->middleware(['auth:api'])->group(function () {

    Route::prefix('/car')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\CarController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\User\CarController::class, 'show']);
        Route::post('/{id}/start', [\App\Http\Controllers\User\CarController::class, 'start']);
        Route::post('/{id}/finish', [\App\Http\Controllers\User\CarController::class, 'finish']);
    });

    Route::prefix('/trip')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\TripController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\User\TripController::class, 'show']);
    });
});

Route::prefix('/admin')->middleware(['auth:api','isAdmin'])->group(function () {

    Route::prefix('/car')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\CarController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Admin\CarController::class, 'show']);
        Route::post('/', [\App\Http\Controllers\Admin\CarController::class, 'store']);
        Route::put('/', [\App\Http\Controllers\Admin\CarController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Admin\CarController::class, 'destroy']);
    });

    Route::prefix('/user')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show']);
        Route::put('/', [\App\Http\Controllers\Admin\UserController::class, 'update']);
    });

    Route::prefix('/rate')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RateController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Admin\RateController::class, 'store']);
        Route::put('/', [\App\Http\Controllers\Admin\RateController::class, 'update']);
    });

});
